<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Response;

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

    public function response(){
        return $this->hasOne(Response::class);
    }
}
