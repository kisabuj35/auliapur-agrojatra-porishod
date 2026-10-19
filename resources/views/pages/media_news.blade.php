@extends('layouts.app')
@section('title', 'বিজ্ঞপ্তি - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
  <div class="bg-emerald-800 p-8 rounded-3xl text-white text-center shadow-lg mb-8 relative">
    <h3 class="text-3xl font-black">বিজ্ঞপ্তি</h3>
    <p class="text-xs sm:text-sm text-emerald-100 mt-2 font-medium">সর্বশেষ বিজ্ঞপ্তি, ঘোষণা ও গুরুত্বপূর্ণ সিদ্ধান্ত</p>
  </div>

  <div class="space-y-4 max-w-4xl mx-auto">
    @forelse($notices as $n)
      <div class="bg-white p-6 rounded-3xl border shadow-sm flex items-start gap-4">
        <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0">
          <i class="fa-regular fa-bell"></i>
        </div>
        <div>
          <span class="text-[10px] text-gray-400 font-bold block mb-1">{{ $n->date_str }}</span>
          <h4 class="text-base font-black text-gray-800">{{ $n->title }}</h4>
          <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $n->description }}</p>
        </div>
      </div>
    @empty
      <div class="text-center py-12 text-gray-400 bg-white rounded-3xl border font-bold">কোনো বিজ্ঞপ্তি পাওয়া যায়নি।</div>
    @endforelse
  </div>
</div>
@endsection
