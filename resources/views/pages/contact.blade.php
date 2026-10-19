@extends('layouts.app')
@section('title', 'যোগাযোগ - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12 select-none">
  
  <div class="bg-gradient-to-r from-emerald-800 to-teal-800 p-8 rounded-3xl text-white text-center shadow-lg mb-8 relative">
    <h3 class="text-3xl font-black">যোগাযোগ ও লোকেশন</h3>
    <p class="text-xs sm:text-sm text-emerald-100 mt-2 font-medium">অগ্রযাত্রা পরিষদের কার্যালয় ও আপনার জিজ্ঞাসা — সরাসরি আমাদের সাথে যোগাযোগ করুন</p>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <div class="space-y-4 flex flex-col justify-between">
      <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex gap-4">
        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl h-fit"><i class="fa-solid fa-location-dot text-xl"></i></div>
        <div>
          <span class="text-[10px] font-extrabold text-gray-400 block uppercase">আমাদের কার্যালয়</span>
          <h5 class="text-sm font-black text-slate-800">আউলিয়াপুর ইউনিয়ন পরিষদ রোড</h5>
          <p class="text-xs text-gray-500">পটুয়াখালী সদর, পটুয়াখালী জেলা, বরিশাল বিভাগ।</p>
        </div>
      </div>

      <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex gap-4 items-center justify-between">
        <div class="flex gap-4">
          <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl h-fit"><i class="fa-solid fa-phone text-xl"></i></div>
          <div>
            <span class="text-[10px] font-extrabold text-gray-400 block uppercase">হেল্পলাইন নম্বর</span>
            <h5 class="text-sm font-black text-slate-800">+৮৮০ ১৭১০-১৮১০৫৯</h5>
          </div>
        </div>
      </div>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100 space-y-4">
      <h4 class="text-base font-black text-slate-800 border-b pb-2">আমাদের নিকট বার্তা পাঠান</h4>
      <form id="contact-form" class="space-y-4 text-xs font-bold text-gray-600">
        @csrf
        <div>
          <label class="block text-gray-500 mb-1">আপনার নাম *</label>
          <input type="text" name="name" required class="w-full px-4 py-2.5 border rounded-xl bg-slate-50">
        </div>
        <div>
          <label class="block text-gray-500 mb-1">মোবাইল নম্বর *</label>
          <input type="tel" name="phone" required class="w-full px-4 py-2.5 border rounded-xl bg-slate-50">
        </div>
        <div>
          <label class="block text-gray-500 mb-1">আপনার বার্তা *</label>
          <textarea name="message" required rows="3" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50"></textarea>
        </div>
        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-3 rounded-xl transition">
          <i class="fa-solid fa-paper-plane mr-1"></i> বার্তা প্রেরণ করুন
        </button>
      </form>
    </div>
  </div>

  <div class="bg-white p-4 rounded-3xl border shadow-sm">
    <iframe src="https://maps.google.com/maps?q=Auliyapur%20Union,%20Patuakhali,%20Bangladesh&t=&z=13&ie=UTF8&iwloc=&output=embed" class="w-full h-80 rounded-2xl border-0" allowfullscreen="" loading="lazy"></iframe>
  </div>
</div>
@endsection
