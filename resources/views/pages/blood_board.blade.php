@extends('layouts.app')
@section('title', 'রক্তদান খতিয়ান বোর্ড - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12 select-none space-y-8">
  <div class="text-center mb-4">
    <span class="bg-red-50 text-red-500 text-[10px] px-3.5 py-1.5 rounded-full font-black uppercase border border-red-100 inline-flex items-center gap-1.5 mb-3 shadow-sm">
      <i class="fa-solid fa-heart-pulse animate-pulse text-xs"></i> জীবন বাঁচাতে রক্তদান
    </span>
    <h3 class="text-3xl font-extrabold text-gray-800">কেন্দ্রীয় রক্তদান খতিয়ান বোর্ড</h3>
    <p class="text-gray-400 mt-2 text-xs sm:text-sm font-semibold">আউলিয়াপুর অগ্রযাত্রা পরিষদের অধীনে সম্পন্ন হওয়া সফল রক্তদান ও ডোনারদের লাইভ খতিয়ান</p>
    <div class="w-16 h-1 bg-red-500 mx-auto mt-3 rounded-full"></div>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
    <div class="bg-gradient-to-br from-red-50 to-white p-5 rounded-3xl border border-red-100 flex items-center justify-between">
      <div>
        <span class="text-xs font-bold text-red-500 uppercase block">সর্বমোট রক্তদান</span>
        <span class="text-3xl font-black text-red-600">{{ \App\Helpers\BanglaHelper::toBn($totalDonations) }} বার</span>
      </div>
      <div class="p-4 bg-red-500 text-white rounded-2xl"><i class="fa-solid fa-droplet text-xl"></i></div>
    </div>
    <div class="bg-gradient-to-br from-emerald-50 to-white p-5 rounded-3xl border border-emerald-100 flex items-center justify-between">
      <div>
        <span class="text-xs font-bold text-emerald-500 uppercase block">নিবন্ধিত রক্তদাতা</span>
        <span class="text-3xl font-black text-emerald-600">{{ \App\Helpers\BanglaHelper::toBn($registeredDonors) }} জন</span>
      </div>
      <div class="p-4 bg-emerald-500 text-white rounded-2xl"><i class="fa-solid fa-users text-xl"></i></div>
    </div>
    <div class="bg-gradient-to-br from-purple-50 to-white p-5 rounded-3xl border border-purple-100 flex items-center justify-between">
      <div>
        <span class="text-xs font-bold text-purple-500 uppercase block">রক্তদান করেছেন</span>
        <span class="text-3xl font-black text-purple-600">{{ \App\Helpers\BanglaHelper::toBn($uniqueDonors) }} জন</span>
      </div>
      <div class="p-4 bg-purple-500 text-white rounded-2xl"><i class="fa-solid fa-hand-holding-heart text-xl"></i></div>
    </div>
  </div>

  <div class="bg-white p-6 rounded-3xl border border-slate-100 space-y-4">
    <h4 class="font-extrabold text-gray-800 text-sm border-b pb-3 flex items-center"><i class="fa-solid fa-chart-simple text-red-500 mr-2"></i> গ্রুপ ভিত্তিক রক্তদানের পরিসংখ্যান</h4>
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
      @foreach($groupStats as $grp => $cnt)
        <div class="border rounded-2xl p-3 text-center {{ $cnt > 0 ? 'bg-red-50 text-red-600 font-bold border-red-100' : 'bg-slate-50 text-gray-400' }}">
          <span class="block text-xs text-gray-500 mb-0.5">{{ $grp }}</span>
          <span class="text-sm font-black">{{ \App\Helpers\BanglaHelper::toBn($cnt) }} বার</span>
        </div>
      @endforeach
    </div>
  </div>

  <div class="space-y-6">
    @forelse($donations as $item)
      <div class="bg-white rounded-3xl border border-emerald-500/20 p-6 flex flex-col md:flex-row items-center justify-between gap-6 shadow-sm">
        <div class="flex items-center gap-5 w-full md:w-5/12">
          <img class="w-28 h-24 rounded-2xl border-2 border-emerald-500 bg-slate-100 object-cover" src="{{ $item->donor_photo ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150' }}" alt="Donor">
          <div class="space-y-1">
            <span class="inline-block px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase bg-emerald-50 text-emerald-600">{{ $item->donor_type }}</span>
            <h5 class="text-base font-black text-gray-800">{{ $item->donor_name }}</h5>
            <p class="text-[10px] text-gray-400 font-bold">পিতা: {{ $item->donor_father }}</p>
            <p class="text-[10px] text-gray-500 font-black"><i class="fa-solid fa-phone text-gray-400 mr-1"></i> {{ $item->donor_phone }}</p>
          </div>
        </div>

        <div class="flex flex-col items-center justify-center shrink-0">
          <span class="bg-red-50 text-red-600 text-xs font-black px-3.5 py-1 rounded-full border border-red-100">{{ $item->donor_blood }}</span>
          <div class="h-6 w-[1px] md:w-12 md:h-[1px] bg-red-200 my-2"></div>
          <span class="text-[10px] text-gray-400 font-bold">{{ \App\Helpers\BanglaHelper::bnDate($item->donation_date) }}</span>
        </div>

        <div class="flex items-center md:flex-row-reverse gap-5 w-full md:w-5/12 text-left md:text-right">
          <img class="w-28 h-24 rounded-2xl border-2 border-red-400 bg-slate-100 object-cover" src="{{ $item->recipient_photo ?? 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150' }}" alt="Recipient">
          <div class="space-y-1 w-full">
            <span class="inline-block px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase bg-red-50 text-red-600">রক্তগ্রহীতা</span>
            <h5 class="text-base font-black text-gray-800">{{ $item->recipient_name }}</h5>
            <p class="text-[10px] text-gray-400 font-bold">রোগ: {{ $item->recipient_disease }}</p>
            <p class="text-[10px] text-gray-500 font-black">{{ $item->recipient_address }}</p>
          </div>
        </div>
      </div>
    @empty
      <div class="text-center py-12 bg-white rounded-3xl border text-gray-400 font-bold">কোনো রক্তদানের তথ্য পাওয়া যায়নি।</div>
    @endforelse
  </div>
</div>
@endsection
