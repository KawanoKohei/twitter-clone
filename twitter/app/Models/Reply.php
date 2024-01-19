<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
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
        'text',
    ];

    /**
     * ユーザーとのリレーション
     *
     * @return belongsTo
     */
    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * リプライの保存
     *
     * @return void
     */
    public function store(): void
    {
        $this->save();
    }

    /**
     * リプライの編集
     *
     * @return void
     */
    public function edit(): void
    {
        $this->update();
    }

    /**
     * リプライの削除
     *
     * @return void
     */
    public function deleteReply(): void
    {
        $this->delete();
    }
}
