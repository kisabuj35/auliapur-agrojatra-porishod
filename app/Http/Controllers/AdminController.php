<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Payment;
use App\Models\BloodDonation;
use App\Models\Cashbook;
use App\Models\Campaign;
use App\Models\Committee;
use App\Models\AdminUser;
use App\Models\MediaContent;
use App\Helpers\BanglaHelper;

class AdminController extends Controller
{
    public function index()
    {
        return view('pages.admin_panel');
    }

    public function login(Request $request)
    {
        $username = trim($request->username);
        $password = trim($request->password);

        if ($username === 'superadmin' && $password === 'AAP2026') {
            return response()->json([
                'success' => true,
                'role' => 'Super Admin',
                'name' => 'প্রধান প্রশাসক',
                'username' => 'superadmin'
            ]);
        }

        $admin = AdminUser::where('username', $username)->first();
        if ($admin && password_verify($password, $admin->password)) {
            return response()->json([
                'success' => true,
                'role' => $admin->role,
                'name' => $admin->name,
                'username' => $admin->username
            ]);
        }

        return response()->json(['success' => false, 'message' => 'ভুল ইউজারনেম বা পাসওয়ার্ড!']);
    }

    public function approveMember(Request $request)
    {
        $member = Member::find($request->id);
        if ($member) {
            $member->update(['status' => 'সক্রিয়']);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'error' => 'সদস্য পাওয়া যায়নি']);
    }

    public function approvePayment(Request $request)
    {
        $payment = Payment::find($request->id);
        if ($payment) {
            $payment->update(['status' => 'অনুমোদিত']);

            // স্বয়ংক্রিয় ক্যাশবুক এন্ট্রি
            Cashbook::create([
                'date' => now(),
                'type' => 'আয়',
                'sector' => 'মাসিক চাঁদা (' . $payment->month . ') - ID: ' . $payment->member_id,
                'amount' => $payment->amount,
                'remarks' => 'অনুমোদিত চাঁদা স্লিপ এন্ট্রি'
            ]);

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'error' => 'পেমেন্ট পাওয়া যায়নি']);
    }

    public function approveBlood(Request $request)
    {
        $donation = BloodDonation::find($request->id);
        if ($donation) {
            $donation->update(['status' => 'অনুমোদিত']);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'error' => 'রক্তদান রেকর্ড পাওয়া যায়নি']);
    }

    public function saveExpense(Request $request)
    {
        Cashbook::create([
            'date' => $request->date ?? now(),
            'type' => 'ব্যয়',
            'sector' => $request->sector,
            'amount' => $request->amount,
            'remarks' => $request->remarks,
            'spent_by' => $request->spent_by,
            'approved_by' => $request->approved_by,
        ]);

        return response()->json(['success' => true]);
    }

    public function saveCampaign(Request $request)
    {
        Campaign::create([
            'date' => $request->date ?? now(),
            'title' => $request->title,
            'sector' => $request->sector,
            'amount' => $request->amount,
            'desc' => $request->desc,
            'status' => $request->status ?? 'সম্পন্ন',
            'location' => $request->location ?? 'আউলিয়াপুর'
        ]);

        return response()->json(['success' => true]);
    }

    public function saveMedia(Request $request)
    {
        MediaContent::create([
            'type' => $request->type,
            'title' => $request->title,
            'url' => $request->photoUrl ?? $request->videoUrl ?? $request->pressImageUrl ?? $request->awardImageUrl,
            'category' => $request->photoCategory,
            'description' => $request->photoDescription ?? $request->awardDescription,
            'date_str' => $request->photoDate ?? $request->newsDate ?? $request->pressDate,
            'duration' => $request->videoDuration,
            'pdf_url' => $request->newsPdfUrl,
            'source' => $request->pressSource,
            'excerpt' => $request->pressExcerpt,
            'news_url' => $request->pressNewsUrl,
            'authority' => $request->awardAuthority,
            'year' => $request->awardYear
        ]);

        return response()->json(['status' => 'success']);
    }
}
