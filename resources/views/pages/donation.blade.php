@extends('layouts.app')
@section('title', 'দান করুন - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8 select-none">
  <div class="w-full bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
    
    <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-6 sm:p-8 text-white text-center">
      <h3 class="text-2xl font-black">দান ও সাহায্য পোর্টাল</h3>
      <p class="text-xs text-orange-100 mt-1.5 leading-relaxed">আউলিয়াপুর অগ্রযাত্রা পরিষদের ফান্ডে আপনার অনুদান প্রদান করুন</p>
    </div>

    <form id="donation-form" onsubmit="submitDonationPay(event)" class="p-6 sm:p-8 space-y-5 text-xs font-bold text-gray-600 bg-white">
      @csrf
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-gray-500 mb-1">আপনার নাম *</label>
          <input type="text" name="donor_name" required placeholder="আপনার পূর্ণ নাম" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-gray-700">
        </div>
        <div>
          <label class="block text-gray-500 mb-1">মোবাইল নম্বর *</label>
          <input type="tel" name="phone" required placeholder="১১ ডিজিটের মোবাইল নম্বর" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-gray-700">
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-gray-500 mb-1">টাকার পরিমাণ (৳) *</label>
          <input type="number" name="amount" required placeholder="টাকার পরিমাণ লিখুন" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-gray-700">
        </div>
        <div>
          <label class="block text-gray-500 mb-1">পেমেন্ট মেথড *</label>
          <select name="method" required class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-gray-700">
            <option value="bKash">bKash (01760264893)</option>
            <option value="Nagad">Nagad (01760264893)</option>
            <option value="Rocket">Rocket (01710181059)</option>
            <option value="Bank">ব্যাংক ট্রান্সফার</option>
          </select>
        </div>
      </div>

      <div>
        <label class="block text-gray-500 mb-1">ট্রানজেকশন আইডি (TxnID) *</label>
        <input type="text" name="txn_id" required placeholder="যেমন: 8N70X9K2M9" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-gray-700 font-mono">
      </div>

      <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-black py-4 rounded-xl shadow-lg transition">
        <i class="fa-solid fa-heart mr-1"></i> অনুদান নিশ্চিত করুন
      </button>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function submitDonationPay(e) {
    e.preventDefault();
    const form = document.getElementById('donation-form');
    const formData = new FormData(form);

    fetch('{{ route("donation.store") }}', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("আপনার অনুদানের তথ্য সফলভাবে গৃহীত হয়েছে। ধন্যবাদ!");
        window.location.href = "{{ route('home') }}";
      }
    });
  }
</script>
@endpush
