<aside id="sidebar" class="sidebar fixed top-0 left-0 h-screen bg-white border-r border-secondary-100 z-40 flex flex-col w-64 -translate-x-full lg:translate-x-0 shadow-soft">
    
    {{-- LOGO & BRAND SECTION --}}
    <div class="h-20 flex items-center justify-between px-4 ml-4 border-b border-secondary-100 flex-shrink-0">

        {{-- Logo: shown in full when expanded, hidden when collapsed --}}
        <div id="brandContent" class="flex items-center gap-3 overflow-hidden">
            <img 
                src="/sushi-mentai-logo.png" 
                alt="Logo" 
                id="logoImg"
                class="logo-img logo-expanded flex-shrink-0"
            >
        </div>

        {{-- Collapse Button (desktop only) --}}
        <button id="toggleCollapse"
                title="Toggle Sidebar"
                class="hidden lg:flex flex-shrink-0 p-2 rounded-lg hover:bg-orange-light-50 text-secondary-400 hover:text-primary-500 transition-all duration-200">
            <svg class="w-4 h-4" style="transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>
    </div>

    {{-- NAVIGATION - CLEAN & MINIMAL --}}
    <nav class="flex-1 overflow-y-auto hide-scrollbar py-6 px-4">
        @php
            $menus = [
                ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'home', 'permission' => null],
                ['name' => 'Purchase Requisition', 'route' => 'pr.index', 'icon' => 'file-text', 'permission' => 'pr.view'],
                ['name' => 'Approval', 'route' => 'approval.index', 'icon' => 'check-circle', 'permission' => 'pr.approve'],
                ['name' => 'User Management', 'route' => 'users.index', 'icon' => 'users', 'permission' => 'user.view'],
                ['name' => 'My Profile', 'route' => 'profile', 'icon' => 'user', 'permission' => null],
            ];
        @endphp

        @foreach ($menus as $menu)
            @if(!$menu['permission'] || auth()->user()->can($menu['permission']))
                @php 
                    $isActive = request()->routeIs($menu['route']); 
                    
                    // Count pending PRs for approval badge
                    $pendingCount = 0;
                    if($menu['route'] === 'approval.index') {
                        $pendingCount = \App\Models\PurchaseRequisition::where('status', 'submitted')->count();
                    }
                @endphp
                
                <a href="{{ route($menu['route']) }}" 
                   class="nav-link relative flex items-center gap-3 px-3 py-3 rounded-lg mb-1 text-sm font-medium group transition-all duration-200
                          {{ $isActive 
                             ? 'bg-primary-50 text-primary-600 shadow-orange-soft' 
                             : 'text-secondary-600 hover:bg-orange-light-50 hover:text-primary-600' }}">
                    
                    {{-- Icon Container --}}
                    <div class="icon-container flex-shrink-0 w-9 h-9 rounded-lg flex items-center justify-center
                                {{ $isActive 
                                   ? 'bg-white/20' 
                                   : 'bg-orange-light-50 group-hover:bg-primary-50' }}
                                transition-all duration-200">
                        @if($menu['icon'] === 'home')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        @elseif($menu['icon'] === 'file-text')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        @elseif($menu['icon'] === 'check-circle')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @elseif($menu['icon'] === 'users')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        @elseif($menu['icon'] === 'user')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        @endif
                    </div>
                    
                    <span class="nav-text flex-1 truncate">{{ $menu['name'] }}</span>

                    {{-- Badge - Clean Style --}}
                    @if($pendingCount > 0)
                        <span class="nav-badge flex-shrink-0 inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[10px] font-bold bg-red-500 text-white rounded-full">
                            {{ $pendingCount > 9 ? '9+' : $pendingCount }}
                        </span>
                    @endif
                    
                    {{-- Active Indicator --}}
                    @if($isActive)
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-primary-500 rounded-r-full"></div>
                    @endif
                </a>
            @endif
        @endforeach
    </nav>

    {{-- USER PROFILE SECTION - NEW DESIGN --}}
    <div class="mt-auto border-t border-secondary-200 p-4 flex-shrink-0">
        <a href="{{ route('profile') }}" class="nav-link relative flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-primary-50 hover:shadow-orange-soft transition-all duration-200 group {{ request()->routeIs('profile') ? 'bg-primary-50 shadow-orange-soft' : '' }}">
            {{-- User Avatar --}}
            <div class="icon-container relative flex-shrink-0 w-9 h-9 rounded-lg flex items-center justify-center">
                <img src="{{ Auth::user()->avatar_url }}" 
                     alt="{{ Auth::user()->name }}" 
                     class="w-9 h-9 rounded-xl object-cover border-2 {{ request()->routeIs('profile') ? 'border-primary-300' : 'border-secondary-200' }} group-hover:border-primary-300 transition-colors">
                
                {{-- Signature indicator badge --}}
                @if(Auth::user()->hasSignature())
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full flex items-center justify-center" title="Signature tersimpan">
                        <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                @else
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-amber-500 border-2 border-white rounded-full flex items-center justify-center" title="Set signature">
                        <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Profile text (hidden when collapsed) --}}
            <div class="nav-text flex-1 min-w-0">
                <p class="text-sm font-semibold text-secondary-900 truncate group-hover:text-primary-600 transition-colors">
                    {{ Auth::user()->name }}
                </p>
                <p class="text-xs text-secondary-500 truncate">
                    {{ Auth::user()->roles->pluck('name')->first() ?? 'User' }}
                </p>
            </div>
        </a>

        {{-- Logout Button --}}
        <form method="POST" action="{{ route('logout') }}" class="mt-1">
            @csrf
            <button type="submit" class="nav-link w-full flex items-center gap-3 px-3 py-2.5 text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200 group">
                <div class="icon-container w-9 h-9 rounded-lg bg-red-50 group-hover:bg-red-100 flex items-center justify-center transition-colors flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </div>
                <span class="nav-text text-sm font-medium">Logout</span>
            </button>
        </form>
    </div>
</aside>

<style>
    /* ── Sidebar base transition ── */
    .sidebar {
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                    transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ── Logo transitions ── */
    .logo-img {
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                    height 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                    opacity 0.2s ease;
        object-fit: contain;
    }
    .logo-expanded { width: 110px; height: auto; }
    .logo-collapsed { width: 32px; height: 32px; }

    /* ── Collapsed state overrides ── */
    .sidebar-collapsed .nav-link {
        justify-content: center;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    .sidebar-collapsed .nav-text {
        display: none !important;
    }
    .sidebar-collapsed .nav-badge {
        position: absolute;
        top: 0.2rem;
        right: 0.2rem;
        transform: scale(0.75);
    }
    .sidebar-collapsed .icon-container {
        margin-left: 0 !important;
    }
    .sidebar-collapsed #brandContent {
        display: none !important;
    }
    .sidebar-collapsed #brandCollapsed {
        display: flex !important;
    }
    .sidebar-collapsed #toggleIcon {
        transform: rotate(180deg);
    }

    /* ── Custom nav scrollbar ── */
    .hide-scrollbar::-webkit-scrollbar { width: 3px; }
    .hide-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .hide-scrollbar::-webkit-scrollbar-thumb { background: #fed7aa; border-radius: 2px; }
    .hide-scrollbar::-webkit-scrollbar-thumb:hover { background: #fb923c; }

    /* ── Icon container ── */
    .icon-container {
        transition: background-color 0.2s ease, margin 0.3s ease;
        flex-shrink: 0;
    }
</style>