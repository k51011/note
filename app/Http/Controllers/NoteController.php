<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Note $note)
    {
        return view('index')->with(['notes' => $note->getPaginateByLimit()]);  
    }
    
    public function indexnote(Note $note)
    {
        return $note->get();
    }
    
    public function show(String $id, Note $note)
    {   
        $note = Note::where('id', $id)->first();
        return $note;
    }
    
    // public function create()
    // {
    //     return view('create');
    // }
    
    public function store(Request $request, Note $note)
    {
        $input = $request->input();
        $note->fill($input);
        $note->user_id = auth()->user()->id;
        $note->save();
        return redirect('/notes/' . $note->id);
        // return redirect('/');
    }
    
    // public function show(Note $note)
    // {
    //     return view('show')->with(['note' => $note]);
    // }
    
    // public function edit(Note $note)
    // {
    //     return view('edit')->with(['note' => $note]);
    // }
    
    public function update(Request $request, Note $note)
    {
        $input_note = $request->input();
        $note->fill($input_note)->save();
        // return redirect('/notes/' . $note->id); 
    
        
    }
    
    // public function destroy(Note $note)
    // {
    //     $note->delete();
    //     return redirect('/');
    // }
    public function destroy($id)
    {
        Note::where("id",$id)->delete();
    }
    
}
