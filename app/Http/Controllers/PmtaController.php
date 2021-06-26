<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;
use Auth;

class PmtaController extends Controller
{
  public function index()
  {
    Helper::checkPermissions('pmta'); // check user permission
    $pmta = json_decode(\DB::table('settings')->whereId(config('mc.app_id'))->value('pmta'));
    $page = 'setup_pmta';
    return view('pmta.index')->with(compact('page', 'pmta'));
  }

  public function pmtaSteps(Request $request, $step=null)
  { 
    if($request->step == 0) {
      return $this->validateServer($request);
    } elseif($request->step == 3) {
      return $this->IpsDomainsMapping($request);
    } elseif($request->step == 4) {
      return $this->bounces($request);
    } elseif($request->step == 5) {
      return $this->authentication($request);
    } elseif($request->step == 6) {
      return $this->config($request);
    } elseif($request->step == 7) {
      return $this->finish($request);
    } elseif($request->step == 10) {
      return $this->validateBounce($request);
    } elseif($request->step == 15) {
      return $this->delete(1);
    } elseif($request->step == 16) {
      return $this->downloadPmtaSettings(1);
    }
  }

  /**
   * Create .zip according to PMTA settings
  */
  private function downloadPmtaSettings($id)
  {
    $path_pmta = str_replace('[user-id]', Auth::user()->id, config('mc.path_pmta'));
    \Helper::dirCreateOrExist($path_pmta); // create dir if not exist

    $pmta = json_decode(\DB::table('settings')->whereId(config('mc.app_id'))->value('pmta'), true);

    $main_domain = Helper::getAppURL(true);
    $files = [];

    // Create config file
    $config = $this->config($pmta, true);
    $config_file = $path_pmta.'config';
    \File::put($config_file, $config);

    $zip_file = $path_pmta.$pmta['server_name'].'.zip';
    $zipper = new \Chumper\Zipper\Zipper;
    $zipper->make($zip_file)->add($config_file);
    array_push($files, $config_file);

    // Main Domain DKIM 
    $private_key_file = $path_pmta."fallback.{$main_domain}.pem";
    \File::put($private_key_file, $pmta['domain_keys']["main_domain_private_key"]);
    array_push($files, $private_key_file);

    $zipper->make($zip_file)->add($private_key_file);

    $public_key_file = $path_pmta."{$main_domain}_public_key.txt";
    \File::put($public_key_file, $pmta['domain_keys']["main_domain_public_key"]);
    array_push($files, $public_key_file);

    $zipper->make($zip_file)->add($public_key_file);

    // Create DKIMs
    $domains = Helper::splitLineBreakWithComma($pmta['domains']);
    foreach ($domains as $domain) {
      // Main Domain DKIM 
      $sending_domain_part = explode('.', $domain);
      $private_key = $pmta['domain_keys']["{$sending_domain_part[0]}_private_key"];
      $pmta['dkim_selector'] = $pmta['dkim_selector'] ?? config('mc.dkim_selector');
      $private_key_file = $path_pmta.$pmta['dkim_selector'].".{$domain}.pem";
      \File::put($private_key_file, $private_key);
      array_push($files, $private_key_file);

      $zipper->make($zip_file)->add($private_key_file);

      $public_key_file = $path_pmta."{$domain}_public_key.txt";
      \File::put($public_key_file, $pmta['domain_keys']["{$sending_domain_part[0]}_public_key"]);

      $zipper->make($zip_file)->add($public_key_file);
      array_push($files, $public_key_file);
    }

    // Summary PDF File
    $dns_file = $path_pmta.'DNS.pdf';

    // Get Summary
    $html = $this->authentication($pmta, true);
    \PDF::loadHTML($html)->setPaper('a4')->setWarnings(false)->save($dns_file);

    $zipper->make($zip_file)->add($dns_file);
    array_push($files, $dns_file);

    $zipper->close();

    foreach($files as $file) {
      unlink($file);
    }

    return [
      'msg' =>'success',
      'file' => route('download.pmta', ['file' => "{$pmta['server_name']}.zip"])
    ];
  }

  public function download($file)
  {
    $path_pmta = str_replace('[user-id]', Auth::user()->id, config('mc.path_pmta'));
    $zip_file = $path_pmta.$file;
    return response()->download($zip_file)->deleteFileAfterSend(true);
  }

  /**
   * Validate bounces
  */
  private function validateBounce($request)
  {

    $validate_cert = $request->selects[2] == 'Yes' ? true : false;
    $oClient = new \Webklex\IMAP\Client([
      'host'          => $request->inputs[0],
      'port'          => $request->inputs[1],
      'encryption'    => $request->selects[1],
      'validate_cert' => $validate_cert,
      'username'      => $request->inputs[2],
      'password'      => $request->inputs[3],
      'protocol'      => $request->method     // imap or pop3
    ]);
    try {
      $oClient->connect();
      return '<span class="text-success">'.__('app.msg_successfully_connected').'</span>';
    } catch(\Exception $e) {
      $msg = $e->getMessage();
      return "<span class='text-danger'>{$msg}</span>";
    }
  }

