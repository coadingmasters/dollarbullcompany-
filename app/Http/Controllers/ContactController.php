<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    
    public function send(Request $request)
    {
        $request->validate([

            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:255',
        ]);

        return redirect()->route('contact')->with('success', 'Message sent successfully');
        dd($request->all());

    }



    public function index()

    {

        return view('contact');
    }

}


