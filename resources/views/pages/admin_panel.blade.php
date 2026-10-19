@extends('layouts.app')
@section('title', 'অ্যাডমিন ERP কন্ট্রোল হাব - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 select-none">
  <div class="bg-gradient-to-r from-emerald-800 to-teal-800 p-8 rounded-3xl text-white text-center shadow-lg mb-8 relative">
    <h3 class="text-3xl font-black">অ্যাডমিন ERP মাস্টার হাব</h3>
    <p class="text-xs sm:text-sm text-emerald-100 mt-2 font-medium">আউলিয়াপুর অগ্রযাত্রা পরিষদের কেন্দ্রীয় ডাটাবেজ ও পরিচালনা প্যানেল</p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
      <span class="text-xs font-bold text-gray-400 block mb-1">মোট সক্রিয় সদস্য</span>
      <span class="text-2xl font-black text-slate-800">{{ \App\Models\Member::where('status', 'সক্রিয়')->count() }} জন</span>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
      <span class="text-xs font-bold text-gray-400 block mb-1">পেন্ডিং সদস্য আবেদন</span>
      <span class="text-2xl font-black text-amber-500">{{ \App\Models\Member::where('status', 'পেন্ডিং')->count() }} টি</span>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
      <span class="text-xs font-bold text-gray-400 block mb-1">পেন্ডিং চাঁদা অনুমোদন</span>
      <span class="text-2xl font-black text-rose-500">{{ \App\Models\Payment::where('status', 'পেন্ডিং')->count() }} টি</span>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
      <span class="text-xs font-bold text-gray-400 block mb-1">রক্তদান কর্মসূচি সংখ্যা</span>
      <span class="text-2xl font-black text-emerald-600">{{ \App\Models\BloodDonation::count() }} বার</span>
    </div>
  </div>

  <!-- পেন্ডিং আবেদন লিস্ট -->
  <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
    <h4 class="text-base font-black text-gray-800 border-b pb-3 mb-4">পেন্ডিং সদস্য আবেদনসমূহ</h4>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-100 text-xs text-left">
        <thead class="bg-slate-50 text-slate-700 font-bold">
          <tr>
            <th class="px-4 py-3">সদস্য আইডি</th>
            <th class="px-4 py-3">নাম</th>
            <th class="px-4 py-3">মোবাইল</th>
            <th class="px-4 py-3">পদবী</th>
            <th class="px-4 py-3 text-center">অ্যাকশন</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @forelse(\App\Models\Member::where('status', 'পেন্ডিং')->get() as $p)
          <tr>
            <td class="px-4 py-3 font-bold text-emerald-600">{{ $p->member_id }}</td>
            <td class="px-4 py-3 font-bold">{{ $p->name }}</td>
            <td class="px-4 py-3 text-gray-500">{{ $p->phone }}</td>
            <td class="px-4 py-3 text-gray-500">{{ $p->designation }}</td>
            <td class="px-4 py-3 text-center">
              <span class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full font-bold">অনুমোদন সচল</span>
            </td>
          </tr>
          @empty
          <tr><td colspan="5" class="text-center py-6 text-gray-400">কোনো পেন্ডিং আবেদন নেই।</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
