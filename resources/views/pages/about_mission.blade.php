@extends('layouts.app')
@section('title', 'লক্ষ্য ও উদ্দেশ্য - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12 select-none space-y-12">
  <div class="bg-gradient-to-r from-emerald-800 to-teal-800 p-8 rounded-3xl text-white text-center shadow-lg relative">
    <h3 class="text-3xl font-black">লক্ষ্য ও উদ্দেশ্য</h3>
    <p class="text-xs sm:text-sm text-emerald-100 mt-2 font-medium">আউলিয়াপুর অগ্রযাত্রা পরিষদ-এর প্রধান লক্ষ্য ও উদ্দেশ্যসমূহ</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="bg-white p-8 rounded-[32px] shadow-sm border flex items-start gap-5">
      <div class="bg-emerald-50 text-emerald-600 p-4 rounded-2xl text-xl shrink-0"><i class="fa-solid fa-bullseye"></i></div>
      <div>
        <h4 class="text-lg font-black text-emerald-700">আমাদের মিশন</h4>
        <p class="text-xs text-gray-500 leading-relaxed font-semibold mt-2">সমাজের প্রতিটি স্তরের মানুষের জীবনমান উন্নয়নে নিঃস্বার্থভাবে কাজ করা। শিক্ষা, স্বাস্থ্য, পরিবেশ সুরক্ষা ও মানবিক সেবার মাধ্যমে একটি সুস্থ ও স্বনির্ভর সমাজ গড়ে তোলা।</p>
      </div>
    </div>

    <div class="bg-white p-8 rounded-[32px] shadow-sm border flex items-start gap-5">
      <div class="bg-amber-50 text-amber-500 p-4 rounded-2xl text-xl shrink-0"><i class="fa-solid fa-earth-asia"></i></div>
      <div>
        <h4 class="text-lg font-black text-amber-600">আমাদের ভিশন</h4>
        <p class="text-xs text-gray-500 leading-relaxed font-semibold mt-2">আমরা স্বপ্ন দেখি এমন একটি সুসভ্য ও বৈষম্যহীন সমাজের, যেখানে প্রতিটি মানুষের মৌলিক অধিকার সুরক্ষিত থাকবে এবং মাদকাসক্তির অন্ধকার থাকবে না।</p>
      </div>
    </div>
  </div>
</div>
@endsection
