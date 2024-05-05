<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PermissionExport;
use App\Imports\PermissionImport;
use App\Models\User;
use DB;

class RoleController extends Controller
{
    public function AllPermission(){

        $permission = Permission::all();
        return view('backend.pages.permission.all_permission',compact('permission'));
    }//End Method


    public function AddPermission(){

        return view('backend.pages.permission.add_permission');
    }//End Method

    public function StorePermission(Request $request){

        $permission = Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Permission Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.permission')->with($notification);

    }//End Method

    public function EditPermission($id){
        $permission = Permission::findOrFail($id);
        return view('backend.pages.permission.edit_permission',compact('permission'));
    }//End Method

    public function UpdatePermission(Request $request){

        $per_id = $request->id;

        Permission::findOrFail($per_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Permission Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.permission')->with($notification);
    }//End Method


    public function DeletePermission($id){
        Permission::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Permission Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }//End Method


    public function ImportPermission(){
        return view('backend.pages.permission.import_permission');
    }//End Method


    public function Export(){
        return Excel::download(new PermissionExport, 'permission.xlsx');
    }//End Method


    public function Import(Request $request){

        Excel::import(new PermissionImport, $request->file('import_file'));
        $notification = array(
            'message' => 'Permission Imported Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }//End Method



    //// Role all Method Start From here



    public function AllRole(){
        $roles = Role::all();
        return view('backend.pages.role.all_role',compact('roles'));
    }//End Method

    public function AddRoles(){

        return view('backend.pages.role.add_roles');
    }//End Method

    public function StoreRoles(Request $request){

        Role::create([
            'name' => $request->name,
        ]);

        $notification = array(
            'message' => 'Role Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.role')->with($notification);

    }//End Method

    public function EditRoles($id){
        $roles = Role::findOrFail($id);
        return view('backend.pages.role.edit_roles',compact('roles'));
    }//End Method


    public function UpdateRoles(Request $request){
        $rid = $request->id;

        Role::findOrFail($rid)->update([
            'name' => $request->name,
        ]);
        $notification = array(
            'message' => 'Role Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.role')->with($notification);
    }//End Method


    public function DeleteRoles($id){
        Role::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Role Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.role')->with($notification);
    }//End Method


    ////// Add Role IN Permission Method Start From Here

    public function AddRolePermission(){
        $role = Role::all();
        $permission = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('backend.pages.rolesetup.add_role_permission',compact('role','permission','permission_groups'));
    }// End Method


    public function RolePermissionStore(Request $request){

        $data = array();
        $permissions = $request->permission;


        foreach($permissions as $key => $item){
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;

            DB::table('role_has_permissions')->insert($data);
        }//End Foreach

        $notification = array(
            'message' => 'Role Permission Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.role.permission')->with($notification);
    }//End Method


    public function AllRolePermission(){
        $roles = Role::all();
        return view('backend.pages.rolesetup.all_role_permission',compact('roles'));
    }//End Method


    public function AdminEditRoles($id){
        $role = Role::findOrFail($id);
        $permission = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('backend.pages.rolesetup.edit_role_permission',compact('role','permission','permission_groups'));

    }//End Method

    public function RolePermisionUpdate(Request $request, $id){
        $role = Role::findOrFail($id);
        $permissions = $request->permission;
        if (!empty($permissions)){
            $role->syncPermissions($permissions);
        }

        $notification = array(
            'message' => 'Role Permission Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.role.permission')->with($notification);
    }//End Method


    public function AdminDeleteRoles($id){
        $role = Role::findOrFail($id);
        if (!is_null($role)) {
            $role->delete();
        }
        $notification = array(
            'message' => 'Role Permission Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }//End Method



















}
