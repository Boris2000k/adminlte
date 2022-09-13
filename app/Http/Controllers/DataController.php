<?php

namespace App\Http\Controllers;
use Rap2hpoutre\FastExcel\FastExcel;
use App\orders;
use App\Imports\Order;
use App\Imports\Refund;
use Illuminate\Http\Request;
use App\User;
use \Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

use refunds;
use Throwable;

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

        $path = $request->file('file')->getRealPath();

        (new FastExcel)->import($path, function ($line) {
        $config = config('adminlte_config');
        foreach($config as $perm)
        $keys = array_keys($perm);
        $keys_amount = sizeof($keys);
        // create arrays for config data
        for($i=0;$i<$keys_amount;$i++)
        {
            // $headers[$i] = array();
            $data[$i] = array();
            array_push($data[$i],($perm[$keys[$i]]["label"]));
            array_push($data[$i],($perm[$keys[$i]]["permission_required"]));
            array_push($data[$i],($perm[$keys[$i]]["files"]["ds_sheet"]["headers_to_db"]));
        }

            $order = new orders();
            $headers = $data[0][2];
            foreach($headers as $key=>$value)
            {
                try
                {
                    $order->$value = $line[$key];
                    
                }
                catch (PDOException $e) {
                    dd($e);
                    }  
                catch(\Exception $e)
                {
                  dd($e);
                  throw ValidationException::withMessages(['error' => 'Header Validation Error']);
                     
                }
                catch(\Illuminate\Database\QueryException $e)
                {
                    dd($e);
                    throw QueryException::withMessages(['error' => 'Query Error']);
                }
                 
                
                
            }

            $order->save();
      
            });
            return redirect()->back()->with('success', 'Orders imported successfully'); 
    }
        

        
 
   

        // check mime type
        // $this->validate($request, [
        //     'file' => 'required|mimes:csv,xlsx'
        // ]);

        
        
     
        
        

       
    

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
