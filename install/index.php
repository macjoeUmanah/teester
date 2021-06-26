<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Install - MailCarry</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="icon" href="../storage/app/public/favicon.ico" type="image/gif" sizes="16x16">
  <link rel="stylesheet" href="../public/components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../public/components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../public/components/sweetalert/sweetalert.css">
  <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../public/css/skins/skin-blue-light.min.css">
  <link rel="stylesheet" href="../public/css/custom.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    .panel-primary>.panel-heading {
      background-color: #3d5a6b;
      border-color: #3d5a6b;
    }
  </style>
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
<?php
  // It will redirect to login page if successfull installed
  $app_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
  $app_url = str_replace('/install/', '', $app_url);
  $main_dir = str_replace(DIRECTORY_SEPARATOR.'install', '',__DIR__).DIRECTORY_SEPARATOR;
  if(file_exists($main_dir.'storage/app/public/installed')) {
    echo "<meta http-equiv=\"refresh\" content=\"0;URL='{$app_url}'\" />";
    exit;
  }
?>
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Header -->
<header class="main-header">
  <!-- Logo -->
  <a href="{{route('dashboard" class="logo" style="background-color: #FFFFFF; color: #000000; border-right: 1px solid #d2d6de">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><img src="../storage/app/public/mc-logo.png"></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><img src="../storage/app/public/mc-logo.png"></span>
  </a>
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"></a>
  </nav>
