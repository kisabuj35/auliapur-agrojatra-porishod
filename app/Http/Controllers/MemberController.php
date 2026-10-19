<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Helpers\BanglaHelper;

class MemberController extends Controller
{
    public function create()
    {
        return view('pages.member_register');
    }

    public function store(Request $request)
    {
        $lastMember = Member::latest('id')->first();
        $nextNum = $lastMember ? ((int) filter_var($lastMember->member_id, FILTER_SANITIZE_NUMBER_INT)) + 1 : 1;
        $memberId = 'AAP' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('members', 'public');
        }

        Member::create([
            'member_id' => $memberId,
            'name' => $request->name,
            'father_name' => $request->fatherName,
            'mother_name' => $request->motherName,
            'gender' => $request->gender ?? 'পুরুষ',
            'education' => $request->education,
            'designation' => $request->designation ?? 'সাধারণ সদস্য',
            'address' => $request->address,
            'phone' => $request->phone,
            'nid' => $request->nid,
            'profession' => $request->profession,
            'blood_group' => $request->bloodGroup,
            'monthly_fee' => $request->monthlyFee ?? 100,
            'photo' => $photoPath ? asset('storage/' . $photoPath) : null,
            'status' => 'পেন্ডিং',
            'join_date' => $request->joinDate ?? now(),
            'email' => $request->email,
            'fb_link' => $request->fbLink,
            'comments' => $request->comments,
            'member_type' => $request->memberType ?? 'সাধারণ সদস্য',
        ]);

        return response()->json(['success' => true, 'memberId' => $memberId]);
    }

    public function search(Request $request)
    {
        $query = Member::where('status', 'সক্রিয়');
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('name', 'LIKE', "%{$q}%")
                    ->orWhere('member_id', 'LIKE', "%{$q}%")
                    ->orWhere('phone', 'LIKE', "%{$q}%");
            });
        }
        if ($request->filled('type')) {
            $query->where('member_type', $request->type);
        }

        $members = $query->paginate(20);
        return view('pages.search_members', compact('members'));
    }

    public function ledger()
    {
        return view('pages.search_ledger');
    }

    public function lookup(Request $request)
    {
        $idOrPhone = $request->idOrPhone;
        $member = Member::with('payments')->where('member_id', $idOrPhone)
                        ->orWhere('phone', $idOrPhone)
                        ->first();

        if (!$member) {
            return response()->json(['success' => false, 'message' => 'সদস্য পাওয়া যায়নি']);
        }

        $ledger = $member->calculated_ledger;
        return response()->json([
            'success' => true,
            'member' => $member,
            'ledger' => [
                'months' => BanglaHelper::toBn($ledger['months']),
                'total_accrued' => BanglaHelper::toBn($ledger['total_accrued']),
                'total_paid' => BanglaHelper::toBn($ledger['total_paid']),
                'due' => BanglaHelper::toBn($ledger['due'])
            ]
        ]);
    }
}
