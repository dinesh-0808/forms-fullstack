<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Response;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    //

    public function index($id)
    {
        $user = Auth::user();
        $response = Response::findOrFail($id);

        return view('user.show-response', compact(['user', 'response']));
    }
}
