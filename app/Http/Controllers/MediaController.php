<?php

namespace App\Http\Controllers;

use App\Models\MediaContent;

class MediaController extends Controller
{
    public function photos()
    {
        $photos = MediaContent::where('type', 'photo')->latest()->get();
        return view('pages.media_photos', compact('photos'));
    }

    public function videos()
    {
        $videos = MediaContent::where('type', 'video')->latest()->get();
        return view('pages.media_videos', compact('videos'));
    }

    public function news()
    {
        $notices = MediaContent::where('type', 'news')->latest()->get();
        return view('pages.media_news', compact('notices'));
    }

    public function press()
    {
        $pressList = MediaContent::where('type', 'press')->latest()->get();
        return view('pages.media_press', compact('pressList'));
    }

    public function awards()
    {
        $awards = MediaContent::where('type', 'award')->latest()->get();
        return view('pages.media_awards', compact('awards'));
    }
}
