<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Package;
use Auth;
use Helper;

class ClientController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('clients'); // check user permission
    $page = 'user_management_clients'; // choose sidebar menu option
    return view('clients.index')->with(compact('page'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getClients(Request $request)
  {
    $result = User::leftJoin('roles', 'users.role_id', '=', 'roles.id')
      ->leftJoin('packages', 'users.package_id', '=', 'packages.id')
      ->select('users.id', 'users.name as name', 'users.role_id', 'users.package_id', 'roles.name as role_name', 'packages.name as package_name', 'users.email', 'users.country_code', 'users.active', 'users.created_at')
      ->where('users.is_client', 1)
      ->where('users.parent_id', Auth::user()->app_id);
    
    $columns = ['users.id', 'users.name', 'roles.name', 'users.email', 'users.country_code', 'users.active', 'users.created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $users = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($users as $user) {
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';

      $actions.= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('client.show', ['id' => $user->id]).'\')"><i class="fa fa-eye"></i>'.__('app.view').'</a></li>';
      $actions .= '<li><a href="'.route('client.edit', ['id' => $user->id]).'"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
      $actions .= '<li><a href="'.route('user.impersonate', ['id' => $user->id]).'"><i class="fa fa-user-o"></i>'.__('app.impersonate_client').'</a></li>';
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$user->id.'\', \''.route('client.destroy', ['id' => $user->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul>
        </div>';

      $package =  !empty($user->package_name) ? '<a href="javascript:;" onclick="viewModal(\'modal\', \''.route('package.edit', ['id' => $user->package_id]).'\')">'.$user->package_name.'</a>' : __('app.not_defined');
      $role =  !empty($user->role_name) ? '<a href="'.route('roles_permissions.permissions', ['id' => $user->role_id]).'">'.$user->role_name.'</a>' : __('app.not_defined');

      $data['data'][] = [
        "DT_RowId" => "row_{$user->id}",
        $user->name,
        $package,
        $role,
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
    Helper::checkPermissions('clients'); // check user permission
    $roles = Role::whereAppId(Auth::user()->app_id)->where('id', '<>', config('mc.superadmin'))->get(); // get all roles except superadmin
    $packages = Package::whereAppId(Auth::user()->app_id)->get(); // get all packages
    $page = 'user_management_clients';
    return view('clients.create')->with(compact('page', 'roles', 'packages'));
  }

  /**
   * Save data
  */
  public function store(ClientRequest $request)
  {
    $input = $request->except('_token', 'password_confirmation');
    $input['password'] = bcrypt($input['password']);
    $input['api_token'] = str_random(60);
    // Should be next App-ID
    $input['app_id'] = User::max('app_id')+1;
    $input['is_client'] = 1;
    $input['parent_id'] = Auth::user()->id;

    $user = User::create($input);
    $role = Role::whereId($request->role_id)->value('name');
    $user->syncRoles([$role]); // assign role to user

    // Save client default settings
    \DB::table('client_settings')->insert(['app_id' => $input['app_id'], 'user_id' => $input['parent_id']]);

    // Save default pages/emails data for client
     Helper::defaultPagesEamils($input['app_id']);

    // Save activiy
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.client') . " ({$request->name}) ". __('app.log_create')); // log
  }

  /**
   * Retrun user view
  */
  public function show($id)
  {
    Helper::checkPermissions('clients'); // check user permission
    $user = User::whereId($id)->where('users.parent_id', Auth::user()->app_id)
    ->with('role')->with('package')->first();
    return view('clients.view')->with(compact('user'));
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('clients'); // check user permission
    $user = User::whereId($id)->app()->first(); // get user detail
    $roles = Role::whereAppId(Auth::user()->app_id)->where('id', '<>', config('mc.superadmin'))->get(); // get all roles except superadmin
    $packages = Package::whereAppId(Auth::user()->app_id)->get(); // get all packages
    $page = 'user_management_clients'; // choose sidebar menu option
    return view('clients.edit')->with(compact('user', 'page', 'roles', 'packages'));
  }

  /**
   * Update data
  */
  public function update(ClientRequest $request, $id)
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

    $input['user_id'] = Auth::user()->id;
    $update = $user->fill($input)->save(); // update user data

    // Update status for all users to a client
    $client_users = User::whereParentId($user->id)->get();
    foreach ($client_users as $client_user) {
      $client_user->fill(['active' => $input['active']])->save(); // update user data
    }

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
      // Delete client users as well
      $client_users = User::whereIn('parent_id', $ids)->get();
      foreach ($client_users as $client_user) {
        User::destroy($client_user->id);
      }

      $names = json_encode(array_values(User::whereIn('id', $ids)->pluck('name')->toArray()));
      $destroy = User::whereIn('id', $ids)->delete();
    } else {
      $client_users = User::where('parent_id', $id)->get();
      foreach ($client_users as $client_user) {
        User::destroy($client_user->id);
      }

      $names = User::whereId($id)->value('name');
      $destroy = User::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.client') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }
}
