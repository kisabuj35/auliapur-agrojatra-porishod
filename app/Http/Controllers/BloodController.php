<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BloodDonor;
use App\Models\BloodDonation;
use App\Helpers\BanglaHelper;

class BloodController extends Controller
{
    public function board()
    {
        $totalDonations = BloodDonation::where('status', 'অনুমোদিত')->count();
        $registeredDonors = BloodDonor::where('status', 'সক্রিয়')->count();
        $uniqueDonors = BloodDonation::where('status', 'অনুমোদিত')->distinct('donor_phone')->count();

        $groupStats = [
            'A+' => BloodDonation::where('donor_blood', 'A+')->where('status', 'অনুমোদিত')->count(),
            'A-' => BloodDonation::where('donor_blood', 'A-')->where('status', 'অনুমোদিত')->count(),
            'B+' => BloodDonation::where('donor_blood', 'B+')->where('status', 'অনুমোদিত')->count(),
            'B-' => BloodDonation::where('donor_blood', 'B-')->where('status', 'অনুমোদিত')->count(),
            'AB+' => BloodDonation::where('donor_blood', 'AB+')->where('status', 'অনুমোদিত')->count(),
            'AB-' => BloodDonation::where('donor_blood', 'AB-')->where('status', 'অনুমোদিত')->count(),
            'O+' => BloodDonation::where('donor_blood', 'O+')->where('status', 'অনুমোদিত')->count(),
            'O-' => BloodDonation::where('donor_blood', 'O-')->where('status', 'অনুমোদিত')->count(),
        ];

        $donations = BloodDonation::where('status', 'অনুমোদিত')->latest('donation_date')->get();

        return view('pages.blood_board', compact('totalDonations', 'registeredDonors', 'uniqueDonors', 'groupStats', 'donations'));
    }

    public function donors(Request $request)
    {
        $query = BloodDonor::where('status', 'সক্রিয়');

        if ($request->filled('group') && $request->group !== 'ALL') {
            $query->where('blood_group', $request->group);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('name', 'LIKE', "%{$q}%")
                    ->orWhere('upazila', 'LIKE', "%{$q}%")
                    ->orWhere('village', 'LIKE', "%{$q}%")
                    ->orWhere('blood_group', 'LIKE', "%{$q}%");
            });
        }

        $donors = $query->paginate(12);
        return view('pages.donor_list', compact('donors'));
    }

    public function createDonor()
    {
        return view('pages.donor_registration');
    }

    public function storeDonor(Request $request)
    {
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('donors', 'public');
        }

        BloodDonor::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'gender' => $request->gender ?? 'পুরুষ',
            'dob' => $request->dob,
            'blood_group' => $request->blood_group,
            'last_donation_date' => $request->last_donation_date,
            'weight' => $request->weight,
            'division' => $request->division,
            'district' => $request->district,
            'upazila' => $request->upazila,
            'village' => $request->village,
            'photo' => $photoPath ? asset('storage/' . $photoPath) : null,
            'donor_type' => $request->donor_type ?? 'সাধারণ',
            'member_id' => $request->member_id,
            'status' => 'সক্রিয়',
        ]);

        return redirect()->route('blood.donors')->with('success', 'রক্তদাতা হিসেবে সফলভাবে নিবন্ধিত হয়েছেন!');
    }

    public function createDonation()
    {
        return view('pages.blood_donation');
    }

    public function storeDonation(Request $request)
    {
        $donorPhoto = null;
        if ($request->hasFile('donor_photo')) {
            $donorPhoto = $request->file('donor_photo')->store('donations', 'public');
        }

        $recipientPhoto = null;
        if ($request->hasFile('recipient_photo')) {
            $recipientPhoto = $request->file('recipient_photo')->store('donations', 'public');
        }

        BloodDonation::create([
            'donor_type' => $request->donor_type ?? 'সাধারণ',
            'donor_id' => $request->donor_id,
            'donor_name' => $request->donor_name,
            'donor_father' => $request->donor_father,
            'donor_blood' => $request->donor_blood,
            'donor_phone' => $request->donor_phone,
            'donation_date' => $request->donation_date ?? now(),
            'donor_photo' => $donorPhoto ? asset('storage/' . $donorPhoto) : null,
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
            'recipient_address' => $request->recipient_address,
            'recipient_disease' => $request->recipient_disease,
            'recipient_photo' => $recipientPhoto ? asset('storage/' . $recipientPhoto) : null,
            'remarks' => $request->remarks,
            'status' => 'পেন্ডিং',
        ]);

        return response()->json(['success' => true]);
    }
}
