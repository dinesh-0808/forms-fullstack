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
        'accept_response'
    ];

    protected $attributes = [
        'question_order' => '[]',
    ];
    protected $casts = [
        'question_order' => 'array',
    ];

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function responses(){
        return $this->hasMany(Response::class);
    }
}
