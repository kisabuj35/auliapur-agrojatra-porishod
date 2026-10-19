@extends('layouts.app')
@section('title', 'রক্ত ডোনার তালিকা - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12 select-none">
  
  <div class="bg-gradient-to-r from-emerald-800 to-teal-800 p-8 rounded-3xl text-white text-center shadow-lg mb-8 relative">
    <h3 class="text-3xl font-black">রক্ত ডোনার তালিকা</h3>
    <p class="text-xs sm:text-sm text-emerald-100 mt-2 font-medium">রক্তদাতাদের তালিকা — জরুরি মুহূর্তে সরাসরি যোগাযোগ করুন</p>
  </div>

  <form method="GET" action="{{ route('blood.donors') }}" class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 space-y-5 mb-8">
    <div class="relative max-w-2xl mx-auto">
      <input type="text" name="q" value="{{ request('q') }}" class="w-full pl-10 pr-4 py-3 border rounded-2xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-400" placeholder="নাম, এলাকা বা রক্তের গ্রুপ দিয়ে খুঁজুন...">
      <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-gray-400 text-sm"></i>
    </div>

    <div class="flex flex-wrap justify-center gap-2 pt-1">
      <a href="{{ route('blood.donors', ['group' => 'ALL', 'q' => request('q')]) }}" class="px-4 py-1.5 rounded-full text-xs font-black {{ request('group', 'ALL') == 'ALL' ? 'bg-emerald-600 text-white' : 'bg-slate-50 text-slate-600 border' }}">সকল গ্রুপ</a>
      @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $grp)
        <a href="{{ route('blood.donors', ['group' => $grp, 'q' => request('q')]) }}" class="px-4 py-1.5 rounded-full text-xs font-black {{ request('group') == $grp ? 'bg-emerald-600 text-white' : 'bg-slate-50 text-slate-600 border' }}">{{ $grp }}</a>
      @endforeach
    </div>
  </form>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($donors as $item)
      <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col justify-between">
        <div class="bg-gradient-to-br from-emerald-600 to-teal-700 pt-7 pb-6 px-5 text-center relative text-white">
          <span class="absolute top-3.5 right-3.5 bg-rose-600 font-extrabold px-2 py-0.5 rounded text-[10px]">{{ $item->blood_group }}</span>
          <img class="w-20 h-20 rounded-2xl border-2 border-white/40 object-cover mx-auto mb-3" src="{{ $item->photo ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150' }}" alt="{{ $item->name }}">
          <h4 class="text-lg font-bold">{{ $item->name }}</h4>
          <span class="bg-white/20 text-[10px] px-3.5 py-1 rounded-full uppercase">{{ $item->donor_type }}</span>
        </div>

        <div class="p-5 flex-1 flex flex-col justify-between">
          <div class="space-y-2 text-xs text-gray-500">
            <p class="flex justify-between py-1 border-b"><span>ঠিকানা:</span> <span class="font-bold text-gray-700">{{ $item->upazila ?? $item->village }}</span></p>
            <p class="flex justify-between py-1 border-b"><span>শেষ রক্তদান:</span> <span class="font-bold text-gray-700">{{ \App\Helpers\BanglaHelper::bnDate($item->last_donation_date) }}</span></p>
          </div>
          
          <div class="pt-4 border-t mt-4 flex justify-between items-center">
            <a href="tel:{{ $item->phone }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold px-4 py-2 rounded-xl transition flex items-center gap-1.5 shadow-sm">
              <i class="fa-solid fa-phone-volume"></i> কল করুন
            </a>
          </div>
        </div>
      </div>
    @empty
      <div class="col-span-full text-center py-12 text-gray-400 bg-white rounded-3xl border font-bold">কোনো ডোনার পাওয়া যায়নি।</div>
    @endforelse
  </div>

  <div class="mt-8">
    {{ $donors->links() }}
  </div>
</div>
@endsection
