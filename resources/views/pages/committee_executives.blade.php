@extends('layouts.app')
@section('title', 'কার্যনির্বাহী পরিষদ - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
  <div class="text-center mb-10 select-none">
    <span class="bg-emerald-50 text-emerald-700 text-xs px-4 py-1.5 rounded-full font-black uppercase tracking-wider">পরিচালনা পর্ষদ</span>
    <h3 class="text-3xl font-black text-gray-800 mt-3">কার্যনির্বাহী পরিষদ</h3>
    <p class="text-xs sm:text-sm text-gray-400 mt-2">পরিচালনা পর্ষদের কার্যকরী কমিটি</p>
  </div>

  @if($president)
  <div class="bg-white rounded-[32px] shadow-xl border border-gray-100 p-8 flex flex-col lg:flex-row gap-8 mb-16">
    <div class="lg:w-1/3 flex flex-col items-center border-r border-gray-100 pr-0 lg:pr-8 text-center select-none">
      <img class="w-36 h-36 rounded-full border-4 border-emerald-50 object-cover object-top shadow-lg mb-4" src="{{ $president->photo ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150' }}" alt="President">
      <h4 class="text-2xl font-black text-gray-800 mb-1">{{ $president->name }}</h4>
      <span class="text-xs bg-emerald-50 text-emerald-700 px-4 py-1.5 rounded-full font-black uppercase mb-6">{{ $president->designation }}</span>
      <p class="text-xs text-gray-500 font-bold"><i class="fa-solid fa-phone text-emerald-500 mr-1"></i> {{ $president->phone }}</p>
    </div>
    <div class="lg:w-2/3 flex flex-col justify-between">
      <p class="text-base text-gray-700 italic font-semibold leading-relaxed">"{{ $president->message ?? 'আউলিয়াপুর অগ্রযাত্রা পরিষদ এগিয়ে যাক...' }}"</p>
      <div class="text-right border-t pt-4">
        <span class="font-bold text-gray-800 text-sm">{{ $president->name }}</span>
        <p class="text-xs text-gray-400">প্রতিষ্ঠাতা সভাপতি</p>
      </div>
    </div>
  </div>
  @endif

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    @foreach($executives as $m)
      <div class="bg-white rounded-3xl shadow-md border p-6 text-center">
        <img class="w-24 h-24 rounded-2xl object-cover mx-auto mb-4 border-2 border-emerald-100" src="{{ $m->photo ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150' }}" alt="{{ $m->name }}">
        <h4 class="font-black text-gray-800 text-base">{{ $m->name }}</h4>
        <span class="text-xs bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full font-bold mt-1 inline-block">{{ $m->designation }}</span>
        <p class="text-xs text-gray-500 mt-2"><i class="fa-solid fa-phone text-emerald-500 mr-1"></i> {{ $m->phone }}</p>
      </div>
    @endforeach
  </div>
</div>
@endsection
