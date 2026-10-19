@extends('layouts.app')
@section('title', 'রক্ত ডোনার নিবন্ধন - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12 select-none">
  
  <div class="bg-gradient-to-r from-emerald-600 to-teal-600 p-8 rounded-3xl text-white text-center shadow-lg mb-8 relative overflow-hidden">
    <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
    <div class="absolute -bottom-12 -left-12 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
    <span class="bg-white/20 text-white text-[10px] px-3.5 py-1.5 rounded-full font-black uppercase border border-white/10 inline-flex items-center gap-1.5 mb-2">
      <i class="fa-solid fa-ribbon text-xs animate-pulse"></i> রক্তদান মহৎ দান
    </span>
    <h3 class="text-3xl font-black">ডোনার নিবন্ধন</h3>
    <p class="text-xs sm:text-sm text-emerald-100 mt-2 font-medium tracking-wide">রক্তদাতা হিসেবে নিবন্ধন করুন — একটু রক্তই বাঁচাতে পারে একটি প্রাণ</p>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-1 space-y-6">
      <div class="bg-gradient-to-br from-red-500 to-rose-600 p-6 rounded-3xl text-white text-center shadow-md space-y-4">
        <div class="bg-white/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto shadow-inner text-2xl">
          <i class="fa-solid fa-heart-pulse animate-pulse"></i>
        </div>
        <h4 class="text-base font-extrabold">রক্তদান কেন গুরুত্বপূর্ণ?</h4>
        <p class="text-xs text-red-50 leading-relaxed font-medium">
          প্রতি ২ সেকেন্ডে একজন মানুষের রক্তের প্রয়োজন হয়। আপনার এক ব্যাগ রক্ত তিনজনের জীবন বাঁচাতে পারে। রক্তদান স্বাস্থ্যের জন্যও অনেক উপকারী!
        </p>
      </div>
    </div>

    <div class="lg:col-span-2 bg-white p-6 sm:p-8 rounded-3xl shadow-xl border border-gray-100 space-y-6">
      <div class="border-b pb-3 mb-2 flex justify-between items-center">
        <h4 class="text-base font-black text-gray-800 flex items-center gap-2"><i class="fa-solid fa-user-plus text-emerald-600"></i> রক্তদাতা নিবন্ধন ফর্ম</h4>
        <span class="bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full text-[10px] font-black uppercase">রক্তদাতা সদস্য</span>
      </div>

      <form id="reg-form" action="{{ route('blood.donor.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs font-bold text-gray-600">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="space-y-1.5">
            <label class="block text-gray-500">আপনার পুরো নাম *</label>
            <input type="text" name="name" required placeholder="দাতার পূর্ণ নাম লিখুন" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-gray-700">
          </div>
          <div class="space-y-1.5">
            <label class="block text-gray-500">মোবাইল নম্বর *</label>
            <input type="tel" name="phone" required placeholder="১১ ডিজিটের মোবাইল নম্বর" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-gray-700">
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="space-y-1.5">
            <label class="block text-gray-500">রক্তের গ্রুপ *</label>
            <select name="blood_group" required class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-gray-700">
              <option value="">নির্বাচন করুন</option>
              <option value="A+">A+</option><option value="A-">A-</option>
              <option value="B+">B+</option><option value="B-">B-</option>
              <option value="AB+">AB+</option><option value="AB-">AB-</option>
              <option value="O+">O+</option><option value="O-">O-</option>
            </select>
          </div>
          <div class="space-y-1.5">
            <label class="block text-gray-500">শেষ রক্তদানের তারিখ</label>
            <input type="date" name="last_donation_date" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-gray-700">
          </div>
        </div>

        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-xl shadow-lg transition">
          <i class="fa-solid fa-circle-check"></i> ডোনার হিসেবে নিবন্ধন করুন
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
