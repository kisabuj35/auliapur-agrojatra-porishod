@extends('layouts.app')
@section('title', 'সদস্য নিবন্ধন - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12 select-none">
  
  <div class="bg-gradient-to-r from-emerald-600 to-teal-600 p-6 sm:p-8 rounded-t-3xl text-white text-center relative shadow-lg">
    <div class="absolute top-4 right-4 bg-white/20 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
      <i class="fa-solid fa-circle-check animate-pulse"></i> অনলাইন রেজিস্ট্রেশন
    </div>
    <h3 class="text-2xl font-black">সদস্য নিবন্ধন স্লিপ</h3>
    <p class="text-xs text-emerald-100 mt-1 leading-relaxed">আউলিয়াপুর অগ্রযাত্রা পরিষদের ডিজিটাল সদস্য তথ্য ফর্ম</p>
    <div class="w-16 h-1 bg-white/40 mx-auto mt-4 rounded-full"></div>
  </div>

  <form id="reg-form" onsubmit="submitMemberForm(event)" class="bg-white p-6 sm:p-8 rounded-b-3xl shadow-xl border-x border-b border-gray-100 space-y-6">
    @csrf
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-gray-700">১. সদস্যের ধরণ (ক্যাটাগরি) <span class="text-rose-500">*</span></label>
        <select id="memberType" name="memberType" required class="w-full px-4 py-2.5 border rounded-xl text-sm bg-slate-50 text-gray-700">
          <option value="সাধারণ সদস্য">সাধারণ সদস্য</option>
          <option value="ফাউন্ডার মেম্বার">ফাউন্ডার মেম্বার (প্রতিষ্ঠাতা সদস্য)</option>
          <option value="আজীবন সদস্য">আজীবন সদস্য</option>
          <option value="দাতা সদস্য">দাতা সদস্য</option>
          <option value="স্বেচ্ছাসেবী সদস্য">স্বেচ্ছাসেবী সদস্য (ভলান্টিয়ার)</option>
        </select>
      </div>
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-gray-700">২. সদস্যের নাম <span class="text-rose-500">*</span></label>
        <input type="text" id="name" name="name" required placeholder="আপনার পূর্ণ নাম লিখুন" class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-700 bg-slate-50">
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-gray-700">৩. পিতার নাম <span class="text-rose-500">*</span></label>
        <input type="text" id="fatherName" name="fatherName" required placeholder="পিতার নাম লিখুন" class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-700 bg-slate-50">
      </div>
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-gray-700">৪. মাতার নাম <span class="text-rose-500">*</span></label>
        <input type="text" id="motherName" name="motherName" required placeholder="মাতার নাম লিখুন" class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-700 bg-slate-50">
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-gray-700">৫. লিঙ্গ <span class="text-rose-500">*</span></label>
        <select id="gender" name="gender" required class="w-full px-4 py-2.5 border rounded-xl text-sm bg-slate-50 text-gray-700">
          <option value="পুরুষ">পুরুষ</option>
          <option value="মহিলা">মহিলা</option>
          <option value="অন্যান্য">অন্যান্য</option>
        </select>
      </div>
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-gray-700">৬. শিক্ষাগত যোগ্যতা <span class="text-rose-500">*</span></label>
        <input type="text" id="education" name="education" placeholder="যেমন: এসএসসি, এইচএসসি, বিএ" required class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-700 bg-slate-50">
      </div>
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-gray-700">৭. পদবী <span class="text-rose-500">*</span></label>
        <input type="text" id="designation" name="designation" placeholder="যেমন: সাধারণ সদস্য" required class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-700 bg-slate-50">
      </div>
    </div>

    <div class="space-y-1.5">
      <label class="block text-xs font-bold text-gray-700">৮. ঠিকানা (গ্রাম, ওয়ার্ড, ডাকঘর, ইউনিয়ন, জেলা) <span class="text-rose-500">*</span></label>
      <input type="text" id="address" name="address" required placeholder="আউলিয়াপুর ইউনিয়ন, পটুয়াখালী সদর" class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-700 bg-slate-50">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-gray-700">৯. মোবাইল নম্বর <span class="text-rose-500">*</span></label>
        <input type="tel" id="phone" name="phone" required placeholder="০১৭১০১৮১০৫৯" class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-700 bg-slate-50">
      </div>
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-gray-700">১০. এনআইডি / জন্মনিবন্ধন <span class="text-rose-500">*</span></label>
        <input type="text" id="nid" name="nid" required placeholder="NID নম্বর" class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-700 bg-slate-50">
      </div>
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-gray-700">১১. রক্তের গ্রুপ <span class="text-rose-500">*</span></label>
        <select id="bloodGroup" name="bloodGroup" required class="w-full px-4 py-2.5 border rounded-xl text-sm bg-slate-50 text-gray-700">
          <option value="">নির্বাচন করুন</option>
          <option value="A+">A+</option><option value="A-">A-</option>
          <option value="B+">B+</option><option value="B-">B-</option>
          <option value="AB+">AB+</option><option value="AB-">AB-</option>
          <option value="O+">O+</option><option value="O-">O-</option>
        </select>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-gray-700">১২. মাসিক চাঁদা <span class="text-rose-500">*</span></label>
        <input type="number" id="monthlyFee" name="monthlyFee" value="100" required class="w-full px-4 py-2.5 border rounded-xl text-sm text-gray-700 bg-slate-50">
      </div>
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-gray-700">১৩. এক কপি ছবি আপলোড করুন</label>
        <input type="file" id="photo" name="photo" accept="image/*" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
      </div>
    </div>

    <div class="flex items-start gap-3 px-1.5 py-1">
      <input type="checkbox" id="agree-checkbox" onchange="document.getElementById('submit-btn').disabled = !this.checked; document.getElementById('submit-btn').classList.toggle('opacity-50', !this.checked);" class="mt-0.5 w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-gray-300 cursor-pointer">
      <label for="agree-checkbox" class="text-[11px] font-bold text-gray-600 leading-relaxed cursor-pointer">
        আমি সংগঠনের সকল নিয়মাবলী পড়েছি এবং আউলিয়াপুর অগ্রযাত্রা পরিষদের সদস্য হিসেবে সকল বিধিবিধান মেনে চলতে সম্মত আছি।
      </label>
    </div>

    <button type="submit" id="submit-btn" disabled class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-4 rounded-xl shadow-lg transition opacity-50 flex items-center justify-center gap-2">
      <i class="fa-solid fa-user-plus text-sm"></i> তথ্য সাবমিট করুন
    </button>
  </form>

  <div id="success-modal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-3xl shadow-2xl text-center max-w-sm w-full">
      <div class="mx-auto w-16 h-16 rounded-full bg-emerald-500 text-white flex items-center justify-center text-3xl mb-4">
        <i class="fa-solid fa-circle-check"></i>
      </div>
      <h4 class="text-xl font-black text-gray-800 mb-2">আবেদন সফল হয়েছে!</h4>
      <p class="text-xs text-gray-500 mb-4">আপনার সদস্য আইডি জেনারেট করা হয়েছে:</p>
      <span id="new-id-display" class="bg-emerald-50 text-emerald-800 font-extrabold text-lg px-5 py-2.5 rounded-xl border border-emerald-100 inline-block mb-6 font-mono">...</span>
      <button onclick="window.location.href='{{ route('home') }}'" class="w-full bg-emerald-600 text-white font-bold py-3 rounded-xl text-sm">হোম পেজে ফিরুন</button>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function submitMemberForm(e) {
    e.preventDefault();
    const form = document.getElementById('reg-form');
    const formData = new FormData(form);

    fetch('{{ route("member.store") }}', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        document.getElementById('new-id-display').innerText = data.memberId;
        document.getElementById('success-modal').classList.remove('hidden');
      } else {
        alert("ত্রুটি: " + (data.error || "সাবমিট করা সম্ভব হয়নি।"));
      }
    });
  }
</script>
@endpush
