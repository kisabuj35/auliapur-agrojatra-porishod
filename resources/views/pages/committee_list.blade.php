@extends('layouts.app')
@section('title', 'কমিটি তালিকা - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
  <div class="text-center mb-10">
    <h3 class="text-3xl font-extrabold text-gray-800">আমাদের কমিটি তালিকা</h3>
    <p class="text-xs text-gray-400 mt-2">উপদেষ্টা মণ্ডলী ও কার্যনির্বাহী পরিষদের সম্মানিত সদস্যবৃন্দ</p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach($executives->concat($advisors) as $m)
      <div class="bg-white rounded-3xl border shadow-sm p-5 text-center">
        <img class="w-20 h-20 rounded-2xl object-cover mx-auto mb-3" src="{{ $m->photo ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150' }}" alt="{{ $m->name }}">
        <h4 class="font-bold text-gray-800 text-sm">{{ $m->name }}</h4>
        <span class="text-[10px] bg-slate-100 text-slate-700 px-2.5 py-0.5 rounded-full inline-block mt-1">{{ $m->designation }}</span>
        <p class="text-[11px] text-gray-500 mt-2"><i class="fa-solid fa-phone mr-1"></i> {{ $m->phone }}</p>
      </div>
    @endforeach
  </div>
</div>
@endsection
