<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $note = Notes::all('id','title','content','writer');
        if(count($note)){
            return response()->json([
                'message' => 'fetch notes sukses',
                'data' => $note
            ],200);
        }else{
            return response()->json([
                'message' => 'fetch data kosong'
            ],400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'title' => 'required',
            'content' => 'required',
            'writer' => 'required'
        ],[
            'required' => ':attribute harus terisi!'
        ]);

        if($validate->fails()){
            return response()->json(['message' => 'Invalid field','errors' => $validate->errors()],400);
        }else{
          $note =   Notes::create([
                'title' => $request->title,
                'content' => $request->content,
                'writer' => $request->writer,
            ]);
            return response()->json([
                'message' => 'notes berhasil ditambahkan',
                'data' => [
                    'id' => $note->title,
                    'title' => $note->title,
                    'writer' => $note->writer
                ]
            ],201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $notes = Notes::find($id);
        if($notes !== null){
            $notes->update([
                'title' => $request->title,
                'content' => $request->content,
                'writer' => $request->writer
            ]);
            return response()->json([
                'message' => 'notes berhasil diupdate',
                'data' => [
                    'id' => $notes->id,
                    'title' => $notes->title,
                    'content' => $notes->content,
                    'writer' => $notes->writer
                ]
            ],201);
        }else{
            return response()->json([
                'message' => 'Unauthorized'
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $notes = Notes::find($id);
        if($notes !== null){
            $notes->delete();
            return response()->json([
                'message' => 'notes berhasil dihapus'
            ],200);
        }else{
            return response()->json([
                'message' => 'Unauthorized'
            ],404);
        }
    }
}
