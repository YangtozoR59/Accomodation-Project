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
                        primary: '#852828',
                        secondary: '#4DE3E3',
                        neutral: '#BAB1B1',
                        dark: '#1a1a1a',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.8s ease-out',
                        'slide-in': 'slideIn 0.6s ease-out',
                        'slide-down': 'slideDown 0.4s ease-out',
                        'float': 'float 6s ease-in-out infinite',
                        'scale-in': 'scaleIn 0.5s ease-out',
                        'bounce-soft': 'bounceSoft 2s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideIn: {
                            '0%': { transform: 'translateX(-50px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' }
                        },
                        slideDown: {
                            '0%': { opacity: '0', transform: 'translateY(-20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' }
                        },
                        scaleIn: {
                            '0%': { transform: 'scale(0.9)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' }
                        },
                        bounceSoft: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' }
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        html {
            scroll-behavior: smooth;
        }
        
        /* Glassmorphisme pour la navbar */
        .nav-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(186, 177, 177, 0.2);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }
        
        /* Neumorphisme pour les cartes */
        .card-neomorphism {
            background: #f9fafb;
            box-shadow: 8px 8px 16px rgba(186, 177, 177, 0.2),
                        -8px -8px 16px rgba(255, 255, 255, 0.9);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-neomorphism:hover {
            box-shadow: 12px 12px 24px rgba(186, 177, 177, 0.25),
                        -12px -12px 24px rgba(255, 255, 255, 1);
            transform: translateY(-8px);
        }
        
        /* Neumorphisme enfoncé */
        .card-inset {
            background: #f9fafb;
            box-shadow: inset 6px 6px 12px rgba(186, 177, 177, 0.15),
                        inset -6px -6px 12px rgba(255, 255, 255, 0.9);
        }
        
        /* Bouton neumorphique primaire */
        .btn-neomorphism-primary {
            background: #852828;
            box-shadow: 6px 6px 12px rgba(133, 40, 40, 0.3),
                        -6px -6px 12px rgba(133, 40, 40, 0.1);
            transition: all 0.3s ease;
        }
        
        .btn-neomorphism-primary:hover {
            box-shadow: 8px 8px 16px rgba(133, 40, 40, 0.4),
                        -8px -8px 16px rgba(133, 40, 40, 0.15);
            transform: translateY(-2px);
        }
        
        .btn-neomorphism-primary:active {
            box-shadow: inset 4px 4px 8px rgba(0, 0, 0, 0.3),
                        inset -4px -4px 8px rgba(133, 40, 40, 0.5);
            transform: translateY(0);
        }
        
        /* Bouton neumorphique secondaire */
        .btn-neomorphism-secondary {
            background: #4DE3E3;
            box-shadow: 6px 6px 12px rgba(77, 227, 227, 0.3),
                        -6px -6px 12px rgba(77, 227, 227, 0.1);
            transition: all 0.3s ease;
        }
        
        .btn-neomorphism-secondary:hover {
            box-shadow: 8px 8px 16px rgba(77, 227, 227, 0.4),
                        -8px -8px 16px rgba(77, 227, 227, 0.15);
            transform: translateY(-2px);
        }
        
        .btn-neomorphism-secondary:active {
            box-shadow: inset 4px 4px 8px rgba(0, 0, 0, 0.2),
                        inset -4px -4px 8px rgba(77, 227, 227, 0.5);
            transform: translateY(0);
        }
        
        /* Glassmorphisme pour les dropdowns */
        .dropdown-glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(186, 177, 177, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        /* Animation dropdown */
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-15px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
            height: 3px;
            bottom: -8px;
            left: 50%;
            background: #4DE3E3;
            transition: all 0.4s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Flash messages glassmorphisme */
        .flash-glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(186, 177, 177, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
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
            animation: slideInRight 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Footer avec neumorphisme */
        .footer-neomorphism {
            background: #f9fafb;
            box-shadow: 0 -8px 32px rgba(186, 177, 177, 0.15);
        }
        
        /* Icônes sociales neumorphiques */
        .social-icon {
            background: #f9fafb;
            box-shadow: 4px 4px 8px rgba(186, 177, 177, 0.2),
                        -4px -4px 8px rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            box-shadow: 2px 2px 4px rgba(186, 177, 177, 0.2),
                        -2px -2px 4px rgba(255, 255, 255, 0.9);
            transform: translateY(-3px);
        }
        
        .social-icon:active {
            box-shadow: inset 2px 2px 4px rgba(186, 177, 177, 0.2),
                        inset -2px -2px 4px rgba(255, 255, 255, 0.9);
            transform: translateY(0);
        }
        
        /* Animation du burger menu */
        .burger-line {
            transition: all 0.3s ease;
        }
        
        .burger-active .burger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }
        
        .burger-active .burger-line:nth-child(2) {
            opacity: 0;
        }
        
        .burger-active .burger-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }
        
        /* Logo avec effet glassmorphisme */
        .logo-container {
            background: rgba(77, 227, 227, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(77, 227, 227, 0.2);
        }
        
        /* Menu mobile avec glassmorphisme */
        #mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        
        #mobile-menu.active {
            max-height: 700px;
        }
        
        /* Input avec neumorphisme */
        .input-neomorphism {
            background: #f9fafb;
            box-shadow: inset 4px 4px 8px rgba(186, 177, 177, 0.15),
                        inset -4px -4px 8px rgba(255, 255, 255, 0.9);
            border: none;
            transition: all 0.3s ease;
        }
        
        .input-neomorphism:focus {
            outline: none;
            box-shadow: inset 6px 6px 12px rgba(186, 177, 177, 0.2),
                        inset -6px -6px 12px rgba(255, 255, 255, 1),
                        0 0 0 3px rgba(77, 227, 227, 0.2);
        }
        
        /* Badge avec effet subtil */
        .badge-soft {
            background: rgba(77, 227, 227, 0.1);
            border: 1px solid rgba(77, 227, 227, 0.3);
            transition: all 0.3s ease;
        }
        
        .badge-soft:hover {
            background: rgba(77, 227, 227, 0.2);
            transform: scale(1.05);
        }
        
        /* Effet de survol sur les liens */
        .hover-lift-subtle {
            transition: all 0.3s ease;
        }
        
        .hover-lift-subtle:hover {
            transform: translateY(-3px);
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">
    
    <!-- Navigation -->
    <nav class="nav-glass sticky top-0 z-50">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="logo-container w-12 h-12 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-home text-2xl text-secondary"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-2xl font-bold text-primary">
                            Hébergement
                        </span>
                        <span class="text-xs text-neutral font-semibold -mt-1">Ngaoundéré</span>
                    </div>
                </a>
                
                <!-- Menu Desktop -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="nav-link text-gray-700 hover:text-primary font-medium transition-colors duration-300">
                        <i class="fas fa-house-user mr-2"></i> Accueil
                    </a>
                    <a href="{{ route('accommodations.index') }}" class="nav-link text-gray-700 hover:text-primary font-medium transition-colors duration-300">
                        <i class="fas fa-search mr-2"></i> Rechercher
                    </a>
                    
                    @auth
                        @if(auth()->user()->isOwner())
                            <a href="{{ route('owner.accommodations.index') }}" class="nav-link text-gray-700 hover:text-primary font-medium transition-colors duration-300">
                                <i class="fas fa-building mr-2"></i> Mes hébergements
                            </a>
                        @endif
                        
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="nav-link text-gray-700 hover:text-primary font-medium transition-colors duration-300">
                                <i class="fas fa-shield-alt mr-2"></i> Administration
                            </a>
                        @endif
                        
                        <a href="{{ route('reservations.index') }}" class="nav-link text-gray-700 hover:text-primary font-medium transition-colors duration-300 relative">
                            <i class="fas fa-calendar-check mr-2"></i> Mes réservations
                        </a>
                        
                        <!-- User Dropdown -->
                        <div class="relative group">
                            <button class="flex items-center space-x-3 text-gray-700 hover:text-primary transition-colors duration-300 px-4 py-2 rounded-2xl hover-lift-subtle">
                                <div class="w-10 h-10 bg-secondary rounded-full flex items-center justify-center text-white font-bold shadow-md">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="font-medium">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs transform group-hover:rotate-180 transition-transform duration-300"></i>
                            </button>
                            
                            <div class="dropdown-menu dropdown-glass absolute right-0 mt-3 w-56 rounded-2xl py-2">
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-5 py-3 text-gray-700 hover:text-primary transition-all duration-300 hover-lift-subtle">
                                    <i class="fas fa-user mr-3 text-secondary"></i>
                                    <span class="font-medium">Mon profil</span>
                                </a>
                                <div class="h-px bg-neutral opacity-20 my-2 mx-4"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-5 py-3 text-gray-700 hover:text-primary transition-all duration-300 hover-lift-subtle">
                                        <i class="fas fa-sign-out-alt mr-3 text-primary"></i>
                                        <span class="font-medium">Déconnexion</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="nav-link text-gray-700 hover:text-primary font-medium transition-colors duration-300">
                            <i class="fas fa-sign-in-alt mr-2"></i> Connexion
                        </a>
                        <a href="{{ route('register') }}" class="btn-neomorphism-secondary text-white px-8 py-3 rounded-full font-semibold">
                            <i class="fas fa-user-plus mr-2"></i> Inscription
                        </a>
                    @endauth
                </div>
                
                <!-- Burger Menu Mobile -->
                <button id="mobile-menu-btn" class="lg:hidden text-primary w-10 h-10 flex flex-col items-center justify-center space-y-1.5 focus:outline-none card-neomorphism rounded-xl p-2">
                    <span class="burger-line w-5 h-0.5 bg-primary rounded-full"></span>
                    <span class="burger-line w-5 h-0.5 bg-primary rounded-full"></span>
                    <span class="burger-line w-5 h-0.5 bg-primary rounded-full"></span>
                </button>
            </div>
        </div>
        
        <!-- Menu Mobile -->
        <div id="mobile-menu" class="lg:hidden border-t border-neutral border-opacity-20">
            <div class="container mx-auto px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-primary rounded-xl transition-all duration-300 hover-lift-subtle">
                    <i class="fas fa-house-user mr-3 text-secondary w-5"></i>
                    <span class="font-medium">Accueil</span>
                </a>
                <a href="{{ route('accommodations.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-primary rounded-xl transition-all duration-300 hover-lift-subtle">
                    <i class="fas fa-search mr-3 text-secondary w-5"></i>
                    <span class="font-medium">Rechercher</span>
                </a>
                @auth
                    <a href="{{ route('reservations.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-primary rounded-xl transition-all duration-300 hover-lift-subtle">
                        <i class="fas fa-calendar-check mr-3 text-secondary w-5"></i>
                        <span class="font-medium">Mes réservations</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-primary rounded-xl transition-all duration-300 hover-lift-subtle">
                        <i class="fas fa-user mr-3 text-secondary w-5"></i>
                        <span class="font-medium">Mon profil</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3 text-gray-700 hover:text-primary rounded-xl transition-all duration-300 hover-lift-subtle">
                            <i class="fas fa-sign-out-alt mr-3 text-primary w-5"></i>
                            <span class="font-medium">Déconnexion</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-primary rounded-xl transition-all duration-300 hover-lift-subtle">
                        <i class="fas fa-sign-in-alt mr-3 text-secondary w-5"></i>
                        <span class="font-medium">Connexion</span>
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center px-4 py-3 text-white bg-secondary rounded-xl transition-all duration-300 hover-lift-subtle">
                        <i class="fas fa-user-plus mr-3 w-5"></i>
                        <span class="font-medium">Inscription</span>
                    </a>
                @endauth
            </div>
        </div>
    </nav>
    
    <!-- Messages Flash -->
    @if(session('success'))
        <div class="container mx-auto px-4 mt-6">
            <div class="flash-message flash-glass border-l-4 border-secondary text-gray-800 p-5 rounded-xl flex items-center">
                <div class="w-10 h-10 bg-secondary rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <i class="fas fa-check text-white"></i>
                </div>
                <p class="font-medium flex-1">{{ session('success') }}</p>
                <button onclick="this.parentElement.remove()" class="ml-4 text-gray-600 hover:text-gray-800 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="container mx-auto px-4 mt-6">
            <div class="flash-message flash-glass border-l-4 border-primary text-gray-800 p-5 rounded-xl flex items-center">
                <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                </div>
                <p class="font-medium flex-1">{{ session('error') }}</p>
                <button onclick="this.parentElement.remove()" class="ml-4 text-gray-600 hover:text-gray-800 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif
    
    <!-- Contenu principal -->
    <main class="min-h-screen">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="footer-neomorphism text-gray-700 mt-20 relative overflow-hidden">
        <div class="container mx-auto px-4 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- À propos -->
                <div class="space-y-4 animate-fade-in">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 card-inset rounded-xl flex items-center justify-center">
                            <i class="fas fa-info-circle text-secondary text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-dark">À propos</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Plateforme de réservation d'hébergements à Ngaoundéré. 
                        Trouvez le logement idéal pour votre séjour en quelques clics.
                    </p>
                </div>
                
                <!-- Liens rapides -->
                <div class="space-y-4 animate-fade-in">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 card-inset rounded-xl flex items-center justify-center">
                            <i class="fas fa-link text-secondary text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-dark">Liens rapides</h3>
                    </div>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-600 hover:text-secondary transition-colors duration-300 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-xs transform group-hover:translate-x-1 transition-transform"></i>
                                Accueil
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('accommodations.index') }}" class="text-gray-600 hover:text-secondary transition-colors duration-300 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-xs transform group-hover:translate-x-1 transition-transform"></i>
                                Hébergements
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-secondary transition-colors duration-300 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-xs transform group-hover:translate-x-1 transition-transform"></i>
                                Contact
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-secondary transition-colors duration-300 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-xs transform group-hover:translate-x-1 transition-transform"></i>
                                FAQ
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div class="space-y-4 animate-fade-in">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 card-inset rounded-xl flex items-center justify-center">
                            <i class="fas fa-phone text-secondary text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-dark">Contact</h3>
                    </div>
                    <ul class="space-y-4 text-gray-600">
                        <li class="flex items-start group">
                            <div class="w-8 h-8 card-inset rounded-lg flex items-center justify-center mr-3 flex-shrink-0 group-hover:scale-110 transition-transform">
                                <i class="fas fa-map-marker-alt text-sm text-secondary"></i>
                            </div>
                            <span>Ngaoundéré, Cameroun</span>
                        </li>
                        <li class="flex items-start group">
                            <div class="w-8 h-8 card-inset rounded-lg flex items-center justify-center mr-3 flex-shrink-0 group-hover:scale-110 transition-transform">
                                <i class="fas fa-envelope text-sm text-secondary"></i>
                            </div>
                            <span>contact@hebergement.cm</span>
                        </li>
                        <li class="flex items-start group">
                            <div class="w-8 h-8 card-inset rounded-lg flex items-center justify-center mr-3 flex-shrink-0 group-hover:scale-110 transition-transform">
                                <i class="fas fa-phone text-sm text-secondary"></i>
                            </div>
                            <span>+237 6XX XX XX XX</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Réseaux sociaux -->
                <div class="space-y-4 animate-fade-in">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 card-inset rounded-xl flex items-center justify-center">
                            <i class="fas fa-share-alt text-secondary text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-dark">Suivez-nous</h3>
                    </div>
                    <p class="text-gray-600 mb-6">Restez connectés pour les dernières offres</p>
                    <div class="flex space-x-4">
                        <a href="#" class="social-icon w-12 h-12 rounded-xl flex items-center justify-center">
                            <i class="fab fa-facebook-f text-lg text-primary"></i>
                        </a>
                        <a href="#" class="social-icon w-12 h-12 rounded-xl flex items-center justify-center">
                            <i class="fab fa-twitter text-lg text-primary"></i>
                        </a>
                        <a href="#" class="social-icon w-12 h-12 rounded-xl flex items-center justify-center">
                            <i class="fab fa-instagram text-lg text-primary"></i>
                        </a>
                        <a href="#" class="social-icon w-12 h-12 rounded-xl flex items-center justify-center">
                            <i class="fab fa-linkedin-in text-lg text-primary"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Ligne de séparation -->
            <div class="h-px bg-neutral opacity-20 my-12"></div>
            
            <!-- Copyright -->
            <div class="text-center text-gray-600">
                <p class="flex items-center justify-center space-x-2">
                    <i class="far fa-copyright"></i>
                    <span>{{ date('Y') }} Hébergement Ngaoundéré. Tous droits réservés.</span>
                </p>
                <p class="mt-2 text-sm flex items-center justify-center">
                    Créé avec <i class="fas fa-heart text-secondary animate-bounce-soft mx-1"></i> à Ngaoundéré
                </p>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenuBtn.classList.toggle('burger-active');
            mobileMenu.classList.toggle('active');
        });
        
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
        
        setTimeout(() => {
            const flashMessages = document.querySelectorAll('.flash-message');
            flashMessages.forEach(el => {
                el.style.transition = 'all 0.5s ease';
                el.style.transform = 'translateX(100%)';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 5000);
        
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenuBtn.classList.remove('burger-active');
                mobileMenu.classList.remove('active');
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>