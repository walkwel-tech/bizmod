<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application Home.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('home');
    }
}
