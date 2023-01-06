<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKaryaRequest;
use App\Http\Requests\UpdateKaryaRequest;
use App\Models\Karya;

class KaryaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Karya::all();

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
            'judul'=>'required',
            'keterangan'=>'required',
            'tgl_upload'=>'required',
            'gambar'=>'required',
            'link'=>'active_url'
        ]);

        $gambar = $request->file('gambar')->getClientOriginalName();
        $request->file('gambar')->move('karya', $gambar);

        $data = [
            'judul'=>$request->input('judul'),
            'keterangan'=>$request->input('keterangan'),
            'tgl_upload'=>$request->input('tgl_upload'),
            'gambar'=>url('karya/'.$gambar),
            'link'=>$request->input('link')
        ];

        $run = Karya::create($data);

        if($run){
            return response()->json([
                'pesan'=>'Data berhasil disimpan',
                'gambar'=>url('karya/'.$gambar),
                'status'=>200,
                'data'=>$data
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKaryaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKaryaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Karya  $karya
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Karya::where('id', $id)->get();

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Karya  $karya
     * @return \Illuminate\Http\Response
     */
    public function edit(Karya $karya)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKaryaRequest  $request
     * @param  \App\Models\Karya  $karya
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'judul'=>'required',
            'keterangan'=>'required',
            'tgl_upload'=>'required',
            'gambar'=>'required',
            'link'=>'active_url'
        ]);

        $gambar = $request->file('gambar')->getClientOriginalName();
        $request->file('gambar')->move('karya', $gambar);

        $data = [
            'judul'=>$request->input('judul'),
            'keterangan'=>$request->input('keterangan'),
            'tgl_upload'=>$request->input('tgl_upload'),
            'gambar'=>url('karya/'.$gambar),
            'link'=>$request->input('link')
        ];

        $run = Karya::where('id', $id)->update($data);

        if($run){
            return response()->json([
                'pesan'=>'Data berhasil diperbaharui',
                'gambar'=>url('karya/'.$gambar),
                'status'=>200,
                'data'=>$data
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Karya  $karya
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $run = Karya::where('id', $id)->delete();

        if($run){
            return response()->json([
                'pesan'=>'Data berhasil dihapus',
                'status'=>200
            ]);
        }
    }
}
