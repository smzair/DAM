<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Event;


class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(Permission $permission)
{


$this->permission = $permission;
//$this->middleware("auth");

}
     

    public function index()
    {
        $permission =$this->permission::all();
    
        return view("permission.index",['permission'=> $permission]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

   return view("permission.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {
        $this->validate($request,[
             'name'=>'required'

        ]);
        $this->permission->create([
          'name'=>$request->name

        ]);
        return redirect()->route('permission.index')->with('success','Permission Created');

    }


    public function getAll(){
        $permissions = $this->permission->all();
         return response() ->json([
          'permissions' => $permissions
        ], 200);
          }   


          
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function getAllPermissions(){
        $permissions = $this->permission->all();
        return response()->json([
            'permissions' => $permissions
        ], 200);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
            $data = Permission::find($id);

           
           return view('permission.editing',compact('data'));

    }

    public function update($id)
{
    $this->permission->update([
          'name'=>$request->name

        ]);



}
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response4
     */
    
    public function delete($id)
    {
     $permission=permission::findOrfail($id);
     $permission->delete();
     
     return redirect()->route('permission.index')->with('success','Permission Deleted');

    }
}
