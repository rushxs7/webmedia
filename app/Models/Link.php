<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hash',
        'original_link'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
