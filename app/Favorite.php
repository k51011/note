<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    
    protected $fillable = [
        'note_id',
        'user_id'
    ];
    
    public $timestamps = false;
    
    public function user()
    {
       return $this->belongsTo('App\User');
    }

    public function note()
    {
       return $this->belongsTo('App\Note');
    }

}
