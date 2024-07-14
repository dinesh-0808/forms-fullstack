<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Response;
use App\Models\Answer;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'type',
        'name',
        'options',
        'required',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function response()
    {
        return $this->hasOne(Response::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