</header>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <div class="container" style="padding-top: 30px;">
        <div id="step1">
          <form id="frm-install" class="form-horizontal" action="install.php" method="post">
            <div class="panel panel-primary">
              <div class="panel-heading">
                 <h3 class="panel-title">Permissions
                  <span style="float: right;"><button class="btn btn-default btn-xs" onclick="location.href='/install/'">Refresh</button></span>
                 </h3>
              </div>
              <div class="panel-body">

                <div class="col-md-12"><label>Files & Folders</label></div>
                <label class="col-md-3 control-label">
                  <?php echo ".env &nbsp;&nbsp;&nbsp;(777) <br>
                  <small>
                  
                  chmod 777 {$main_dir}.env
                  </small>"; ?>
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                    $env_file = $main_dir.'.env';
                    $env_file_permission = substr(sprintf('%o', fileperms($env_file)), -4);
                    echo $env_file_permission >= '0777' ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>
                <?php $bootstrap_folder = $main_dir.'bootstrap'.DIRECTORY_SEPARATOR.'cache'; ?>
                <label class="col-md-3 control-label">
                  <?php echo DIRECTORY_SEPARATOR."bootstrap".DIRECTORY_SEPARATOR."cache &nbsp;&nbsp;&nbsp;
                  <small>
                    (should be 777 recursively) <br>
                    chmod 777 -R $bootstrap_folder
                  </small>"; ?>
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                    
                    $bootstrap_folder_permissions = substr(sprintf('%o', fileperms($bootstrap_folder)), -4);
                    echo $bootstrap_folder_permissions >= '0777' ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>
                <?php $storage_folder = $main_dir.'storage'; ?>
                <label class="col-md-3 control-label">
                  <?php echo DIRECTORY_SEPARATOR."storage &nbsp;&nbsp;&nbsp;
                  <small>
                    (must be 777 recursively) <br>
                    chmod 777 -R $storage_folder
                  </small>"; ?>
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                    
                    $storage_folder_permissions = substr(sprintf('%o', fileperms($storage_folder)), -4);
                    echo $storage_folder_permissions >= '0777' ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>

                <div class="col-md-12"><label>PHP Extensions</label></div>
                <label class="col-md-3 control-label">
                  PHP >= 7.1.3
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                  echo version_compare(PHP_VERSION, "7.1.3") > 0  ? '<i class="fa fa-check green-check"><small>'.PHP_VERSION.'</small></i>' : '<i class="fa fa-times red-times"><small>'.PHP_VERSION.'</small></i>';
                  ?>
                </div>
                <label class="col-md-3 control-label">
                  PDO
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                  echo extension_loaded ('PDO') ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>
                <label class="col-md-3 control-label">
                  openssl
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                  echo extension_loaded ('openssl') ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>

                <label class="col-md-3 control-label">
                  curl
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                  echo extension_loaded ('curl') ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>
                <label class="col-md-3 control-label">
                  mbstring
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                  echo extension_loaded ('mbstring') ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>
                <label class="col-md-3 control-label">
                  tokenizer
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                  echo extension_loaded ('tokenizer') ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>


                <label class="col-md-3 control-label">
                  xml
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                  echo extension_loaded ('xml') ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>
                <label class="col-md-3 control-label">
                  imap
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                  echo extension_loaded ('imap') ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>
                <label class="col-md-3 control-label">
                  zip
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                  echo extension_loaded ('zip') ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>

                <div class="col-md-12"><label>MySQL <font style="font-weight: normal;">Version should be >= 5.7.8</font></label></div>
                <div class="col-md-12">Or</div>
                <div class="col-md-12"><label>MariaDB <font style="font-weight: normal;">Version should be >= 10.3</font></label></div>
                <div class="col-md-12"><i style="color:#CE1A1A">Note: We are not verifying the Database version, so please make sure you are using the correct Database version.</i></div>
              </div>
            </div>

              <div class="panel panel-primary">
                <div class="panel-heading">
                   <h3 class="panel-title">Application Settings</h3>
                </div>
                <div class="panel-body">
                  <div class="form-group">
                    <label class="col-md-2 control-label">Application Name <span class="required">*</span></label>
                    <div class="col-md-10">
                      <input type="text" class="form-control" id="app_name" name="app_name" value="" placeholder="Enter Application Name" required="required">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Application URL <span class="required">*</span></label>
                    <div class="col-md-10">
                      <input type="url" class="form-control" id="app_url" name="app_url" value="<?php echo $app_url; ?>" placeholder="Enter Application URL" required="required">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Login Email <span class="required">*</span></label>
                    <div class="col-md-10">
                      <input type="email" class="form-control" id="email" name="email" value="" placeholder="Enter Application Login Email" required="required">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Login Password <span class="required">*</span></label>
                    <div class="col-md-10">
                      <input type="password" class="form-control" id="password" name="password" value="" placeholder="Enter Application Login Password" required="required" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Timezone</label>
                    <div class="col-md-10">
                      <select name="time_zone" id="timezone" class="form-control">
                        <option value="Pacific/Midway">(GMT-11:00) Midway Island </option>
                        <option value="US/Samoa">(GMT-11:00) Samoa </option>
                        <option value="US/Hawaii">(GMT-10:00) Hawaii </option>
                        <option value="US/Alaska">(GMT-09:00) Alaska </option>
                        <option value="US/Pacific">(GMT-08:00) Pacific Time (US &amp; Canada) </option>
                        <option value="America/Tijuana">(GMT-08:00) Tijuana </option>
                        <option value="US/Arizona">(GMT-07:00) Arizona </option>
                        <option value="US/Mountain">(GMT-07:00) Mountain Time (US &amp; Canada) </option>
                        <option value="America/Chihuahua">(GMT-07:00) Chihuahua </option>
                        <option value="America/Mazatlan">(GMT-07:00) Mazatlan </option>
                        <option value="America/Mexico_City">(GMT-06:00) Mexico City </option>
                        <option value="America/Monterrey">(GMT-06:00) Monterrey </option>
                        <option value="Canada/Saskatchewan">(GMT-06:00) Saskatchewan </option>
                        <option value="US/Central">(GMT-06:00) Central Time (US &amp; Canada) </option>
                        <option value="US/Eastern">(GMT-05:00) Eastern Time (US &amp; Canada) </option>
                        <option value="US/East-Indiana">(GMT-05:00) Indiana (East) </option>
                        <option value="America/Bogota">(GMT-05:00) Bogota </option>
                        <option value="America/Lima">(GMT-05:00) Lima </option>
                        <option value="America/Caracas">(GMT-04:30) Caracas </option>
                        <option value="Canada/Atlantic">(GMT-04:00) Atlantic Time (Canada) </option>
                        <option value="America/La_Paz">(GMT-04:00) La Paz </option>
                        <option value="America/Santiago">(GMT-04:00) Santiago </option>
                        <option value="Canada/Newfoundland">(GMT-03:30) Newfoundland </option>
                        <option value="America/Buenos_Aires">(GMT-03:00) Buenos Aires </option>
                        <option value="Greenland">(GMT-03:00) Greenland </option>
                        <option value="Atlantic/Stanley">(GMT-02:00) Stanley </option>
                        <option value="Atlantic/Azores">(GMT-01:00) Azores </option>
                        <option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is. </option>
                        <option value="Africa/Casablanca">(GMT) Casablanca </option>
                        <option value="Europe/Dublin">(GMT) Dublin </option>
                        <option value="Europe/Lisbon">(GMT) Lisbon </option>
                        <option value="Europe/London" selected="selected">(GMT) London </option>
                        <option value="Africa/Monrovia">(GMT) Monrovia </option>
                        <option value="Europe/Amsterdam">(GMT+01:00) Amsterdam </option>
                        <option value="Europe/Belgrade">(GMT+01:00) Belgrade </option>
                        <option value="Europe/Berlin">(GMT+01:00) Berlin </option>
                        <option value="Europe/Bratislava">(GMT+01:00) Bratislava </option>
                        <option value="Europe/Brussels">(GMT+01:00) Brussels </option>
                        <option value="Europe/Budapest">(GMT+01:00) Budapest </option>
                        <option value="Europe/Copenhagen">(GMT+01:00) Copenhagen </option>
                        <option value="Europe/Ljubljana">(GMT+01:00) Ljubljana </option>
                        <option value="Europe/Madrid">(GMT+01:00) Madrid </option>
                        <option value="Europe/Paris">(GMT+01:00) Paris </option>
                        <option value="Europe/Prague">(GMT+01:00) Prague </option>
                        <option value="Europe/Rome">(GMT+01:00) Rome </option>
                        <option value="Europe/Sarajevo">(GMT+01:00) Sarajevo </option>
                        <option value="Europe/Skopje">(GMT+01:00) Skopje </option>
                        <option value="Europe/Stockholm">(GMT+01:00) Stockholm </option>
                        <option value="Europe/Vienna">(GMT+01:00) Vienna </option>
                        <option value="Europe/Warsaw">(GMT+01:00) Warsaw </option>
                        <option value="Europe/Zagreb">(GMT+01:00) Zagreb </option>
                        <option value="Europe/Athens">(GMT+02:00) Athens </option>
                        <option value="Europe/Bucharest">(GMT+02:00) Bucharest </option>
                        <option value="Africa/Cairo">(GMT+02:00) Cairo </option>
                        <option value="Africa/Harare">(GMT+02:00) Harare </option>
                        <option value="Europe/Helsinki">(GMT+02:00) Helsinki </option>
                        <option value="Europe/Istanbul">(GMT+02:00) Istanbul </option>
                        <option value="Asia/Jerusalem">(GMT+02:00) Jerusalem </option>
                        <option value="Europe/Kiev">(GMT+02:00) Kyiv </option>
                        <option value="Europe/Minsk">(GMT+02:00) Minsk </option>
                        <option value="Europe/Riga">(GMT+02:00) Riga </option>
                        <option value="Europe/Sofia">(GMT+02:00) Sofia </option>
                        <option value="Europe/Tallinn">(GMT+02:00) Tallinn </option>
                        <option value="Europe/Vilnius">(GMT+02:00) Vilnius </option>
                        <option value="Asia/Baghdad">(GMT+03:00) Baghdad </option>
                        <option value="Asia/Kuwait">(GMT+03:00) Kuwait </option>
                        <option value="Africa/Nairobi">(GMT+03:00) Nairobi </option>
                        <option value="Asia/Riyadh">(GMT+03:00) Riyadh </option>
                        <option value="Europe/Moscow">(GMT+03:00) Moscow </option>
                        <option value="Asia/Tehran">(GMT+03:30) Tehran </option>
                        <option value="Asia/Baku">(GMT+04:00) Baku </option>
                        <option value="Europe/Volgograd">(GMT+04:00) Volgograd </option>
                        <option value="Asia/Muscat">(GMT+04:00) Muscat </option>
                        <option value="Asia/Tbilisi">(GMT+04:00) Tbilisi </option>
                        <option value="Asia/Yerevan">(GMT+04:00) Yerevan </option>
                        <option value="Asia/Kabul">(GMT+04:30) Kabul </option>
                        <option value="Asia/Karachi">(GMT+05:00) Karachi </option>
                        <option value="Asia/Tashkent">(GMT+05:00) Tashkent </option>
                        <option value="Asia/Kolkata">(GMT+05:30) Kolkata </option>
                        <option value="Asia/Kathmandu">(GMT+05:45) Kathmandu </option>
                        <option value="Asia/Yekaterinburg">(GMT+06:00) Ekaterinburg </option>
                        <option value="Asia/Almaty">(GMT+06:00) Almaty </option>
                        <option value="Asia/Dhaka">(GMT+06:00) Dhaka </option>
                        <option value="Asia/Novosibirsk">(GMT+07:00) Novosibirsk </option>
                        <option value="Asia/Bangkok">(GMT+07:00) Bangkok </option>
                        <option value="Asia/Jakarta">(GMT+07:00) Jakarta </option>
                        <option value="Asia/Krasnoyarsk">(GMT+08:00) Krasnoyarsk </option>
                        <option value="Asia/Chongqing">(GMT+08:00) Chongqing </option>
                        <option value="Asia/Hong_Kong">(GMT+08:00) Hong Kong </option>
                        <option value="Asia/Kuala_Lumpur">(GMT+08:00) Kuala Lumpur </option>
                        <option value="Australia/Perth">(GMT+08:00) Perth </option>
                        <option value="Asia/Singapore">(GMT+08:00) Singapore </option>
                        <option value="Asia/Taipei">(GMT+08:00) Taipei </option>
                        <option value="Asia/Ulaanbaatar">(GMT+08:00) Ulaan Bataar </option>
                        <option value="Asia/Urumqi">(GMT+08:00) Urumqi </option>
                        <option value="Asia/Irkutsk">(GMT+09:00) Irkutsk </option>
                        <option value="Asia/Seoul">(GMT+09:00) Seoul </option>
                        <option value="Asia/Tokyo">(GMT+09:00) Tokyo </option>
                        <option value="Australia/Adelaide">(GMT+09:30) Adelaide </option>
                        <option value="Australia/Darwin">(GMT+09:30) Darwin </option>
                        <option value="Asia/Yakutsk">(GMT+10:00) Yakutsk </option>
                        <option value="Australia/Brisbane">(GMT+10:00) Brisbane </option>
                        <option value="Australia/Canberra">(GMT+10:00) Canberra </option>
                        <option value="Pacific/Guam">(GMT+10:00) Guam </option>
                        <option value="Australia/Hobart">(GMT+10:00) Hobart </option>
                        <option value="Australia/Melbourne">(GMT+10:00) Melbourne </option>
                        <option value="Pacific/Port_Moresby">(GMT+10:00) Port Moresby </option>
                        <option value="Australia/Sydney">(GMT+10:00) Sydney </option>
                        <option value="Asia/Vladivostok">(GMT+11:00) Vladivostok </option>
                        <option value="Asia/Magadan">(GMT+12:00) Magadan </option>
                        <option value="Pacific/Auckland">(GMT+12:00) Auckland </option>
                        <option value="Pacific/Fiji">(GMT+12:00) Fiji </option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                      <label class="col-md-2 control-label">Language</label>
                      <div class="col-md-10">
                        <select class="form-control" id="language" name="language">
                          <option value="en">English</option>
                          <option value="fr">French</option>
                          <option value="de">German</option>
                          <option value="es">Español</option>
                        </select>
                      </div>
                  </div>
                </div>
              </div>
              
              <div class="panel panel-primary">
                  <div class="panel-heading">
                       <h3 class="panel-title">Database Settings</h3>
                  </div>
                  <div class="panel-body">
                      <div class="form-group">
                        <label class="col-md-2 control-label">Database Host <span class="required">*</span></label>
                        <div class="col-md-10">
                          <input type="text" name="db_host" value="localhost" id="db_host" required="required" class="form-control" placeholder="Enter Database Host" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-2 control-label">Database Name <span class="required">*</span></label>
                        <div class="col-md-10">
                          <input type="text" name="db_name" id="db_name" required="required" class="form-control" placeholder="Enter Database Name" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-2 control-label">Database Username <span class="required">*</span></label>
                        <div class="col-md-10">
                          <input type="text" name="db_username" id="db_username" required="required" class="form-control" placeholder="Enter Database Username" />
                        </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-2 control-label">Database Password</label>
                          <div class="col-md-10">
                            <input type="password" name="db_password" id="db_password" class="form-control" placeholder="Enter Database Password" />
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-2 control-label">Table Prefix</label>
                          <div class="col-md-10">
                            <input  type="text" name="tables_prefix" id="tables_prefix" value="mc_" class="form-control" placeholder="Enter Tables Prefix" />
                          </div>
                      </div>
                  </div>
              </div>

              <div style="padding: 20px">
                <input type="hidden" id="server_ip" name="server_ip" value="<?php echo $_SERVER['SERVER_ADDR'] ?>">
                <button type="button" class="btn btn-success" id="btn-install" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Install">Install</button>
                <span id="msg" class="text-red"></span>
              </div>
            </div>
          </form>
        </div>
        <div id="step2" style="display: none;">
          <div class="panel panel-success">
              <div class="panel-heading">
                 <h3 class="panel-title">Congratulation!!!</h3>
              </div>
              <div class="panel-body">
                <div class="form-group">
                  <label class="col-md-12 control-label">
                    <h3>MailCarry has been successfully installed!</h3><br/>
                    Now you will need to setup the following cron job:
                    <div id="cronjob" class="text-green"></div>
                    <h4 style="padding-top: 20px;"><a id="login" href="">Login to Application</a></h4>
                  </label>
                </div>
              </div>
            </div>
        </div>
    </div>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
  <div class="pull-right">
    <b>Version</b> 2.5.1
  </div>
  <strong><?php echo date('Y') ?> &copy; MailCarry</strong>
</footer>
</div>
<!-- ./wrapper -->
<script src="../public/components/jquery/dist/jquery.min.js"></script>
<script src="../public/components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../public/components/sweetalert/sweetalert.min.js"></script>
<script src="../public/js/adminlte.min.js"></script>
<script src="install.js"></script>
</body>
</html>
