<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Notifications\ContactAdded;
use App\Models\Contact;
use Auth;
use Helper;

class ContactController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('contacts'); // check user permission
    $list_id = !empty(\Input::get('list_id')) ? \Input::get('list_id') : 0;
    $list_name = !empty($list_id) ? \App\Models\Lists::whereId($list_id)->value('name') : null;
    $page = 'contact_view_all'; // choose sidebar menu option
    return view('contacts.index')->with(compact('page', 'list_id', 'list_name'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getContacts(Request $request) {
    $result = Contact::select('contacts.*')
      ->whereAppId(Auth::user()->app_id);

    if($request->list_id) {
      $result->whereListId($request->list_id);
    }
    $columns = ['id', 'id', 'email', 'id', 'format', 'active', 'confirmed', 'unsubscribed', 'created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $contacts = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($contacts as $contact) {
      $checkbox = "<input type=\"checkbox\" value=\"{$contact->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions.= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('contact.show', ['id' => $contact->id]).'\')"><i class="fa fa-eye"></i>'.__('app.view').'</a></li>';
      $actions .= '<li><a href="'.route('contact.edit', ['id' => $contact->id]).'"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$contact->id.'\', \''.route('contact.destroy', ['id' => $contact->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul>
        </div>';

      $list_name = !empty($contact->list->name) ? '<a href="javascript:;" onclick="viewModal(\'modal\', \''.route('list.show', ['id' => $contact->list->id]).'\')">'.$contact->list->name.'</a>' : '---';

      $data['data'][] = [
        "DT_RowId" => "row_{$contact->id}",
        $checkbox,
        '<a href="javascript:;" onclick="viewModal(\'modal\', \''.route('contact.show', ['id' => $contact->id]).'\')">'.$contact->id.'</a>',
        $contact->email,
        $list_name,
        $contact->format,
        $contact->active,
        $contact->confirmed,
        $contact->verified,
        $contact->unsubscribed,
        Helper::datetimeDisplay($contact->created_at),
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
    if(!Helper::allowedLimit(Auth::user()->app_id, 'no_of_recipients', 'contacts')) {
      return view('errors.not_allowed')->with('module', __('app.contacts'));
    }
    Helper::checkPermissions('contacts'); // check user permission
    $page = 'contact_add_new';
    $list_id = !empty(\Input::get('list_id')) ? \Input::get('list_id') : 0; // will use when add contact from list dropdown
    return view('contacts.create')->with(compact('page', 'list_id'));
  }

  /**
   * Save data
  */
  public function store(ContactRequest $request)
  {
    if(!Helper::allowedLimit(Auth::user()->app_id, 'no_of_recipients', 'contacts')) {
      return false;
    }
    $data = $this->contactData($request);
    $contact = Contact::create($data);
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.contact') . " ({$contact->email}) ". __('app.log_create')); // log
    $this->contactCustomData($contact->id, $data);

    if($data['confirmed'] == 'Yes') {
      // send email to subscriber and notifiy to list admin
      $subscriber_email = $contact->list->double_optin == 'Yes' ? 'confirm-email-app' : 'welcome-email';
      $contact->notify(new ContactAdded($subscriber_email, 'app', 'notify-email-contact-added'));
      \Artisan::call('queue:work', ['--once' => true]); // execute queue
    }
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('contacts'); // check user permission
    $contact = Contact::whereId($id)->app()->first();
    $page = 'contact_add_new';
    return view('contacts.edit')->with(compact('page', 'contact'));
  }

  /**
   * Update data
  */
  public function update(ContactRequest $request, $id)
  {

    $contact = Contact::findOrFail($id);
    $data = $this->contactData($request);

    if($data['bounced'] == 'No') {
      // Remove bounced data if exist
      \App\Models\ScheduleCampaignStatLogBounce::whereEmail($data['email'])->delete();
    } else {
      // Add bounced data
      $bounce_data = [
        'schedule_campaign_stat_log_id' => 0,
        'section' => 'Campaign',
        'email'  => $data['email'],
        'code'   => '---',
        'type'   => 'hard',
        'detail' => json_encode(['short_detail' => '---', 'full_detail' => '---' ] ),
        'created_at' => \Carbon\Carbon::now(),
      ];
      \App\Models\ScheduleCampaignStatLogBounce::create($bounce_data);
    }
    $contact->fill($data)->save();
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.contact') . " ({$contact->email}) ". __('app.log_update')); // log

    \DB::table('custom_field_contact')->whereContactId($contact->id)->delete();
    $this->contactCustomData($contact->id, $data);
  }

  /**
   * Retrun data for store or update
  */
  public function contactData($request)
  {
    $input = $request->except('_token');
    $input['user_id'] = !empty($input['user_id']) ? $input['user_id'] : Auth::user()->id; // data can come from webform
    $input['app_id'] = !empty($input['app_id']) ? $input['app_id'] : Auth::user()->app_id; // data can come from webform
    $input['format'] = !empty($input['format']) ? 'HTML' : 'Text';
    $input['active'] = !empty($input['active']) ? 'Yes' : 'No';
    $input['unsubscribed'] = !empty($input['unsubscribed']) ? 'No' : 'Yes';
    $input['confirmed'] = !empty($input['confirmed']) ? 'Yes' : 'No';
    $input['verified'] = !empty($input['verified']) ? 'Yes' : 'No';
    $input['bounced'] = !empty($input['bounced']) ? 'Yes' : 'No';
    return $input;
  }

  /**
   * Retrun contact custom data
  */
  public function contactCustomData($contact_id, $input)
  {
    if(!empty($input['custom_fields'])) {
      foreach($input['custom_fields'] as $custom_field_id => $data) {
        $data = is_array($data) ? implode('||', $data) : $data ;
        if(!empty($data)) {
          \DB::table('custom_field_contact')->insert([
            'contact_id' => $contact_id,
            'custom_field_id' => $custom_field_id,
            'data' => $data
          ]);
        }
      }
    }
  }

  /**
   * Retrun contact view
  */
  public function show($id)
  {
    $contact = Contact::with('customFields')->whereId($id)->app()->first();
    return view('contacts.view')->with(compact('contact'));
  }

  /**
   * Delete one or more
  */
  public function destroy($id, Request $request)
  {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $emails = json_encode(array_values(Contact::whereIn('id', $ids)->pluck('email')->toArray()));
      $destroy = Contact::whereIn('id', $ids)->delete();
    } else {
      $emails = Contact::whereId($id)->value('email');
      $destroy = Contact::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.contact') . " ({$emails}) ". __('app.log_delete')); // log
    return $destroy;
  }

  /**
   * Retrun custom fields associate with the list
  */
  public function getListsCustomFields(Request $request)
  {
    $list_id = $request->list_id;
    $contact_data = [];

    if(!empty($request->contact_id)) {
      $contact_custom_data = \DB::table('custom_field_contact')->whereContactId($request->contact_id)->get();
      foreach($contact_custom_data as $data) {
        $contact_data[$data->custom_field_id] = $data->data;
      }
    }

    $list = \App\Models\Lists::findOrFail($list_id);
    $list_custom_fields = $list->customFields()->get();
    if(!empty($request->view)) {
      $custom_field_ids = !empty($request->custom_field_ids) ? $request->custom_field_ids : null;
      return view('contacts.'.$request->view)->with(compact('list_custom_fields', 'contact_data', 'custom_field_ids'));
    }
    return view('contacts.list_custom_fields')->with(compact('list_custom_fields', 'contact_data'));
  }

  /**
   * Export contacts for a list
  */
  public function contactsExport($list_id, $field=null, Request $request)
  {
    Helper::checkPermissions('import_contacts'); // check user permission

    if(!empty($field) && $field == 'show_modal') {
      $list = \App\Models\Lists::findOrFail($list_id);
      return view('contacts.export')->with(compact('list'));
    }
    
    if($request->isMethod('post')) {
      $field = 'options';
      print_r($request->all());
      foreach($request->options as $option) {
        $field .= "_{$option}";
      }
    }

    \App\Jobs\ListExport::dispatch($list_id, Auth::user()->id, $field)
      ->delay(now()->addSeconds(10));
    \Artisan::call('queue:work', ['--once' => true]); // execute queue

    // save activity log
    $list = \App\Models\Lists::findOrFail($list_id);
    activity('export')->withProperties(['app_id' => $list->app_id])->log(__('app.list') . " ({$list->name}) ". __('app.log_export')); // log

  }

  /**
   * Import contact into a list
  */
  public function contactsImport(Request $request, $list_id)
  {
    Helper::checkPermissions('import_contacts'); // check user permission
    if($request->isMethod('post')) {
      if(!empty($request->fieldMapping)) {
        $path_import_list = str_replace('[user-id]', Auth::user()->id, config('mc.path_import_list'));
        $file = $path_import_list.$request->list_id.'-header.csv';
        $file_header = Helper::getCsvFileHeader($file);
        $list = \App\Models\Lists::findOrFail($request->list_id);
        $list_custom_fields = $list->customFields()->pluck('name', 'custom_field_id');

        $drop_down = '<select name="custom_fields[]" class="form-control">';
        $drop_down .= "<option value='none'></option>";
        $drop_down .= "<option value='email'>Email</option>";
        foreach($list_custom_fields as $custom_filed_id => $custom_field_name) {
          $drop_down .= "<option value='{$custom_filed_id}'>{$custom_field_name}</option>";
        }
        $drop_down .= '</select>';

        $string = '';
        foreach($file_header as $header) {
          $string .= "<div class='form-group'>
              <label class='col-md-2 control-label'>{$header}</label>
              <div class='col-md-6'>{$drop_down}</div>
            </div>";
        }
        return $string;
      } elseif($request->do_import) {
        $path_import_list = str_replace('[user-id]', Auth::user()->id, config('mc.path_import_list'));
        $file_name = md5(uniqid()).'.csv';
        $file = $request->file('file');
        $attributes = $request->except('_token', 'file', 'do_import');

        $attributes['format'] = !empty($attributes['format']) ? 'HTML' : 'Text';
        $attributes['active'] = !empty($attributes['active']) ? 'Yes' : 'No';
        $attributes['unsubscribed'] = !empty($attributes['unsubscribed']) ? 'No' : 'Yes';
        $attributes['confirmed'] = !empty($attributes['confirmed']) ? 'Yes' : 'No';

        $contact_import = \App\Models\Import::create([
          'type' => 'contact',
          'file' => $path_import_list.$file_name,
          'attributes' => json_encode($attributes),
          'total' => Helper::getCsvCount($file),
          'user_id' => Auth::user()->id,
          'app_id' => Auth::user()->app_id
        ]);

        try{
          $file->move($path_import_list, $file_name); // save original file to import
          
          \App\Jobs\ListImport::dispatch($contact_import->id, Auth::user()->id)
            ->delay(now()->addSeconds(10));
          \Artisan::call('queue:work', ['--once' => true]); // execute queue

          // save activity log
          $list = \App\Models\Lists::findOrFail($request->list_id);
          activity('import')->withProperties(['app_id' => $list->app_id])->log(__('app.list') . " ({$list->name}) ". __('app.log_import')); // log

          unlink($path_import_list.$request->list_id.'-header.csv'); // delete header file
        } catch(\Exception $e) {
          // nothing
        }
        return $contact_import->id;
      } else {
        $request->validate([
          'list_id' => 'required|integer',
          'file' => 'required|mimes:csv,txt|max:'.Helper::getMaxFileSizeMB()
        ]);
        $file = $request->file('file');
        //echo $file->originalName();
        $header = Helper::getCsvFileHeader($file);
        $path_import_list = str_replace('[user-id]', Auth::user()->id, config('mc.path_import_list'));
        Helper::dirCreateOrExist($path_import_list); // create dir if not exist
        $file = $path_import_list.$request->list_id.'-header.csv';
        $writer = \League\Csv\Writer::createFromPath($file, 'w'); // create a .csv file to write data
        $writer->insertOne($header); // write file header
      }
    } else {
      $page = 'contact_import';
      return view('contacts.import')->with(compact('page', 'list_id'));
    }
  }

  /**
   * Return status for the import progress
  */
  public function contactsImportStatus($id)
  {
    return \App\Models\Import::select('total', 'processed', 'duplicates', 'invalids', 'suppressed', 'bounced')->whereId($id)->first()->toJson();
  }

  /**
   * Return respective page after contact is confirmed
  */
  public function confirm($id)
  {
    $id = base64_decode($id);
    $contact = Contact::findOrFail($id);

    // If user tries to access the link again then no need to confirm again or send email.
    if($contact->confirmed == 'No') {
      $contact->fill(['confirmed' => 'Yes'])->save(); // update contact data

      // send email to subscriber and notifiy to list admin
      $contact->notify(new ContactAdded('welcome-email', 'confirm', 'notify-email-contact-confirm'));
      \Artisan::call('queue:work', ['--once' => true]); // execute queue
      activity('confirm')->withProperties(['app_id' => $contact->app_id])->log(__('app.contact') . " ({$contact->email}) ". __('app.log_confirm')); // log
    }
    
    return redirect()->route('page.show', ['slug' => 'thankyou', 'id' => base64_encode($id)]);
  }

  /**
   * Return respective page after contact is unsubscribed
  */
  public function unsub($id)
  {
    $id = base64_decode($id);
    $contact = Contact::findOrFail($id);
    $contact->fill(['unsubscribed' => 'Yes'])->save(); // update contact data

    // If unsubscribed once no need to send other email if click twice
    if($contact->unsubscribed == 'No') {
      // send email to subscriber and notifiy to list admin
      $contact->notify(new ContactAdded('unsub-email', 'unsub', 'notify-email-contact-unsub'));
      \Artisan::call('queue:work', ['--once' => true]); // execute queue
    }

    activity('unsub')->withProperties(['app_id' => $contact->app_id])->log(__('app.contact') . " ({$contact->email}) ". __('app.log_unsub')); // log
    return redirect()->route('page.show', ['slug' => 'unsub', 'id' => base64_encode($id)]);
  }
}
