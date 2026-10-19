@extends('layouts.app')
@section('title', 'চাঁদা ও অনুদান পরিশোধ - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8 select-none">
  <div class="w-full bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
    
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 p-6 sm:p-8 text-white text-center relative">
      <div class="absolute top-4 right-4 bg-white/20 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
        <i class="fa-solid fa-heart animate-pulse"></i> পেমেন্ট গেটওয়ে
      </div>
      <h3 class="text-2xl font-black">চাঁদা ও অনুদান পোর্টাল</h3>
      <p class="text-xs text-emerald-100 mt-1.5 leading-relaxed">আউলিয়াপুর অগ্রযাত্রা পরিষদের ফান্ডে আপনার চাঁদা বা অনুদান নিরাপদে প্রেরণ করুন</p>
    </div>

    <form id="pay-form" action="{{ route('member.payment.store') }}" method="POST" class="p-6 sm:p-8 space-y-5 text-xs font-bold text-gray-600 bg-white">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1.5">সদস্য আইডি *</label>
          <input type="text" name="member_id" id="pay-id" required placeholder="যেমন: AAP001" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-gray-700 text-xs font-semibold">
        </div>
        <div>
          <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1.5">টাকার পরিমাণ *</label>
          <input type="number" name="amount" required placeholder="টাকার পরিমাণ লিখুন" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-gray-700 text-xs font-semibold">
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1.5">পেমেন্ট মাধ্যম *</label>
          <select name="method" required class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-gray-700 text-xs font-semibold">
            <option value="bKash">bKash (বিকাশ - 01710181059)</option>
            <option value="Nagad">Nagad (নগদ - 01710181059)</option>
            <option value="Rocket">Rocket (রকেট - 01710181059)</option>
            <option value="Bank">ব্যাংক ট্রান্সফার</option>
            <option value="Cash">ক্যাশ প্রদান</option>
          </select>
        </div>
        <div>
          <label class="block text-[10px] font-extrabold text-gray-500 uppercase tracking-wider mb-1.5">ট্রানজেকশন আইডি (TxnID) *</label>
          <input type="text" name="txn_id" required placeholder="যেমন: 8N70X9K2M9" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-gray-700 text-xs font-semibold font-mono">
        </div>
      </div>

      <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-xl shadow-lg transition">
        <i class="fa-solid fa-credit-card mr-1"></i> পরিশোধ নিশ্চিত করুন
      </button>
    </form>
  </div>
</div>
@endsection
