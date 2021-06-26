<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\WebformRequest;
use App\Notifications\ContactAdded;
use App\Models\Webform;
use Auth;
use Helper;

class WebformController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('web_forms'); // check user permission
    $page = 'layouts_webforms'; // choose sidebar menu option
    return view('webforms.index')->with(compact('page'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getWebforms(Request $request)
  {
    $result = Webform::select('id', 'name', 'created_at')
      ->whereAppId(Auth::user()->app_id);

    $columns = ['id', 'id', 'name', 'created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $webforms = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($webforms as $webform) {
      $checkbox = "<input type=\"checkbox\" value=\"{$webform->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions.= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('webform.show', ['id' => $webform->id]).'\')"><i class="fa fa-eye"></i>'.__('app.view').'</a></li>';
      $actions.= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('webform.edit', ['id' => $webform->id]).'\')"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
      $actions.= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('webform.show', ['id' => $webform->id, 'get_html' => 1]).'\')"><i class="fa fa-code"></i>'.__('app.webform_get_html').'</a></li>';
      $actions .= '<li><a href="'.route('webform.copy', ['id' => $webform->id]).'"><i class="fa fa-copy"></i>'.__('app.make_a_copy').'</a></li>';
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$webform->id.'\', \''.route('webform.destroy', ['id' => $webform->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul></div>';
      $data['data'][] = [
        "DT_RowId" => "row_{$webform->id}",
        $checkbox,
        $webform->id,
        $webform->name,
        Helper::datetimeDisplay($webform->created_at),
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
    Helper::checkPermissions('web_forms'); // check user permission
    return view('webforms.create');
  }

  /**
   * Save data
  */
  public function store(WebformRequest $request)
  {

    $data = $this->webformData($request);
    Webform::create($data);
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.webform') . " ({$request->name}) ". __('app.log_create')); // log
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('web_forms'); // check user permission
    $webform = Webform::whereId($id)->app()->first();
    return view('webforms.edit')->with(compact('webform'));
  }

  /**
   * Update data
  */
  public function update(WebformRequest $request, $id)
  {

    $webform = Webform::findOrFail($id);
    $data = $this->webformData($request);
    $webform->fill($data)->save();
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.webform') . " ({$request->name}) ". __('app.log_update')); // log
  }

  /**
   * Retrun data for store or update
  */
  public function webformData($request)
  {
    $input = $request->except('_token');
    if(!empty($input['custom_fields'])) {
      $input['custom_field_ids'] = implode(',', $input['custom_fields']);
    }
    $input['attributes'] = json_encode($input);
    $input['user_id'] = Auth::user()->id;
    $input['app_id'] = Auth::user()->app_id;
    return $input;
  }

  /**
   * Delete one or more
  */
  public function destroy($id, Request $request)
  {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $names = json_encode(array_values(Webform::whereIn('id', $ids)->pluck('name')->toArray()));
      $destroy = Webform::whereIn('id', $ids)->delete();
    } else {
      $names = Webform::whereId($id)->value('name');
      $destroy = Webform::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.webform') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }

  /**
   * Return webform view
  */
  public function show($id, $get_html=0)
  {
    Helper::checkPermissions('web_forms'); // check user permission
    $webform = Webform::whereId($id)->app()->first();
    $custom_fields = explode(',', $webform->custom_field_ids);
    $list = \App\Models\Lists::findOrFail($webform->list_id);
    $list_custom_fields = $list->customFields()->whereIn('custom_fields.id', $custom_fields)->get();
    return view('webforms.show')->with(compact('webform', 'list_custom_fields', 'get_html'));
  }

  /**
   * Retrun index after copy webform
  */
  public function copy($id)
  {
    Helper::checkPermissions('web_forms'); // check user permission
    $webform = Webform::whereId($id)->app()->first();
    $webform->name = $webform->name .' - copy ';
    $webform = $webform->replicate();
    $webform->save();
    activity('copy')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.webform') . " ({$webform->name}) ". __('app.log_copy')); // log
    session()->flash('msg', trans('app.msg_successfully_copied'));
    return redirect(route('webforms.index'));
  }

  /**
   * Retrun respecitve page after store webform data
  */
  public function saveWebFormData(Request $request) {

    if ($request->isMethod('post')) {
      $webform = Webform::whereId($request->form_id)->with('list')->first();
      $attributes = json_decode($webform->attributes);
      $custom_url = null;
      if($webform->list->double_optin == 'Yes') {
        $input['confirmed'] = 'No';
        $subscriber_page = 'confirm';
        $subscriber_email = 'confirm-email-webform';

        if($attributes->confirmation_page_option == 'custom') {
          $custom_url =  $attributes->confirmation_page_custom_url;
        }
      } else {
        $input['confirmed'] = 'Yes';
        $subscriber_page = 'thankyou';
        $subscriber_email = 'welcome-email';
        if($attributes->thankyou_page_option == 'custom') {
          $custom_url =  $attributes->thankyou_page_custom_url;
        }
      }
      $input = $request->all();
      $input['user_id'] = $webform->user_id;
      $input['app_id'] = $webform->app_id;
      $input['list_id'] = $webform->list_id;
      $input['format'] = 'HTML';
      $input['active'] = 'Yes';
      $input['unsubscribed'] = 'No';
      $input['source'] = 'form';

      $contact = \App\Models\Contact::whereEmail($input['email'])->whereListId($input['list_id'])->select('id')->with('customFields')->first();
      if(!empty($contact->id)) {
        if($webform->duplicates == 'Overwrite') {
          \DB::table('custom_field_contact')->whereContactId($contact->id)->delete();
          app('App\Http\Controllers\ContactController')->contactCustomData($contact->id, $input);
        }
      } else {
        $contact = \App\Models\Contact::create($input);
        app('App\Http\Controllers\ContactController')->contactCustomData($contact->id, $input);
      }

      if($webform->list->welcome_email == 'Yes' || $webform->list->double_optin == 'Yes') {
        // send email to subscriber and notifiy to list admin
        $contact->notify(new ContactAdded($subscriber_email, 'webform', 'notify-email-contact-added'));
        \Artisan::call('queue:work', ['--once' => true]); // execute queue
      }

      if(!empty($custom_url)) {
        return redirect($custom_url);
      } else {
        // display page as per list settings opt-in
        return redirect()->route('page.show', ['slug' => $subscriber_page, 'id' => base64_encode($contact->id)]);
      }
    } else {
      return response()->json(['success' => 'success'], 200);
    }
  }
}
