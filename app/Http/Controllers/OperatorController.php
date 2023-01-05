<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOperatorRequest;
use App\Http\Requests\UpdateOperatorRequest;
use App\Models\Operator;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Operator::all();

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'operator'=>'required | alpha | max:255',
            'username'=>'required | alpha | max:255',
            'email'=>'required | string | email:dns,rfc | max:255',
            'password'=>'required | min:8 | regex:/[a-z]/ | regex:/[A-Z]/ | regex:/[0-9]/ | regex:/[@$!%*#?&]/',
            'telp'=>'required | numeric',
        ]);

        $data = [
            'operator'=>$request->input('operator'),
            'username'=>$request->input('username'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($request->input('password')),
            'telp'=>$request->input('telp')
        ];

        $run = Operator::create($data);

        if($run){
            return response()->json([
                'pesan'=>'Data berhasil disimpan',
                'status'=>200
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOperatorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOperatorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Operator  $operator
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Operator::where('id',$id)->get();

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Operator  $operator
     * @return \Illuminate\Http\Response
     */
    public function edit(Operator $operator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOperatorRequest  $request
     * @param  \App\Models\Operator  $operator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'operator'=>'required | alpha | max:255',
            'username'=>'required | alpha | max:255',
            'email'=>'required | string | email:dns,rfc | max:255',
            'password'=>'required | min:8 | regex:/[a-z]/ | regex:/[A-Z]/ | regex:/[0-9]/ | regex:/[@$!%*#?&]/',
            'telp'=>'required | numeric',
        ]);

        $data = [
            'operator'=>$request->input('operator'),
            'username'=>$request->input('username'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($request->input('password')),
            'telp'=>$request->input('telp')
        ];

        $run = Operator::where('id', $id)->update($data);

        if($run){
            return response()->json([
                'pesan'=>'Data berhasil diperbaharui',
                'status'=>200
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Operator  $operator
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $run = Operator::where('id',$id)->delete();

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

        $user = Operator::where('username', $username)->first();

        if(isset($username)){
            if($user->status == 1){
                if(Hash::check($passwword, $user->password)){
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
