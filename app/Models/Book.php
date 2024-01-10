<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    // テーブル名
    protected $table = 'books';

    // 可変項目
    /** @var array */
    protected $fillable =
    [
        'publisher_id',
        'isbn',
        'title',
        'author',
        'published_date',
        'image_url',
        'description',
        'price',
    ];

    /**
     * 出版社テーブルとのリレーション
     *
     * @return BelongsTo
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    /**
     * カテゴリテーブルとのリレーション
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'book_category');
    }

    /**
     * ジャンルテーブルとのリレーション
     *
     * @return BelongsToMany
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'book_genre');
    }
}
