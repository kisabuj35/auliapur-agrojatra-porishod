@extends('layouts.app')
@section('title', 'পুরস্কার ও সম্মাননা - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
  <div class="bg-gradient-to-r from-emerald-800 to-teal-800 p-8 rounded-3xl text-white text-center shadow-lg mb-8 relative">
    <h3 class="text-3xl font-black">পুরস্কার ও সম্মাননা</h3>
    <p class="text-xs sm:text-sm text-emerald-100 mt-2 font-medium">সমাজসেবায় অসামান্য অবদানের জন্য প্রাপ্ত সম্মাননা ও পুরস্কারসমূহ</p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($awards as $award)
      <div class="bg-white rounded-3xl overflow-hidden border shadow-sm p-6 text-center">
        <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-3 text-xl">
          <i class="fa-solid fa-trophy"></i>
        </div>
        <h4 class="text-base font-black text-gray-800">{{ $award->title }}</h4>
        <p class="text-xs text-gray-400 mt-1">প্রদানকারী: {{ $award->authority }}</p>
        <p class="text-xs text-gray-500 mt-3 leading-relaxed">{{ $award->description }}</p>
      </div>
    @empty
      <div class="col-span-full text-center py-12 text-gray-400 bg-white rounded-3xl border font-bold">কোনো সম্মাননা তথ্য পাওয়া যায়নি।</div>
    @endforelse
  </div>
</div>
@endsection
