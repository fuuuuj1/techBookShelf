<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookGenre extends Model
{
    use HasFactory;

    // テーブル名
    protected $table = 'book_genre';

    // 可変項目
    /** @var array */
    protected $fillable =
    [
        'book_id',
        'genre_id',
    ];

    /**
     * 本テーブルとのリレーション
     *
     * @return BelongsTo
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * ジャンルテーブルとのリレーション
     *
     * @return BelongsTo
     */
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
}
