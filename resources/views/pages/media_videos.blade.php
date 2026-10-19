@extends('layouts.app')
@section('title', 'ভিডিও গ্যালারি - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
  <div class="bg-gradient-to-r from-emerald-800 to-teal-800 p-8 rounded-3xl text-white text-center shadow-lg mb-8 relative">
    <h3 class="text-3xl font-black">ভিডিও গ্যালারী</h3>
    <p class="text-xs sm:text-sm text-emerald-100 mt-2 font-medium">আমাদের কার্যক্রমের ভিডিও চিত্র — প্রতিটি মুহূর্ত ধারণ</p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @forelse($videos as $v)
      <div class="bg-white rounded-3xl overflow-hidden border shadow-sm p-4">
        <div class="aspect-video bg-black rounded-2xl overflow-hidden mb-3">
          <iframe class="w-full h-full" src="{{ $v->url }}" allowfullscreen></iframe>
        </div>
        <h5 class="font-bold text-gray-800 text-sm">{{ $v->title }}</h5>
      </div>
    @empty
      <div class="col-span-full text-center py-12 text-gray-400 bg-white rounded-3xl border font-bold">কোনো ভিডিও পাওয়া যায়নি।</div>
    @endforelse
  </div>
</div>
@endsection
