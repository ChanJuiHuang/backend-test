<?php

namespace App\Modules\Todo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'attachment_path',
        'done_at',
    ];
}
