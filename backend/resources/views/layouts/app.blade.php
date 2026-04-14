<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MiniFoot Academy — Plateforme de gestion d'académie de sport">
    <title>@yield('title', 'MiniFoot Academy')</title>

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Design Tokens -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50:  '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        },
                        gold: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                        },
                        slate: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-in-out',
                        'slide-in': 'slideIn 0.3s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideIn: {
                            '0%': { transform: 'translateX(-20px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                    }
                }
            }
        }
    </script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: #0f172a;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Sidebar animations */
        .sidebar {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-content {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed .sidebar-logo .title,
        .sidebar.collapsed .sidebar-logo .subtitle,
        .sidebar.collapsed .nav-link span:not(.icon),
        .sidebar.collapsed .nav-section-title,
        .sidebar.collapsed .user-card div:not(.user-avatar) {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 12px;
        }

        .sidebar.collapsed .nav-link .icon {
            margin: 0;
            font-size: 20px;
        }

        .sidebar.collapsed .user-card {
            justify-content: center;
            padding: 12px;
        }

        .sidebar.collapsed .logout-btn {
            justify-content: center;
            padding-left: 12px;
            padding-right: 12px;
        }

        .sidebar.collapsed .logout-btn .logout-label {
            display: none;
        }

        .sidebar.collapsed .logout-btn i {
            margin: 0;
        }

        /* Smooth transitions */
        .nav-link, .stat-card, .btn-primary, .btn-gold, .btn-ghost {
            transition: all 0.2s ease;
        }

        /* Loading spinner */
        .spinner {
            border: 3px solid #e2e8f0;
            border-top: 3px solid #10b981;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Glass morphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

@auth
<!-- Sidebar -->
<aside class="sidebar fixed left-0 top-0 bottom-0 w-[260px] bg-white border-r border-slate-200 shadow-sm z-[100] flex flex-col" id="sidebar">
    <div class="sidebar-logo p-6 border-b border-slate-100 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center shadow-md shadow-brand-500/30">
            <i class="fas fa-futbol text-white text-xl"></i>
        </div>
        <div>
            <div class="title text-sm font-extrabold text-slate-900 tracking-tight">MiniFoot</div>
            <div class="subtitle text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Academy</div>
        </div>
    </div>

    <nav class="sidebar-nav flex-1 py-4 px-3 overflow-y-auto">
        @if(auth()->user()->isSuperAdmin())
            <div class="nav-section-title text-[10px] font-bold text-slate-400 uppercase tracking-[1px] px-2 py-2">Administration</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all {{ request()->is('admin/dashboard') ? 'active bg-emerald-50 text-brand-600 font-semibold border border-emerald-100' : '' }}">
                <i class="fas fa-tachometer-alt w-5 text-center text-sm"></i>
                <span class="text-sm font-medium">Tableau de bord</span>
            </a>
            <a href="{{ route('admin.coachs.create') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all {{ request()->is('admin/coachs/*') ? 'active bg-emerald-50 text-brand-600 font-semibold border border-emerald-100' : '' }}">
                <i class="fas fa-chalkboard-user w-5 text-center text-sm"></i>
                <span class="text-sm font-medium">Coachs</span>
            </a>
            <a href="{{ route('admin.parents.create') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all {{ request()->is('admin/parents/*') ? 'active bg-emerald-50 text-brand-600 font-semibold border border-emerald-100' : '' }}">
                <i class="fas fa-users w-5 text-center text-sm"></i>
                <span class="text-sm font-medium">Parents</span>
            </a>
            <a href="{{ route('admin.joueurs.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all {{ request()->is('admin/joueurs*') ? 'active bg-emerald-50 text-brand-600 font-semibold border border-emerald-100' : '' }}">
                <i class="fas fa-futbol w-5 text-center text-sm"></i>
                <span class="text-sm font-medium">Joueurs</span>
            </a>

            <div class="nav-section-title text-[10px] font-bold text-slate-400 uppercase tracking-[1px] px-2 py-2 mt-4">Structure</div>
            <a href="{{ route('admin.categories.create') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all {{ request()->is('admin/categories/*') ? 'active bg-emerald-50 text-brand-600 font-semibold border border-emerald-100' : '' }}">
                <i class="fas fa-layer-group w-5 text-center text-sm"></i>
                <span class="text-sm font-medium">Catégories</span>
            </a>
            <a href="{{ route('admin.groupes.create') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all {{ request()->is('admin/groupes/*') ? 'active bg-emerald-50 text-brand-600 font-semibold border border-emerald-100' : '' }}">
                <i class="fas fa-users-viewfinder w-5 text-center text-sm"></i>
                <span class="text-sm font-medium">Groupes</span>
            </a>

            <div class="nav-section-title text-[10px] font-bold text-slate-400 uppercase tracking-[1px] px-2 py-2 mt-4">Financier</div>
            <a href="{{ route('admin.paiements.index') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all {{ request()->is('admin/paiements*') ? 'active bg-emerald-50 text-brand-600 font-semibold border border-emerald-100' : '' }}">
                <i class="fas fa-credit-card w-5 text-center text-sm"></i>
                <span class="text-sm font-medium">Paiements</span>
            </a>

            <div class="nav-section-title text-[10px] font-bold text-slate-400 uppercase tracking-[1px] px-2 py-2 mt-4">Communication</div>
            <a href="{{ route('admin.notifications.create') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all {{ request()->is('admin/notifications*') ? 'active bg-emerald-50 text-brand-600 font-semibold border border-emerald-100' : '' }}">
                <i class="fas fa-bell w-5 text-center text-sm"></i>
                <span class="text-sm font-medium">Notifications</span>
            </a>

        @elseif(auth()->user()->isCoach())
            <div class="nav-section-title text-[10px] font-bold text-slate-400 uppercase tracking-[1px] px-2 py-2">Espace Coach</div>
            <a href="{{ route('coach.dashboard') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all {{ request()->is('coach/dashboard') ? 'active bg-emerald-50 text-brand-600 font-semibold border border-emerald-100' : '' }}">
                <i class="fas fa-tachometer-alt w-5 text-center text-sm"></i>
                <span class="text-sm font-medium">Dashboard</span>
            </a>
            @foreach(auth()->user()->groupesGeres as $groupe)
            <a href="{{ route('coach.groupes.show', $groupe) }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all">
                <i class="fas fa-users w-5 text-center text-sm"></i>
                <span class="text-sm font-medium flex-1">{{ $groupe->nom }}</span>
                <span class="text-[10px] font-semibold bg-slate-100 text-slate-600 px-2 py-1 rounded-full">{{ $groupe->joueurs_count ?? 0 }}</span>
            </a>
            @endforeach

        @elseif(auth()->user()->isParent())
            <div class="nav-section-title text-[10px] font-bold text-slate-400 uppercase tracking-[1px] px-2 py-2">Espace Parent</div>
            <a href="{{ route('parent.dashboard') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all {{ request()->is('parent/dashboard') ? 'active bg-emerald-50 text-brand-600 font-semibold border border-emerald-100' : '' }}">
                <i class="fas fa-home w-5 text-center text-sm"></i>
                <span class="text-sm font-medium">Dashboard</span>
            </a>
            @foreach(auth()->user()->joueurs as $joueur)
            <a href="{{ route('parent.joueurs.show', $joueur) }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all">
                <i class="fas fa-child w-5 text-center text-sm"></i>
                <span class="text-sm font-medium">{{ $joueur->prenom }} {{ $joueur->nom }}</span>
            </a>
            @endforeach
            <a href="{{ route('parent.paiement') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all {{ request()->is('parent/paiement*') ? 'active bg-emerald-50 text-brand-600 font-semibold border border-emerald-100' : '' }}">
                <i class="fas fa-credit-card w-5 text-center text-sm"></i>
                <span class="text-sm font-medium">Paiements</span>
            </a>
        @endif
    </nav>

    <!-- User card + Logout -->
    <div class="sidebar-footer p-4 border-t border-slate-100 bg-slate-50/50">
        <div class="user-card flex items-center gap-3 p-3 rounded-xl bg-white border border-slate-200 mb-3 shadow-sm">
            <div class="user-avatar w-10 h-10 rounded-full bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center text-white font-bold shadow-md">
                {{ strtoupper(substr(auth()->user()->prenom, 0, 1)) }}{{ strtoupper(substr(auth()->user()->nom, 0, 1)) }}
            </div>
            <div class="flex-1">
                <div class="user-name text-sm font-bold text-slate-900">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</div>
                <div class="user-role text-[11px] font-semibold text-slate-500">
                    <i class="fas fa-{{ auth()->user()->role === 'super_admin' ? 'crown' : (auth()->user()->role === 'coach' ? 'chalkboard-user' : 'user') }} text-[9px] mr-1"></i>
                    {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
                </div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 transition-all text-sm font-semibold">
                <i class="fas fa-sign-out-alt text-sm"></i>
                <span class="logout-label">Déconnexion</span>
            </button>
        </form>
    </div>
</aside>

<!-- Main Content -->
<div class="main-content ml-[260px] min-h-screen bg-slate-50" id="mainContent">
    <!-- Top bar -->
    <header class="topbar sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-200 px-6 py-4 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-4">
            <button id="sidebarToggle" class="w-8 h-8 rounded-lg hover:bg-slate-100 transition-colors flex items-center justify-center text-slate-500">
                <i class="fas fa-bars text-sm"></i>
            </button>
            <h1 class="text-lg font-extrabold text-slate-900 tracking-tight">@yield('page-title', 'Dashboard')</h1>
            @yield('topbar_actions')
        </div>
        <div class="flex items-center gap-4">
            @php
                $nbNotifs = auth()->user()->notificationsRecues()->where('est_lu', false)->count();
                $topbarNotifs = auth()->user()->notificationsRecues()->where('est_lu', false)->with('expediteur')->latest()->take(6)->get();
            @endphp
            <div class="relative">
                <button id="notifToggle" type="button" class="w-8 h-8 rounded-lg hover:bg-slate-100 transition-colors flex items-center justify-center text-slate-500 relative">
                    <i class="fas fa-bell text-sm"></i>
                    @if($nbNotifs > 0)
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center animate-pulse-slow">{{ $nbNotifs }}</span>
                    @endif
                </button>

                <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-[360px] max-w-[90vw] bg-white border border-slate-200 rounded-xl shadow-xl z-50 overflow-hidden">
                    <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                        <h4 class="text-sm font-bold text-slate-800">Notifications</h4>
                        @if($nbNotifs > 0)
                            <form action="{{ route('notifications.readAll') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Tout marquer lu</button>
                            </form>
                        @endif
                    </div>

                    <div class="max-h-[360px] overflow-y-auto">
                        @if($topbarNotifs->isEmpty())
                            <p class="px-4 py-6 text-sm text-slate-500">Aucune notification non lue.</p>
                        @else
                            <div class="divide-y divide-slate-100">
                                @foreach($topbarNotifs as $notif)
                                    <div class="px-4 py-3 hover:bg-slate-50">
                                        <div class="flex items-start justify-between gap-3">
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold text-slate-800 truncate">{{ $notif->titre }}</p>
                                                <p class="text-xs text-slate-600 mt-1">{{ $notif->message }}</p>
                                                <p class="text-[11px] text-slate-400 mt-1">
                                                    {{ $notif->created_at->format('d/m/Y H:i') }}
                                                    @if($notif->expediteur)
                                                        | {{ $notif->expediteur->prenom }} {{ $notif->expediteur->nom }}
                                                    @endif
                                                </p>
                                            </div>
                                            <form action="{{ route('notifications.read', $notif) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-[11px] font-semibold text-blue-600 hover:text-blue-700">Lu</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="w-px h-6 bg-slate-200"></div>
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <i class="far fa-calendar-alt text-xs"></i>
                <span class="font-medium">{{ now()->format('d/m/Y') }}</span>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="page-content p-6 animate-fade-in">
        @if(session('success'))
            <div class="alert-success bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-3.5 rounded-xl mb-6 flex items-center gap-3 shadow-sm">
                <i class="fas fa-check-circle text-emerald-500"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-xl mb-6 flex items-center gap-3 shadow-sm">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-xl mb-6 shadow-sm">
                <div class="flex items-start gap-3">
                    <i class="fas fa-times-circle text-red-500 mt-0.5"></i>
                    <div>
                        <span class="font-medium block mb-1">Veuillez corriger les erreurs suivantes :</span>
                        <ul class="text-sm list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script>
    // Sidebar toggle functionality
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleBtn = document.getElementById('sidebarToggle');
    let isCollapsed = false;

    const isMobileViewport = () => window.innerWidth <= 768;

    const applySidebarState = () => {
        if (isMobileViewport()) {
            // On small screens, use overlay behavior only.
            sidebar.classList.remove('collapsed');
            sidebar.style.width = '260px';
            mainContent.style.marginLeft = '0';
            isCollapsed = false;
            return;
        }

        // On desktop, use collapsed/expanded behavior.
        sidebar.classList.remove('mobile-open');

        if (isCollapsed) {
            sidebar.classList.add('collapsed');
            sidebar.style.width = '80px';
            mainContent.style.marginLeft = '80px';
        } else {
            sidebar.classList.remove('collapsed');
            sidebar.style.width = '260px';
            mainContent.style.marginLeft = '260px';
        }
    };

    toggleBtn.addEventListener('click', () => {
        if (isMobileViewport()) {
            sidebar.classList.toggle('mobile-open');
            return;
        }

        isCollapsed = !isCollapsed;
        applySidebarState();
    });

    window.addEventListener('resize', applySidebarState);
    applySidebarState();

    const notifToggle = document.getElementById('notifToggle');
    const notifDropdown = document.getElementById('notifDropdown');

    if (notifToggle && notifDropdown) {
        notifToggle.addEventListener('click', (event) => {
            event.stopPropagation();
            notifDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            if (isMobileViewport() && !sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                sidebar.classList.remove('mobile-open');
            }

            if (!notifDropdown.classList.contains('hidden') && !notifDropdown.contains(event.target) && !notifToggle.contains(event.target)) {
                notifDropdown.classList.add('hidden');
            }
        });
    }
</script>

@else
    <div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-slate-50 to-slate-100">
        @yield('content')
    </div>
@endauth

@stack('scripts')
</body>
</html>
