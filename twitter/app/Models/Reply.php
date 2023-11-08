<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $guarded = [
        'user_id',
        'tweet_id',
    ];

    protected $fillable = [
        'reply',
    ];
    
    public function store()
    {
        $this->save();
    }
}
