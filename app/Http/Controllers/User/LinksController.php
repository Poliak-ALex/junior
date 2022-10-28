<?php

namespace App\Http\Controllers\User;

use App\Models\Links;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LinksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user/links.index');
    }

    /**
     * Get the data for listing in yajra.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getLinks( Links $links)
    {   
        $userId =  Auth::id();
        $data   = $links->getData($userId);

        return \DataTables::of($data)
            ->addColumn('Actions', function($data) {
                return '<button type="button" class="btn btn-primary btn-sm" id="getEditLinkData" data-id="'.$data->id.'"><i class="fas fa-edit"></i></button>
                        <button type="button" data-id="'.$data->id.'" data-toggle="modal" data-target="#DeleteLinkModal" class="btn btn-danger btn-sm" id="getDeleteId"><i class="fas fa-trash-alt"></i></button>';
            })
            ->rawColumns(['Actions'])
            
            ->addColumn('generated_link', function($data) 
            { 
                return $_SERVER['HTTP_HOST'].'/' . $data->generated_link;
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
            'primary_link' => 'required|url',
            'generated_link' => 'required|alpha_dash|unique:links',
        ]);

        $userId = Auth::id();

        Links::create([
            'primary_link'      => $request['primary_link'],
            'generated_link'    => $request['generated_link'],
            'user_id'           => $userId,
        ]);

        return redirect()->route('link.index')
            ->with('success','URL created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Links $link)
    {   
        return view('user.links.edit',compact('link'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Links $link)
    {   
        $request->validate([
            'primary_link' => 'required|url',
            'generated_link' => 'required|alpha_dash|unique:links,id,'. $link->id,
        ]);
        
        $link->update([
            'primary_link'      => $request['primary_link'],
            'generated_link'    => $request['generated_link'],
        ]);

        return redirect()->route('link.index')
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
        Links::find($id)->delete();

        return response()->json(['success' => 'User deleted successfully']);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.links.create');
    }

    //  /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function forwarding($url)
    // {
    //     $link = Links::limit(1)->where('generated_link', '=', $url)->get();
        
    //     if(!isset($link[0]))
    //     {
    //         dd('home page');;
    //     }

    //     $link[0]->update([
    //         'count' => $link[0]->count + 1,
    //     ]);

    //     return redirect($link[0]->primary_link);
    // }


    //  /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function generateLink()
    // {
    //     do 
    //     {
    //         $random = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!_-'), 0, 16);
    //         $link   = Links::limit(1)->where('generated_link', '=', $random)->get();
    //     } 
    //     while (isset($link[0]));

    //     return $random;
    // }

    // /**
    // * Show the form for creating a new resource.
    // *
    // * @return \Illuminate\Http\Response
    // */
    // public function verifyLink(Request $request)
    // {
    //     $link   = Links::limit(1)->where('generated_link', '=', $request->generated_link)->get();

    //     if(isset($link[0]))
    //     {
    //         return 'err';
    //     }
    //     else
    //     {
    //         return 'ok';
    //     }   
    // }
}