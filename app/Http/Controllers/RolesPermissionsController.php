<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Helper;

class RolesPermissionsController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('roles'); // check user permission
    $page = 'user_management_roles'; // choose sidebar menu option
    return view('roles_permissions.index')->with(compact('page'));
  }

  /**
   * Retrun create role view
  */
  public function createRole()
  {
    Helper::checkPermissions('roles'); // check user permission
    return view('roles_permissions.create_role');
  }

  /**
   * Save role
  */
  public function saveRole(Request $request)
  {
    $data = $this->roleData($request);
    $role = Role::create($data);
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.role') . " ({$request->name}) ". __('app.log_create')); // log
  }

  /**
   * Update role
  */
  public function updateRole(Request $request)
  {
    $data = $this->roleData($request);
    Role::whereId($request->input('id'))->update($data);
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.role') . " ({$request->name}) ". __('app.log_update')); // log
  }

  /**
   * Retrun data for store or update
  */
  public function roleData($request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
    ]);
    $input = $request->except('_token');
    $input['user_id'] = Auth::user()->id;
    $input['app_id'] = Auth::user()->app_id;
    return $input;
  }

  /**
   * Delete one or more roles
  */
  public function destroyRole($id)
  {
    $role = Role::whereId($id)->value('name'); // get role name
    $users = User::whereRoleId($id)->get(); // Returns only users using this role
    foreach($users as $user) {
      $user->removeRole($role); // remove roles for the users
    }
    $destroy = Role::destroy($id); // delete the role
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.role') . " ({$role}) ". __('app.log_delete')); // log
    return $destroy;
  }

  /**
   * Retrun JSON datatable data
  */
  public function getRoles(Request $request)
  {
    $result = Role::select('id', 'name', 'created_at')->whereAppId(Auth::user()->app_id);
    $result->where('id', '<>', 1); // avoid to get superadmin
    $columns = ['id', 'id', 'name', 'created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $roles = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($roles as $role) {
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions .= '<li><a href="'.route('roles_permissions.permissions', ['id' => $role->id]).'"><i class="fa fa-list-alt"></i>'.__('app.manage_permissions').'</a></li>';
      $actions .= '<li><a href="javascript:;" onclick="renameRole(\''.$role->id.'\')"><i class="fa fa-edit"></i>'.__('app.rename').'</a></li>';
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$role->id.'\', \''.route('roles_permissions.destroy.role', ['id' => $role->id]).'\', \''. __('app.role_delete') .'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul>
        </div>';
      $role_name = "<span id='role-label-{$role->id}'>{$role->name}</span>
        <span class='input-group' style='float:none;display:none;' id='role-text-{$role->id}'>
          <span id=input-role-{$role->id}>
          <input type='text' class='form-control' id='new_role_name_{$role->id}' style='width:200px; display:inline-block' value='{$role->name}' />
          </span>
          <div class='input-group-addon' onclick=\"saveRole('{$role->id}', '". route('roles_permissions.update.role')."')\" style='cursor:pointer;'>
            <i class='fa fa-check'></i>
          </div>
          <div class='input-group-addon' onclick=\"exitRole('{$role->id}')\" style='cursor:pointer;'>
            <i class='fa fa-times'></i>
          </div>
        </span>";
      $manage_permissions = '<a href="'.route('roles_permissions.permissions', ['id' => $role->id]).'">'.__('app.manage').'</a>';
      $data['data'][] = [
        "DT_RowId" => "row_{$role->id}",
        $role_name,
        $manage_permissions,
        Helper::datetimeDisplay($role->created_at),
        $actions
      ];
    }
    echo json_encode($data);
  }

  /**
   * View role permissions
  */
  public function rolePermissions($role_id) {
    Helper::checkPermissions('roles'); // check user permission
    $role = Role::whereId($role_id)->whereAppId(Auth::user()->app_id)->where('id', '<>', 1)->first();
    $role_permissions = $role->permissions->pluck('name', 'id'); // get all permissions of a role
    $permissions = Helper::mcPermissions();
    $page = 'user_management_roles'; // choose sidebar menu option
    return view('roles_permissions.permissions')->with(compact('page', 'permissions', 'role', 'role_permissions'));
  }

  /**
   * Save role permissions
  */
  public function savePermissions(Request $request){
    $role = Role::findById($request->input('role_id')); // ger a role
    $role->syncPermissions(null); // first remove all permissions
    if(!empty($request->input('roles_permissions'))) {
      foreach($request->input('roles_permissions') as $roles_permission) {
        $permission = Permission::firstOrCreate(['name' => $roles_permission]);
        $permission->assignRole($role);
      }
    }
  }
}
