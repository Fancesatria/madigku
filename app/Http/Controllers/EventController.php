<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Event::all();

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
            'deskripsi'=>'required',
            'tgl_event'=>'required | date',
            'gambar'=>'required'
        ]);

        $gambar = $request->file('gambar')->getClientOriginalName();
        $request->file('gambar')->move('event', $gambar);

        $data = [
            'judul'=>$request->input('judul'),
            'deskripsi'=>$request->input('deskripsi'),
            'tgl_event'=>$request->input('tgl_event'),//yyyy-mm-dd
            'gambar'=>url('event/'. $gambar)
        ];

        $run = Event::create($data);

        if($run){

            $event = Event::where('tgl_event', "2023-01-08")->first();
            $now = Carbon::now()->format('Y-m-d');
            // $tgl = $event->tgl_event;
            $datediff = DB::table('events')->select(DB::raw("DATEDIFF('$now','$event')"))->where('id', 1)->first();

            return response()->json([
                'pesan'=>'Data berhasil disimpan',
                'status'=>200,
                'data'=>$data,
                'diff'=>$datediff
            ]);
            // Event::selectRaw('set TIMEZONE="Asia/Jakarta";
            // select created_at, now() - interval "1 minutes" from events
            // and created_at >= now() - interval "1 minutes" order by created_at desc limit 1')->all();

            // if($datediff == 0){
            //     Event::where('tgl_event', Carbon::now())->delete();
            // }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Event::where('id', $id)->get();

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'judul'=>'required',
            'deskripsi'=>'required',
            'tgl_event'=>'required | date',
            'gambar'=>'required'
        ]);

        $gambar = $request->file('gambar')->getClientOriginalName();
        $request->file('gambar')->move('event', $gambar);

        $data = [
            'judul'=>$request->input('judul'),
            'deskripsi'=>$request->input('deskripsi'),
            'tgl_event'=>$request->input('tgl_event'),
            'gambar'=>url('event/'.$gambar)//ini ambik urlnyya, jadi gk lgsg ambil gambar
        ];

        $run = Event::where('id', $id)->update($data);

        if($run){
            return response()->json([
                'pesan'=>'Data berhasil diperbaharui',
                'status'=>200,
                'data'=>$data
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $run = Event::where('id', $id)->delete();

        if($run){
            return response()->json([
                'pesan'=>'Data berhasil dihapus',
                'status'=>200
            ]);
        }
    }
}
