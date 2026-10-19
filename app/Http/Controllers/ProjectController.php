<?php

namespace App\Http\Controllers;

use App\Models\Campaign;

class ProjectController extends Controller
{
    public function show($slug)
    {
        $projectName = urldecode($slug);
        $campaigns = Campaign::where('sector', $projectName)
            ->orWhere('title', 'LIKE', "%{$projectName}%")
            ->latest('date')
            ->get();

        $totalAmount = $campaigns->sum('amount');
        $totalEntries = $campaigns->count();

        return view('pages.project_view', compact('projectName', 'campaigns', 'totalAmount', 'totalEntries'));
    }
}
