@extends('layouts.app')
@section('title', $projectName . ' - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12 select-none space-y-12">
  
  <div class="bg-gradient-to-r from-emerald-800 to-teal-800 p-8 sm:p-10 rounded-3xl text-white text-center shadow-lg relative">
    <h3 class="text-3xl sm:text-4xl font-black">{{ $projectName }}</h3>
    <p class="text-xs sm:text-sm text-emerald-100 mt-2 font-medium">আউলিয়াপুর অগ্রযাত্রা পরিষদের অন্যতম প্রধান সামাজিক প্রকল্প</p>
  </div>

  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100">
      <span class="text-[9px] font-extrabold text-gray-400 block uppercase">অর্জিত পরিমাণ</span>
      <span class="text-xl font-black text-slate-800 mt-1 block">{{ \App\Helpers\BanglaHelper::toBn($totalAmount) }}+</span>
    </div>
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100">
      <span class="text-[9px] font-extrabold text-gray-400 block uppercase">মোট কর্মসূচি</span>
      <span class="text-xl font-black text-slate-800 mt-1 block">{{ \App\Helpers\BanglaHelper::toBn($totalEntries) }} টি</span>
    </div>
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100">
      <span class="text-[9px] font-extrabold text-gray-400 block uppercase">অবস্থা</span>
      <span class="text-xl font-black text-emerald-600 mt-1 block">চলমান</span>
    </div>
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100">
      <span class="text-[9px] font-extrabold text-gray-400 block uppercase">কার্য এলাকা</span>
      <span class="text-xl font-black text-slate-800 mt-1 block">পটুয়াখালী</span>
    </div>
  </div>

  <div class="bg-white p-6 sm:p-8 rounded-[32px] shadow-sm border border-gray-100 space-y-4">
    <h5 class="text-base font-black text-gray-800 border-b pb-2">প্রকল্প সময়রেখা ও বাস্তবায়ন লগ</h5>
    <div class="space-y-3 pt-2">
      @forelse($campaigns as $camp)
        <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl flex items-start gap-4">
          <div class="bg-emerald-50 text-emerald-700 w-16 h-10 rounded-xl flex items-center justify-center font-black text-xs shrink-0">
            {{ \App\Helpers\BanglaHelper::toBn(date('Y', strtotime($camp->date))) }}
          </div>
          <div>
            <h6 class="font-bold text-gray-800 text-sm">{{ $camp->title }}</h6>
            <p class="text-xs text-gray-500 mt-0.5">{{ $camp->desc }}</p>
          </div>
        </div>
      @empty
        <p class="text-xs text-gray-400 py-4 text-center font-bold">এই প্রকল্পের কোনো অতীত রেকর্ড পাওয়া যায়নি।</p>
      @endforelse
    </div>
  </div>
</div>
@endsection
