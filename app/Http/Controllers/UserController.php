<?php

namespace App\Http\Controllers;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        $permissions = Permission::all();
        return view('users.create',compact('roles' , 'permissions'));

    }


    public function store(Request $request)
    {
        
       $validator =  $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
           
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = null;
        if($request->input('roles_name')){
            $user = User::create($input);
            $user->assignRole($request->input('roles_name'));
        }else if($request->input('user_permissions')){
             $user = User::create($input);
             $user->givePermissionTo($request->input('user_permissions'));  
        }else {
            return back()->withErrors(['roles_name.required', 'role name or permission is required']);    
        }
        return redirect()->route('users.index')
            ->with('success','تم اضافة المستخدم بنجاح');
    }


    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show',compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $permissions = Permission::all();
        $permissions_id = $user->permissions->pluck('id')->toArray();
        return view('users.edit',compact('user','roles','userRole' , 'permissions_id' , 'permissions'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            
        ]);
        $input = $request->all();
      
        $user = User::findOrFail($id);
        if($request->input('roles_name')){
            $user->update($input);
            DB::table('model_has_roles')->where('model_id',$id)->delete();
            DB::table('model_has_permissions')->where('model_id',$id)->delete();
            $user->assignRole($request->input('roles_name'));
        }
        else if($request->input('user_permissions')){
            $user->update($input);
            DB::table('model_has_permissions')->where('model_id',$id)->delete();
            DB::table('model_has_roles')->where('model_id',$id)->delete();
            $user->givePermissionTo($request->input('user_permissions'));  
        }
        else{
            return back()->withErrors(['roles_name.required', 'role name or permission is required']);    
        }
      
        return redirect()->route('users.index')
            ->with('success','success updated user infromation');
    }

    public function destroy(Request $request)
    {
        User::findOrFail($request->user_id)->delete();
        return redirect()->route('users.index')->with('success','تم حذف المستخدم بنجاح');
    }






}
