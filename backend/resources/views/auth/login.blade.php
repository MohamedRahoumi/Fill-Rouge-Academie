@extends('layouts.app')

@section('title', 'Connexion — MiniFoot Academy')

@section('content')
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(145deg, #e8f0f5 0%, #f5f9fc 100%);padding:16px;">

    <!-- Décoration géométrique moderne -->
    <div style="position:fixed;inset:0;overflow:hidden;pointer-events:none;z-index:0;">
        <div style="position:absolute;top:-20%;left:-10%;width:600px;height:600px;background:radial-gradient(circle, #10b98108 0%, transparent 70%);border-radius:50%;"></div>
        <div style="position:absolute;bottom:-15%;right:-5%;width:500px;height:500px;background:radial-gradient(circle, #3b82f605 0%, transparent 70%);border-radius:50%;"></div>
        <svg style="position:absolute;bottom:0;left:0;opacity:0.03;" width="100%" height="200" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="currentColor" class="text-brand-500"></path>
        </svg>
    </div>

    <div style="position:relative;z-index:1;width:100%;max-width:880px;display:flex;flex-wrap:wrap;background:#ffffff;border-radius:48px;box-shadow:0 25px 50px -12px rgba(0,0,0,0.15);overflow:hidden;">

        <!-- Côté gauche - Branding / Hero -->
        <div style="flex:1;min-width:280px;background:linear-gradient(135deg, #10b981 0%, #059669 100%);padding:40px 32px;display:flex;flex-direction:column;justify-content:space-between;color:white;">
            <div>
                <div style="display:inline-flex;align-items:center;justify-content:center;width:56px;height:56px;background:rgba(255,255,255,0.2);border-radius:18px;margin-bottom:32px;">
                    <i class="fas fa-futbol" style="font-size:28px;"></i>
                </div>
                <h2 style="font-size:28px;font-weight:700;margin:0 0 12px;letter-spacing:-0.5px;">Bienvenue</h2>
                <p style="font-size:14px;line-height:1.5;opacity:0.9;margin:0;">Accédez à votre espace dédié pour suivre la progression, gérer les séances et consulter les évaluations.</p>
            </div>

            <div style="margin-top:40px;">
                <div style="display:flex;gap:12px;margin-bottom:20px;">
                    <div style="width:32px;height:32px;background:rgba(255,255,255,0.15);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-chalkboard-user" style="font-size:14px;"></i>
                    </div>
                    <div>
                        <p style="font-size:13px;font-weight:600;margin:0 0 4px;">Suivi personnalisé</p>
                        <p style="font-size:11px;opacity:0.75;margin:0;">Évaluations et présences en temps réel</p>
                    </div>
                </div>
                <div style="display:flex;gap:12px;margin-bottom:20px;">
                    <div style="width:32px;height:32px;background:rgba(255,255,255,0.15);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-chart-line" style="font-size:14px;"></i>
                    </div>
                    <div>
                        <p style="font-size:13px;font-weight:600;margin:0 0 4px;">Statistiques détaillées</p>
                        <p style="font-size:11px;opacity:0.75;margin:0;">Progrès techniques et physiques</p>
                    </div>
                </div>
                <div style="display:flex;gap:12px;">
                    <div style="width:32px;height:32px;background:rgba(255,255,255,0.15);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-credit-card" style="font-size:14px;"></i>
                    </div>
                    <div>
                        <p style="font-size:13px;font-weight:600;margin:0 0 4px;">Paiements sécurisés</p>
                        <p style="font-size:11px;opacity:0.75;margin:0;">Gestion financière intégrée</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Côté droit - Formulaire -->
        <div style="flex:1;min-width:300px;padding:48px 40px;background:#ffffff;">
            <div style="margin-bottom:32px;">
                <h3 style="font-size:24px;font-weight:700;color:#0f172a;margin:0 0 8px;">Connexion</h3>
                <p style="font-size:13px;color:#64748b;margin:0;">Entrez vos identifiants pour continuer</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Champ email -->
                <div style="margin-bottom:24px;">
                    <label for="email" style="display:block;margin-bottom:8px;font-size:13px;font-weight:600;color:#334155;">
                        <i class="fas fa-envelope" style="font-size:12px;margin-right:8px;color:#94a3b8;"></i>
                        Adresse email
                    </label>
                    <div style="position:relative;">
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="ex: parent@minifoot.com"
                            autocomplete="email"
                            required
                            style="width:100%;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:16px;padding:14px 18px;font-size:14px;color:#1e293b;transition:all 0.2s;outline:none;"
                            onfocus="this.style.borderColor='#10b981'; this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.08)'"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
                        >
                    </div>
                    @error('email')
                        <p style="font-size:12px;color:#ef4444;margin-top:6px;">
                            <i class="fas fa-exclamation-circle" style="font-size:10px;margin-right:4px;"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Champ mot de passe -->
                <div style="margin-bottom:20px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                        <label for="password" style="font-size:13px;font-weight:600;color:#334155;">
                            <i class="fas fa-lock" style="font-size:12px;margin-right:8px;color:#94a3b8;"></i>
                            Mot de passe
                        </label>
                        <a href="#" style="font-size:11px;color:#94a3b8;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color='#94a3b8'">
                            Mot de passe oublié ?
                        </a>
                    </div>
                    <div style="position:relative;">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                            style="width:100%;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:16px;padding:14px 18px;font-size:14px;color:#1e293b;transition:all 0.2s;outline:none;"
                            onfocus="this.style.borderColor='#10b981'; this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.08)'"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
                        >
                        <i class="fas fa-eye" style="position:absolute;right:18px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:16px;cursor:pointer;transition:color 0.2s;"
                           onclick="togglePassword()" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color='#94a3b8'"></i>
                    </div>
                </div>

                <!-- Se souvenir de moi -->
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:32px;">
                    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                        <input type="checkbox" name="remember" style="width:18px;height:18px;margin:0;accent-color:#10b981;cursor:pointer;">
                        <span style="font-size:13px;color:#475569;">Se souvenir de moi</span>
                    </label>
                </div>

                <!-- Bouton connexion -->
                <button type="submit" style="width:100%;background:#10b981;border:none;border-radius:40px;padding:14px 20px;color:white;font-weight:700;font-size:15px;cursor:pointer;transition:all 0.2s;box-shadow:0 4px 14px rgba(16,185,129,0.25);display:flex;align-items:center;justify-content:center;gap:10px;"
                    onmouseover="this.style.background='#059669'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 20px rgba(16,185,129,0.35)'"
                    onmouseout="this.style.background='#10b981'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 14px rgba(16,185,129,0.25)'"
                    onmousedown="this.style.transform='scale(0.98)'"
                    onmouseup="this.style.transform='scale(1)'">
                    <i class="fas fa-arrow-right-to-bracket" style="font-size:14px;"></i>
                    Se connecter
                </button>
            </form>

            <!-- Message de sécurité -->
            <div style="margin-top:32px;padding-top:24px;border-top:1px solid #eef2f8;text-align:center;">
                <p style="font-size:11px;color:#94a3b8;margin:0;">
                    <i class="fas fa-shield-alt" style="font-size:10px;margin-right:6px;"></i>
                    Connexion sécurisée — Environnement privé
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.querySelector('.fa-eye');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}
</script>
@endsection
