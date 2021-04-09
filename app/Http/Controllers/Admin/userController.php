<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.user')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string|min:3|unique:users,username',
            'password' => 'required|string'
        ]);

        $role = Role::where('id', $request->role)->first();
        $user = new User;
        $user->username = ucwords($request->username);
        $user->password = Hash::make($request->password);
        $user->save();
        $user->roles()->attach($role);
        return redirect()->back()->with('success','New User Added!');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {  
       
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:3|unique:users,username,' . $id,
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['erroredit' => $validator->errors(),'username' => $request->username]);
        }
        $roleVal = Role::where('name', $request->rolee)->first();
        $roles = Role::all();
        $user = User::find($id);
        $user->username = $request->username;
        if (!Hash::check($request->password,  $user->password)) {
            $user->password = Hash::make($request->password);
        }
    
        $user->save();        
       foreach ($roles as $role) {
         $role->users()->updateExistingPivot($id,['role_id' => $roleVal->id]);
       }
        
        return redirect()->back()->with('updated','Successfully Updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        $user->roles()->detach();
        return redirect()->back()->with('deleted','User has been removed!');
    }
}
