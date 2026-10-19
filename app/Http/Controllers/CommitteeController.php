<?php

namespace App\Http\Controllers;

use App\Models\Committee;

class CommitteeController extends Controller
{
    public function advisors()
    {
        $chiefAdvisor = Committee::where('type', 'উপদেষ্টা মণ্ডলী')
            ->where('designation', 'LIKE', '%প্রধান%')
            ->first();
        $advisors = Committee::where('type', 'উপদেষ্টা মণ্ডলী')
            ->where('id', '!=', $chiefAdvisor?->id)
            ->get();

        return view('pages.committee_advisors', compact('chiefAdvisor', 'advisors'));
    }

    public function executives()
    {
        $president = Committee::where('type', 'কার্যনির্বাহী কমিটি')
            ->where('designation', 'LIKE', '%সভাপতি%')
            ->where('designation', 'NOT LIKE', '%সহ%')
            ->first();
        $executives = Committee::where('type', 'কার্যনির্বাহী কমিটি')
            ->where('id', '!=', $president?->id)
            ->get();

        return view('pages.committee_executives', compact('president', 'executives'));
    }

    public function list()
    {
        $advisors = Committee::where('type', 'উপদেষ্টা মণ্ডলী')->get();
        $executives = Committee::where('type', 'কার্যনির্বাহী কমিটি')->get();

        return view('pages.committee_list', compact('advisors', 'executives'));
    }
}
