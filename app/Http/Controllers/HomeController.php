<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\BloodDonation;
use App\Models\Campaign;
use App\Models\Committee;

class HomeController extends Controller
{
    public function index()
    {
        $totalMembers = Member::where('status', 'সক্রিয়')->count();
        $totalBlood = BloodDonation::where('status', 'অনুমোদিত')->count();
        $totalPlanted = Campaign::where('sector', 'LIKE', '%রোপণ%')->sum('amount') + 500;

        $recentActivities = Campaign::latest()->take(3)->get();
        $advisor = Committee::where('type', 'উপদেষ্টা মণ্ডলী')->where('designation', 'LIKE', '%প্রধান%')->first();
        $president = Committee::where('designation', 'LIKE', '%সভাপতি%')->where('designation', 'NOT LIKE', '%সহ%')->first();
        $secretary = Committee::where('designation', 'LIKE', '%সম্পাদক%')->where('designation', 'LIKE', '%সাধারণ%')->first();
        $donors = Committee::where('type', 'ডোনার ও পার্টনার')->take(8)->get();

        return view('pages.home', compact(
            'totalMembers', 'totalBlood', 'totalPlanted',
            'recentActivities', 'advisor', 'president', 'secretary', 'donors'
        ));
    }
}
