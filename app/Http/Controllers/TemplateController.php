<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use Auth;
use Helper;

class TemplateController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('templates'); // check user permission
    $page = 'layouts_templates'; // choose sidebar menu option
    return view('templates.index')->with(compact('page'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getTemplates(Request $request)
  {
    $result = Template::select('id', 'name', 'created_at')
      ->whereAppId(Auth::user()->app_id);

    $columns = ['id', 'id', 'name', 'created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $templates = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($templates as $template) {
      $checkbox = "<input type=\"checkbox\" value=\"{$template->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions.= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('template.show', ['id' => $template->id]).'\')"><i class="fa fa-eye"></i>'.__('app.view').'</a></li>';
      $actions .= '<li><a href="'.route('template.edit', ['id' => $template->id]).'"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
      $actions .= '<li><a href="'.route('broadcast.create', ['tid' => base64_encode($template->id)]).'"><i class="fa fa-copy"></i>'.__('app.template_create_broadcast').'</a></li>';
      $actions .= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('send.email', ['broadcast_id' => 0, 'sending_server_id' => 0, 'template_id' => $template->id]).'\')"><i class="fa fa-send-o"></i>'.__('app.send_test_email').'</a></li>';
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$template->id.'\', \''.route('template.destroy', ['id' => $template->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul>
        </div>';
      $data['data'][] = [
        "DT_RowId" => "row_{$template->id}",
        $checkbox,
        $template->id,
        '<a href="javascript:;" onclick="viewModal(\'modal\', \''.route('template.show', ['id' => $template->id]).'\')">'.$template->name.'</a>',
        Helper::datetimeDisplay($template->created_at),
        $actions
      ];
    }
    echo json_encode($data);
  }

  /**
   * Retrun create view
  */
  public function create()
  {
    Helper::checkPermissions('templates'); // check user permission
    $action = 'create';
    $id = 0;
    $page = 'layouts_templates'; // choose sidebar menu option
    if(\Input::get('t') == 1)
      return view('templates.create')->with(compact('id', 'action', 'page'));
    elseif(\Input::get('t') == 2)
      return view('templates.create_2')->with(compact('id', 'action', 'page'));
    else
      return view('templates.create_3')->with(compact('id', 'action', 'page'));
  }

  /**
   * Save / Update data
  */
  public function save(Request $request)
  {
    $request->validate([
      'name' => 'required',
    ]);
    $input = $request->all();
    $sanitizer = new \Phlib\XssSanitizer\Sanitizer();
    $input['content'] = !empty($input['content']) ? Helper::XSSReplaceTags($sanitizer->sanitize($input['content'])) : Helper::XSSReplaceTags($sanitizer->sanitize($input['content_html']));
    if($input['action'] == 'create') {
       $input['user_id'] = Auth::user()->id;
       $input['app_id'] = Auth::user()->app_id;
       $template = Template::create($input);
       activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.template') . " ({$request->name}) ". __('app.log_create')); // log
       return $template->id;
    } elseif($input['action'] == 'edit') {
      $template = Template::findOrFail($input['id']);
      $input['user_id'] = Auth::user()->id;
      $input['app_id'] = Auth::user()->app_id;
      $template->fill($input)->save();
      activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.template') . " ({$request->name}) ". __('app.log_update')); // log
      return $input['id'];
    }
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('templates'); // check user permission
    $action = 'edit';
    $page = 'layouts_templates'; // choose sidebar menu option
    $template = Template::whereId($id)->app()->first();
    if($template->type == 1)
      return view('templates.create')->with(compact('id', 'action', 'page'));
    elseif(\Input::get('t') == 2)
      return view('templates.create_2')->with(compact('id', 'action', 'page'));
    else
      return view('templates.create_3')->with(compact('id', 'action', 'page', 'template'));
  }

  /**
   * Retrun template view
  */
  public function show($id)
  {
    Helper::checkPermissions('templates'); // check user permission
    $template = Template::whereId($id)->app()->first();
    return view('templates.view')->with(compact('template'));
  }

  /**
   * Retrun HTML data of a template
  */
  public function getHTMLContent($id) {
    return Template::whereId($id)->app()->value('content');
  }

  /**
   * Delete one or more
  */
  public function destroy($id, Request $request)
  {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $names = json_encode(array_values(Template::whereIn('id', $ids)->pluck('name')->toArray()));
      $destroy = Template::whereIn('id', $ids)->delete();
    } else {
      $names = Template::whereId($id)->value('name');
      $destroy = Template::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.template') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }

  /**
   * Return MailCarry campaign builder for create or edit
  */
  function getMCBuilder() {
    Helper::checkPermissions('templates'); // check user permission
    $action = \Input::get('action');
    $id = \Input::get('id');
    if($id == 0) {
      $name = $html = '';
    } else {
      $template = Template::whereId($id)->app()->first();
      $name = $template->name;
      $html = Helper::extractHtmlTagContents('body', Helper::XSSReplaceTags(Helper::decodeString($template->content)));
    }
    return view('templates.mc_builder')->with(compact('id', 'action', 'name', 'html'));
  }

  /**
   * Return MailCarry campaign builder 2 for create
  */
  function getMCBuilder2() {
    Helper::checkPermissions('templates'); // check user permission
    $action = \Input::get('action');
    $id = \Input::get('id');
    if($id == 0) {
      $name = $html = '';
    } else {
      $template = Template::whereId($id)->app()->first();
      $name = $template->name;
      $html = Helper::XSSReplaceTags(Helper::decodeString($template->content));
    }
    return view('templates.mc_builder_2')->with(compact('id', 'action', 'name', 'html'));;
  }
}
