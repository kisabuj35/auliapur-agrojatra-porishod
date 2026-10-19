@extends('layouts.app')
@section('title', 'রক্তদান কর্মসূচী ফর্ম - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12 select-none">
  
  <div class="bg-gradient-to-r from-red-600 to-rose-600 p-6 sm:p-8 rounded-t-3xl text-white text-center relative shadow-lg">
    <h3 class="text-2xl font-black">রক্তদান কর্মসূচী ফর্ম</h3>
    <p class="text-xs text-rose-100 mt-1">আউলিয়াপুর অগ্রযাত্রা পরিষদের রক্তদাতা ও রক্তগ্রহীতা ট্র্যাকার স্লিপ</p>
  </div>

  <form id="blood-form" onsubmit="submitBloodDonation(event)" class="bg-white p-6 sm:p-8 rounded-b-3xl shadow-xl border-x border-b border-gray-100 space-y-6">
    @csrf
    <h4 class="font-extrabold text-gray-700 text-sm border-b pb-2 flex items-center gap-2"><i class="fa-solid fa-droplet text-red-500 animate-pulse"></i> রক্তদাতার বিবরণী</h4>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-xs font-bold text-gray-500 mb-1">রক্তদাতার নাম *</label>
        <input type="text" name="donor_name" required placeholder="দাতার পূর্ণ নাম" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-xs">
      </div>
      <div>
        <label class="block text-xs font-bold text-gray-500 mb-1">পিতার নাম *</label>
        <input type="text" name="donor_father" required placeholder="পিতার নাম" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-xs">
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block text-xs font-bold text-gray-500 mb-1">রক্তের গ্রুপ *</label>
        <select name="donor_blood" required class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-xs">
          <option value="">নির্বাচন করুন</option>
          <option value="A+">A+</option><option value="A-">A-</option>
          <option value="B+">B+</option><option value="B-">B-</option>
          <option value="AB+">AB+</option><option value="AB-">AB-</option>
          <option value="O+">O+</option><option value="O-">O-</option>
        </select>
      </div>
      <div>
        <label class="block text-xs font-bold text-gray-500 mb-1">মোবাইল নম্বর *</label>
        <input type="tel" name="donor_phone" required placeholder="১১ ডিজিটের নম্বর" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-xs">
      </div>
      <div>
        <label class="block text-xs font-bold text-gray-500 mb-1">রক্তদানের তারিখ *</label>
        <input type="date" name="donation_date" required class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-xs">
      </div>
    </div>

    <h4 class="font-extrabold text-gray-700 text-sm border-b pb-2 pt-4 flex items-center gap-2"><i class="fa-solid fa-hospital text-emerald-600"></i> রক্তগ্রহীতার বিবরণী</h4>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-xs font-bold text-gray-500 mb-1">গ্রহীতার নাম *</label>
        <input type="text" name="recipient_name" required placeholder="গ্রহীতার পূর্ণ নাম" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-xs">
      </div>
      <div>
        <label class="block text-xs font-bold text-gray-500 mb-1">গ্রহীতার মোবাইল নম্বর *</label>
        <input type="tel" name="recipient_phone" required placeholder="১১ ডিজিটের নম্বর" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-xs">
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-xs font-bold text-gray-500 mb-1">গ্রহীতার ঠিকানা *</label>
        <input type="text" name="recipient_address" required placeholder="গ্রাম বা জেলা ও ইউনিয়ন" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-xs">
      </div>
      <div>
        <label class="block text-xs font-bold text-gray-500 mb-1">রোগের সমস্যা *</label>
        <input type="text" name="recipient_disease" required placeholder="ডেলিভারি / থ্যালাসেমিয়া" class="w-full px-4 py-2.5 border rounded-xl bg-slate-50 text-xs">
      </div>
    </div>

    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-extrabold py-4 rounded-xl shadow-lg transition">
      <i class="fa-solid fa-heart mr-1"></i> রক্তদান রিপোর্ট সাবমিট করুন
    </button>
  </form>
</div>
@endsection

@push('scripts')
<script>
  function submitBloodDonation(e) {
    e.preventDefault();
    const form = document.getElementById('blood-form');
    const formData = new FormData(form);

    fetch('{{ route("blood.donation.store") }}', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("রক্তদান রিপোর্ট সফলভাবে সংরক্ষিত হয়েছে! অনুমোদনের পর বোর্ডে প্রদর্শিত হবে।");
        window.location.href = "{{ route('blood.board') }}";
      }
    });
  }
</script>
@endpush
