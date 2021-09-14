<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Note $note)
    {
        return view('index')->with(['notes' => $note->get()]);  
    }
    
    public function create()
    {
        return view('create');
    }
    
    public function store(Request $request, Note $note)
    {
        $input = $request['note'];
        $note->fill($input);
        $note->user_id = auth()->user()->id;
        $note->save();
        // return redirect('/notes/' . $note->id);
        return redirect('/');
    }
}
