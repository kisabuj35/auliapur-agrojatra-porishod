<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <title>আউলিয়াপুর অগ্রযাত্রা পরিষদ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { font-family: 'Hind Siliguri', sans-serif; }
    .nav-active { color: #059669 !important; background-color: #f0fdf4; border-radius: 8px; }
  </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen text-gray-800">

<!-- টপ স্লোগান ও হেল্পলাইন বার -->
<header class="bg-white shadow-md sticky top-0 z-50">
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

  <!-- সম্পূর্ণ ড্রপডাউন মেনুবার -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-20 items-center">
      
      <div class="flex items-center space-x-2 sm:space-x-3 cursor-pointer select-none" onclick="navigateTo('home')">
        <div class="bg-emerald-50 p-1 rounded-full shadow-md shrink-0 w-11 h-11 sm:w-12 sm:h-12 flex items-center justify-center overflow-hidden">
          <img src="https://lh3.googleusercontent.com/d/1Z6FVIIFOBq8kWcdalYa0lczot3yLS5Vl" alt="Logo" class="w-full h-full object-cover rounded-full">
        </div>
        <div>
          <h1 class="text-sm sm:text-base md:text-lg lg:text-xl font-bold text-gray-800 leading-tight">আউলিয়াপুর অগ্রযাত্রা পরিষদ</h1>
          <p class="text-[9px] sm:text-xs text-emerald-600 font-semibold tracking-wide">মানবিক সেবামূলক সংগঠন, পটুয়াখালী</p>
        </div>
      </div>

      <nav class="hidden md:flex space-x-1 xl:space-x-2 text-sm font-semibold text-gray-600 items-center">
        <a href="#home" class="nav-active px-3 py-2 rounded-lg">হোম</a>
        
        <!-- ১. আমাদের সম্পর্কে -->
        <div class="relative group">
          <button class="hover:bg-emerald-50 hover:text-emerald-700 px-3 py-2 rounded-lg flex items-center transition">
            আমাদের সম্পর্কে <i class="fa-solid fa-chevron-down text-[10px] ml-1 transition group-hover:rotate-180"></i>
          </button>
          <div class="absolute left-0 top-full pt-1 w-52 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 z-50">
            <div class="bg-white border border-gray-100 rounded-lg shadow-lg py-1">
              <a href="#about_intro" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-address-card mr-2 text-emerald-600 w-4"></i>আমাদের সম্পর্কে জানুন</a>
              <a href="#about_rules" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-scale-balanced mr-2 text-emerald-600 w-4"></i>সংগঠনের বিধিমালা</a>
              <a href="#about_mission" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-bullseye mr-2 text-emerald-600 w-4"></i>লক্ষ্য ও উদ্দেশ্য</a>
              <a href="#about_faq" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-circle-question mr-2 text-emerald-600 w-4"></i>প্রশ্ন ও উত্তর</a>
            </div>
          </div>
        </div>

        <!-- ২. কমিটি -->
        <div class="relative group">
          <button class="hover:bg-emerald-50 hover:text-emerald-700 px-3 py-2 rounded-lg flex items-center transition">
            কমিটি <i class="fa-solid fa-chevron-down text-[10px] ml-1 transition group-hover:rotate-180"></i>
          </button>
          <div class="absolute left-0 top-full pt-1 w-52 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 z-50">
            <div class="bg-white border border-gray-100 rounded-lg shadow-lg py-1">
              <a href="#committee_advisors" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-graduation-cap mr-2 text-emerald-600 w-4"></i>উপদেষ্টা মণ্ডলী</a>
              <a href="#committee_executives" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-users mr-2 text-emerald-600 w-4"></i>কার্যনির্বাহী পরিষদ</a>
              <a href="#committee_list" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-list mr-2 text-emerald-600 w-4"></i>কমিটি তালিকা</a>
            </div>
          </div>
        </div>

        <!-- ৩. মিডিয়া -->
        <div class="relative group">
          <button class="hover:bg-emerald-50 hover:text-emerald-700 px-3 py-2 rounded-lg flex items-center transition">
            মিডিয়া <i class="fa-solid fa-chevron-down text-[10px] ml-1 transition group-hover:rotate-180"></i>
          </button>
          <div class="absolute left-0 top-full pt-1 w-52 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 z-50">
            <div class="bg-white border border-gray-100 rounded-lg shadow-lg py-1">
              <a href="#media_photos" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-image mr-2 text-emerald-600 w-4"></i>ফটো গ্যালারি</a>
              <a href="#media_videos" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-video mr-2 text-emerald-600 w-4"></i>ভিডিও গ্যালারি</a>
              <a href="#media_news" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-newspaper mr-2 text-emerald-600 w-4"></i>বিজ্ঞপ্তি</a>
              <a href="#media_press" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-newspaper mr-2 text-emerald-600 w-4"></i>পত্রিকায় সংবাদ</a>
              <a href="#media_awards" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-trophy mr-2 text-emerald-600 w-4"></i>পুরস্কার ও সম্মাননা</a>
            </div>
          </div>
        </div>

        <!-- ৪. প্রকল্প -->
        <div class="relative group">
          <button class="hover:bg-emerald-50 hover:text-emerald-700 px-3 py-2 rounded-lg flex items-center transition">
            প্রকল্প <i class="fa-solid fa-chevron-down text-[10px] ml-1 transition group-hover:rotate-180"></i>
          </button>
          <div class="absolute left-0 top-full pt-1 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 z-50">
            <div class="bg-white border border-gray-100 rounded-lg shadow-lg py-1">
              <a href="#project_view/উষ্ণ হোক শীত" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-snowflake mr-2 text-emerald-600 w-4"></i>উষ্ণ হোক শীত</a>
              <a href="#project_view/তরুণ জ্ঞানের দীপশিখা" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-book-open mr-2 text-emerald-600 w-4"></i>তরুণ জ্ঞানের দীপশিখা</a>
              <a href="#project_view/সবুজ স্বপ্ন" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-tree mr-2 text-emerald-600 w-4"></i>সবুজ স্বপ্ন</a>
              <a href="#project_view/সম্প্রীতির কুরবানি" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-hands-holding-child mr-2 text-emerald-600 w-4"></i>সম্প্রীতির কুরবানি</a>
              <a href="#project_view/ভাতের হাসি" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-bowl-rice mr-2 text-emerald-600 w-4"></i>ভাতের হাসি</a>
              <a href="#project_view/মেধাবীদের সম্মাননা" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-graduation-cap mr-2 text-emerald-600 w-4"></i>মেধাবীদের সম্মাননা</a>
            </div>
          </div>
        </div>

        <!-- ৫. সদস্য পোর্টাল -->
        <div class="relative group">
          <button class="hover:bg-emerald-50 hover:text-emerald-700 px-3 py-2 rounded-lg flex items-center transition">
            সদস্য পোর্টাল <i class="fa-solid fa-chevron-down text-[10px] ml-1 transition group-hover:rotate-180"></i>
          </button>
          <div class="absolute left-0 top-full pt-1 w-52 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 z-50">
            <div class="bg-white border border-gray-100 rounded-lg shadow-lg py-1">
              <a href="#member_register" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-user-plus mr-2 text-emerald-600 w-4"></i>সদস্য তথ্য ফর্ম</a>
              <a href="#member_payment" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-credit-card mr-2 text-emerald-600 w-4"></i>ফি বা চাঁদা প্রদান</a>
              <a href="#search_members" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-magnifying-glass mr-2 text-emerald-600 w-4"></i>সদস্য তালিকা</a>
              <a href="#search_ledger" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-file-invoice-dollar mr-2 text-emerald-600 w-4"></i>ব্যক্তিগত লেজার স্লিপ</a>
            </div>
          </div>
        </div>

        <!-- ৬. রক্তদান -->
        <div class="relative group">
          <button class="hover:bg-emerald-50 hover:text-emerald-700 px-3 py-2 rounded-lg flex items-center transition">
            রক্তদান <i class="fa-solid fa-chevron-down text-[10px] ml-1 transition group-hover:rotate-180"></i>
          </button>
          <div class="absolute left-0 top-full pt-1 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 z-50">
            <div class="bg-white border border-gray-100 rounded-lg shadow-lg py-1">
              <a href="#blood-board" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-chart-line mr-2 text-emerald-600 w-4"></i>রক্তদাতার পরিসংখ্যান</a>
              <a href="#donor_list" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-users-viewfinder mr-2 text-emerald-600 w-4"></i>রক্ত ডোনার তালিকা</a>
              <a href="#donor_registration" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-user-plus mr-2 text-emerald-600 w-4"></i>রক্ত ডোনার নিবন্ধন</a>
              <a href="#blood_donation" class="flex items-center px-4 py-2.5 text-xs text-gray-700 hover:bg-emerald-50 hover:text-emerald-600"><i class="fa-solid fa-droplet mr-2 text-emerald-600 w-4"></i>রক্তদান ফর্ম</a> 
            </div>
          </div>
        </div>
        
        <!-- দান করুন -->
        <a href="#donation" class="bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-extrabold px-5 py-2.5 rounded-2xl text-xs flex items-center shadow-lg transition ml-2">
          <i class="fa-solid fa-heart mr-1.5 animate-pulse text-sm"></i> দান করুন
        </a>
        
        <a href="#contact" class="hover:bg-emerald-50 hover:text-emerald-700 px-3 py-2 rounded-lg transition">যোগাযোগ</a>
        
        <a href="#admin_panel" class="bg-slate-900 text-white hover:bg-emerald-600 px-4 py-2 rounded-lg transition flex items-center">
          <i class="fa-solid fa-lock mr-2"></i>অ্যাডমিন
        </a>
      </nav>
    </div>
  </div>

  <!-- স্ক্রলিং বার্তা -->
  <div class="bg-amber-400 text-amber-950 text-xs font-bold py-2 overflow-hidden flex items-center shadow-inner border-t border-amber-300">
    <div class="bg-amber-500 px-4 py-1 rounded-r-full shrink-0 z-10 shadow-md text-amber-950"><i class="fa-solid fa-bullhorn mr-1.5"></i>সর্বশেষ বার্তা:</div>
    <marquee class="flex-grow select-none" behavior="scroll" direction="left" scrollamount="5">
      * আউলিয়াপুর অগ্রযাত্রা পরিষদের নতুন সদস্য নিবন্ধন ফর্ম ও কেন্দ্রীয় রক্তদান পোর্টাল এখন সম্পূর্ণ সচল *
    </marquee>
  </div>
</header>

<!-- মূল কনটেন্ট ফ্রেম -->
<main class="flex-grow">
  <div id="loading" class="hidden fixed inset-0 bg-gray-950/40 backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-3xl shadow-xl flex flex-col items-center">
      <div class="animate-spin rounded-full border-4 border-t-emerald-600 border-gray-200 h-10 w-10 mb-3"></div>
      <p class="text-gray-700 font-bold text-xs">তথ্য লোড হচ্ছে...</p>
    </div>
  </div>
  <div id="main-content" class="transition-opacity duration-300 opacity-100"></div>
</main>

<!-- ফুটার -->
<footer class="bg-slate-950 text-gray-400 select-none mt-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 pt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 text-sm">
    <div class="space-y-4">
      <div class="flex items-center space-x-2">
        <div class="bg-emerald-600 text-white p-2 rounded-full"><i class="fa-solid fa-people-group text-sm"></i></div>
        <span class="font-extrabold text-white text-base">আউলিয়াপুর অগ্রযাত্রা পরিষদ</span>
      </div>
      <p class="text-gray-500 text-xs leading-relaxed">আমরা একটি অরাজনৈতিক ও সেবামূলক সামাজিক সংগঠন যা সমাজের অবহেলিত মানুষের পাশে দাঁড়াতে প্রতিজ্ঞাবদ্ধ।</p>
    </div>
    <div class="space-y-3">
      <h5 class="text-white font-extrabold text-sm border-b border-emerald-500 pb-2 inline-block">গুরুত্বপূর্ণ পেজ</h5>
      <ul class="space-y-2 text-xs">
        <li><a href="#about_intro" class="hover:text-emerald-500">আমাদের পরিচিতি</a></li>
        <li><a href="#committee_list" class="hover:text-emerald-500">কমিটি তালিকা</a></li>
        <li><a href="#blood-board" class="hover:text-emerald-500">রক্তদান খতিয়ান</a></li>
      </ul>
    </div>
    <div class="space-y-3">
      <h5 class="text-white font-extrabold text-sm border-b border-emerald-500 pb-2 inline-block">পোর্টাল ও সেবা</h5>
      <ul class="space-y-2 text-xs">
        <li><a href="#member_register" class="hover:text-emerald-500">সদস্য তথ্য ফর্ম</a></li>
        <li><a href="#search_ledger" class="hover:text-emerald-500">ব্যক্তিগত লেজার স্লিপ</a></li>
        <li><a href="#donor_list" class="hover:text-emerald-500">রক্ত ডোনার তালিকা</a></li>
      </ul>
    </div>
    <div class="space-y-3">
      <h5 class="text-white font-extrabold text-sm border-b border-emerald-500 pb-2 inline-block">যোগাযোগ</h5>
      <p class="text-xs text-gray-500">আউলিয়াপুর ইউনিয়ন পরিষদ রোড, পটুয়াখালী সদর। ফোন: +৮৮০ ১৭১০-১৮১০৫৯</p>
    </div>
  </div>
  <div class="bg-slate-900 py-4 text-center text-xs text-gray-500 border-t border-slate-800">
    &copy; ২০২৬ আউলিয়াপুর অগ্রযাত্রা পরিষদ — ডিজাইন ও ডেভলপমেন্টঃ <span class="text-emerald-500 font-bold">মোঃ কামরুল ইসলাম সবুজ</span>
  </div>
</footer>

<script>
  // সুরক্ষিত TiDB ডাটাবেজ ব্রিজ (এরর মেসেজ যাতে কোনোভাবেই undefined না হয়)
  function executeServerFunction(functionName, args, onSuccess, onFailure) {
    fetch('api.php', {
      method: 'POST',
      body: JSON.stringify({ action: functionName, arguments: args }),
      headers: { 'Content-Type': 'application/json' }
    })
    .then(async res => {
      const text = await res.text();
      try {
        return JSON.parse(text);
      } catch(e) {
        throw new Error("সার্ভার রেসপন্স বুঝতে সমস্যা হয়েছে।");
      }
    })
    .then(result => {
      if (result.status === 'success') {
        if (onSuccess) onSuccess(result.data);
      } else {
        const errorMsg = result.message || 'অজানা সমস্যা';
        if (onFailure) onFailure({ message: errorMsg, toString: () => errorMsg });
      }
    })
    .catch(err => {
      const errorMsg = (err && err.message) ? err.message : String(err);
      if (onFailure) onFailure({ message: errorMsg, toString: () => errorMsg });
    });
  }

  function createRunProxy(onSuccess, onFailure) {
    return new Proxy({}, {
      get: function(target, prop) {
        if (prop === 'withSuccessHandler') return function(sc) { return createRunProxy(sc, onFailure); };
        if (prop === 'withFailureHandler') return function(fc) { return createRunProxy(onSuccess, fc); };
        return function(...args) { executeServerFunction(prop, args, onSuccess, onFailure); };
      }
    });
  }
  window.google = { script: { run: createRunProxy(null, null) } };

  function navigateTo(pageName) {
    const loader = document.getElementById('loading');
    const mainContent = document.getElementById('main-content');
    
    if (loader) loader.classList.remove('hidden');
    if (mainContent) mainContent.style.opacity = '0.3';

    fetch(`pages/${pageName}.html`)
      .then(res => {
        if (!res.ok) throw new Error("ফাইলটি pages ফোল্ডারে পাওয়া যায়নি");
        return res.text();
      })
      .then(html => {
        if (mainContent) {
          mainContent.innerHTML = html;
          executeScripts(mainContent);
        }
        if (loader) loader.classList.add('hidden');
        if (mainContent) mainContent.style.opacity = '1';
        window.scrollTo({ top: 0, behavior: 'smooth' });
      })
      .catch(err => {
        if (mainContent) {
          mainContent.innerHTML = `<div class="max-w-xl mx-auto my-12 p-8 bg-red-50 text-red-600 rounded-3xl text-center font-bold">ফাইল লোড ত্রুটি: ${err.message}</div>`;
        }
        if (loader) loader.classList.add('hidden');
        if (mainContent) mainContent.style.opacity = '1';
      });
  }

  function executeScripts(container) {
    const scripts = container.getElementsByTagName('script');
    for (let i = 0; i < scripts.length; i++) {
      const scriptElement = document.createElement('script');
      scriptElement.text = scripts[i].text;
      document.body.appendChild(scriptElement).parentNode.removeChild(scriptElement);
    }
  }

  function handleRouting() {
    let hash = window.location.hash.substring(1);
    if (!hash || hash === "") {
      hash = 'home';
    }
    
    if (hash.startsWith('project_view/')) {
      let projectName = decodeURIComponent(hash.replace('project_view/', ''));
      navigateTo('project_view');
      setTimeout(() => {
        if (typeof renderProjectData === 'function') renderProjectData(projectName);
      }, 500);
    } else {
      navigateTo(hash);
    }
  }

  window.addEventListener('hashchange', handleRouting);
  window.addEventListener('load', handleRouting);
</script>
</body>
</html>
