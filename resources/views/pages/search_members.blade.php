@extends('layouts.app')
@section('title', 'সদস্য অনুসন্ধান পোর্টাল - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-[1600px] mx-auto px-3 sm:px-6 lg:px-8 py-8 select-none font-sans">
  
  <div class="text-center mb-8">
    <span class="bg-emerald-50 text-emerald-700 text-xs px-3.5 py-1.5 rounded-full font-black uppercase tracking-wider border border-emerald-100">
      <i class="fa-solid fa-users-viewfinder mr-1"></i> সদস্য ডিরেক্টরি পোর্টাল
    </span>
    <h3 class="text-3xl font-black text-slate-800 mt-2.5">সদস্য অনুসন্ধান পোর্টাল</h3>
    <p class="text-slate-500 text-xs sm:text-sm mt-1">আউলিয়াপুর অগ্রযাত্রা পরিষদের নিবন্ধিত সদস্য তালিকা ও সার্চ কন্ট্রোল</p>
    <div class="w-16 h-1 bg-emerald-500 mx-auto mt-3 rounded-full"></div>
  </div>

  <form method="GET" action="{{ route('member.search') }}" class="bg-white p-5 sm:p-7 rounded-3xl shadow-lg mb-8 grid grid-cols-1 md:grid-cols-3 gap-4 border border-slate-100">
    <div class="relative md:col-span-2">
      <label class="block text-xs font-bold text-slate-600 mb-1.5">অনুসন্ধান করুন (মোবাইল নম্বর বা আইডি)</label>
      <div class="relative">
        <input type="text" name="q" value="{{ request('q') }}" class="w-full pl-10 pr-4 py-3 border rounded-2xl text-xs sm:text-sm bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-400" placeholder="যেমন: AAP001 অথবা ০১৭০০০০০০০০...">
        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-4 text-slate-400 text-xs"></i>
      </div>
    </div>
    
    <div>
      <label class="block text-xs font-bold text-slate-600 mb-1.5">সদস্যের ধরণ (ক্যাটাগরি)</label>
      <select name="type" onchange="this.form.submit()" class="w-full px-4 py-3 border rounded-2xl text-xs sm:text-sm bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-400">
        <option value="">সকল সদস্য (All Category)</option>
        <option value="সাধারণ সদস্য" {{ request('type') == 'সাধারণ সদস্য' ? 'selected' : '' }}>সাধারণ সদস্য</option>
        <option value="ফাউন্ডার মেম্বার" {{ request('type') == 'ফাউন্ডার মেম্বার' ? 'selected' : '' }}>প্রতিষ্ঠাতা সদস্য (Founder)</option>
        <option value="আজীবন সদস্য" {{ request('type') == 'আজীবন সদস্য' ? 'selected' : '' }}>আজীবন সদস্য</option>
        <option value="দাতা সদস্য" {{ request('type') == 'দাতা সদস্য' ? 'selected' : '' }}>দাতা সদস্য</option>
      </select>
    </div>
  </form>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5 lg:gap-6">
    @forelse($members as $m)
      <div class="bg-white rounded-[30px] shadow-sm hover:shadow-xl border border-slate-200/80 p-4 sm:p-5 transition-all flex flex-col justify-between">
        <div>
          <div class="relative mb-3.5 overflow-hidden rounded-2xl bg-slate-100 w-full aspect-[4/5] sm:h-64">
            <img class="w-full h-full object-cover object-top" src="{{ $m->photo ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150' }}" alt="{{ $m->name }}">
            <span class="absolute top-2.5 left-2.5 bg-slate-900/80 text-white text-[10px] px-2.5 py-1 rounded-full font-black uppercase tracking-wider">{{ $m->member_id }}</span>
            <span class="absolute top-2.5 right-2.5 bg-rose-600 text-white font-extrabold px-2.5 py-1 rounded-full text-[10px] uppercase">{{ $m->blood_group ?? 'N/A' }}</span>
          </div>

          <h4 class="text-lg font-black text-slate-800 mb-1 truncate">{{ $m->name }}</h4>
          <span class="inline-block bg-emerald-50 text-emerald-700 font-bold text-[11px] px-3 py-0.5 rounded-full mb-3">{{ $m->designation }}</span>

          <div class="space-y-1.5 text-xs text-slate-500 mb-4">
            <p class="flex justify-between py-1 border-b"><span>পিতার নাম:</span> <span class="font-bold text-slate-700">{{ $m->father_name ?? 'N/A' }}</span></p>
            <p class="flex justify-between py-1 border-b"><span>মোবাইল:</span> <span class="font-bold text-slate-700">{{ $m->phone }}</span></p>
            <p class="flex justify-between py-1"><span>ঠিকানা:</span> <span class="font-bold text-slate-700 truncate max-w-[150px]">{{ $m->address }}</span></p>
          </div>
        </div>

        <div class="pt-3 border-t flex justify-between items-center">
          <a href="tel:{{ $m->phone }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-extrabold px-3 py-2 rounded-xl transition flex items-center gap-1">
            <i class="fa-solid fa-phone-volume"></i> কল দিন
          </a>
          <a href="{{ route('member.ledger') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-2 rounded-xl text-[11px] font-bold transition">লেজার স্লিপ</a>
        </div>
      </div>
    @empty
      <p class="col-span-full text-center text-xs text-slate-400 py-12 font-bold">কোনো সক্রিয় সদস্যের তথ্য পাওয়া যায়নি।</p>
    @endforelse
  </div>

  <div class="mt-8">
    {{ $members->links() }}
  </div>
</div>
@endsection
