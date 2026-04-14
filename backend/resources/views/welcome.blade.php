<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniFoot Academy — La pépinière des futurs champions</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .hero-pattern {
            background-image: radial-gradient(circle at 10% 20%, rgba(16, 185, 129, 0.03) 0%, transparent 50%);
        }
    </style>
</head>
<body class="bg-gradient-to-b from-slate-50 to-white text-slate-800 font-sans antialiased min-h-screen flex flex-col">

    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center text-white shadow-lg shadow-brand-500/30">
                        <i class="fas fa-futbol text-xl"></i>
                    </div>
                    <div>
                        <span class="font-bold text-slate-900 leading-tight block text-sm">MiniFoot</span>
                        <span class="text-[10px] text-slate-500 font-medium block uppercase tracking-wider">Academy</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/admin/dashboard') }}" class="text-slate-600 hover:text-brand-600 font-medium transition-colors">
                            <i class="fas fa-tachometer-alt mr-1 text-xs"></i> Mon Espace
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-brand-600 font-medium transition-colors">
                            <i class="fas fa-sign-in-alt mr-1 text-xs"></i> Connexion
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 rounded-lg font-semibold transition-all shadow-md shadow-brand-600/20 hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2">
                                <i class="fas fa-user-plus text-sm"></i>
                                <span>S'inscrire</span>
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="flex-1 flex flex-col items-center justify-center text-center px-4 sm:px-6 lg:px-8 py-20 relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-brand-500/5 rounded-full blur-3xl -z-10"></div>
        <div class="absolute top-20 right-10 w-64 h-64 bg-emerald-400/5 rounded-full blur-2xl -z-10"></div>
        <div class="absolute bottom-20 left-10 w-80 h-80 bg-brand-300/5 rounded-full blur-2xl -z-10"></div>

        <span class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full bg-brand-50 border border-brand-100 text-brand-600 text-sm font-semibold mb-8 shadow-sm">
            <i class="fas fa-chart-line text-xs"></i>
            Nouvelle saison
            <i class="fas fa-star text-[10px]"></i>
        </span>

        <h1 class="text-5xl sm:text-6xl font-extrabold text-slate-900 tracking-tight mb-6 max-w-4xl mx-auto leading-tight">
            La pépinière des
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-500 to-emerald-400">futurs champions</span>
        </h1>

        <p class="text-lg sm:text-xl text-slate-600 mb-10 max-w-2xl mx-auto leading-relaxed">
            <i class="fas fa-quote-left text-brand-300 mr-2 text-sm"></i>
            Rejoignez MiniFoot Academy. Un encadrement professionnel, des infrastructures modernes et une passion partagée pour le football.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 items-center justify-center w-full">
            @auth
                <a href="{{ url('/admin/dashboard') }}" class="w-full sm:w-auto px-8 py-3.5 bg-brand-600 text-white font-semibold rounded-xl hover:bg-brand-700 shadow-lg shadow-brand-600/30 hover:shadow-xl transition-all hover:-translate-y-1 inline-flex items-center justify-center gap-2">
                    <i class="fas fa-tachometer-alt"></i>
                    Accéder à mon espace
                    <i class="fas fa-arrow-right text-sm"></i>
                </a>
            @else
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-3.5 bg-brand-600 text-white font-semibold rounded-xl hover:bg-brand-700 shadow-lg shadow-brand-600/30 hover:shadow-xl transition-all hover:-translate-y-1 inline-flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt"></i>
                    Se connecter
                    <i class="fas fa-arrow-right text-sm"></i>
                </a>
            @endauth
        </div>

        <!-- Features Grid avec icônes FA -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-24 max-w-6xl mx-auto text-left relative z-10 w-full">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all hover:-translate-y-1 group">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                    <i class="fas fa-chalkboard-user text-2xl text-brand-600"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Coachs Qualifiés</h3>
                <p class="text-slate-600 leading-relaxed">Un encadrement technique et tactique de haut niveau par des professionnels passionnés.</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all hover:-translate-y-1 group">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                    <i class="fas fa-chart-line text-2xl text-brand-600"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Suivi Personnalisé</h3>
                <p class="text-slate-600 leading-relaxed">Évaluation continue des performances de chaque joueur et communication avec les parents.</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all hover:-translate-y-1 group">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                    <i class="fas fa-building text-2xl text-brand-600"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Infrastructure</h3>
                <p class="text-slate-600 leading-relaxed">Des terrains modernes et du matériel adapté pour un apprentissage dans les meilleures conditions.</p>
            </div>
        </div>

        <!-- Section statistiques / Chiffres clés (optionnelle mais moderne) -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-24 max-w-4xl mx-auto w-full">
            <div class="text-center">
                <div class="text-3xl font-extrabold text-brand-600">500+</div>
                <div class="text-sm text-slate-500 mt-1">
                    <i class="fas fa-users mr-1"></i> Joueurs formés
                </div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-extrabold text-brand-600">15</div>
                <div class="text-sm text-slate-500 mt-1">
                    <i class="fas fa-trophy mr-1"></i> Tournois gagnés
                </div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-extrabold text-brand-600">8</div>
                <div class="text-sm text-slate-500 mt-1">
                    <i class="fas fa-chalkboard-user mr-1"></i> Coachs experts
                </div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-extrabold text-brand-600">3</div>
                <div class="text-sm text-slate-500 mt-1">
                    <i class="fas fa-futbol mr-1"></i> Terrains
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 py-10 text-center text-slate-500 text-sm mt-auto relative z-10">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-500 to-brand-600 flex items-center justify-center text-white">
                        <i class="fas fa-futbol text-sm"></i>
                    </div>
                    <span class="font-semibold text-slate-700">MiniFoot Academy</span>
                </div>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-brand-600 transition-colors"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-brand-600 transition-colors"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-brand-600 transition-colors"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-brand-600 transition-colors"><i class="fab fa-youtube"></i></a>
                </div>
                <p>&copy; {{ date('Y') }} MiniFoot Academy. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

</body>
</html>
