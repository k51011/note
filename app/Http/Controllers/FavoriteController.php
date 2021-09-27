<?php

namespace App\Http\Controllers;
use App\Note;
use App\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class FavoriteController extends Controller
{
    
    public function store(Note $note)
    {
        $user = Auth::user();
        if($note->isFavorited(Auth::id())) {
          // 対象のレコードを取得して、削除する。
            $delete_record = $note->getFavorite($user->id);
            $delete_record->delete();
        } else {
            $favorite = Favorite::firstOrCreate(
                array(
                  'user_id' => Auth::user()->id,
                  'note_id' => $note->id
                )
            );
        }
    }
}  
    
  
    

