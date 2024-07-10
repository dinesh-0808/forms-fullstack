<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\Response;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'published',
    ];


    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function responses(){
        return $this->hasMany(Response::class);
    }
}
