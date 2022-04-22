<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'author', 'comment'
    ];

    public static function getColumnData($search, $column = 'author')
    {
        return Comment::query()
            ->where($column, 'LIKE', "%{$search}%")
            ->pluck($column)->unique();
    }

    public static function search($search, $column = 'author')
    {
        return Comment::query()
            ->where($column, $search)
            ->get();
    }
}
