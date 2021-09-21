<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Note $note)
    {
        return view('index')->with(['category']);  
    }
    
    public function indexnote(Note $note)
    {
        return Note::with('category')->get();
    }
    
    public function show(String $id, Note $note)
    {   
        $note = Note::where('id', $id)->first();
        return $note;
    }
    
    
    public function store(Request $request, Note $note)
    {
        $input = $request->input();
        $note->fill($input);
        $note->user_id = auth()->user()->id;
        $note->save();
        return redirect('/notes/' . $note->id);
    }
    
    public function update(Request $request, Note $note)
    {
        $input_note = $request->input();
        $note->fill($input_note)->save();
    }
    
    public function destroy($id)
    {
        Note::where("id",$id)->delete();
    }
    
}
