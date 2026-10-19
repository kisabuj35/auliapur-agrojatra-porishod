@extends('layouts.app')
@section('title', 'হোম - আউলিয়াপুর অগ্রযাত্রা পরিষদ')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 select-none relative">
  <!-- ১. স্লাইডার হিরো ব্যানার -->
  <section class="relative text-white py-28 px-4 sm:px-6 lg:px-8 shadow-inner overflow-hidden select-none min-h-[480px] flex items-center justify-center rounded-3xl">
    <div class="absolute inset-0 z-0">
      <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 opacity-100" id="slide-1" style="background-image: url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&q=80&w=1200');"></div>
      <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 opacity-0" id="slide-2" style="background-image: url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&q=80&w=1200');"></div>
      <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 opacity-0" id="slide-3" style="background-image: url('https://images.unsplash.com/photo-1593113598332-cd288d649433?auto=format&fit=crop&q=80&w=1200');"></div>
      <div class="absolute inset-0 bg-emerald-950/75 z-10"></div>
    </div>

    <div class="relative max-w-7xl mx-auto text-center z-20 space-y-4">
      <span class="inline-block bg-emerald-900/60 text-white text-xs px-4 py-1.5 rounded-full font-black uppercase tracking-wider shadow border border-emerald-800/40">২০২৬ সালে প্রতিষ্ঠিত সামাজিক সংগঠন</span>
      <h2 class="text-3xl sm:text-5xl font-black leading-tight tracking-tight">আউলিয়াপুর অগ্রযাত্রা পরিষদ</h2>
      <p class="text-sm sm:text-base text-emerald-50 font-bold italic leading-relaxed">"আজকের উদ্যোগ, আগামীর অগ্রযাত্রা।"</p>
      
      <div class="max-w-3xl mx-auto space-y-3 pt-3">
        <p class="text-sm sm:text-base text-emerald-50 font-bold italic leading-relaxed">
          "মানুষ মানুষের জন্য, জীবন জীবনের জন্য — আসুন স্বার্থহীন সেবার মাধ্যমে অসহায় মানুষের মুখে হাসি ফোটাই।"
        </p>
      </div>
    </div>
  </section>

  <!-- ফ্লোটিং লাইভ কাউন্টার -->
  <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 relative z-20 select-none">
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-6 flex flex-col md:flex-row divide-y md:divide-y-0 md:divide-x divide-gray-100 text-center">
      <div class="flex-1 py-4 hover:bg-emerald-50/20 transition rounded-l-3xl">
        <span class="block text-4xl font-black text-emerald-600">{{ \App\Helpers\BanglaHelper::toBn($totalPlanted) }}+</span>
        <span class="text-gray-500 text-xs font-bold uppercase mt-1 block">বৃক্ষরোপণ কর্মসূচি</span>
      </div>
      <div class="flex-1 py-4 hover:bg-emerald-50/20 transition">
        <span class="block text-4xl font-black text-emerald-600">{{ \App\Helpers\BanglaHelper::toBn($totalMembers) }}</span>
        <span class="text-gray-500 text-xs font-bold uppercase mt-1 block">নিবন্ধিত সক্রিয় সদস্য</span>
      </div>
      <div class="flex-1 py-4 hover:bg-emerald-50/20 transition rounded-r-3xl">
        <span class="block text-4xl font-black text-emerald-600">{{ \App\Helpers\BanglaHelper::toBn($totalBlood) }}</span>
        <span class="text-gray-500 text-xs font-bold uppercase mt-1 block">মোট রক্তদান সম্পন্ন</span>
      </div>
    </div>
  </section>

  <!-- সাম্প্রতিক কার্যক্রম -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12 select-none">
      <span class="bg-emerald-50 text-emerald-700 text-xs px-3 py-1 rounded-full font-extrabold uppercase">আমাদের কাজ</span>
      <h3 class="text-3xl font-extrabold text-gray-800 mt-2">সাম্প্রতিক কার্যক্রম</h3>
      <div class="w-16 h-1 bg-emerald-500 mx-auto mt-3 rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      @forelse($recentActivities as $act)
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-emerald-400 hover:shadow-lg hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group">
          <div>
            <div class="text-emerald-500 bg-emerald-50 p-3 rounded-xl inline-block mb-4 group-hover:scale-110 transition-all"><i class="fa-solid fa-seedling text-xl"></i></div>
            <span class="block text-xs text-gray-400 font-bold mb-1"><i class="fa-regular fa-calendar-check mr-1.5"></i> {{ \App\Helpers\BanglaHelper::bnDate($act->date) }}</span>
            <h4 class="text-lg font-extrabold text-gray-800 mb-2 group-hover:text-emerald-600 transition">{{ $act->title }}</h4>
            <p class="text-gray-500 text-xs leading-relaxed mb-4">{{ $act->desc }}</p>
          </div>
          <a href="{{ route('project.view', $act->sector) }}" class="text-emerald-600 hover:text-emerald-700 text-xs font-bold flex items-center transition">বিস্তারিত পড়ুন <i class="fa-solid fa-arrow-right-long ml-1.5 text-xs"></i></a>
        </div>
      @empty
        <p class="col-span-3 text-center text-xs text-gray-400 py-6">বর্তমানে কোনো কার্যক্রম তালিকাভুক্ত নেই।</p>
      @endforelse
    </div>
  </section>

  <!-- প্রধান উপদেষ্টার বাণী -->
  @if($advisor)
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
      <h3 class="text-3xl font-extrabold text-gray-800">প্রধান উপদেষ্টার বাণী</h3>
      <div class="w-16 h-1 bg-emerald-500 mx-auto mt-3 rounded-full"></div>
    </div>

    <div class="bg-white rounded-[32px] shadow-xl border border-gray-100 p-8 flex flex-col lg:flex-row gap-8">
      <div class="lg:w-1/3 flex flex-col items-center border-r border-gray-100 pr-0 lg:pr-8 text-center select-none">
        <img class="w-40 h-44 rounded-3xl border-4 border-emerald-50 object-cover object-top shadow-lg mb-4" src="{{ $advisor->photo ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150' }}" alt="Advisor">
        <h4 class="text-2xl font-black text-gray-800 mb-1">{{ $advisor->name }}</h4>
        <span class="text-xs bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-full font-extrabold mb-6">{{ $advisor->designation }}</span>
        
        <div class="space-y-3.5 text-sm text-gray-500 w-full font-semibold text-left">
          <p><i class="fa-solid fa-briefcase text-emerald-500 w-6"></i> পেশা: <span class="font-bold text-gray-700">{{ $advisor->profession ?? 'সমাজসেবক' }}</span></p>
          <p><i class="fa-solid fa-phone text-emerald-500 w-6"></i> ফোন: <span class="font-bold text-gray-700">{{ $advisor->phone }}</span></p>
        </div>
      </div>

      <div class="lg:w-2/3 flex flex-col justify-between">
        <div class="text-gray-600 text-sm leading-relaxed space-y-4 italic py-4">
          <p class="text-sm sm:text-base text-gray-700 mb-2 leading-relaxed font-semibold">"{{ $advisor->message ?? 'আউলিয়াপুর অগ্রযাত্রা পরিষদ এগিয়ে যাক...' }}"</p>
        </div>
        <div class="mt-8 flex justify-end border-t border-gray-50 pt-4">
          <div class="text-right">
            <span class="font-extrabold text-gray-800 text-base">{{ $advisor->name }}</span>
            <p class="text-xs text-gray-400">প্রধান উপদেষ্টা</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endif

  <!-- ডোনার ও শুভাকাঙ্ক্ষী স্লাইডার -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12 select-none">
      <span class="bg-emerald-50 text-emerald-700 text-xs px-3 py-1 rounded-full font-extrabold uppercase">আমাদের সহযোগীরা</span>
      <h3 class="text-3xl font-extrabold text-gray-800 mt-2">ডোনার ও পার্টনার</h3>
      <div class="w-16 h-1 bg-emerald-500 mx-auto mt-3 rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach($donors as $donor)
        <div class="bg-white rounded-[32px] p-6 shadow-sm border border-gray-100 flex flex-col justify-between hover:border-emerald-400 hover:shadow-md transition duration-300">
          <div>
            <img class="w-full aspect-square object-cover object-top rounded-2xl mb-4" src="{{ $donor->photo ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150' }}" alt="{{ $donor->name }}">
            <h4 class="font-extrabold text-gray-800 text-base">{{ $donor->name }}</h4>
            <p class="text-xs text-emerald-600 font-semibold mt-1"><i class="fa-solid fa-briefcase mr-1 text-[10px]"></i> {{ $donor->designation }}</p>
          </div>
          <div class="pt-4 border-t border-gray-100 mt-5 flex justify-between items-center select-none">
            <a href="tel:{{ $donor->phone }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-bold px-3 py-2 rounded-xl transition flex items-center gap-1 shadow-sm">
              <i class="fa-solid fa-phone-volume"></i> কল করুন
            </a>
          </div>
        </div>
      @endforeach
    </div>
  </section>
</div>
@endsection

@push('scripts')
<script>
  let currentSlide = 1;
  setInterval(function() {
    let nextSlide = currentSlide === 3 ? 1 : currentSlide + 1;
    let curEl = document.getElementById('slide-' + currentSlide);
    let nextEl = document.getElementById('slide-' + nextSlide);
    if (curEl && nextEl) {
      curEl.classList.replace('opacity-100', 'opacity-0');
      nextEl.classList.replace('opacity-0', 'opacity-100');
    }
    currentSlide = nextSlide;
  }, 4500);
</script>
@endpush
