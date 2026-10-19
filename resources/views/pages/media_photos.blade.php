@extends('layouts.app')
@section('title', 'ফটো গ্যালারি - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12 select-none">
  <div class="bg-gradient-to-r from-emerald-800 to-teal-800 p-8 rounded-3xl text-white text-center shadow-lg mb-8 relative">
    <h3 class="text-3xl font-black">ফটো গ্যালারী</h3>
    <p class="text-xs sm:text-sm text-emerald-100 mt-2 font-medium">আমাদের কার্যক্রমের স্মৃতিচিত্র — প্রতিটি মুহূর্তের সাক্ষী</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($photos as $p)
      <div class="bg-white rounded-3xl overflow-hidden border shadow-sm">
        <img class="w-full h-52 object-cover" src="{{ $p->url }}" alt="{{ $p->title }}">
        <div class="p-5">
          <span class="text-[10px] bg-emerald-50 text-emerald-700 font-bold px-2 py-0.5 rounded">{{ $p->category }}</span>
          <h5 class="text-sm font-bold text-gray-800 mt-2">{{ $p->title }}</h5>
          <p class="text-xs text-gray-400 mt-1">{{ $p->description }}</p>
        </div>
      </div>
    @empty
      <div class="col-span-full text-center py-12 text-gray-400 bg-white rounded-3xl border font-bold">কোনো ছবি পাওয়া যায়নি।</div>
    @endforelse
  </div>
</div>
@endsection
