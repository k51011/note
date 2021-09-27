<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'title',
        'content',
        'category_id',
        'user_id'
    ];
    
    public function getPaginateByLimit(int $limit_count = 4)
    {
        return $this->orderBy('updated_at', 'DESC')->paginate($limit_count);
    }
    
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    
    public function isFavorited($user_id)
    {
        return $this->favorites()->where('user_id', $user_id)->exists();
    }
    
    public function getFavorite($user_id)     
    {
        return $this->favorites()->where('user_id', $user_id)->first();
    }
    
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    public function favorites() {
        return $this->hasMany('App\Favorite');
    }
}
