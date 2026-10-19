<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Member;

class PaymentController extends Controller
{
    public function index()
    {
        return view('pages.member_payment');
    }

    public function store(Request $request)
    {
        $member = Member::where('member_id', $request->member_id)->first();

        Payment::create([
            'member_id' => $request->member_id,
            'name' => $member?->name ?? $request->name,
            'fiscal_year' => $request->fiscal_year ?? '২০২৬-২০২৭',
            'month' => $request->month,
            'amount' => $request->amount,
            'phone' => $request->phone,
            'method' => $request->method,
            'txn_id' => $request->txn_id,
            'status' => 'পেন্ডিং',
        ]);

        return response()->json(['success' => true]);
    }

    public function donation()
    {
        return view('pages.donation');
    }

    public function storeDonation(Request $request)
    {
        Payment::create([
            'member_id' => $request->member_id ?? 'ডোনার/সাধারণ',
            'name' => $request->donor_name,
            'fiscal_year' => '২০২৬-২০২৭',
            'month' => $request->month_note ?? 'ডোনেশন / অনুদান',
            'amount' => $request->amount,
            'phone' => $request->phone,
            'method' => $request->method,
            'txn_id' => $request->txn_id,
            'status' => 'পেন্ডিং',
        ]);

        return response()->json(['success' => true]);
    }
}
