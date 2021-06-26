<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ListRequest;
use App\Models\Lists;
use App\Models\Contact;
use Auth;
use Helper;
use League\Csv\Writer;

class ListController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('lists'); // check user permission
    $groups = \App\Models\Group::groups(config('mc.groups.lists'));
    $page = 'list_view_all'; // choose sidebar menu option
    return view('lists.index')->with(compact('page', 'groups'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getLists(Request $request)
  {
    $result = Lists::join('groups', 'groups.id', '=', 'lists.group_id')
      ->select('lists.id', 'lists.name as name', 'lists.created_at', 'groups.id as group_id', 'groups.name as group_name')
      ->where('lists.app_id', Auth::user()->app_id)
      ->withCount('contacts');

    // error occured while search contacts_count
    if(!empty($request->get('search')['value'])) {
      $columns = ['lists.id', 'lists.id', 'lists.name', 'groups.name', 'lists.created_at'];
    } else {
      $columns = ['lists.id', 'lists.id', 'lists.name', 'groups.name', 'contacts_count', 'lists.created_at'];
    }

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $lists = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($lists as $list) {
      $checkbox = "<input type=\"checkbox\" value=\"{$list->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions.= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('list.show', ['id' => $list->id]).'\')"><i class="fa fa-eye"></i>'.__('app.view').'</a></li>';
      $actions .= '<li><a href="'.route('list.edit', ['id' => $list->id]).'"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
      $actions .= '<li><a href="'.route('contact.create', ['list_id' => $list->id]).'"><i class="fa fa-user-plus"></i>'.__('app.add_contact').'</a></li>';
      if(Auth::user()->can('export_contacts')) {
        $actions .= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('contacts.export', ['list_id' => $list->id, 'show_modal']).'\', \''.__('app.msg_export_list').'\')"><i class="fa fa-upload"></i>'.__('app.export_contacts').'</a></li>';
      }
      if(Auth::user()->can('import_contacts')) {
        $actions .= '<li><a href="'.route('contacts.import', ['list_id' => $list->id]).'"><i class="fa fa-download"></i>'.__('app.import_contacts').'</a></li>';
      }
      if(Auth::user()->can('email_verifiers')) {
        $actions .= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('verify.email.list').'\')"><i class="fa fa-check"></i>'.__('app.verify_list').'</a></li>';
      }
      $actions .= '<li><a href="'.route('list.copy', ['id' => $list->id]).'"><i class="fa fa-copy"></i>'.__('app.make_a_copy').'</a></li>';
      $actions .= '<li><a href="javascript:;" onclick="move(\''.$list->id.'\', \''.htmlentities($list->name).'\')"><i class="fa fa-arrows"></i>'.__('app.move').'</a></li>';
      $actions .= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('list.clean', ['id' => $list->id]).'\')"><i class="fa fa-refresh"></i>'.__('app.list_clean').'</a></li>';
      if(Auth::user()->can('split')){
        $actions .= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('list.split', ['id' => $list->id]).'\')"><i class="fa fa-th-large"></i>'.__('app.list_split').'</a></li>';
      }
      $actions .= '<li><a href="javascript:;" onclick="emptyList(\''.$list->id.'\', \''.route('list.empty', ['id' => $list->id]).'\', \''.__('app.msg_list_empty').'\')"><i class="fa fa-user-times"></i>'.__('app.empty').'</a></li>';
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$list->id.'\', \''.route('list.destroy', ['id' => $list->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul></div>';

      $group_name = "<span id='{$list->group_id}'>$list->group_name<span>";
      $contacts = "<a href='".route('contacts.index', ['list_id' => $list->id])."'>{$list->contacts_count}</a>";
      $data['data'][] = [
        "DT_RowId" => "row_{$list->id}",
        $checkbox,
        '<a href="javascript:;" onclick="viewModal(\'modal\', \''.route('list.show', ['id' => $list->id]).'\')">'.$list->id.'</a>',
        $list->name,
        $group_name,
        $contacts,
        Helper::datetimeDisplay($list->created_at),
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
    Helper::checkPermissions('lists'); // check user permission
    $groups = \App\Models\Group::groups(config('mc.groups.lists'));
    $custom_fields = \App\Models\CustomField::customFields();
    $emails = \App\Models\Page::emails();
    $page = 'list_add_new'; // choose sidebar menu option
    return view('lists.create')->with(compact('page', 'groups', 'custom_fields', 'emails'));
  }

  /**
   * Save data
  */
  public function store(ListRequest $request)
  {
    $data = $this->listData($request);
    $list = Lists::create($data);

    if(!empty($data['custom_fields'])) {
      $custom_field_ids = array_values($data['custom_fields']);
      $list->customFields()->attach($custom_field_ids);
    }
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.list') . " ({$request->name}) ". __('app.log_create')); // log
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('lists'); // check user permission
    $list = Lists::whereId($id)->app()->first();
    $list_custom_fields = $list->getCustomFieldId()->toArray();
    $groups = \App\Models\Group::groups(config('mc.groups.lists'));
    $custom_fields = \App\Models\CustomField::customFields();
    $emails = \App\Models\Page::emails();
    $page = 'list_add_new'; // choose sidebar menu option
    return view('lists.edit')->with(compact('page', 'list', 'list_custom_fields', 'groups', 'custom_fields', 'emails'));
  }

  /**
   * Update data
  */
  public function update(ListRequest $request, $id)
  {
    $list = Lists::findOrFail($id);
    $data = $this->listData($request);
    $list->fill($data)->save();

    if(!empty($data['custom_fields'])) {
      $custom_field_ids = array_values($data['custom_fields']);
      $list->customFields()->sync($custom_field_ids);
    }
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.list') . " ({$request->name}) ". __('app.log_update')); // log
  }

  /**
   * Retrun data for store or update
  */
  public function listData($request)
  {
    $input = $request->except('_token');
    $input['notify_criteria'] = !empty($input['notify_criteria']) ? $input['notify_criteria'] : null;
    $input['notification_attributes'] = $input['notification'] == 'Enabled' ? json_encode(['email'=>$input['notify_email'], 'criteria'=>$input['notify_criteria']]) : null;
    $input['attributes'] = json_encode($input);
    $input['user_id'] = Auth::user()->id;
    $input['app_id'] = Auth::user()->app_id;
    return $input;
  }

  /**
   * Retrun list view
  */
  public function show($id)
  {
    $list = Lists::whereId($id)
      ->with('group')
      ->with('customFields')
      ->with('sendingServer')
      ->app()
      ->first();
    return view('lists.view')->with('list', $list);
  }

  /**
   * Delete one or more
  */
  public function destroy($id, Request $request)
  {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $names = json_encode(array_values(Lists::whereIn('id', $ids)->pluck('name')->toArray()));
      $destroy = Lists::whereIn('id', $ids)->delete();
    } else {
      $names = Lists::whereId($id)->value('name');
      $destroy = Lists::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.list') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }

  /**
   * Make empty a list
  */
  public function emtpy($id)
  {
    $empty = \App\Models\Contact::whereListId($id)->forceDelete();
    return $empty;
  }

  /**
   * Split a list
  */
  public function clean($id, Request $request)
  {
    if ($request->isMethod('post')) {
      $request->validate([
        'options' => 'required',
      ]);
      \App\Jobs\ListClean::dispatch($id, Auth::user()->id, $request->options)
        ->delay(now()->addSeconds(10));
      //\Artisan::call('queue:work', ['--once' => true]); // execute queue
    } else {
      $list = Lists::findOrFail($id);
      return view('lists.clean')->with('list', $list);
    }
  }

  /**
   * Split a list
  */
  public function split($id, Request $request)
  {
    Helper::checkPermissions('split'); // check user permission
    if ($request->isMethod('post')) {
      $request->validate([
        'no_of_lists' => 'required|integer',
      ]);

      if($request->no_of_lists > 0) {
        $list_contacts = \App\Models\Contact::whereListId($id)->count();
        $no_of_lists = $request->no_of_lists;
        $list = Lists::findOrFail($id);
        $list_custom_fields = $list->getCustomFieldId()->toArray();
        $list_name = $list->name;
        $no_of_contacts_per_list = $list_contacts / $no_of_lists;
        for($i=1; $i<$no_of_lists; $i++) {
          // create new list
          $list->name = $list_name." - $i";
          $new_list = $list->replicate();
          $new_list->save();
          $new_list->customFields()->attach($list_custom_fields);
          // move contacts to new list
          \App\Models\Contact::whereListId($id)->limit($no_of_contacts_per_list)->update(['list_id' => $new_list->id]);
        }
        activity('split')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.list') . " ({$list_name}) ". __('app.log_split')); // log
      }
    } else {
      $list = Lists::findOrFail($id);
      return view('lists.split')->with('list', $list);
    }
  }
  
  /**
   * Retrun index after copy list
  */
  public function copy($id)
  {
    $list = Lists::whereId($id)->app()->first();
    $list->name = $list->name .' - copy ';
    $list = $list->replicate();
    $list->save();
    session()->flash('msg', trans('app.msg_successfully_copied'));
    activity('copy')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.list') . " ({$list->name}) ". __('app.log_copy')); // log
    return redirect(route('lists.index'));
  }

  /**
   * Bulk update list contacts
  */
  public function bulkUpdate(Request $request)
  {
    if($request->isMethod('post')) {
      //$input['list_ids'] = $request->based_on == 'list' ? $request->list_ids : null;
      switch($request->action) {
        case 'active':
          $value = 'active';
          $status = 'Yes';
          break;
        case 'inactive':
          $value = 'active';
          $status = 'No';
          break;
        case 'confirmed':
          $value = 'confirmed';
          $status = 'Yes';
          break;
        case 'unconfirmed':
          $value = 'confirmed';
          $status = 'No';
          break;
        case 'subscribed':
          $value = 'unsubscribed';
          $status = 'No';
          break;
        case 'unsubscribed':
          $value = 'unsubscribed';
          $status = 'Yes';
          break;
        case 'verified':
          $value = 'verified';
          $status = 'Yes';
          break;
        case 'inactive':
          $value = 'verified';
          $status = 'No';
          break;
        case 'HTML':
          $value = 'format';
          $status = 'HTML';
          break;
        case 'Text':
          $value = 'format';
          $status = 'Text';
          break;
      }

      if($request->based_on == 'global') {
        if($request->option == 'write') {
          $request->validate([
            'emails' => 'required'
          ]);
          $emails = Helper::splitLineBreakWithComma($request->emails);
          foreach($emails as $email) {
            Contact::whereEmail(trim($email))->update([$value => $status]);
          }
        } else {
          $request->validate([
            'file' => 'required|mimes:csv,txt|max:'.Helper::getMaxFileSizeMB()
          ]);
          $file = $request->file('file');
          $reader = \League\Csv\Reader::createFromPath($file->getPathName(), 'r');
          $records = $reader->getRecords();
          foreach ($records as $offset => $record) {
            Contact::whereEmail(trim($record[0]))->update([$value => $status]);
          }
        }
      } else {
        $request->validate([
            'list_ids' => 'required'
          ]);
        Contact::whereIn('list_id', $request->list_ids)->update([$value => $status]);
      }
      die;
    }
    return view('lists.bulk_update');
  }
}
