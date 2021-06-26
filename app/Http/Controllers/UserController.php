<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Auth;
use Helper;

class UserController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('users'); // check user permission
    $page = 'user_management_users'; // choose sidebar menu option
    return view('users.index')->with(compact('page'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getUsers(Request $request)
  {
    $result = User::leftJoin('roles', 'users.role_id', '=', 'roles.id')
      ->select('users.id', 'users.name as name', 'roles.name as role_name', 'users.email', 'users.country_code', 'users.active', 'users.created_at')
      ->where('users.app_id', Auth::user()->app_id)
      ->where('users.is_client', 0)
      ->where('users.id', '<>', config('mc.superadmin')); // avoid to get superadmin as came with installation
    
    $columns = ['users.id', 'users.name', 'roles.name', 'users.email', 'users.country_code', 'users.active', 'users.created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $users = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($users as $user) {
      $checkbox = "<input type=\"checkbox\" value=\"{$user->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions.= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('user.show', ['id' => $user->id]).'\')"><i class="fa fa-eye"></i>'.__('app.view').'</a></li>';
      $actions .= '<li><a href="'.route('user.edit', ['id' => $user->id]).'"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
      $actions .= '<li><a href="'.route('user.impersonate', ['id' => $user->id]).'"><i class="fa fa-user-o"></i>'.__('app.impersonate').'</a></li>';
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$user->id.'\', \''.route('user.destroy', ['id' => $user->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul>
        </div>';
      $data['data'][] = [
        "DT_RowId" => "row_{$user->id}",
        $checkbox,
        $user->name,
        $user->role_name ?? 'Undefined',
        $user->email,
        Helper::countries($user->country_code),
        $user->active,
        Helper::datetimeDisplay($user->created_at),
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
    Helper::checkPermissions('users'); // check user permission
    $roles = Role::where('roles.app_id', Auth::user()->app_id)->get(); // get all roles
    $page = 'user_management_users';
    return view('users.create')->with(compact('page', 'roles'));
  }

  /**
   * Save data
  */
  public function store(UserRequest $request)
  {
    $input = $request->except('_token', 'password_confirmation');
    $input['password'] = bcrypt($input['password']);
    $input['api_token'] = str_random(60);
    $input['app_id'] = Auth::user()->app_id;
    $input['parent_id'] = Auth::user()->id;
    $user = User::create($input);
    $role = Role::whereId($request->role_id)->value('name');
    $user->syncRoles([$role]); // assign role to user
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.user') . " ({$request->name}) ". __('app.log_create')); // log
  }

  /**
   * Retrun user view
  */
  public function show($id)
  {
    Helper::checkPermissions('users'); // check user permission
    $user = User::whereId($id)->where('users.app_id', Auth::user()->app_id)->first();
    return view('users.view')->with('user', $user);
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('users'); // check user permission
    $user = User::whereId($id)->where('users.app_id', Auth::user()->app_id)->first(); // get user detail
    $roles = Role::where('roles.app_id', Auth::user()->app_id)->get(); // get all roles
    $page = 'user_management_users'; // choose sidebar menu option
    $profile = false;
    return view('users.edit')->with(compact('user', 'page', 'roles', 'profile'));
  }

  /**
   * Update data
  */
  public function update(UserRequest $request, $id)
  {
    $user = User::findOrFail($id); // get user detail
    $input = $request->except('_token', '_method', 'password_confirmation');

    if ($request->filled('password')) {
      $input['password'] = bcrypt($input['password']);
    } else {
      $input = array_except($input, ['password']);
    }

    if($id != config('mc.superadmin')) {
      $input['active'] = !empty($request->active) ? 'Yes' : 'No';
    }

    if($user->id == config('mc.superadmin') && $user->email == 'admin@mailcarry.com') {
      $request->validate([
        'email' => 'required|email|string|max:255|unique:users,email,NULL,id,deleted_at,NULL'
      ]);
    }

    $input['user_id'] = Auth::user()->id;
    $input['app_id'] = Auth::user()->app_id;

    $update = $user->fill($input)->save(); // update user data
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.user') . " ({$request->name}) ". __('app.log_update')); // log

    // update role
    if(!empty($request->role_id)) {
      $role = Role::whereId($request->role_id)->value('name'); // get role name
      $user->syncRoles([$role]); // assign role to user
    }
    echo $update ? 1 : 0;
  }

  /**
   * Delete one or more
  */
  public function destroy($id, Request $request)
  {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $names = json_encode(array_values(User::whereIn('id', $ids)->pluck('name')->toArray()));
      $destroy = User::whereIn('id', $ids)->delete();
    } else {
      $names = User::whereId($id)->value('name');
      $destroy = User::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.user') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }

  /**
   * Return view for user profile
  */
  public function profile()
  {
    $user = User::findOrFail(Auth::user()->id); // get user detail
    $page = 'none'; // choose sidebar menu option
    $profile = true;

    $client = [];
    if($user->is_client) {
      $attributes = json_decode($user->attributes, true);
      $lists = \App\Models\Lists::whereIn('id', $attributes['list_ids'])->pluck('name')->toArray();
      $client['lists'] = implode(', ', $lists);

      $sending_servers = \App\Models\SendingServer::whereIn('id', $attributes['sending_server_ids'])->pluck('name')->toArray();
      $client['sending_servers'] = implode(', ', $sending_servers);

      $client['no_of_recipients'] = $attributes['no_of_recipients'] != -1 ? $attributes['no_of_recipients'] : __('app.unlimited');
      $client['no_of_sending_servers'] = $attributes['no_of_sending_servers'] != -1 ? $attributes['no_of_sending_servers'] : __('app.unlimited');
    }
    return view('users.edit')->with(compact('user', 'page', 'profile', 'client'));
  }

}
