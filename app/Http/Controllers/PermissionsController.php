<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    
    public function index(){
      // $permissions = Permission::leftJoin('permissions as parent');

      $permissions = DB::table('permissions')
      ->leftJoin('permissions as parent','permissions.parent_id' , '=' , 'parent.id')
       ->select('permissions.*' , 'parent.name as parent_name')->paginate(10);
                    
       
       return view('permissions.index' , [
        'permissions' =>    $permissions , 
       ]);
    }


    public function show($id){
        
    }

    public function create(){

        $permissions = Permission::all();
        return view('permissions.create'  ,[
            'permissions' => $permissions , 
        ]);
    }

    public function store(Request $request){
          $request->validate([
             'name' => ['required' , 'unique:permissions,name'] , 
            
          ]);

          Permission::create($request->all());
          return redirect()->route('permissions.index')
            ->with('success', 'permissions created successfully');
    }


    public function edit($id){

        $permission = Permission::findOrFail($id);
      //  $permissions = Permission::all();
        $parents = Permission::all();

          return  view('permissions.edit' , [
            'permission' => $permission ,
            'parents' =>  $parents, 
          ]);
    }

    public function update(Request $request , $id){
      $request->validate([
        'name' => ['required' , 'unique:permissions,name,'.$id] , 
       
     ]);
     
     $permission = Permission::findOrFail($id);
     $permission->update($request->all());

     if($request->parent_id){
        $parentPermission = Permission::findOrFail($request->parent_id);
        $parentPermission->update([
          'is_parent' => 1 , 
        ]);

     }
     return redirect()->route('permissions.index')
     ->with('success', 'permissions updated successfully');
    }


    public function destroy($id){

    }

  
}
