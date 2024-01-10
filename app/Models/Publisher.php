<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Publisher extends Model
{
    use HasFactory;

    // テーブル名
    protected $table = 'publishers';

    // 可変項目
    /** @var array */
    protected $fillable =
    [
        'name',
    ];

    /**
     * 本テーブルとのリレーション
     *
     * @return HasMany
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

}
