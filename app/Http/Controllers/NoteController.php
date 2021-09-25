<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;
use Storage;

class NoteController extends Controller
{   
    public function index(Note $note)
    {
        return view('index')->with(['category']);  
    }
    
    //categoryテーブルのデータを入手
    public function indexnote(Note $note)
    {
        return Note::with('category')->get();
    }
    
    //idを指定してノートのデータを入手
    public function show(String $id, Note $note)
    {   
        $note = Note::where('id', $id)->first();
        return $note;
    }
    
    //新規ノート作成
    public function store(Request $request, Note $note)
    {
        $input = $request->input();
        $note->fill($input);
        $note->user_id = auth()->user()->id;
        $note->save();
        return redirect('/notes/' . $note->id);
    }
    
    //既存のノートの更新
    public function update(Request $request, Note $note)
    {
        $input_note = $request->input();
        $note->fill($input_note)->save();
    }
    
    //指定したidのノートを削除
    public function destroy($id)
    {
        Note::where("id",$id)->delete();
    }
    
    //画像をs3に保存
    public function imageStore(Request $request) {
        // s3アップロード開始
        $image = $request->file('image');
        info(base64_decode($image));
        // imgフォルダに格納
        $path = Storage::disk('s3')->putFile('', $image, 'public');

        // フルパスの取得
        $fullPath = Storage::disk('s3')->url($path);
        return $fullPath;
    }
    
    
}
