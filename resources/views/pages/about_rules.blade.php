@extends('layouts.app')
@section('title', 'সংগঠনের বিধিমালা - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12 select-none">
  <div class="bg-gradient-to-r from-emerald-800 to-teal-800 p-8 rounded-3xl text-white text-center shadow-lg mb-8 relative">
    <h3 class="text-3xl font-black">সংগঠনের বিধিমালা</h3>
    <p class="text-xs sm:text-sm text-emerald-100 mt-2 font-medium">আউলিয়াপুর অগ্রযাত্রা পরিষদের সাংবিধানিক গঠনতন্ত্র ও পরিচালনা বিধিমালা</p>
  </div>

  <div class="bg-white p-6 sm:p-8 rounded-[32px] shadow-xl border border-gray-100 space-y-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div class="p-5 rounded-2xl border border-gray-100 bg-slate-50">
        <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase">সাধারণ সদস্য</span>
        <h5 class="font-extrabold text-gray-800 text-sm mt-2">ফি: ৫০ টাকা (ভর্তি ফরম)</h5>
        <p class="text-xs text-gray-400 mt-1">গঠনতন্ত্রের শর্তের সাথে সঙ্গতিপূর্ণ যেকোনো নাগরিক ৫০ টাকা ভর্তি ফরম ফি প্রদানের মাধ্যমে সাধারণ সদস্য হতে পারবেন।</p>
      </div>
      <div class="p-5 rounded-2xl border border-gray-100 bg-slate-50">
        <span class="px-2 py-0.5 rounded bg-blue-50 text-blue-600 text-[10px] font-black uppercase">সহযোগী সদস্য</span>
        <h5 class="font-extrabold text-gray-800 text-sm mt-2">ফি: বাৎসরিক ৫,০০০ টাকা</h5>
        <p class="text-xs text-gray-400 mt-1">প্রবাসী নাগরিকগণ বাৎসরিক ন্যূনতম ৫০০০/- টাকা প্রদানের মাধ্যমে সহযোগী সদস্য হতে পারবেন।</p>
      </div>
    </div>
  </div>
</div>
@endsection
