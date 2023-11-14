<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'user_id',
        'tweet_id',
    ];

    protected $fillable = [
        'reply',
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function store()
    {
        $this->save();
    }

    public function show(int $tweetId)
    {
        return Reply::where('tweet_id')->get();
    }

    public function replyUpdate()
    {
        $this->update();
    }

    public function replyDelete()
    {
        $this->delete();
    }
}
