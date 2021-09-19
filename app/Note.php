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

}
