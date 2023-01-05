<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Admin::all();

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //validasi
        $this->validate($request, [
            'admin'=>'required | alpha | max:255',
            'username'=>'required | alpha | max:255',
            'email'=>'required | string | email:dns,rfc | max:255',
            'password'=>'required | min:8 | regex:/[a-z]/ | regex:/[A-Z]/ | regex:/[0-9]/ | regex:/[@$!%*#?&]/',
            'telp'=>'required | numeric',
            // 'admin'=>'required',
        ]);

        //inisiasi data
        $data = [
            'admin'=>$request->input('admin'),
            'username'=>$request->input('username'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($request->input('password')),
            'telp'=>$request->input('telp'),
        ];

        //menjalankan data
        $run = Admin::create($data);

        //output
        if($run){
            return response()->json([
                'pesan'=>'Data berhasil disimoan',
                'status'=>200
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdminRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $data = Admin::where('id',$id)->get();

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdminRequest  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'admin'=>'required | alpha | max:255',
            'username'=>'required | alpha | max:255',
            'email'=>'required | string | email:dns,rfc | max:255',
            'password'=>'required | min:8 | regex:/[a-z]/ | regex:/[A-Z]/ | regex:/[0-9]/ | regex:/[@$!%*#?&]/',
            'telp'=>'required | numeric',
        ]);

        $data = [
            'admin'=>$request->input('admin'),
            'username'=>$request->input('username'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($request->input('password')),
            'telp'=>$request->input('telp')
        ];

        $run = Admin::where('id', $id)->update($data);

        if($run){
            return respnse()->json([
                'pesan'=>'Data berhasil diperbaharui',
                'status'=>200
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $run = Admin::where('id', $id)->delete();

        if($run){
            return response()->json([
                'pesan'=>'Data berhasil dihapus',
                'status'=>200
            ]);
        }
    }


    public function login(Request $request){
        $this->validate($request, [
            'username'=>'required | alpha | max:255',
            'password'=>'required | min:8 | regex:/[a-z]/ | regex:/[A-Z]/ | regex:/[0-9]/ | regex:/[@$!%*#?&]/'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $user = Admin::where('username', $username)->first();

        if(isset($user)){
            if($user->status == 1){
                if(Hash::check($password, $user->password)){
                    return response()->json([
                        'pesan'=>'Login berhasil',
                        'data'=>$user
                    ]);
                } else {
                    return response()->json([
                        'pesan'=>'Password salah',
                        'data'=>''
                    ]);
                }

            } else {
                return response()->json([
                    'pesan'=>'Login tak dapat dilakukan karena akun diblokir',
                    'data'=>''
                ]);
            }

        } else {
            return response()->json([
                'pesan'=>'Akun tidak ditemukan',
                'data'=>''
            ]);
        }
    }
}
