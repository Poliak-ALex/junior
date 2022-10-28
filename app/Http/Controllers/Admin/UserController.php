<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Links;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/user.index');
    }

    /**
     * Get the data for listing in yajra.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUsers(Request $request, User $user)
    {   
        $data = $user->getData();

        return \DataTables::of($data)
            ->addColumn('Actions', function($data) {
                return '<button type="button" class="btn btn-warning btn-sm" id="getUserLinks" data-id="'.$data->id.'"><i class="fas fa-link"></i></button>
                        <button type="button" class="btn btn-primary btn-sm" id="getEditUserData" data-id="'.$data->id.'"><i class="fas fa-edit"></i></button>
                        <button type="button" data-id="'.$data->id.'" data-toggle="modal" data-target="#DeleteUserModal" class="btn btn-danger btn-sm" id="getDeleteId"><i class="fas fa-trash-alt"></i></button>';
            })
            ->rawColumns(['Actions'])
            
            ->addColumn('TotalURL', function($data) 
            { 
                $count = Links::where('user_id','=', $data->id)->count();
                return $count;
            })
            
            ->addColumn('Roles', function($data) 
            {
                if ($data->is_admin == 1)
                {
                    return 'Admin';
                }
                 return 'User';
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        if($request['is_admin'] == '') {
            $request['is_admin'] = 0;
        }
        
        if($request['is_support'] == '') {
            $request['is_support'] = 0;
        }       
        
        User::create([
            'name'          => $request['name'],
            'email'         => $request['email'],
            'password'      => Hash::make($request['password']),
            'is_admin'      => $request['is_admin'],
            'is_support'    => $request['is_support'],
        ]);

        return redirect()->route('users.index')
            ->with('success','Users created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {   
        return view('admin.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {   
        $request->validate([
            'name'      => 'required|unique:users,name,'.$user->id,
            'email'     => 'required|email|unique:users,email,'.$user->id,
        ]);
        
        if(isset($request->password))
        {
            $request->validate([
                'password' => 'min:8|confirmed',
            ]);
            $user->update([
            'password'  => Hash::make($request['password']),
            ]);
        }

        $request['is_admin']    = isset($request->is_admin)? 1 : 0;
        $request['is_support']  = isset($request->is_support)? 1 : 0;
        
        $user->update([
            'name'          => $request['name'],
            'email'         => $request['email'],
            'is_admin'      => $request['is_admin'],
            'is_support'    => $request['is_support'],
        ]);
    
        return redirect()->route('users.index')
            ->with('success','Users updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {   
        User::find($id)->delete();
        $links = Links::getData($id);
        
        if(isset($links[0]))
        {
            foreach($links as $link)
            {
                $link->delete();
            }
        }

        return response()->json(['success' => 'User deleted successfully']);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }
}