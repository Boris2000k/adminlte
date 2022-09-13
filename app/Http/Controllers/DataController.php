<?php

namespace App\Http\Controllers;


use App\Imports\Order;
use App\Imports\Refund;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Http\Request;
use App\User;
use Excel;
use orders;
use refunds;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




    public function index()
    {

        $config = config('adminlte_config');
        // currently logged in user
        $auth_user = auth()->user();
        // all users
        $users = User::all();
        return view('data.index')->with('auth_user',$auth_user)->with('users',$users)->with('config',$config);
    }

    public function import(Request $request)
    {
        // check mime type
        $this->validate($request, [
            'file' => 'required|mimes:csv,xlsx'
        ]);

        // data backend permission check will use
        $data_array = explode(' ',$request->headers_input);
        $user_perm_array = array();
        $permission_required = $data_array[0];
        $user_perm = auth()->user()->permissions;

        // Call this import for headers check
        $import_type = $data_array[0];
        $import_type = explode('-',$import_type);
        $import_type = ucfirst(substr($import_type[1], 0,-1));
        
        $user_perm = str_replace(","," ",$user_perm);
        // backend check if user has permission for this import
        if(!str_contains($user_perm,$permission_required))
        {
            return redirect()->route('data.index')->with("error", "You don't have permission for this import type");
        }

        // path to file
        $path = $request->file('file')->getRealPath();

        // dynamic class names straight up refuse to work,temp fix
        // Excel::import(new $import_type, $path); <- not working 
        // Call appropriate import class
        if($import_type == 'Order')
        {
        Excel::import(new Order, $path);
        return redirect()->route('data.index')->with("success", "Data imported successfully"); 
        }

        else if($import_type == 'Refund')
        {
            Excel::import(new Refund, $path);
            return redirect()->route('data.index')->with("success", "Data imported successfully"); 
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    
}
