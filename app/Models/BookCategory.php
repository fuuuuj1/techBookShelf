<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookCategory extends Model
{
    use HasFactory;

    // テーブル名
    protected $table = 'book_category';

    // 可変項目
    /** @var array */
    protected $fillable =
    [
        'book_id',
        'category_id',
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
     * カテゴリテーブルとのリレーション
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
