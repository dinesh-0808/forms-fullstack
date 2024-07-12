<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
