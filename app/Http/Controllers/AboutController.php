<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    public function intro()
    {
        return view('pages.about_intro');
    }

    public function rules()
    {
        return view('pages.about_rules');
    }

    public function mission()
    {
        return view('pages.about_mission');
    }

    public function faq()
    {
        return view('pages.about_faq');
    }
}
