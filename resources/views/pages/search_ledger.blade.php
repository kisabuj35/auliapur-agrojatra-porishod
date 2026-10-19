@extends('layouts.app')
@section('title', 'ব্যক্তিগত লেজার স্লিপ - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8 select-none font-sans">
  
  <div class="text-center mb-8">
    <div class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500/10 to-teal-500/10 text-emerald-700 text-xs px-4 py-1.5 rounded-full font-black uppercase tracking-wider border border-emerald-200 shadow-sm">
      <i class="fa-solid fa-shield-halved text-emerald-600"></i> ডিজিটাল খতিয়ান ও মেম্বারশিপ পোর্টাল
    </div>
    <h3 class="text-3xl sm:text-4xl font-black text-slate-800 mt-3 tracking-tight">ব্যক্তিগত লেজার স্লিপ</h3>
    <p class="text-slate-500 text-xs sm:text-sm mt-1.5 max-w-lg mx-auto">সদস্য আইডি বা মোবাইল নম্বর দিয়ে সম্পূর্ণ তথ্য ও হিসাব বিবরণী চেক করুন</p>
    <div class="w-20 h-1.5 bg-gradient-to-r from-emerald-500 via-teal-500 to-indigo-500 mx-auto mt-4 rounded-full"></div>
  </div>

  <!-- সার্চ বক্স -->
  <div class="bg-white/80 backdrop-blur-md p-6 sm:p-8 rounded-3xl shadow-xl border border-slate-100 text-center mb-10 transition-all">
    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-3 text-left flex items-center gap-2">
      <i class="fa-solid fa-magnifying-glass text-emerald-600"></i> সদস্য আইডি বা মোবাইল নম্বর লিখুন:
    </label>
    <div class="flex flex-col sm:flex-row gap-3">
      <div class="relative flex-grow">
        <input type="text" id="ledger-id-input" class="w-full pl-11 pr-4 py-3.5 border border-slate-200 rounded-2xl text-xs sm:text-sm text-slate-800 bg-slate-50/50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all font-semibold" placeholder="যেমন: AAP001 অথবা 01710181059">
        <i class="fa-solid fa-id-badge absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
      </div>
      <button onclick="fetchLedgerSlip()" class="bg-gradient-to-r from-emerald-600 to-teal-700 hover:from-emerald-700 hover:to-teal-800 text-white font-extrabold px-8 py-3.5 rounded-2xl text-xs sm:text-sm shadow-lg shadow-emerald-600/30 transition-all flex items-center justify-center gap-2 shrink-0">
        <i class="fa-solid fa-search"></i> অনুসন্ধান করুন
      </button>
    </div>
  </div>

  <div id="slip-loader" class="hidden text-center py-12">
    <div class="animate-spin rounded-full border-4 border-t-emerald-500 border-slate-200 h-11 w-11 mx-auto"></div>
    <p class="text-xs sm:text-sm text-slate-500 mt-4 font-bold tracking-wide">ডাটাবেজ থেকে তথ্য সংগ্রহ করা হচ্ছে...</p>
  </div>

  <!-- ডিজিটাল স্লিপ কার্ড -->
  <div id="ledger-slip-card" class="hidden bg-slate-50/50 rounded-[36px] shadow-2xl border border-slate-200/80 overflow-hidden">
    <div class="bg-gradient-to-r from-slate-900 via-emerald-900 to-slate-900 text-white p-6 sm:p-10 text-center relative select-none">
      <div class="relative inline-block mb-4">
        <img id="slip-photo" class="w-28 h-28 sm:w-32 sm:h-32 rounded-3xl border-4 border-white/90 object-cover bg-slate-800 shadow-2xl mx-auto" src="" alt="Member">
        <span id="slip-bg-badge" class="absolute -bottom-2 -right-2 bg-red-600 text-white text-[11px] font-black px-3 py-1 rounded-full shadow-lg border-2 border-white">...</span>
      </div>
      <h4 class="text-2xl sm:text-3xl font-black text-white tracking-wide">আউলিয়াপুর অগ্রযাত্রা পরিষদ</h4>
      <p class="text-xs text-emerald-300 font-medium tracking-wider mt-1">ডিজিটাল সদস্য চাঁদা ও ব্যক্তিগত তথ্য বিবরণী</p>
      <div class="mt-4 inline-flex items-center gap-2 bg-white/10 text-emerald-200 text-xs font-black px-5 py-2 rounded-full border border-white/15">
        <span id="slip-id-display">সদস্য আইডি: ...</span>
      </div>
    </div>

    <!-- মূল তথ্য -->
    <div class="p-6 sm:p-8 space-y-6">
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
        <div class="bg-white p-4 rounded-2xl border border-emerald-100 shadow-sm">
          <span class="text-[11px] font-bold text-gray-500 block mb-1">সর্বমোট ধার্য (ফরম ফিসহ)</span>
          <span id="slip-total-accrued" class="text-2xl font-black text-emerald-700">৳ ০</span>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-teal-100 shadow-sm">
          <span class="text-[11px] font-bold text-gray-500 block mb-1">সর্বমোট প্রদান</span>
          <span id="slip-grand-paid" class="text-2xl font-black text-teal-700">৳ ০</span>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-rose-100 shadow-sm">
          <span class="text-[11px] font-bold text-gray-500 block mb-1">মোট বকেয়া পাওনা</span>
          <span id="slip-due" class="text-2xl font-black text-rose-600">৳ ০</span>
        </div>
      </div>

      <div class="bg-white p-6 rounded-3xl border border-slate-200 text-xs sm:text-sm space-y-3">
        <p class="flex justify-between py-2 border-b"><span>নাম:</span> <span id="slip-name" class="font-bold text-slate-800">...</span></p>
        <p class="flex justify-between py-2 border-b"><span>পিতার নাম:</span> <span id="slip-father" class="font-bold text-slate-800">...</span></p>
        <p class="flex justify-between py-2 border-b"><span>মোবাইল নম্বর:</span> <span id="slip-phone" class="font-bold text-slate-800">...</span></p>
        <p class="flex justify-between py-2 border-b"><span>রক্তের গ্রুপ:</span> <span id="slip-bg" class="font-bold text-red-600">...</span></p>
        <p class="flex justify-between py-2 border-b"><span>সংগঠনে পদবী:</span> <span id="slip-designation" class="font-bold text-slate-800">...</span></p>
        <p class="flex justify-between py-2"><span>মাসিক নির্ধারিত ফি:</span> <span id="slip-monthly-fee" class="font-bold text-emerald-600">...</span></p>
      </div>

      <div class="text-center pt-4">
        <button onclick="window.print()" class="bg-slate-900 text-white px-8 py-3 rounded-2xl text-xs font-black shadow-lg">
          <i class="fa-solid fa-print mr-2"></i> স্লিপ প্রিন্ট করুন
        </button>
      </div>
    </div>
  </div>

  <div id="ledger-error" class="hidden bg-rose-50 text-rose-700 text-center p-6 rounded-3xl text-sm border border-rose-200 mt-6 font-bold">
    দুঃখিত, এই আইডি বা মোবাইল নম্বরটির কোনো বিবরণী ডাটাবেজে খুঁজে পাওয়া যায়নি!
  </div>
</div>
@endsection

@push('scripts')
<script>
  function fetchLedgerSlip() {
    const input = document.getElementById('ledger-id-input').value.trim();
    if (!input) return;

    document.getElementById('slip-loader').classList.remove('hidden');
    document.getElementById('ledger-slip-card').classList.add('hidden');
    document.getElementById('ledger-error').classList.add('hidden');

    fetch('{{ route("member.lookup") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({ idOrPhone: input })
    })
    .then(res => res.json())
    .then(data => {
      document.getElementById('slip-loader').classList.add('hidden');
      if (data.success) {
        const m = data.member;
        const l = data.ledger;
        document.getElementById('slip-id-display').innerText = "সদস্য আইডি: " + m.member_id;
        document.getElementById('slip-name').innerText = m.name;
        document.getElementById('slip-father').innerText = m.father_name || 'N/A';
        document.getElementById('slip-phone').innerText = m.phone;
        document.getElementById('slip-bg').innerText = m.blood_group || 'N/A';
        document.getElementById('slip-bg-badge').innerText = m.blood_group || 'N/A';
        document.getElementById('slip-designation').innerText = m.designation;
        document.getElementById('slip-monthly-fee').innerText = "৳ " + m.monthly_fee;

        document.getElementById('slip-total-accrued').innerText = "৳ " + l.total_accrued;
        document.getElementById('slip-grand-paid').innerText = "৳ " + l.total_paid;
        document.getElementById('slip-due').innerText = "৳ " + l.due;

        document.getElementById('slip-photo').src = m.photo || 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150';
        document.getElementById('ledger-slip-card').classList.remove('hidden');
      } else {
        document.getElementById('ledger-error').classList.remove('hidden');
      }
    })
    .catch(() => {
      document.getElementById('slip-loader').classList.add('hidden');
      document.getElementById('ledger-error').classList.remove('hidden');
    });
  }
</script>
@endpush
