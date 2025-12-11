<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Hébergement Ngaoundéré')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Configuration Tailwind personnalisée -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#640d14',
                        secondary: '#ad2831',
                        accent: '#38040e',
                        dark: '#250902',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-out',
                        'slide-in': 'slideIn 0.5s ease-out',
                        'slide-down': 'slideDown 0.3s ease-out',
                        'bounce-slow': 'bounce 3s infinite',
                        'pulse-slow': 'pulse 3s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideIn: {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(0)' }
                        },
                        slideDown: {
                            '0%': { opacity: '0', transform: 'translateY(-10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Scroll smooth */
        html {
            scroll-behavior: smooth;
        }
        
        /* Gradient animé pour le navbar */
        .nav-gradient {
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,1) 100%);
            backdrop-filter: blur(10px);
        }
        
        /* Effet hover sur les cartes */
        .hover-lift {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-lift:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(100, 13, 20, 0.15);
        }
        
        /* Bouton avec effet gradient et animation */
        .btn-primary {
            background: linear-gradient(135deg, #ad2831 0%, #640d14 100%);
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #38040e 0%, #250902 100%);
            transition: left 0.4s ease;
        }
        
        .btn-primary:hover::before {
            left: 0;
        }
        
        .btn-primary span {
            position: relative;
            z-index: 1;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(173, 40, 49, 0.4);
        }
        
        /* Animation pour le menu dropdown */
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
        
        .group:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        /* Effet de ligne animée sous les liens */
        .nav-link {
            position: relative;
            display: inline-block;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 50%;
            background: linear-gradient(90deg, #ad2831, #640d14);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Animation pour les messages flash */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .flash-message {
            animation: slideInRight 0.5s ease-out;
        }
        
        /* Style pour le footer avec effet parallaxe */
        .footer-gradient {
            background: linear-gradient(135deg, #250902 0%, #38040e 50%, #640d14 100%);
            position: relative;
        }
        
        .footer-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, #ad2831, transparent);
        }
        
        /* Effet de survol pour les icônes sociales */
        .social-icon {
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            transform: translateY(-5px) rotate(5deg);
            box-shadow: 0 10px 20px rgba(173, 40, 49, 0.3);
        }
        
        /* Animation du burger menu */
        .burger-line {
            transition: all 0.3s ease;
        }
        
        .burger-active .burger-line:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        
        .burger-active .burger-line:nth-child(2) {
            opacity: 0;
        }
        
        .burger-active .burger-line:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }
        
        /* Effet de brillance sur le logo */
        .logo-shine {
            position: relative;
            overflow: hidden;
        }
        
        .logo-shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent
            );
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }
        
        /* Menu mobile avec effet slide */
        #mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
        }
        
        #mobile-menu.active {
            max-height: 500px;
        }
        
        /* Effet de pulse sur les notifications */
        .notification-badge {
            animation: pulse 2s infinite;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-gray-100 font-sans antialiased">
    
    <!-- Navigation -->
    <nav class="nav-gradient shadow-lg sticky top-0 z-50 border-b border-gray-100">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo avec effet brillant -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group logo-shine">
                    <div class="w-12 h-12 bg-gradient-to-br from-secondary to-accent rounded-xl flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-300 shadow-lg">
                        <i class="fas fa-home text-2xl text-white"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-2xl font-bold bg-gradient-to-r from-dark to-secondary bg-clip-text text-transparent">
                            Hébergement
                        </span>
                        <span class="text-sm text-accent font-semibold -mt-1">Ngaoundéré</span>
                    </div>
                </a>
                
                <!-- Menu Desktop -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="nav-link text-gray-700 hover:text-secondary font-medium transition-colors duration-300">
                        <i class="fas fa-house-user mr-2"></i> Accueil
                    </a>
                    <a href="{{ route('accommodations.index') }}" class="nav-link text-gray-700 hover:text-secondary font-medium transition-colors duration-300">
                        <i class="fas fa-search mr-2"></i> Rechercher
                    </a>
                    
                    @auth
                        @if(auth()->user()->isOwner())
                            <a href="{{ route('owner.accommodations.index') }}" class="nav-link text-gray-700 hover:text-secondary font-medium transition-colors duration-300">
                                <i class="fas fa-building mr-2"></i> Mes hébergements
                            </a>
                        @endif
                        
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="nav-link text-gray-700 hover:text-secondary font-medium transition-colors duration-300">
                                <i class="fas fa-shield-alt mr-2"></i> Administration
                            </a>
                        @endif
                        
                        <a href="{{ route('reservations.index') }}" class="nav-link text-gray-700 hover:text-secondary font-medium transition-colors duration-300 relative">
                            <i class="fas fa-calendar-check mr-2"></i> Mes réservations
                        </a>
                        
                        <!-- User Dropdown avec animation -->
                        <div class="relative group">
                            <button class="flex items-center space-x-3 text-gray-700 hover:text-secondary transition-colors duration-300 px-4 py-2 rounded-full hover:bg-gray-100">
                                <div class="w-10 h-10 bg-gradient-to-br from-secondary to-accent rounded-full flex items-center justify-center text-white font-bold shadow-md">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="font-medium">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs transform group-hover:rotate-180 transition-transform duration-300"></i>
                            </button>
                            
                            <div class="dropdown-menu absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl py-2 border border-gray-100">
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-5 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-primary/5 hover:to-secondary/5 transition-all duration-300 group">
                                    <i class="fas fa-user mr-3 text-secondary group-hover:scale-110 transition-transform"></i>
                                    <span class="font-medium">Mon profil</span>
                                </a>
                                <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-5 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 transition-all duration-300 group">
                                        <i class="fas fa-sign-out-alt mr-3 text-red-500 group-hover:scale-110 transition-transform"></i>
                                        <span class="font-medium">Déconnexion</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="nav-link text-gray-700 hover:text-secondary font-medium transition-colors duration-300">
                            <i class="fas fa-sign-in-alt mr-2"></i> Connexion
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary text-white px-8 py-3 rounded-full font-semibold shadow-lg hover:shadow-xl">
                            <span><i class="fas fa-user-plus mr-2"></i> Inscription</span>
                        </a>
                    @endauth
                </div>
                
                <!-- Burger Menu Mobile -->
                <button id="mobile-menu-btn" class="lg:hidden text-gray-700 w-10 h-10 flex flex-col items-center justify-center space-y-1.5 focus:outline-none">
                    <span class="burger-line w-6 h-0.5 bg-gray-700 rounded-full"></span>
                    <span class="burger-line w-6 h-0.5 bg-gray-700 rounded-full"></span>
                    <span class="burger-line w-6 h-0.5 bg-gray-700 rounded-full"></span>
                </button>
            </div>
        </div>
        
        <!-- Menu Mobile avec animation -->
        <div id="mobile-menu" class="lg:hidden bg-white border-t border-gray-100">
            <div class="container mx-auto px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-primary/5 hover:to-secondary/5 rounded-xl transition-all duration-300">
                    <i class="fas fa-house-user mr-3 text-secondary w-5"></i>
                    <span class="font-medium">Accueil</span>
                </a>
                <a href="{{ route('accommodations.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-primary/5 hover:to-secondary/5 rounded-xl transition-all duration-300">
                    <i class="fas fa-search mr-3 text-secondary w-5"></i>
                    <span class="font-medium">Rechercher</span>
                </a>
                @auth
                    <a href="{{ route('reservations.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-primary/5 hover:to-secondary/5 rounded-xl transition-all duration-300">
                        <i class="fas fa-calendar-check mr-3 text-secondary w-5"></i>
                        <span class="font-medium">Mes réservations</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-primary/5 hover:to-secondary/5 rounded-xl transition-all duration-300">
                        <i class="fas fa-user mr-3 text-secondary w-5"></i>
                        <span class="font-medium">Mon profil</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 rounded-xl transition-all duration-300">
                            <i class="fas fa-sign-out-alt mr-3 text-red-500 w-5"></i>
                            <span class="font-medium">Déconnexion</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-primary/5 hover:to-secondary/5 rounded-xl transition-all duration-300">
                        <i class="fas fa-sign-in-alt mr-3 text-secondary w-5"></i>
                        <span class="font-medium">Connexion</span>
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center px-4 py-3 text-white bg-gradient-to-r from-secondary to-accent rounded-xl transition-all duration-300 hover:shadow-lg">
                        <i class="fas fa-user-plus mr-3 w-5"></i>
                        <span class="font-medium">Inscription</span>
                    </a>
                @endauth
            </div>
        </div>
    </nav>
    
    <!-- Messages Flash avec animation -->
    @if(session('success'))
        <div class="container mx-auto px-4 mt-6">
            <div class="flash-message bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 p-5 rounded-xl shadow-lg flex items-center">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <i class="fas fa-check text-white"></i>
                </div>
                <p class="font-medium">{{ session('success') }}</p>
                <button onclick="this.parentElement.remove()" class="ml-auto text-green-600 hover:text-green-800 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="container mx-auto px-4 mt-6">
            <div class="flash-message bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-800 p-5 rounded-xl shadow-lg flex items-center">
                <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                </div>
                <p class="font-medium">{{ session('error') }}</p>
                <button onclick="this.parentElement.remove()" class="ml-auto text-red-600 hover:text-red-800 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif
    
    <!-- Contenu principal -->
    <main class="min-h-screen">
        @yield('content')
    </main>
    
    <!-- Footer avec gradient -->
    <footer class="footer-gradient text-white mt-20 relative overflow-hidden">
        <!-- Effet de vague décorative -->
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-secondary to-transparent"></div>
        
        <div class="container mx-auto px-4 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- À propos avec animation -->
                <div class="space-y-4 animate-fade-in">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-secondary/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-info-circle text-secondary text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold">À propos</h3>
                    </div>
                    <p class="text-gray-300 leading-relaxed">
                        Plateforme de réservation d'hébergements à Ngaoundéré. 
                        Trouvez le logement idéal pour votre séjour en quelques clics.
                    </p>
                    <div class="pt-4">
                        <div class="h-1 w-20 bg-gradient-to-r from-secondary to-accent rounded-full"></div>
                    </div>
                </div>
                
                <!-- Liens rapides -->
                <div class="space-y-4 animate-fade-in">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-secondary/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-link text-secondary text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold">Liens rapides</h3>
                    </div>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-300 hover:text-secondary transition-colors duration-300 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-xs transform group-hover:translate-x-1 transition-transform"></i>
                                Accueil
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('accommodations.index') }}" class="text-gray-300 hover:text-secondary transition-colors duration-300 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-xs transform group-hover:translate-x-1 transition-transform"></i>
                                Hébergements
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-300 hover:text-secondary transition-colors duration-300 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-xs transform group-hover:translate-x-1 transition-transform"></i>
                                Contact
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-300 hover:text-secondary transition-colors duration-300 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-xs transform group-hover:translate-x-1 transition-transform"></i>
                                FAQ
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div class="space-y-4 animate-fade-in">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-secondary/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-phone text-secondary text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold">Contact</h3>
                    </div>
                    <ul class="space-y-4 text-gray-300">
                        <li class="flex items-start group">
                            <div class="w-8 h-8 bg-secondary/20 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 group-hover:bg-secondary/30 transition-colors">
                                <i class="fas fa-map-marker-alt text-sm"></i>
                            </div>
                            <span>Ngaoundéré, Cameroun</span>
                        </li>
                        <li class="flex items-start group">
                            <div class="w-8 h-8 bg-secondary/20 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 group-hover:bg-secondary/30 transition-colors">
                                <i class="fas fa-envelope text-sm"></i>
                            </div>
                            <span>contact@hebergement.cm</span>
                        </li>
                        <li class="flex items-start group">
                            <div class="w-8 h-8 bg-secondary/20 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 group-hover:bg-secondary/30 transition-colors">
                                <i class="fas fa-phone text-sm"></i>
                            </div>
                            <span>+237 6XX XX XX XX</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Réseaux sociaux -->
                <div class="space-y-4 animate-fade-in">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-secondary/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-share-alt text-secondary text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold">Suivez-nous</h3>
                    </div>
                    <p class="text-gray-300 mb-6">Restez connectés pour les dernières offres</p>
                    <div class="flex space-x-4">
                        <a href="#" class="social-icon w-12 h-12 bg-gradient-to-br from-secondary to-accent rounded-xl flex items-center justify-center hover:from-accent hover:to-secondary shadow-lg">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a href="#" class="social-icon w-12 h-12 bg-gradient-to-br from-secondary to-accent rounded-xl flex items-center justify-center hover:from-accent hover:to-secondary shadow-lg">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        <a href="#" class="social-icon w-12 h-12 bg-gradient-to-br from-secondary to-accent rounded-xl flex items-center justify-center hover:from-accent hover:to-secondary shadow-lg">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="#" class="social-icon w-12 h-12 bg-gradient-to-br from-secondary to-accent rounded-xl flex items-center justify-center hover:from-accent hover:to-secondary shadow-lg">
                            <i class="fab fa-linkedin-in text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Ligne de séparation avec gradient -->
            <div class="h-px bg-gradient-to-r from-transparent via-gray-600 to-transparent my-12"></div>
            
            <!-- Copyright -->
            <div class="text-center text-gray-400">
                <p class="flex items-center justify-center space-x-2">
                    <i class="far fa-copyright"></i>
                    <span>{{ date('Y') }} Hébergement Ngaoundéré. Tous droits réservés.</span>
                </p>
                <p class="mt-2 text-sm">
                    Créé avec <i class="fas fa-heart text-red-500 animate-pulse-slow mx-1"></i> à Ngaoundéré
                </p>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script>
        // Menu mobile toggle avec animation
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenuBtn.classList.toggle('burger-active');
            mobileMenu.classList.toggle('active');
        });
        
        // Smooth scroll pour les ancres
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if(target) {
                    target.scrollIntoView({ 
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Auto-hide flash messages avec animation
        setTimeout(() => {
            const flashMessages = document.querySelectorAll('.flash-message');
            flashMessages.forEach(el => {
                el.style.transition = 'all 0.5s ease';
                el.style.transform = 'translateX(100%)';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 5000);
        
        // Fermer le menu mobile lors du clic sur un lien
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenuBtn.classList.remove('burger-active');
                mobileMenu.classList.remove('active');
            });
        });
        
        // Animation au scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
         </script>
    
    @stack('scripts')
</body>
</html>