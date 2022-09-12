<?php

namespace App\Http\Controllers;

use App\Imports\OrdersImport;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Http\Request;
use App\User;
use Excel;
use orders;

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

        $data_array = explode(' ',$request->headers_input);
        
        // double check user permission
        $permission_required = $data_array[0];

        

        $path = $request->file('file')->getRealPath();

        Excel::import(new OrdersImport, $path);
        return redirect()->route('data.index')->with("success", "Data imported successfully"); 
           
        
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
