<?php

namespace App\Http\Controllers;
use Rap2hpoutre\FastExcel\FastExcel;
use App\orders;
use App\refunds;
use App\Imports\Order;
use App\Imports\Refund;
use Illuminate\Http\Request;
use App\User;
use \Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


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
         // check mime type
         $this->validate($request, [
            'file' => 'required|mimes:csv,xlsx'
        ]);

        // very bad approach, change later
        // pass data to import function
        global $import_type;
        global $data_index;
        
        // class name
        $import_type = $request->import_type;
        // data index for array
        $data_index = $request->data_index;
        $data_index = explode('-',$data_index);
        $data_index = $data_index[0];
        // dd($data_index);
        
        $path = $request->file('file')->getRealPath();

        (new FastExcel)->import($path, function ($line){

        // pass globals to import function
        global $import_type,$data_index;
        
        // get config file to compare with posted data
        $config = config('adminlte_config');
        foreach($config as $perm)
        {
        // read array
        $keys = array_keys($perm);
        $keys_amount = sizeof($keys);
        // create arrays for config data
        for($i=0;$i<$keys_amount;$i++)
        {
            $data[$i] = array();
            array_push($data[$i],($perm[$keys[$i]]["label"]));
            array_push($data[$i],($perm[$keys[$i]]["permission_required"]));
            array_push($data[$i],($perm[$keys[$i]]["files"]["ds_sheet"]["headers_to_db"]));
        }
    }
            // create dynamic class name
            $import = '\\App\\'  . $import_type;
            $varobj = new $import();
            $headers = $data[$data_index][2];
            foreach($headers as $key=>$value)
            {
                try
                {
                    $varobj->$value = $line[$key];
                    
                }
                catch (PDOException $e) {
                    dd($e);
                    }  
                catch(\Exception $e)
                {
                //   dd($e);
                  throw ValidationException::withMessages(['error' => 'Header Validation Error at: ' . $key ]);
                     
                }
                catch(\Illuminate\Database\QueryException $e)
                {
                    dd($e);
                    throw QueryException::withMessages(['error' => 'Query Error']);
                }
            }

            $varobj->save();
      
            });
            return redirect()->back()->with('success', 'Orders imported successfully'); 
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
    public function show($table_name)
    {
        $user_perms = Auth::user()->permissions;
        
        $data_key = request()->key;
        $model = 'App\\' . $table_name;
        $db_data = $model::all();
        
            
        
        $auth_user = auth()->user();
        return view('data.show')->with('auth_user',$auth_user)->with('db_data',$db_data)->with('data_key',$data_key)->with('user_perms',$user_perms);
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
