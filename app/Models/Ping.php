<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ping extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'host',
        'result',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
