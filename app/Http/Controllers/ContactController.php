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
        
        dd($request->all());
        return redirect()->route('contact')->with('success', 'Message sent successfully');

       
     
    }

    public function index()
    {
        return view('contact');
    }
}
