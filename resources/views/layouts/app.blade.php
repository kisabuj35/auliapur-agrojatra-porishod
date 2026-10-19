<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'আউলিয়াপুর অগ্রযাত্রা পরিষদ')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <style>
    body { font-family: 'Hind Siliguri', sans-serif; }
    .nav-active { color: #059669 !important; background-color: #f0fdf4; border-radius: 8px; }
  </style>
  @stack('styles')
</head>
<body class="bg-gray-50 flex flex-col min-h-screen text-gray-800">

<!-- টপ ইউটিলিটি বার -->
<div class="bg-slate-900 text-white text-xs py-2 border-b border-slate-800 select-none">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center flex-wrap gap-2">
    <div class="flex items-center space-x-2 font-medium">
      <i class="fa-solid fa-flag text-emerald-500"></i>
      <span>আজকের উদ্যোগ আগামীর অগ্রযাত্রা</span>
    </div>
    <div class="flex items-center space-x-4 text-gray-300">
      <a href="tel:+8801710181059" class="hover:text-emerald-400 transition flex items-center">
        <i class="fa-solid fa-phone text-emerald-500 mr-1.5"></i> +৮৮০ ১৭১০-১৮১০৫৯
      </a>
      <span class="hidden sm:inline text-slate-700">|</span>
      <a href="mailto:kisabuj35@gmail.com" class="hover:text-emerald-400 transition flex items-center">
        <i class="fa-solid fa-envelope text-emerald-500 mr-1.5"></i> kisabuj35@gmail.com 
      </a>
    </div>
  </div>
</div>

<!-- হেডার ও নেভিগেশন বার -->
<header class="bg-white shadow-md sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-20 items-center">
      
      <!-- লোগো ও টাইটেল -->
      <a href="{{ route('home') }}" class="flex items-center space-x-2 sm:space-x-3 cursor-pointer select-none">
        <div class="bg-emerald-50 p-1 rounded-full shadow-md shrink-0 w-11 h-11 sm:w-12 sm:h-12 flex items-center justify-center overflow-hidden">
          <img src="https://lh3.googleusercontent.com/d/1Z6FVIIFOBq8kWcdalYa0lczot3yLS5Vl" alt="Logo" class="w-full h-full object-cover rounded-full">
        </div>
        <div>
          <h1 class="text-sm sm:text-base md:text-lg lg:text-xl font-bold text-gray-800 leading-tight">আউলিয়াপুর অগ্রযাত্রা পরিষদ</h1>
          <p class="text-[9px] sm:text-xs text-emerald-600 font-semibold tracking-wide">মানবিক সেবামূলক সংগঠন, পটুয়াখালী</p>
        </div>
      </a>

      <!-- ডেস্কটপ মেনু -->
      <nav class="hidden md:flex space-x-1 xl:space-x-2 text-sm font-semibold text-gray-600 items-center">
        <a href="{{ route('home') }}" class="hover:bg-emerald-50 hover:text-emerald-700 px-3 py-2 rounded-lg transition {{ request()->routeIs('home') ? 'nav-active' : '' }}">হোম</a>
        
        <!-- আমাদের সম্পর্কে -->
        <div class="relative group">
          <button class="hover:bg-emerald-50 hover:text-emerald-700 px-3 py-2 rounded-lg flex items-center transition focus:outline-none">
            আমাদের সম্পর্কে <i class="fa-solid fa-chevron-down text-[10px] ml-1 transition group-hover:rotate-180"></i>
          </button>
          <div class="absolute left-0 top-full pt-1 w-52 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 z-50">
            <div class="bg-white border border-gray-100 rounded-lg shadow-lg py-1">
              <a href="{{ route('about.intro') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-address-card mr-2 text-emerald-600 w-4"></i>আমাদের সম্পর্কে</a>
              <a href="{{ route('about.rules') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-scale-balanced mr-2 text-emerald-600 w-4"></i>সংগঠনের বিধিমালা</a>
              <a href="{{ route('about.mission') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-bullseye mr-2 text-emerald-600 w-4"></i>লক্ষ্য ও উদ্দেশ্য</a>
              <a href="{{ route('about.faq') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-circle-question mr-2 text-emerald-600 w-4"></i>প্রশ্ন ও উত্তর</a>
            </div>
          </div>
        </div>

        <!-- কমিটি -->
        <div class="relative group">
          <button class="hover:bg-emerald-50 hover:text-emerald-700 px-3 py-2 rounded-lg flex items-center transition focus:outline-none">
            কমিটি <i class="fa-solid fa-chevron-down text-[10px] ml-1 transition group-hover:rotate-180"></i>
          </button>
          <div class="absolute left-0 top-full pt-1 w-52 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 z-50">
            <div class="bg-white border border-gray-100 rounded-lg shadow-lg py-1">
              <a href="{{ route('committee.advisors') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-graduation-cap mr-2 text-emerald-600 w-4"></i>উপদেষ্টা মণ্ডলী</a>
              <a href="{{ route('committee.executives') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-users mr-2 text-emerald-600 w-4"></i>কার্যনির্বাহী পরিষদ</a>
              <a href="{{ route('committee.list') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-list mr-2 text-emerald-600 w-4"></i>কমিটি তালিকা</a>
            </div>
          </div>
        </div>

        <!-- মিডিয়া -->
        <div class="relative group">
          <button class="hover:bg-emerald-50 hover:text-emerald-700 px-3 py-2 rounded-lg flex items-center transition focus:outline-none">
            মিডিয়া <i class="fa-solid fa-chevron-down text-[10px] ml-1 transition group-hover:rotate-180"></i>
          </button>
          <div class="absolute left-0 top-full pt-1 w-52 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 z-50">
            <div class="bg-white border border-gray-100 rounded-lg shadow-lg py-1">
              <a href="{{ route('media.photos') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-image mr-2 text-emerald-600 w-4"></i>ফটো গ্যালারি</a>
              <a href="{{ route('media.videos') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-video mr-2 text-emerald-600 w-4"></i>ভিডিও গ্যালারি</a>
              <a href="{{ route('media.news') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-newspaper mr-2 text-emerald-600 w-4"></i>বিজ্ঞপ্তি</a>
              <a href="{{ route('media.press') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-newspaper mr-2 text-emerald-600 w-4"></i>পত্রিকায় সংবাদ</a>
              <a href="{{ route('media.awards') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-trophy mr-2 text-emerald-600 w-4"></i>পুরস্কার ও সম্মাননা</a>
            </div>
          </div>
        </div>

        <!-- প্রকল্প -->
        <div class="relative group">
          <button class="hover:bg-emerald-50 hover:text-emerald-700 px-3 py-2 rounded-lg flex items-center transition focus:outline-none">
            প্রকল্প <i class="fa-solid fa-chevron-down text-[10px] ml-1 transition group-hover:rotate-180"></i>
          </button>
          <div class="absolute left-0 top-full pt-1 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 z-50">
            <div class="bg-white border border-gray-100 rounded-lg shadow-lg py-1">
              <a href="{{ route('project.view', 'উষ্ণ হোক শীত') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-snowflake mr-2 text-emerald-600 w-4"></i>উষ্ণ হোক শীত</a>
              <a href="{{ route('project.view', 'তরুণ জ্ঞানের দীপশিখা') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-book-open mr-2 text-emerald-600 w-4"></i>তরুণ জ্ঞানের দীপশিখা</a>
              <a href="{{ route('project.view', 'সবুজ স্বপ্ন') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-tree mr-2 text-emerald-600 w-4"></i>সবুজ স্বপ্ন</a>
              <a href="{{ route('project.view', 'সম্প্রীতির কুরবানি') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-hands-holding-child mr-2 text-emerald-600 w-4"></i>সম্প্রীতির কুরবানি</a>
              <a href="{{ route('project.view', 'ভাতের হাসি') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-bowl-rice mr-2 text-emerald-600 w-4"></i>ভাতের হাসি</a>
              <a href="{{ route('project.view', 'মেধাবীদের সম্মাননা') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-graduation-cap mr-2 text-emerald-600 w-4"></i>মেধাবীদের সম্মাননা</a>
            </div>
          </div>
        </div>

        <!-- সদস্য পোর্টাল -->
        <div class="relative group">
          <button class="hover:bg-emerald-50 hover:text-emerald-700 px-3 py-2 rounded-lg flex items-center transition focus:outline-none">
            সদস্য পোর্টাল <i class="fa-solid fa-chevron-down text-[10px] ml-1 transition group-hover:rotate-180"></i>
          </button>
          <div class="absolute left-0 top-full pt-1 w-52 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 z-50">
            <div class="bg-white border border-gray-100 rounded-lg shadow-lg py-1">
              <a href="{{ route('member.register') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-user-plus mr-2 text-emerald-600 w-4"></i>সদস্য তথ্য ফর্ম</a>
              <a href="{{ route('member.payment') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-credit-card mr-2 text-emerald-600 w-4"></i>ফি বা চাঁদা প্রদান</a>
              <a href="{{ route('member.search') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-magnifying-glass mr-2 text-emerald-600 w-4"></i>সদস্য তালিকা</a>
              <a href="{{ route('member.ledger') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-file-invoice-dollar mr-2 text-emerald-600 w-4"></i>ব্যক্তিগত লেজার স্লিপ</a>
            </div>
          </div>
        </div>

        <!-- রক্তদান -->
        <div class="relative group">
          <button class="hover:bg-emerald-50 hover:text-emerald-700 px-3 py-2 rounded-lg flex items-center transition focus:outline-none">
            রক্তদান <i class="fa-solid fa-chevron-down text-[10px] ml-1 transition group-hover:rotate-180"></i>
          </button>
          <div class="absolute left-0 top-full pt-1 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 z-50">
            <div class="bg-white border border-gray-100 rounded-lg shadow-lg py-1">
              <a href="{{ route('blood.board') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-chart-line mr-2 text-emerald-600 w-4"></i>রক্তদাতার পরিসংখ্যান</a>
              <a href="{{ route('blood.donors') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-users-viewfinder mr-2 text-emerald-600 w-4"></i>রক্ত ডোনার তালিকা</a>
              <a href="{{ route('blood.donor.register') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-user-plus mr-2 text-emerald-600 w-4"></i>রক্ত ডোনার নিবন্ধন</a>
              <a href="{{ route('blood.donation.report') }}" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-droplet mr-2 text-emerald-600 w-4"></i>রক্তদান ফর্ম</a> 
            </div>
          </div>
        </div>
        
        <!-- দান করুন -->
        <a href="{{ route('donation') }}" class="bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-extrabold px-5 py-2.5 rounded-2xl text-xs flex items-center shadow-lg shadow-orange-500/20 hover:shadow-xl transition duration-300 ml-2 scale-[1.03] shrink-0">
          <i class="fa-solid fa-heart mr-1.5 animate-pulse text-sm"></i> দান করুন
        </a>
        
        <!-- যোগাযোগ -->
        <a href="{{ route('contact') }}" class="hover:bg-emerald-50 hover:text-emerald-700 px-3 py-2 rounded-lg transition duration-200 {{ request()->routeIs('contact') ? 'nav-active' : '' }}">যোগাযোগ</a>
        
        <!-- অ্যাডমিন -->
        <a href="{{ route('admin.index') }}" class="bg-slate-900 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg transition duration-200 flex items-center shrink-0">
          <i class="fa-solid fa-lock mr-2"></i>অ্যাডমিন
        </a>
      </nav>
    </div>
  </div>

  <!-- স্ক্রলিং মার্কি ব্যানার -->
  <div class="bg-amber-400 text-amber-950 text-xs font-bold py-2 overflow-hidden flex items-center shadow-inner border-t border-amber-300 select-none">
    <div class="bg-amber-500 px-4 py-1 rounded-r-full shrink-0 z-10 shadow-md text-amber-950"><i class="fa-solid fa-bullhorn mr-1.5"></i>সর্বশেষ বার্তা:</div>
    <marquee class="flex-grow select-none" behavior="scroll" direction="left" scrollamount="5" onmouseover="this.stop();" onmouseout="this.start();">
      * আউলিয়াপুর অগ্রযাত্রা পরিষদের নতুন সদস্য নিবন্ধন ফর্ম এখন সম্পূর্ণ লাইভ *।* জরুরী রক্তের প্রয়োজনে যেকোনো মোবাইল নাম্বার অথবা আইডি দিয়ে রক্তদাতা ও সদস্য খতিয়ান লাইভ চেক করুন *।* রক্ত ডোনার নিবন্ধন ফর্ম এখন সম্পূর্ণ লাইভ *
    </marquee>
  </div>
</header>

<!-- মূল কনটেন্ট সেকশন -->
<main class="flex-grow">
  @yield('content')
</main>

<!-- ফুটার -->
<footer class="bg-slate-950 text-gray-400 select-none mt-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 pt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 text-sm">
    <div class="space-y-4">
      <div class="flex items-center space-x-2">
        <div class="bg-emerald-600 text-white p-2 rounded-full"><i class="fa-solid fa-people-group text-sm"></i></div>
        <span class="font-extrabold text-white text-base">আউলিয়াপুর অগ্রযাত্রা পরিষদ</span>
      </div>
      <p class="text-gray-500 text-xs leading-relaxed">
        আমরা একটি অরাজনৈতিক ও সেবামূলক সামাজিক সংগঠন যা সমাজের অবহেলিত ও দরিদ্র মানুষের পাশে দাঁড়াতে অঙ্গীকারবদ্ধ।
      </p>
    </div>

    <div class="space-y-4">
      <h5 class="text-white font-extrabold text-sm border-b border-emerald-500 pb-2 inline-block">আমাদের সম্পর্কে</h5>
      <ul class="space-y-2 text-xs">
        <li><a href="{{ route('about.intro') }}" class="hover:text-emerald-500 transition flex items-center"><i class="fa-solid fa-angle-right mr-1.5 text-emerald-600"></i>আমাদের পরিচিতি</a></li>
        <li><a href="{{ route('about.rules') }}" class="hover:text-emerald-500 transition flex items-center"><i class="fa-solid fa-angle-right mr-1.5 text-emerald-600"></i>সংগঠনের বিধিমালা</a></li>
        <li><a href="{{ route('about.mission') }}" class="hover:text-emerald-500 transition flex items-center"><i class="fa-solid fa-angle-right mr-1.5 text-emerald-600"></i>লক্ষ্য ও উদ্দেশ্য</a></li>
      </ul>
    </div>

    <div class="space-y-4">
      <h5 class="text-white font-extrabold text-sm border-b border-emerald-500 pb-2 inline-block">গুরুত্বপূর্ণ লিংক সমূহ</h5>
      <ul class="space-y-2 text-xs">
        <li><a href="{{ route('committee.list') }}" class="hover:text-emerald-500 transition flex items-center"><i class="fa-solid fa-angle-right mr-1.5 text-emerald-600"></i>সংগঠনের কমিটি তালিকা</a></li>
        <li><a href="{{ route('member.search') }}" class="hover:text-emerald-500 transition flex items-center"><i class="fa-solid fa-angle-right mr-1.5 text-emerald-600"></i>সদস্য ও রক্তদাতা তালিকা</a></li>
        <li><a href="{{ route('donation') }}" class="hover:text-emerald-500 transition flex items-center"><i class="fa-solid fa-angle-right mr-1.5 text-emerald-600"></i>অনলাইন পেমেন্ট / ডোনেশন</a></li>
      </ul>
    </div>

    <div class="space-y-4">
      <h5 class="text-white font-extrabold text-sm border-b border-emerald-500 pb-2 inline-block">যোগাযোগের ঠিকানা</h5>
      <ul class="space-y-2.5 text-xs text-gray-500">
        <li class="flex items-start"><i class="fa-solid fa-location-dot text-emerald-500 w-5 mt-0.5 shrink-0"></i> <span>আউলিয়াপুর ইউনিয়ন, পটুয়াখালী সদর, পটুয়াখালী।</span></li>
        <li class="flex items-center"><i class="fa-solid fa-phone text-emerald-500 w-5 shrink-0"></i> <span>+8801710181059</span></li>
        <li class="flex items-center"><i class="fa-solid fa-envelope text-emerald-500 w-5 shrink-0"></i> <span class="truncate">kisabuj35@gmail.com</span></li>
      </ul>
    </div>
  </div>

  <div class="bg-slate-900 py-6 border-t border-slate-800 text-xs text-gray-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-2">
      <p>&copy; ২০২৬ আউলিয়াপুর অগ্রযাত্রা পরিষদ — সর্বস্বত্ব সংরক্ষিত।</p>
      <p class="font-medium text-gray-400">ডিজাইন ও ডেভলপমেন্টঃ <span class="text-emerald-500">মোঃ কামরুল ইসলাম সবুজ</span></p>
    </div>
  </div>
</footer>

@stack('scripts')
</body>
</html>
