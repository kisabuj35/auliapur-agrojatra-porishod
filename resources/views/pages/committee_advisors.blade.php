@extends('layouts.app')
@section('title', 'উপদেষ্টা মণ্ডলী - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
  <div class="text-center mb-10 select-none">
    <span class="bg-emerald-50 text-emerald-700 text-xs px-4 py-1.5 rounded-full font-black uppercase tracking-wider">সম্মানিত পর্ষদ</span>
    <h3 class="text-3xl font-black text-gray-800 mt-3">উপদেষ্টা মণ্ডলী</h3>
    <p class="text-xs sm:text-sm text-gray-400 mt-2">আমাদের সম্মানিত উপদেষ্টাগণ যারা পথ দেখান ও অনুপ্রেরণা জোগান</p>
  </div>

  @if($chiefAdvisor)
  <div class="bg-white rounded-[32px] shadow-xl border border-gray-100 p-8 flex flex-col lg:flex-row gap-8 mb-16">
    <div class="lg:w-1/3 flex flex-col items-center border-r border-gray-100 pr-0 lg:pr-8 text-center select-none">
      <img class="w-40 h-40 rounded-full border-4 border-emerald-50 object-cover object-top shadow-lg mb-4" src="{{ $chiefAdvisor->photo ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150' }}" alt="Chief Advisor">
      <h4 class="text-2xl font-black text-gray-800 mb-1">{{ $chiefAdvisor->name }}</h4>
      <span class="text-xs bg-emerald-50 text-emerald-700 px-4 py-1.5 rounded-full font-black uppercase mb-6">প্রধান উপদেষ্টা</span>
      <p class="text-xs text-gray-500"><i class="fa-solid fa-phone mr-1 text-emerald-500"></i> {{ $chiefAdvisor->phone }}</p>
    </div>
    <div class="lg:w-2/3 flex flex-col justify-between">
      <p class="text-base text-gray-700 italic font-semibold leading-relaxed">"{{ $chiefAdvisor->message ?? 'অগ্রযাত্রা এগিয়ে যাক...' }}"</p>
      <div class="text-right border-t pt-4">
        <span class="font-bold text-gray-800 text-sm">{{ $chiefAdvisor->name }}</span>
        <p class="text-xs text-gray-400">প্রধান উপদেষ্টা</p>
      </div>
    </div>
  </div>
  @endif

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($advisors as $m)
      <div class="bg-white rounded-3xl shadow-md border p-6 text-center">
        <img class="w-28 h-28 rounded-full object-cover mx-auto mb-4 border-2 border-emerald-100" src="{{ $m->photo ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150' }}" alt="{{ $m->name }}">
        <h4 class="font-black text-gray-800 text-lg">{{ $m->name }}</h4>
        <span class="text-xs bg-amber-50 text-amber-700 px-3 py-1 rounded-full font-bold mt-1 inline-block">{{ $m->designation }}</span>
        <p class="text-xs text-gray-500 mt-3"><i class="fa-solid fa-briefcase text-emerald-500 mr-1"></i> {{ $m->profession }}</p>
      </div>
    @endforeach
  </div>
</div>
@endsection
