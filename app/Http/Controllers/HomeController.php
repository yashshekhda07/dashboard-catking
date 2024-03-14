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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function studentProfile()
    {
        return view('Admin.coming');
    }

    public function examToppers()
    {
        return view('Admin.coming');
    }

    public function mentorsInterView()
    {
        return view('Admin.coming');
    }

    public function facultySession()
    {
        return view('Admin.coming');
    }

    public function finance()
    {
        return view('Admin.coming');
    }

    public function marketing()
    {
        return view('Admin.coming');
    }

    public function forum()
    {
        return view('Admin.coming');
    }

    public function CATKingOne()
    {
        return view('Admin.coming');
    }

    public function CATKingSupport() {
        return view('support');
    }
}
