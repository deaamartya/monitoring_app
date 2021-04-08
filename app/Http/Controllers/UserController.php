<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user',compact('users'));
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
            'username' => 'required',
            'NAMA_LENGKAP' => 'required',
            'password' => 'required'
        ]);

        User::insert([
            'username' => $request->username,
            'NAMA_LENGKAP' => $request->NAMA_LENGKAP,
            'password' => bcrypt($request->password),
        ]);
        
        return redirect('admin/user')->with('success','User berhasil dibuat');
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
        $request->validate([
            'username' => 'required',
            'NAMA_LENGKAP' => 'required'
        ]);

        User::find($id)->update([
            'username' => $request->username,
            'NAMA_LENGKAP' => $request->NAMA_LENGKAP
        ]);

        return redirect('admin/user')->with('success','Data berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect('admin/user')->with('success','Data berhasil dihapus.');
    }
}
