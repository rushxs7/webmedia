<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Whois extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'domain',
        'result',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
