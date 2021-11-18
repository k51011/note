<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{   
    public function index(Note $note)
    {
        return view('index')->with(['category']);  
    }
    
    //categoryテーブルのデータを入手
    public function indexnote(Note $note)
    {   
        $notes = Note::where('user_id',Auth::id())->with('category')->get();
        foreach($notes as $note){
            if($note->isFavorited(Auth::id())){
                $note['isLiked']=true;
            }else{
                $note['isLiked']=false;
            }
        }
        return $notes;
        
    }
    
    public function indexHighNote(Note $note)
    {   
        // $notes = Note::where('user_id',Auth::id())->with('category')->get();
        $notes = Note::where('user_id',Auth::id())->whereHas('Category',function($q){
            $q->where('color','red');
        })->get();
        foreach($notes as $note){
            if($note->isFavorited(Auth::id())){
                $note['isLiked']=true;
            }else{
                $note['isLiked']=false;
            }
        }
        return $notes;
        
    }
    
    public function indexMiddleNote(Note $note)
    {   
        // $notes = Note::where('user_id',Auth::id())->with('category')->get();
        $notes = Note::where('user_id',Auth::id())->whereHas('Category',function($q){
            $q->where('color','yellow');
        })->get();
        foreach($notes as $note){
            if($note->isFavorited(Auth::id())){
                $note['isLiked']=true;
            }else{
                $note['isLiked']=false;
            }
        }
        return $notes;
        
    }
    
    public function indexLowNote(Note $note)
    {   
        // $notes = Note::where('user_id',Auth::id())->with('category')->get();
        $notes = Note::where('user_id',Auth::id())->whereHas('Category',function($q){
            $q->where('color','blue');
        })->get();
        foreach($notes as $note){
            if($note->isFavorited(Auth::id())){
                $note['isLiked']=true;
            }else{
                $note['isLiked']=false;
            }
        }
        return $notes;
        
    }
    
    public function indexProgressNote(Note $note)
    {   
        // $notes = Note::where('user_id',Auth::id())->with('category')->get();
        $notes = Note::where('user_id',Auth::id())->whereHas('Category',function($q){
            $q->where('color','green');
        })->get();
        foreach($notes as $note){
            if($note->isFavorited(Auth::id())){
                $note['isLiked']=true;
            }else{
                $note['isLiked']=false;
            }
        }
        return $notes;
        
    }
    
    public function indexCompletionNote(Note $note)
    {   
        // $notes = Note::where('user_id',Auth::id())->with('category')->get();
        $notes = Note::where('user_id',Auth::id())->whereHas('Category',function($q){
            $q->where('color','black');
        })->get();
        foreach($notes as $note){
            if($note->isFavorited(Auth::id())){
                $note['isLiked']=true;
            }else{
                $note['isLiked']=false;
            }
        }
        return $notes;
        
    }
    
    public function indexFavoriteNote(Note $note)
    {   
        // $notes = Note::where('user_id',Auth::id())->where('Favorite',isFavorited(Auth::id()))->get();
        $notes = Note::where('user_id',Auth::id())->whereHas('Favorite',function($q){
            $q->where('user_id',Auth::id());
        })->get();

        foreach($notes as $note){
            $note['isLiked']=true;
        }
        return $notes;
        
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
 
    
    public function imageStore(Request $request)
    {
      //見やすいので事前に定義しておく
        $disk = Storage::disk('s3');
      //postされてきた画像
        $image = $request->file('image');
      //putFileというのは、画像を保存して、その保存したパス（バケット以下を返してくれる関数、第一引数ディレクトリ名、第二引数画像データ、第３引数公開・非公開）
        $path = $disk->putFile('images', $image,'public');
        return $disk->url($path);
    }
    
    // public function imageStore(Request $request)
    // {
    //   //見やすいので事前に定義しておく
    //     $disk = Storage::disk('s3');
    //   //postされてきた画像
    //     $image = $request->image;
    //   //putFileというのは、画像を保存して、その保存したパス（バケット以下を返してくれる関数、第一引数ディレクトリ名、第二引数画像データ、第３引数公開・非公開）
    //     $path = $disk->putFile('images', $image,'public');

    //     //$pathには保存してあるパスが返っていることがわかる
    //     //なのでデータベースに$pathを保存することで呼び出せるようになる
    //     return response()->json(['response'=>$path],200);
    // }
    
}
