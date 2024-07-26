<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    //
    public function index(){
        $user = Auth::user();
        $forms = $user->forms()->orderBy('id', 'desc')->get();


        return view('home',compact(['user','forms']));

    }

    public function create(Request $request){
        $user = Auth::user();
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $title = $request['title'];

        return view('user.form',compact(['user','title']));


    }


}
