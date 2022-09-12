<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Config;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // currently logged in user
        $auth_user = auth()->user();
        // all users
        $users = User::all();
        return view('users.index')->with('auth_user',$auth_user)->with('users',$users);
    }

    public function permissions()
    {
        
        // get permissions from config
        $perms = config('adminlte_config');

        $auth_user = auth()->user();
        $users = DB::table('users')->simplePaginate(10);
        return view('users.permissions')->with('users',$users)->with('auth_user',$auth_user)->with('perms',$perms);
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
        //
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
        $auth_user = auth()->user();
        $user = User::findOrFail($id);

        return view('users.edit', ['user' => $user])->with('auth_user',$auth_user);
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
        $request->validate(
            [
            'username'=>'required|min:6|unique:users,username'
            ],
            [
            'username.required' => 'Username cannot be empty',
            'username.min' => 'Username must be atleast 6 characters long',
            'username.unique' => 'This Username already exists',
            ]
        );

        $user = User::findOrFail($id);

        $user->username = $request->username;
        $user->save();

        return redirect()->route('users.index')->with("success", "$user->username was updated successfully");  
    }

    // update user permissions
    public function updatePermissions(Request $request, $id)
    {

        $user_permissions ="";
        $user = User::findOrFail($id);

        

        // create permissions format for database
        foreach($request->except('_token','_method') as $perm)
        {
            $user_permissions = $user_permissions . $perm . ',';
        }

         $user->permissions = $user_permissions;
         $user->save();

         return redirect()->back()->with('success', 'Permissions updated successfully');  

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if(Auth::id() == $id)
        {
            
            return redirect()->route('users.index')->with("error", "You cannot delete your own profile");  
            
        }
        else
        {
            $user -> delete();
            return redirect()->route('users.index')->with("success", "$user->username was deleted successfully"); 
        }
          
    }
}