  /**
   * Domain & IPs mapping
  */
  private function IpsDomainsMapping($request)
  {
    $ips     = Helper::splitLineBreakWithComma($request->ips);
    $domains = Helper::splitLineBreakWithComma($request->domains);
    $ip_per_domain = ceil(count($ips) / count($domains));

    $str = "<script>$(function () {
        $('[data-toggle=\"tooltip\"]').tooltip();
      });
      function displayBounce(chk_id, bounce_id){
        var checkBox = document.getElementById(chk_id);
        var bounce = document.getElementById(bounce_id);
        if(checkBox.checked == true ){
          bounce.style.display = 'none';
        } else {
          bounce.style.display = 'block';
        }
      }
    </script>";
    foreach($domains as $domain) {
      $domain = trim($domain);
      if(empty($domain)) continue;

      $str .= "<div class='col-md-4 col-md-offset-1'>";
      $str .= "<div class='row'>";
      $str .= "<div class='input-group from-group'>";
      $str .= "<select name=\"protocol[{$domain}]\" class=\"form-control\" style=\"width:100px;\">
              <option value=\"https://\">https://</option>
              <option value=\"http://\">http://</option>
            </select>";
      $str .= "<div class='input-group-addon input-group-addon-right' style=\"width:100%;\">{$domain}</div>";
      $str .= "</div>";
      $str .= "<div class='well'>";
      for ($i=0; $i<$ip_per_domain; $i++) {
        if(!empty($ips)) {
          $str .= "<li style='list-style:none;'><h3>".array_shift($ips)."</h3></li>";
        }
      }

      $str .= "<div class='row' style='padding-top: 5px;'>";
      $str .= "<div class='input-group from-group'>";
      $str .= "<input type='text' name='from_name[{$domain}]' placeholder='".__('app.from_name')."' class='form-control' value=''>";
      $str .= "<div class='input-group-addon input-group-addon-right'><i class='fa fa-info-circle' data-toggle='tooltip' title='".__('help.pmta_from_name')."'></i></div>";
      $str .= "</div></div>";

      $str .= "<div class='row' style='padding-top: 5px;'>";
      $str .= "<div class='input-group from-group'>";
      $str .= "<input type='text' name='from_email[{$domain}]' placeholder='".__('app.from_email')."' class='form-control' value=''>";
      $str .= "<div class='input-group-addon input-group-addon-right'>@{$domain}</div>";
      $str .= "<div class='input-group-addon input-group-addon-right'><i class='fa fa-info-circle' data-toggle='tooltip' title='".__('help.pmta_from_email')."'></i></div>";
      $str .= "</div></div>";

      $str .= "<div class='row' style='padding-top: 5px;'>";
      $str .= "<div class='input-group from-group'>";
      $str .= "<input type='text' name='reply_email[{$domain}]' placeholder='".__('app.reply_email')."' class='form-control' value=''>";
      $str .= "<div class='input-group-addon input-group-addon-right'><i class='fa fa-info-circle' data-toggle='tooltip' title='".__('help.pmta_reply_email')."'></i></div>";
      $str .= "</div></div>";

      $str .= "<div class='row' style='padding-top: 5px;'>";
      $str .= "<div class='from-group input-group'>";
      
      $str .= "<label class='form-control'>";
      $str .= "<input type='checkbox' id='chk_bounce_pmta_{$domain}' name='bounce_pmta[{$domain}]' value='Y' checked='checked' onclick=\"displayBounce('chk_bounce_pmta_{$domain}', 'bounce_pmta_{$domain}')\">&nbsp; ".__('app.bounce_pmta_file')."</label>";
      $str .= "<div class='input-group-addon input-group-addon-right'><i class='fa fa-info-circle' data-toggle='tooltip' title='".__('help.bounce_pmta_file')."'></i></div>";
      $str .= "</div></div>";

      $str .= "<div class='row' id='bounce_pmta_{$domain}' style='padding-top: 5px; display:none;'>";
      $str .= "<div class='input-group from-group'>";
      $str .= "<input type='text' name='bounce_email[{$domain}]' placeholder='".__('app.bounce_email')."' class='form-control' value=''>";
      $str .= "<div class='input-group-addon input-group-addon-right'>@{$domain}</div>";
      $str .= "<div class='input-group-addon input-group-addon-right'><i class='fa fa-info-circle' data-toggle='tooltip' title='".__('help.pmta_bounce_email')."'></i></div>";
      $str .= "</div></div>";

      $str .= "</div></div></div>";

      // No need to display empty domain with no ip assigned
      if(empty($ips)) break;
    }
    return $str;
  }

  /**
   * Create bounces dynamically according to the sending domains
  */
  private function bounces($request)
  {
    $str = "<script>$(function () {
        $('[data-toggle=\"tooltip\"]').tooltip();
      });
    </script>";
    foreach($request->bounce_email as $key => $bounce) {
      $bounce_email = $bounce.'@'.$key;
      $div_id = 'bounce-'.explode('.', $key)[0];
      $str .= "<div class=\"panel panel-default\">";
      $str .= "<div class=\"panel-heading\"><h4 class=\"panel-title\"><a class=\"accordion-toggle accordion-toggle-styled collapsed\" data-toggle=\"collapse\" href=\"#{$div_id}\"> $bounce_email </a></h4></div>";
      $str .= "<div id=\"{$div_id}\" class=\"panel-collapse collapse\">";
      $str .= '<div class="panel-body">';
      if(!empty($request->bounce_pmta[$key]) && $request->bounce_pmta[$key] == 'Y') {
        $str .= '<label class="col-md-8"><h3>'.__('app.bounce_pmta_file').'</h3></label>';
      } else {
        $str .= '<div class="form-group">
                  <label class="col-md-2 control-label">'.__('app.pmta_bounce_method').'<span class="required">*</span></label>
                  <div class="col-md-6">
                    <div class="input-group from-group">
                      <select name="'.$div_id.'[]" class="form-control">
                        <option value="imap">IMAP</option>
                        <option value="pop3">POP3</option>
                      </select>
                      <div class="input-group-addon input-group-addon-right">
                        <i class="fa fa-info-circle" data-toggle="tooltip" title="'.__('help.pmta_bounce_method').'"></i>
                      </div>
                    </div>
                  </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">'.__('app.pmta_bounce_host').'<span class="required">*</span></label>
            <div class="col-md-6">
              <div class="input-group from-group">
                <input type="text" class="form-control" name="'.$div_id.'[]" value="" placeholder="'.__('app.pmta_bounce_host').'">
                <div class="input-group-addon input-group-addon-right">
                  <i class="fa fa-info-circle" data-toggle="tooltip" title="'.__('help.pmta_bounce_host').'"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">'.__('app.pmta_bounce_port').'<span class="required">*</span></label>
            <div class="col-md-6">
              <div class="input-group from-group">
                <input type="text" class="form-control" name="'.$div_id.'[]" value="143" placeholder="'.__('app.pmta_bounce_port').'">
                <div class="input-group-addon input-group-addon-right">
                  <i class="fa fa-info-circle" data-toggle="tooltip" title="'.__('help.pmta_bounce_port').'"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">'.__('app.pmta_bounce_username').'<span class="required">*</span></label>
            <div class="col-md-6">
              <div class="input-group from-group">
                <input type="text" class="form-control" name="'.$div_id.'[]" value="'.$bounce_email.'" placeholder="'.__('app.pmta_bounce_username').'">
                <div class="input-group-addon input-group-addon-right">
                  <i class="fa fa-info-circle" data-toggle="tooltip" title="'.__('help.pmta_bounce_username').'"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">'.__('app.pmta_bounce_password').'<span class="required">*</span></label>
            <div class="col-md-6">
              <div class="input-group from-group">
                <input type="password" class="form-control" name="'.$div_id.'[]" value="" placeholder="'.__('app.pmta_bounce_password').'">
                <div class="input-group-addon input-group-addon-right">
                  <i class="fa fa-info-circle" data-toggle="tooltip" title="'.__('help.pmta_bounce_password').'"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">'.__('app.pmta_bounce_encryption').'<span class="required">*</span></label>
            <div class="col-md-6">
              <div class="input-group from-group">
                <select name="'.$div_id.'[]" class="form-control">
                  <option value="none" selected="selected">None</option>
                  <option value="ssl">SSL</option>
                  <option value="tls">TLS</option>
                </select>
                <div class="input-group-addon input-group-addon-right">
                  <i class="fa fa-info-circle" data-toggle="tooltip" title="'.__('help.pmta_bounce_encryption').'"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">'.__('app.pmta_bounce_validate_cert').'<span class="required">*</span></label>
            <div class="col-md-6">
              <div class="input-group from-group">
                <select name="'.$div_id.'[]" class="form-control">
                  <option value="No">'.__('app.no').'</option>
                  <option value="Yes">'.__('app.yes').'</option>
                </select>
                <div class="input-group-addon input-group-addon-right">
                  <i class="fa fa-info-circle" data-toggle="tooltip" title="'.__('help.pmta_bounce_encryption').'"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
              <button type="button" class="btn btn-success" onclick="validateBounce(\''.$div_id.'\')">'.__('app.validate').'</button><span id="msg-'.$div_id.'" style="padding-left:20px;"></span>
            </div>
          </div>';
      }
      
      $str .= '</div></div>';
      $str .= '</div></div></div>';
    }
    return $str;
  }

  /**
   * DNS entries for PMTA
  */
  private function authentication($request, $pmta_data=false)
  {
    $pmta = $pmta_data ? $request : $request->all();

    $main_domain = Helper::getAppURL(true);
    $smtp_a_record = $pmta['smtp_host'].'.'.$main_domain;
    $keys = Helper::generateKeys();
    $domain_keys['data']["main_domain_public_key"] = $keys['public_key'];
    $domain_keys['data']["main_domain_private_key"] = $keys['private_key'];
    $dkim_host = "fallback._domainkey.{$main_domain}.";
    $dkim_value = 'v=DKIM1; k=rsa; p='.str_replace(['-----BEGINPUBLICKEY-----', '-----ENDPUBLICKEY-----'], ['', ''], $keys['public_key']);
    $str = "<div class=\"panel panel-default\">";
    $str .= "<div class=\"panel-heading\"><h4 class=\"panel-title\"><a class=\"accordion-toggle accordion-toggle-styled collapsed\" data-toggle=\"collapse\" href=\"#smtp-record\"> ".$main_domain." </a></h4></div>";
    $str .= "<div id=\"smtp-record\" class=\"panel-collapse collapse\">";
    $str .= "<div class='panel-body'>
              <table class='table table-striped table-bordered table-hover'>
                <tr>
                <td style='padding:10px;' width='40%'><strong>".__('app.host')."</strong></td>
                <td style='padding:10px;' width='10%'><strong>".__('app.type')."</strong></td>
                <td style='padding:10px;' width='50%'><strong>".__('app.value')."</strong></td>
                </tr>
                <tr>
                <td style='padding:10px;'>{$smtp_a_record}.</td>
                <td style='padding:10px;'>A</td>
                <td style='padding:10px;'>
                <div class='input-group from-group'>
                <input type='text' class='form-control' value='{$pmta['server_ip']}' readonly='readonly' id='main-domain' onclick='copy(this.id)'>
                <div class='input-group-addon input-group-addon-right' style='cursor: pointer;' onclick='copy(\"main-domain\")'><i class='fa fa-copy'></i></div></div>
                </td>
                </tr>
                <tr>
                <td style='padding:10px;'>{$dkim_host}</td>
                <td style='padding:10px;'>TXT</td>
                <td style='padding:10px;'>
                <div class='input-group from-group'>
                <input type='text' class='form-control' value='{$dkim_value}' id='main-domain-dkim' readonly='readonly'>
                <div class='input-group-addon input-group-addon-right' style='cursor: pointer;' onclick='copy(\"main-domain-dkim\")'><i class='fa fa-copy'></i></div></div>
                </td>
                </tr>
              </table>
             </div></div>";
    $str .= "</div></div></div>";

    $ips = Helper::splitLineBreakWithComma($pmta['ips']);
    $domains = Helper::splitLineBreakWithComma($pmta['domains']);
    $ip_per_domain = ceil(count($ips) / count($domains));

    foreach($domains as $domain) {
      $keys = Helper::generateKeys();
      $domain_part = explode('.', $domain)[0];
      $domain_keys['data']["{$domain_part}_public_key"] = $keys['public_key'];
      $domain_keys['data']["{$domain_part}_private_key"] = $keys['private_key'];
      $pmta['dkim_selector'] = $pmta['dkim_selector'] ?? config('mc.dkim_selector');
      $pmta['dmarc_selector'] = $pmta['dmarc_selector'] ?? config('mc.dmarc_selector');
      $pmta['tracking_selector'] = $pmta['tracking_selector'] ?? config('mc.tracking_selector');
      $dkim_host = $pmta['dkim_selector']."._domainkey.{$domain}";
      $dkim_value = 'v=DKIM1; k=rsa; p='.str_replace(['-----BEGINPUBLICKEY-----', '-----ENDPUBLICKEY-----'], ['', ''], $keys['public_key']);
      $dmarc_value = "v=DMARC1;p=none;rua=mailto:{$pmta['dmarc_selector']}@{$domain};ruf=mailto:{$pmta['dmarc_selector']}@{$domain}";
      $cname_host = "{$pmta['tracking_selector']}.".$domain;
      $div_id = 'domain-'.$domain_part;
      $str .= "<div class=\"panel panel-default\">";
      $str .= "<div class=\"panel-heading\"><h4 class=\"panel-title\"><a class=\"accordion-toggle accordion-toggle-styled collapsed\" data-toggle=\"collapse\" href=\"#{$div_id}\"> ".$domain." </a></h4></div>";
      $str .= "<div id=\"{$div_id}\" class=\"panel-collapse collapse\">";
      $str .= "<div class='panel-body'>
                <table class='table table-striped table-bordered table-hover'>

                  <tr>
                  <td style='padding:10px;' width='40%'><strong>".__('app.host')."</strong></td>
                  <td style='padding:10px;' width='10%'><strong>".__('app.type')."</strong></td>
                  <td style='padding:10px;' width='50%'><strong>".__('app.value')."</strong></td>
                  </tr>

                  <tr>
                  <td style='padding:10px;'>{$cname_host}.</td>
                  <td style='padding:10px;'>CNAME</td>
                  <td style='padding:10px;'>
                  <div class='input-group from-group'>
                  <input type='text' class='form-control' value='{$main_domain}' id='cname-{$div_id}' readonly='readonly'>
                  <div class='input-group-addon input-group-addon-right' style='cursor: pointer;' onclick='copy(\"cname-{$div_id}\")'><i class='fa fa-copy'></i></div></div>
                  </td>
                  </tr>

                  <tr>
                  <td style='padding:10px;'>{$dkim_host}.</td>
                  <td style='padding:10px;'>TXT</td>
                  <td style='padding:10px;'>
                  <div class='input-group from-group'>
                  <input type='text' class='form-control' value='{$dkim_value}' id='key-{$div_id}' readonly='readonly'>
                  <div class='input-group-addon input-group-addon-right' style='cursor: pointer;' onclick='copy(\"key-{$div_id}\")'><i class='fa fa-copy'></i></div></div>
                  </td>
                  </tr>

                  <tr>
                  <td style='padding:10px;'>_dmarc</td>
                  <td style='padding:10px;'>TXT</td>
                  <td style='padding:10px;'>
                  <div class='input-group from-group'>
                  <input type='text' class='form-control' value='{$dmarc_value}' id='dmarc-{$div_id}' readonly='readonly'>
                  <div class='input-group-addon input-group-addon-right' style='cursor: pointer;' onclick='copy(\"dmarc-{$div_id}\")'><i class='fa fa-copy'></i></div></div>
                  </td>
                  </tr>
                  ";

      // otherwise array shift will empty the ips array
      $ips1 = $ips;
      $spf_value = 'v=spf1 mx a ';
      for ($i=0; $i<$ip_per_domain; $i++) {
        if(!empty($ips1)) {
          $ip = array_shift($ips1);
          $spf_value .= "ip4:{$ip} ";
        }
      }
      $spf_value .= '~all';

      $str .= "<tr>
      <td style='padding:10px;'>{$domain}.</td>
      <td style='padding:10px;'>TXT</td>
      <td style='padding:10px;'>
      <div class='input-group from-group'>
      <input type='text' class='form-control' value='{$spf_value}' id='spf-{$div_id}' readonly='readonly'>
      <div class='input-group-addon input-group-addon-right' style='cursor: pointer;' onclick='copy(\"spf-{$div_id}\")'><i class='fa fa-copy'></i></div></div>
      </td>
      </tr>";
      
      $vmta_selector_number = 0;
      $ptr_data = [];
      for ($i=0; $i<$ip_per_domain; $i++) {
        if(!empty($ips)) {
          $ip = array_shift($ips);
          $selector_no = sprintf("%02d", $vmta_selector_number);
          $vmta_selector = $pmta['vmta_prefix'].$selector_no.'.'.$domain;

          $str .= "<tr>
          <td style='padding:10px;'>{$vmta_selector}.</td>
          <td  style='padding:10px;'>A</td>
          <td style='padding:10px;'>
          <div class='input-group from-group'>
          <input type='text' class='form-control' value='{$ip}' id='ip-{$div_id}' readonly='readonly'>
          <div class='input-group-addon input-group-addon-right' style='cursor: pointer;' onclick='copy(\"ip-{$div_id}\")'><i class='fa fa-copy'></i></div></div>
          </td>
          </tr>";
          $ptr_data[$vmta_selector_number]['ip'] = $ip;
          $ptr_data[$vmta_selector_number]['domain'] = $vmta_selector;
        }
        $vmta_selector_number += 1;
      }

      if(count($ptr_data)) {
        $str .= "<tr>
                  <td style='padding:10px;' colspan=3><strong>Reverse DNS (PTR)</strong></td>
                </tr>";
      }

      foreach($ptr_data as $key_prt => $value_ptr) {
          $str .= "<tr>
                    <td style='padding:10px;'>{$value_ptr['ip']}</td>
                    <td  style='padding:10px;'>PTR</td>
                    <td style='padding:10px;'>
              <div class='input-group from-group'>
              <input type='text' class='form-control' value='{$value_ptr['domain']}' id='ptr-{$div_id}' readonly='readonly'>
              <div class='input-group-addon input-group-addon-right' style='cursor: pointer;' onclick='copy(\"ptr-{$div_id}\")'><i class='fa fa-copy'></i></div></div>
              </td>
              </tr>";
      }

      $str .= "</table>
               </div></div>";
      $str .= "</div></div></div>";
    }

    foreach($domain_keys['data'] as $key => $value) {
      $str .= "<input type='hidden' name=domain_keys[$key] value='{$value}'> ";
    }

    return $str;
  }

  /**
   * Return config for PMTA
  */
  private function config($request, $pmta_data=false)
  {
    $pmta = $pmta_data ? $request : $request->all();
    $main_domain = Helper::getAppURL(true);

    $str = "";
    $admin_ips = explode(',', $pmta['admin_ips']);
    foreach($admin_ips as $ip) {
      $ip = trim($ip);
      if($ip) {
        $str .= "http-access ".$ip." admin\n";
      }
    }

    $str .= "postmaster admin@".$main_domain."\n";
    $str .= "http-mgmt-port {$pmta['management_port']}\nrun-as-root yes\nsync-msg-update false\n\n";

    $str .= "
<smtp-pattern-list SMTPRESPONS>
    reply /421 PR(ct1)/ mode=backoff
    reply /^550 SC-001/ mode=backoff
    reply /420 Resources unavailable temporarily/ mode=backoff
    reply /^Resources unavailable temporarily/ mode=backoff
    reply /^421/ mode=backoff
    reply /^450/ mode=backoff
    reply /^try later/ mode=backoff
    reply /^553/ mode=backoff
    reply /^421/ mode=backoff
    reply /^550/ mode=backoff
    reply /^553/ mode=backoff
    reply /^550 SC-001/ mode=backoff
    reply /^421 4.7.0/ mode=backoff
    reply /^busy/ mode=backoff
    reply /^WSAECONNREFUSED/ mode=backoff
    reply /^WSAECONNRESET/ mode=backoff
    reply /^Connection attempt failed/ mode=backoff
</smtp-pattern-list>";

    $virtual_mta = $virtual_mta_pool = $smtp_user = $smtp_listener = $dkim_selector = '';
    $smtp_listener .= "\nsmtp-listener {$pmta['server_ip']}:{$pmta['smtp_port']}\n";
    $ips = Helper::splitLineBreakWithComma($pmta['ips']);
    $domains = Helper::splitLineBreakWithComma($pmta['domains']);
    $ip_per_domain = ceil(count($ips) / count($domains));

    $loop = 0;
    foreach ($domains as $domain) {
      $domain = trim($domain);
      $vmta_selector_number = 0;
      for ($i=0; $i<$ip_per_domain; $i++) {
        if($loop >= count($ips)) break;
        $vmta_selector_number = sprintf("%02d", $vmta_selector_number);
        if(!empty($ips)) {
          $smtp_username = str_replace('.', '', $domain).$i;
          $smtp_password = substr(hash('ripemd160',$domain), 20);
          $smtp_user .= "
<smtp-user {$smtp_username}>
    password {$smtp_password}
    source {server{$loop}}
</smtp-user>
<source {server{$loop}}>
    default-virtual-mta vmtapool{$vmta_selector_number}.{$domain}
    always-allow-relaying yes
    smtp-service yes
</source>\n";
        }
        $vmta_selector_number += 1;
        $loop++;
      }
    }

    
    foreach ($domains as $domain) {
            $domain = trim($domain);
            $vmta_selector_number = 0;
            for ($i=0; $i<$ip_per_domain; $i++) {
                if (!empty($ips)){
                    $ip = array_shift($ips);
                    $selector_no = sprintf("%02d", $vmta_selector_number);
                    $vmta_selector_number = sprintf("%02d", $vmta_selector_number);

$virtual_mta .= "
<virtual-mta {$pmta['vmta_prefix']}".$vmta_selector_number.".{$domain}>
    smtp-source-host {$ip} {$pmta['vmta_prefix']}{$vmta_selector_number}.{$domain}
</virtual-mta>\n";


                    $virtual_mta_pool .= "
<virtual-mta-pool vmtapool".$vmta_selector_number.".{$domain}>
    virtual-mta {$pmta['vmta_prefix']}{$vmta_selector_number}.{$domain}
</virtual-mta-pool>\n";

                    if($ip != $pmta['server_ip'])
                      $smtp_listener .= "smtp-listener {$ip}:{$pmta['smtp_port']}\n";
                }
                $vmta_selector_number += 1;
            }
            $pmta['dkim_selector'] = $pmta['dkim_selector'] ?? config('mc.dkim_selector');
            $dkim_selector .= "domain-key ".$pmta['dkim_selector'].",{$domain}, /etc/pmta/dkim/".$pmta['dkim_selector'].".{$domain}.pem\n";
        }

        $str .= $virtual_mta;
        $str .= $virtual_mta_pool;
        $str .= $smtp_user;
        $str .= $smtp_listener;

        $tls_value = ($pmta['smtp_encryption'] != 'none') ? 'yes' : 'no';

        $str  .="
<source 0/0>
    jobid-header Message-ID 
    process-x-job yes
    hide-message-source yes
    allow-unencrypted-plain-auth yes
    hide-message-source yes
    always-allow-relaying yes
    add-received-header no
    process-x-virtual-mta yes
    max-message-size unlimited 
    smtp-service yes
    require-auth true
    add-message-id-header yes
</source>\n\n";

    $str .= "# DKIM SELECTORS START \n";
    $str .= $dkim_selector;
    $str .= "# DKIM SELECTORS END \n";

        $str.= "
<domain *>
    max-smtp-out 10
    bounce-after 5d
    retry-after  10m
    max-msg-per-connection 10
    dk-sign yes
    dkim-sign yes
    dkim-identity sender-or-from
    dkim-identity-fallback @{$main_domain}
    log-commands    yes
    backoff-to-normal-after 2h
    backoff-to-normal-after-delivery true
    backoff-retry-after 30m
    backoff-max-msg-rate  100/m
    bounce-upon-no-mx yes
    smtp-pattern-list SMTPRESPONS
    use-starttls  {$tls_value}
    require-starttls {$tls_value}
</domain>\n\n";

    $str .= "log-file {$pmta['log_file_path']}\n";
    $str .= "log-rotate 10\n";

    $str .= "
<acct-file {$pmta['acct_file_path']}>
  record-fields delivery *,envId,jobId,bounceCat
  move-interval 5m
  delete-after 7d
  max-size 50M
  user-string from
</acct-file>\n";

    $str .= "
<acct-file {$pmta['diag_file_path']}>
  move-interval 1d
  delete-after 7d
</acct-file>\n\n";

    $str .= "spool {$pmta['spool_path']}\n\n";

    $str .= "host-name {$pmta['smtp_host']}".'.'.$main_domain;

    return $str;
  }

  private function finish($request)
  {
    try {
      $ssh = new \phpseclib\Net\SSH2($request->server_ip, $request->server_port);
      if (!$ssh->login($request->server_username, $request->server_password)) {
        return '<span class="alert text-danger">'.__('app.login_failed').'</span>';
      } else {
        $step = $this->pmtaFiles($request);
        if($step === true) {
          $step = $this->createConfigFile($request);
          if($step === true) {
            $step = $this->createAppEntries($request);
            if($step === true) {
              $this->restartServices($request);
              activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.setup_pmta') . " ({$request->server_name}) ". __('app.log_create')); // log
              session()->flash('msg', trans('app.pmta_msg_success'));
              return 'success';
            }
          }
        }
        return $step;
      }
    } catch (\Exception $e) {
      return '<span class="text-danger">'.$e->getMessage().'</span>';
    }
  }

  private function pmtaFiles($request)
  {
    $sftp = new \phpseclib\Net\SFTP($request->server_ip, $request->server_port);
    if (!$sftp->login($request->server_username, $request->server_password)) {
       return '<span class="alert text-danger">'.__('app.login_failed').'</span>';
    } else {
      // Create log files directory if not exist
      $log_file_path = substr($request->log_file_path, 0, strrpos($request->log_file_path, '/'));
      if(!$sftp->file_exists($log_file_path)) {
        try {
          $sftp->mkdir($log_file_path, -1, true);
        } catch(\Exception $e) {
          return '<span class="text-danger">'.$e->getMessage().'</span>';
        }
      }

      // Create accountings files directory if not exist
      $acct_file_path = substr($request->acct_file_path, 0, strrpos($request->acct_file_path, '/'));
      if(!$sftp->file_exists($acct_file_path)) {
        try {
          $sftp->mkdir($acct_file_path, -1, true);
        } catch(\Exception $e) {
          return '<span class="text-danger">'.$e->getMessage().'</span>';
        }
      }

      // Create diag files directory if not exist
      $diag_file_path = substr($request->diag_file_path, 0, strrpos($request->diag_file_path, '/'));
      if(!$sftp->file_exists($diag_file_path, -1, true)) {
        try {
          $sftp->mkdir($diag_file_path);
        } catch(\Exception $e) {
          return '<span class="text-danger">'.$e->getMessage().'</span>';
        }
      }

      // Create dkim files directory if not exist
      if(!$sftp->file_exists($request->dkim_path)) {
        try {
          $sftp->mkdir($request->dkim_path, -1, true);
        } catch(\Exception $e) {
          return '<span class="text-danger">'.$e->getMessage().'</span>';
        }
      }
      return true;
    }
  }

  /**
   * Create PMTA config file
  */
  private function createConfigFile($request)
  {
    $ssh = new \phpseclib\Net\SSH2($request->server_ip, $request->server_port);
    try {
      if (!$ssh->login($request->server_username, $request->server_password)) {
        return '<span class="alert alert-danger">'.__('app.login_failed').'</span>';
      } else {
        // Backup old config pmta file
        $ssh->exec("cp {$request->path}/config {$request->path}/config-backup-".date('Y-m-d'));

        // Create new config file for pmta
        $sftp = new \phpseclib\Net\SFTP($request->server_ip, $request->server_port);
        if (!$sftp->login($request->server_username, $request->server_password)) {
          return '<span class="alert text-danger">'.__('app.login_failed').'</span>';
        } else {
          $pmta_data =  $this->config($request);
          $sftp->put("{$request->path}/config", $pmta_data);
        }
        return true;
      }
    } catch (\Exception $e) {
      return '<span class="text-danger">'.$e->getMessage().'</span>';
    }
  }

  /**
   * Sending Servers, Sending Domains & Bounces entries for MailCarry
  */
  private function createAppEntries($request)
  {
    $input = $request->except('_token');
    // Save pmta data
    \DB::table('settings')->whereId(config('mc.app_id'))->update([
      'pmta' => json_encode($input)
    ]);

    $ips     = Helper::splitLineBreakWithComma($input['ips']);
    $domains = Helper::splitLineBreakWithComma($input['domains']);
    $ip_per_domain = ceil(count($ips) / count($domains));

    // Create group for sending server if not exist
    $group = app('App\Http\Controllers\GroupController')->createGroup(config('mc.groups.sending_server'), 'PowerMTA');

    $sftp = new \phpseclib\Net\SFTP($request->server_ip, $request->server_port);
    $sftp->login($request->server_username, $request->server_password);

    // Upload Main Domain Private Key
    $main_domain = Helper::getAppURL(true);
    $private_key = $input['domain_keys']["main_domain_private_key"];
    $private_key_file = "fallback.{$main_domain}.pem";
    $sftp->put($request->dkim_path.'/'.$private_key_file, $private_key);


    // Delete all data before new update otherwise duplicate the data
    // Delete Bounces
    \App\Models\Bounce::wherePmta(1)->delete();
    // Delete SendingDomain
    \App\Models\SendingDomain::wherePmta(1)->delete();
    // Delete SendingServer
    \App\Models\SendingServer::wherePmta(1)->delete();

    foreach($domains as $domain) {
      $domain = trim($domain);

      $sending_domain_part = explode('.', $domain);

      // Bounces data
      // If bounces processed by pmta files
      if(!empty($input['bounce_pmta'][$domain]) && $input['bounce_pmta'][$domain] == 'Y') {
        $bounce_id = null;
      } else {
        $password = $input["bounce-{$sending_domain_part[0]}"][4];
        $bounce_data = [
          'email'   => $input['bounce_email'][$domain]."@{$domain}",
          'method'  => $input["bounce-{$sending_domain_part[0]}"][0],
          'host'  => $input["bounce-{$sending_domain_part[0]}"][1] ?? null,
          'username'   => $input["bounce-{$sending_domain_part[0]}"][3],
          'password'  => !empty($password) ? \Crypt::encrypt($password) : null,
          'port'      => $input["bounce-{$sending_domain_part[0]}"][2] ?? 143,
          'encryption'      => $input["bounce-{$sending_domain_part[0]}"][5],
          'user_id'  => Auth::user()->id,
          'app_id'  => Auth::user()->app_id,
          'validate_cert' => $input["bounce-{$sending_domain_part[0]}"][6],
          'pmta'    => 1
        ];
        $bounce = \App\Models\Bounce::create($bounce_data);
        $bounce_id = $bounce->id;
      }
      

      // otherwise array shift will empty the ips array
      $ips1 = $ips;
      $spf_value = 'v=spf1 mx a ';
      for ($i=0; $i<$ip_per_domain; $i++) {
        if(!empty($ips1)) {
          $ip = array_shift($ips1);
          $spf_value .= "ip4:{$ip} ";
        }
      }
      $spf_value .= '~all';

      // Sending Server data
      for ($i=0; $i<$ip_per_domain; $i++) {
        if(!empty($ips)) {
          $ip = array_shift($ips);
          $smtp_username = str_replace('.', '', $domain).$i;
          $smtp_password = substr(hash('ripemd160',$domain), 20);
          $data = [
            'type' => 'smtp',
            'host' => $ip,
            'username' => $smtp_username,
            'password' => $smtp_password,
            'port' => $input['smtp_port'],
            'encryption' => $input['smtp_encryption'],
            'body_encoding' => $input['body_encoding']
          ];
          $smtp_data = [
            'name'      => $ip,
            'type' => 'smtp',
            'group_id'  => $group->id,
            'from_name' => $input['from_name'][$domain],
            'from_email'  => $input['from_email'][$domain].'@'.$domain,
            'reply_email' => $input['reply_email'][$domain],
            'tracking_domain' => "{$input['protocol'][$domain]}{$input['tracking_selector']}.{$domain}",
            'sending_attributes' => app('App\Http\Controllers\SendingServerController')->sendingServerAttributes($data),
            'speed_attributes' => json_encode(['speed'=>'Unlimited', 'limit'=>null, 'duration'=>null]),
            'bounce_id' => $bounce_id,
            'user_id' => Auth::user()->id,
            'app_id'  => Auth::user()->app_id,
            'pmta'    => 1
          ];
          \App\Models\SendingServer::create($smtp_data);
        }
      }

      // Upload Domain Private Keys
      $private_key = $input['domain_keys']["{$sending_domain_part[0]}_private_key"];
      $private_key_file = $request->dkim_selector.".{$domain}.pem";
      $sftp->put($request->dkim_path.'/'.$private_key_file, $private_key);

      // Sending Domain data
      $sending_domain_data = [
        'domain'   => $domain,
        'protocol'     => $input['protocol'][$domain],
        'public_key' => $input['domain_keys']["{$sending_domain_part[0]}_public_key"],
        'private_key' => $private_key,
        'spf_value' => $spf_value,
        'dkim' => $input['dkim_selector'],
        'dmarc' => $input['dmarc_selector'],
        'tracking' => $input['tracking_selector'],
        'user_id' => Auth::user()->id,
        'app_id'  => Auth::user()->app_id,
        'pmta'    => 1
      ];
      \App\Models\SendingDomain::create($sending_domain_data);
    }
    return true;
  }

  /**
   * Check server connection
  */
  public function validateServer($request)
  {
    try {
      $ssh = new \phpseclib\Net\SSH2($request->ip, $request->port);
      if (!$ssh->login($request->username, $request->password)) {
        return '<span class="alert text-danger">'.__('app.login_failed').'</span>';
      } else {
        return '<span class="alert text-success">'.__('app.msg_successfully_connected').'</span>';
      }
    } catch (\Exception $e) {
      return '<span class="text-danger">'.$e->getMessage().'</span>';
    }
  }

  /**
   * Restard server services
  */
  public function restartServices($request)
  {
    try {
      $sftp = new \phpseclib\Net\SFTP($request->server_ip, $request->server_port);
      if (!$sftp->login($request->server_username, $request->server_password)) {
        return '<span class="alert text-danger">'.__('app.login_failed').'</span>';
      } else {
        if($request->server_os == 'ubuntu20.04' || $request->server_os == 'ubuntu18.04' || $request->server_os == 'ubuntu16.04' || $request->server_os == 'other') {
          $ssh->exec('/etc/init.d/pmta restart');
          sleep(2);
          $ssh->exec('/etc/init.d/pmtahttp restart');
        } elseif($request->server_os == 'centos6.x') {
          $ssh->exec('service pmta restart');
          sleep(2);
          $ssh->exec('service pmtahttp restart');
        } elseif($request->server_os == 'centos7.x' || $request->server_os == 'centos8.x') {
          $ssh->exec('systemctl restart pmta.service');
          sleep(2);
          $ssh->exec('systemctl restart pmtahttp.service');
        }
      }
    } catch (\Exception $e) {
      return '<span class="text-danger">'.$e->getMessage().'</span>';
    }
  }

  /**
   * Delete PMTA
  */
  private function delete($id)
  {
    // Delete Sending Domains
    \App\Models\SendingDomain::wherePmta($id)->delete();

    // Delete Bounces
    \App\Models\Bounce::wherePmta($id)->delete();

    // Delete Sending Servers
    \App\Models\SendingServer::wherePmta($id)->delete();

    // Reset Pmta value
    \DB::table('settings')->whereId(config('mc.app_id'))->update([
      'pmta' => null
    ]);
    session()->flash('msg', trans('app.pmta_msg_delete_success'));
  }
}
