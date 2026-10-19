@extends('layouts.app')
@section('title', 'পত্রিকায় সংবাদ - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
  <div class="bg-gradient-to-r from-emerald-800 to-teal-800 p-8 rounded-3xl text-white text-center shadow-lg mb-8 relative">
    <h3 class="text-3xl font-black">পত্রিকায় সংবাদ</h3>
    <p class="text-xs sm:text-sm text-emerald-100 mt-2 font-medium">আমাদের সংগঠনের কার্যক্রম নিয়ে বিভিন্ন জাতীয় ও স্থানীয় পত্রিকায় প্রকাশিত সংবাদ</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($pressList as $press)
      <div class="bg-white rounded-3xl overflow-hidden border shadow-sm p-5">
        <span class="text-[10px] bg-blue-50 text-blue-700 font-bold px-2 py-0.5 rounded">{{ $press->source ?? 'গণমাধ্যম' }}</span>
        <h4 class="text-base font-extrabold text-gray-800 mt-2">{{ $press->title }}</h4>
        <p class="text-xs text-gray-400 mt-2 leading-relaxed">{{ $press->excerpt }}</p>
      </div>
    @empty
      <div class="col-span-full text-center py-12 text-gray-400 bg-white rounded-3xl border font-bold">কোনো প্রকাশিত সংবাদ পাওয়া যায়নি।</div>
    @endforelse
  </div>
</div>
@endsection
