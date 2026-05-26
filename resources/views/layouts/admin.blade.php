<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PT Mada Wikri Tunggal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Anti-Flicker for Sidebar Collapse State */
        .sidebar-is-closed #sidebar {
            display: none !important;
        }

        /* Hide scrollbars for navigations */
        #sidebar::-webkit-scrollbar,
        #sidebar nav::-webkit-scrollbar {
            display: none !important;
        }
        #sidebar,
        #sidebar nav {
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
        }

        /* Custom Scrollbar for inner elements */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    {{-- Anti-Flicker / State Restore (Run before paint) --}}
    <script>
        (function() {
            const state = localStorage.getItem('sidebarState');
            const isMobile = window.innerWidth < 1024;
            // Default to 'closed' on mobile, 'open' on desktop if no state is stored
            const shouldBeClosed = state === 'closed' || (!state && isMobile);

            if (shouldBeClosed) {
                document.documentElement.classList.add('sidebar-is-closed');
            } else {
                document.documentElement.classList.remove('sidebar-is-closed');
            }
        })();
    </script>
</head>
<body class="bg-[#f8fafc] text-slate-800 h-full flex flex-col antialiased overflow-hidden">
    
    <!-- Top Header -->
    <header id="appHeader" class="bg-white border-b border-gray-100 h-16 flex items-center justify-between px-6 z-40 relative shrink-0">
        <div id="sidebarToggle" class="flex items-center gap-3 cursor-pointer hover:opacity-85 select-none active:scale-[0.98] transition-all">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo MW" class="h-8">
            <div>
                <h1 class="font-extrabold text-gray-900 text-sm tracking-wide leading-tight uppercase">PT MADA WIKRI TUNGGAL</h1>
                <p class="text-[9px] text-gray-500 font-bold tracking-wider">Pembagian Qurban 1447 H / 2026</p>
            </div>
        </div>

        <div class="flex items-center gap-5">
            {{-- Profile --}}
            <div class="flex items-center gap-2.5">
                <div class="text-right hidden sm:block leading-tight">
                    <div class="text-xs font-bold text-gray-800">{{ Auth::user()->name ?? 'Admin Pembagi' }}</div>
                    <div class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">{{ Auth::user()->role ?? 'Administrator' }}</div>
                </div>
                <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 border border-slate-200 overflow-hidden shrink-0 shadow-inner">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin Pembagi') }}&background=f1f5f9&color=475569&bold=true" alt="Avatar" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </header>

    <!-- App Body Wrapper -->
    <div class="flex flex-1 overflow-hidden relative">
        
        <!-- Sidebar Overlay for Mobile -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/40 z-40 hidden transition-opacity duration-300 backdrop-blur-xs"></div>

        <!-- Sidebar Sibling (positioned relative below top header on desktop, drawer on mobile) -->
        <aside id="sidebar" class="hidden flex-col w-60 bg-white border-r border-gray-100 shrink-0 lg:relative fixed inset-y-0 left-0 lg:top-0 top-0 lg:h-full h-full z-50 overflow-hidden transition-all duration-300 shadow-sm lg:shadow-none">
            
            {{-- Sidebar Mobile Header Brand --}}
            <div class="h-16 flex items-center px-6 border-b border-gray-100 shrink-0 bg-white gap-3 select-none lg:hidden">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo MW" class="h-8">
                <div>
                    <h1 class="font-extrabold text-gray-900 text-xs tracking-wide leading-tight uppercase">PT MADA WIKRI TUNGGAL</h1>
                    <p class="text-[8px] text-gray-500 font-bold tracking-wider">Pembagian Qurban 1447 H / 2026</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="py-6 flex flex-col gap-1 flex-1 overflow-y-auto">
                
                {{-- Rekapitulasi --}}
                <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between py-2.5 pl-4 pr-3 border-r-4 transition-all {{ request()->routeIs('admin.dashboard') ? 'border-emerald-600 bg-[#e6f4ea] text-[#137333] font-bold active-item-marker ml-3' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-semibold mx-3 rounded-lg' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Rekapitulasi
                    </div>
                </a>

                {{-- Daftar Tukar Kupon --}}
                <a href="{{ route('admin.daftar-tukar') }}" class="flex items-center justify-between py-2.5 pl-4 pr-3 border-r-4 transition-all {{ request()->routeIs('admin.daftar-tukar') ? 'border-emerald-600 bg-[#e6f4ea] text-[#137333] font-bold active-item-marker ml-3' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-semibold mx-3 rounded-lg' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Daftar Tukar Kupon
                    </div>
                </a>

                {{-- Semua Karyawan --}}
                <a href="{{ route('admin.karyawan.index') }}" class="flex items-center justify-between py-2.5 pl-4 pr-3 border-r-4 transition-all {{ request()->routeIs('admin.karyawan.index') || request()->routeIs('admin.import') ? 'border-emerald-600 bg-[#e6f4ea] text-[#137333] font-bold active-item-marker ml-3' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-semibold mx-3 rounded-lg' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Semua Karyawan
                    </div>
                </a>

                {{-- Tambah Karyawan (Manual) --}}
                <a href="{{ route('admin.karyawan.tambah') }}" class="flex items-center justify-between py-2.5 pl-4 pr-3 border-r-4 transition-all {{ request()->routeIs('admin.karyawan.tambah') ? 'border-emerald-600 bg-[#e6f4ea] text-[#137333] font-bold active-item-marker ml-3' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-semibold mx-3 rounded-lg' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                        Tambah Karyawan
                    </div>
                </a>

                {{-- Export Data --}}
                <a href="{{ route('admin.export') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg mx-3 font-semibold text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export Data
                </a>

                {{-- Logout --}}
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-lg mx-3 font-semibold text-gray-500 hover:bg-gray-50 hover:text-gray-955 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </a>
            </nav>

            {{-- Sidebar Footer --}}
            <div class="p-4 border-t border-gray-50 flex flex-col items-center select-none bg-slate-50/50 shrink-0">
                <img src="{{ asset('assets/images/kurban.png') }}" alt="Kurban" class="w-32 h-auto opacity-95 mb-3 object-contain">
                <p class="text-[9px] text-gray-400 text-center leading-normal font-semibold">
                    &copy; 2026 PT Mada Wikri Tunggal.<br>All rights reserved.
                </p>
            </div>
        </aside>

        <!-- Main Content Area Sibling -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden relative">
            <main id="mainContent" class="flex-1 overflow-y-auto px-5 py-6">
                @yield('content')
            </main>
        </div>
        
    </div>

    <!-- Hidden Form for Logout -->
    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
        @csrf
    </form>
    
    <!-- Sidebar Controller Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('sidebarToggle');
            const side = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const mainContent = document.getElementById('mainContent');

            // Apply specific layout classes based on localStorage
            const applySidebarState = (state) => {
                if (state === 'open') {
                    side.classList.remove('hidden');
                    side.classList.add('flex');
                    document.documentElement.classList.remove('sidebar-is-closed');
                    if (window.innerWidth < 1024 && overlay) {
                        overlay.classList.remove('hidden');
                        overlay.classList.add('opacity-100');
                    }
                } else if (state === 'closed') {
                    side.classList.add('hidden');
                    side.classList.remove('flex');
                    document.documentElement.classList.add('sidebar-is-closed');
                    if (overlay) {
                        overlay.classList.add('hidden');
                        overlay.classList.remove('opacity-100');
                    }
                }
            };

            // Force close on mobile by default, retrieve state for desktop
            const storedState = localStorage.getItem('sidebarState');
            const isMobile = window.innerWidth < 1024;
            const finalState = isMobile ? 'closed' : (storedState || 'open');
            applySidebarState(finalState);

            // Listen for scroll in sidebar to persist scroll location
            if (side) {
                const nav = side.querySelector('nav');
                if (nav) {
                    const scrollPos = localStorage.getItem('sidebarScrollPos');
                    if (scrollPos) {
                        nav.scrollTop = parseInt(scrollPos);
                    }
                    nav.addEventListener('scroll', () => {
                        localStorage.setItem('sidebarScrollPos', nav.scrollTop);
                    });
                }
            }

            // Click Handler
            if (btn && side) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isClosed = side.classList.contains('hidden') || document.documentElement.classList.contains('sidebar-is-closed');
                    const newState = isClosed ? 'open' : 'closed';
                    applySidebarState(newState);
                    localStorage.setItem('sidebarState', newState);
                });
            }

            // Close when clicking overlay (mobile)
            if (overlay) {
                overlay.addEventListener('click', function() {
                    applySidebarState('closed');
                    localStorage.setItem('sidebarState', 'closed');
                });
            }

            // Close on click outside (mobile)
            document.addEventListener('click', function(e) {
                if (window.innerWidth < 1024 && side && !side.contains(e.target) && btn && !btn.contains(e.target) && !side.classList.contains('hidden')) {
                    applySidebarState('closed');
                    localStorage.setItem('sidebarState', 'closed');
                }
            });

            // Scroll Active navigation link into view
            const activeMarker = document.querySelector('.active-item-marker');
            if (activeMarker && side) {
                const nav = side.querySelector('nav');
                if (nav) {
                    activeMarker.scrollIntoView({ behavior: 'auto', block: 'center', inline: 'nearest' });
                }
            }

            // Logout execution Form
            document.querySelectorAll('a[href="#"]').forEach(el => {
                if (el.textContent.includes('Logout')) {
                    el.addEventListener('click', (e) => {
                        e.preventDefault();
                        document.getElementById('logout-form').submit();
                    });
                }
            });
        });
    </script>
</body>
</html>
