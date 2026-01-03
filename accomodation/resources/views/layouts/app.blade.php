<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LiveHouse237 - Hébergement au Cameroun')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Configuration Tailwind personnalisée -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#CE1126',
                            light: '#E53E52',
                            dark: '#A00E1E',
                        },
                        secondary: {
                            DEFAULT: '#007A5E',
                            light: '#00A87E',
                            dark: '#005A46',
                        },
                        accent: {
                            DEFAULT: '#FCD116',
                            light: '#FFE066',
                            dark: '#D4AF13',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.8s ease-out',
                        'slide-in': 'slideIn 0.6s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'scale-in': 'scaleIn 0.5s ease-out',
                        'float': 'float 3s ease-in-out infinite',
                        'pulse-soft': 'pulseSoft 2s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideIn: {
                            '0%': { transform: 'translateX(-30px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(30px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        },
                        scaleIn: {
                            '0%': { transform: 'scale(0.95)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' }
                        },
                        pulseSoft: {
                            '0%, 100%': { opacity: '1' },
                            '50%': { opacity: '0.8' }
                        }
                    },
                    backdropBlur: {
                        xs: '2px',
                    }
                }
            }
        }
    </script>
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        /* Gradient de fond subtil */
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }
        
        /* Glassmorphisme pour la navbar */
        .nav-glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        }
        
        /* Effet de ligne animée sous les liens */
        .nav-link {
            position: relative;
            display: inline-block;
            padding-bottom: 4px;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background: linear-gradient(90deg, #FCD116, #007A5E);
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Cartes avec glassmorphisme */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .glass-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
            border-color: rgba(252, 209, 22, 0.3);
        }
        
        /* Boutons avec gradient et glassmorphisme */
        .btn-primary {
            background: linear-gradient(135deg, #CE1126 0%, #E53E52 100%);
            box-shadow: 0 4px 15px rgba(206, 17, 38, 0.3);
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(206, 17, 38, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #007A5E 0%, #00A87E 100%);
            box-shadow: 0 4px 15px rgba(0, 122, 94, 0.3);
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 122, 94, 0.4);
        }
        
        .btn-accent {
            background: linear-gradient(135deg, #FCD116 0%, #FFE066 100%);
            box-shadow: 0 4px 15px rgba(252, 209, 22, 0.3);
            transition: all 0.3s ease;
            border: none;
            color: #1a1a1a;
        }
        
        .btn-accent:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(252, 209, 22, 0.4);
        }
        
        /* Dropdown avec glassmorphisme */
        .dropdown-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        }
        
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .group:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        /* Logo avec effet brillant */
        .logo-container {
            background: linear-gradient(135deg, rgba(252, 209, 22, 0.1) 0%, rgba(0, 122, 94, 0.1) 100%);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }
        
        .logo-container:hover {
            background: linear-gradient(135deg, rgba(252, 209, 22, 0.2) 0%, rgba(0, 122, 94, 0.2) 100%);
            box-shadow: 0 8px 20px rgba(252, 209, 22, 0.2);
        }
        
        /* Badge avec accent */
        .badge-accent {
            background: linear-gradient(135deg, #FCD116 0%, #FFE066 100%);
            box-shadow: 0 2px 8px rgba(252, 209, 22, 0.3);
        }
        
        /* Messages flash avec glassmorphisme */
        .flash-glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
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
            animation: slideInRight 0.5s cubic-bezier(0.4, 0, 0.2, 1);
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
            max-height: 800px;
        }
        
        /* Animation burger menu */
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
        
        /* Input avec glassmorphisme */
        .input-glass {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }
        
        .input-glass:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.8);
            border-color: rgba(252, 209, 22, 0.5);
            box-shadow: 0 0 0 4px rgba(252, 209, 22, 0.1);
        }
        
        /* Footer avec glassmorphisme */
        .footer-glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 -8px 32px rgba(0, 0, 0, 0.08);
        }
        
        /* Icônes sociales avec effet hover */
        .social-icon {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            transform: translateY(-4px) scale(1.1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        
        /* Avatar avec gradient border */
        .avatar-gradient {
            background: linear-gradient(135deg, #FCD116, #007A5E, #CE1126);
            padding: 3px;
            border-radius: 50%;
        }
        
        .avatar-inner {
            background: white;
            border-radius: 50%;
        }
        
        /* Effet parallaxe subtil sur scroll */
        .parallax {
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Decoration avec les couleurs nationales */
        .decoration-bar {
            height: 4px;
            background: linear-gradient(90deg, #007A5E 0%, #007A5E 33.33%, #CE1126 33.33%, #CE1126 66.66%, #FCD116 66.66%, #FCD116 100%);
        }
        
        /* Hover effect subtil */
        .hover-lift {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-4px);
        }
    </style>
    
    @stack('styles')
</head>
<body class="antialiased">
    
    <!-- Barre décorative avec couleurs nationales -->
    <div class="decoration-bar"></div>
    
    <!-- Navigation -->
    <nav class="nav-glass sticky top-0 z-50">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="logo-container w-14 h-14 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-all duration-300">
                        <img src="{{ asset('images/logo.png') }}" class="w-10 h-10" alt="LiveHouse237">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-2xl font-bold bg-gradient-to-r from-primary via-accent to-secondary bg-clip-text text-transparent">
                            LiveHouse237
                        </span>
                        <span class="text-xs text-gray-600 font-medium -mt-1">Hébergement au Cameroun</span>
                    </div>
                </a>
                
                <!-- Menu Desktop -->
                <div class="hidden lg:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="nav-link text-gray-700 hover:text-primary font-medium text-sm transition-colors duration-300">
                        <i class="fas fa-home mr-2"></i>Accueil
                    </a>
                    <a href="{{ route('accommodations.index') }}" class="nav-link text-gray-700 hover:text-secondary font-medium text-sm transition-colors duration-300">
                        <i class="fas fa-search mr-2"></i>Explorer
                    </a>
                    
                    @auth
                        @if(auth()->user()->isOwner())
                            <a href="{{ route('owner.accommodations.index') }}" class="nav-link text-gray-700 hover:text-accent-dark font-medium text-sm transition-colors duration-300">
                                <i class="fas fa-building mr-2"></i>Mes logements
                            </a>
                        @endif
                        
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="nav-link text-gray-700 hover:text-primary font-medium text-sm transition-colors duration-300">
                                <i class="fas fa-shield-alt mr-2"></i>Admin
                            </a>
                        @endif
                        
                        <a href="{{ route('reservations.index') }}" class="nav-link text-gray-700 hover:text-secondary font-medium text-sm transition-colors duration-300">
                            <i class="fas fa-calendar-check mr-2"></i>Réservations
                        </a>
                        
                        <!-- User Dropdown -->
                        <div class="relative group">
                            <button class="flex items-center space-x-3 text-gray-700 hover:text-primary transition-all duration-300 px-4 py-2 rounded-xl hover-lift">
                                <div class="avatar-gradient">
                                    <div class="avatar-inner w-9 h-9 flex items-center justify-center">
                                        <span class="text-sm font-bold bg-gradient-to-br from-secondary to-primary bg-clip-text text-transparent">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <span class="font-medium text-sm">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs transform group-hover:rotate-180 transition-transform duration-300"></i>
                            </button>
                            
                            <div class="dropdown-menu dropdown-glass absolute right-0 mt-3 w-56 rounded-2xl py-2 overflow-hidden">
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-5 py-3 text-gray-700 hover:bg-white hover:bg-opacity-50 transition-all duration-300">
                                    <i class="fas fa-user mr-3 text-secondary w-5"></i>
                                    <span class="font-medium text-sm">Mon profil</span>
                                </a>
                                <div class="h-px bg-gray-200 my-2 mx-4"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-5 py-3 text-gray-700 hover:bg-white hover:bg-opacity-50 transition-all duration-300">
                                        <i class="fas fa-sign-out-alt mr-3 text-primary w-5"></i>
                                        <span class="font-medium text-sm">Déconnexion</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="nav-link text-gray-700 hover:text-secondary font-medium text-sm transition-colors duration-300">
                            <i class="fas fa-sign-in-alt mr-2"></i>Connexion
                        </a>
                        <a href="{{ route('register') }}" class="btn-secondary text-white px-6 py-2.5 rounded-full font-semibold text-sm hover-lift">
                            <i class="fas fa-user-plus mr-2"></i>Inscription
                        </a>
                    @endauth
                </div>
                
                <!-- Burger Menu Mobile -->
                <button id="mobile-menu-btn" class="lg:hidden text-primary w-10 h-10 flex flex-col items-center justify-center space-y-1.5 focus:outline-none glass-card rounded-xl">
                    <span class="burger-line w-5 h-0.5 bg-primary rounded-full"></span>
                    <span class="burger-line w-5 h-0.5 bg-primary rounded-full"></span>
                    <span class="burger-line w-5 h-0.5 bg-primary rounded-full"></span>
                </button>
            </div>
        </div>
        
        <!-- Menu Mobile -->
        <div id="mobile-menu" class="lg:hidden border-t border-gray-200 border-opacity-30">
            <div class="container mx-auto px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-primary rounded-xl hover:bg-white hover:bg-opacity-50 transition-all duration-300">
                    <i class="fas fa-home mr-3 text-secondary w-5"></i>
                    <span class="font-medium">Accueil</span>
                </a>
                <a href="{{ route('accommodations.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-secondary rounded-xl hover:bg-white hover:bg-opacity-50 transition-all duration-300">
                    <i class="fas fa-search mr-3 text-accent-dark w-5"></i>
                    <span class="font-medium">Explorer</span>
                </a>
                @auth
                    <a href="{{ route('reservations.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-primary rounded-xl hover:bg-white hover:bg-opacity-50 transition-all duration-300">
                        <i class="fas fa-calendar-check mr-3 text-primary w-5"></i>
                        <span class="font-medium">Mes réservations</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-secondary rounded-xl hover:bg-white hover:bg-opacity-50 transition-all duration-300">
                        <i class="fas fa-user mr-3 text-secondary w-5"></i>
                        <span class="font-medium">Mon profil</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3 text-gray-700 hover:text-primary rounded-xl hover:bg-white hover:bg-opacity-50 transition-all duration-300">
                            <i class="fas fa-sign-out-alt mr-3 text-primary w-5"></i>
                            <span class="font-medium">Déconnexion</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-secondary rounded-xl hover:bg-white hover:bg-opacity-50 transition-all duration-300">
                        <i class="fas fa-sign-in-alt mr-3 text-secondary w-5"></i>
                        <span class="font-medium">Connexion</span>
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center px-4 py-3 text-white btn-secondary rounded-xl transition-all duration-300">
                        <i class="fas fa-user-plus mr-3 w-5"></i>
                        <span class="font-medium">Inscription</span>
                    </a>
                @endauth
            </div>
        </div>
    </nav>
    
    <!-- Messages Flash -->
    @if(session('success'))
        <div class="fixed top-24 right-4 z-50 max-w-md">
            <div class="flash-message flash-glass border-l-4 border-secondary text-gray-800 p-4 rounded-xl flex items-center shadow-lg">
                <div class="w-10 h-10 bg-gradient-to-br from-secondary to-secondary-light rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                    <i class="fas fa-check text-white"></i>
                </div>
                <p class="font-medium flex-1 text-sm">{{ session('success') }}</p>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-gray-500 hover:text-gray-700 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="fixed top-24 right-4 z-50 max-w-md">
            <div class="flash-message flash-glass border-l-4 border-primary text-gray-800 p-4 rounded-xl flex items-center shadow-lg">
                <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary-light rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                </div>
                <p class="font-medium flex-1 text-sm">{{ session('error') }}</p>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-gray-500 hover:text-gray-700 transition-colors">
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
    <footer class="footer-glass text-gray-700 mt-20">
        <div class="container mx-auto px-4 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- À propos -->
                <div class="space-y-4 animate-fade-in">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <span class="w-1 h-6 bg-gradient-to-b from-secondary to-primary rounded-full mr-3"></span>
                        À propos
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        LiveHouse237 est votre plateforme de confiance pour trouver l'hébergement parfait au Cameroun. Découvrez des logements de qualité à Ngaoundéré et partout au pays.
                    </p>
                    <div class="flex items-center space-x-2 pt-2">
                        <span class="w-8 h-1 bg-secondary rounded-full"></span>
                        <span class="w-8 h-1 bg-primary rounded-full"></span>
                        <span class="w-8 h-1 bg-accent rounded-full"></span>
                    </div>
                </div>
                
                <!-- Liens rapides -->
                <div class="space-y-4 animate-fade-in">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <span class="w-1 h-6 bg-gradient-to-b from-accent to-secondary rounded-full mr-3"></span>
                        Liens rapides
                    </h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-600 hover:text-secondary transition-colors duration-300 flex items-center text-sm group">
                                <i class="fas fa-chevron-right mr-2 text-xs text-accent transform group-hover:translate-x-1 transition-transform"></i>
                                Accueil
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('accommodations.index') }}" class="text-gray-600 hover:text-secondary transition-colors duration-300 flex items-center text-sm group">
                                <i class="fas fa-chevron-right mr-2 text-xs text-accent transform group-hover:translate-x-1 transition-transform"></i>
                                Hébergements
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-secondary transition-colors duration-300 flex items-center text-sm group">
                                <i class="fas fa-chevron-right mr-2 text-xs text-accent transform group-hover:translate-x-1 transition-transform"></i>
                                Contact
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-secondary transition-colors duration-300 flex items-center text-sm group">
                                <i class="fas fa-chevron-right mr-2 text-xs text-accent transform group-hover:translate-x-1 transition-transform"></i>
                                Devenir hôte
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div class="space-y-4 animate-fade-in">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <span class="w-1 h-6 bg-gradient-to-b from-primary to-accent rounded-full mr-3"></span>
                        Contact
                    </h3>
                    <ul class="space-y-4 text-gray-600">
                        <li class="flex items-start group text-sm">
                            <div class="glass-card w-8 h-8 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 group-hover:scale-110 transition-transform">
                                <i class="fas fa-map-marker-alt text-xs text-primary"></i>
                            </div>
                            <span>Ngaoundéré, Cameroun</span>
                        </li>
                        <li class="flex items-start group text-sm">
                            <div class="glass-card w-8 h-8 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 group-hover:scale-110 transition-transform">
                                <i class="fas fa-envelope text-xs text-secondary"></i>
                            </div>
                            <span>contact@livehouse237.cm</span>
                        </li>
                        <li class="flex items-start group text-sm">
                            <div class="glass-card w-8 h-8 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 group-hover:scale-110 transition-transform">
                                <i class="fas fa-phone text-xs text-accent-dark"></i>
                            </div>
                            <span>+237 6XX XX XX XX</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Réseaux sociaux -->
                <div class="space-y-4 animate-fade-in">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <span class="w-1 h-6 bg-gradient-to-b from-accent to-primary rounded-full mr-3"></span>
                        Suivez-nous
                    </h3>
                    <p class="text-gray-600 mb-6 text-sm">Restez connectés pour les dernières offres et actualités</p>
                    <div class="flex space-x-3">
                        <a href="#" class="social-icon w-11 h-11 rounded-xl flex items-center justify-center">
                            <i class="fab fa-facebook-f text-lg text-primary"></i>
                        </a>
                        <a href="#" class="social-icon w-11 h-11 rounded-xl flex items-center justify-center">
                            <i class="fab fa-twitter text-lg text-secondary"></i>
                        </a>
                        <a href="#" class="social-icon w-11 h-11 rounded-xl flex items-center justify-center">
                            <i class="fab fa-instagram text-lg text-accent-dark"></i>
                        </a>
                        <a href="#" class="social-icon w-11 h-11 rounded-xl flex items-center justify-center">
                            <i class="fab fa-whatsapp text-lg text-secondary"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Ligne de séparation -->
            <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent my-10"></div>
            
            <!-- Copyright -->
            <div class="text-center text-gray-600">
                <p class="flex items-center justify-center space-x-2 text-sm">
                    <i class="far fa-copyright text-accent"></i>
                    <span>{{ date('Y') }} LiveHouse237. Tous droits réservés.</span>
                </p>
                <p class="mt-2 text-xs flex items-center justify-center">
                    Fait avec <i class="fas fa-heart text-primary animate-pulse-soft mx-1"></i> au Cameroun
                </p>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script>
        // Mobile menu toggle
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
        
        // Auto-hide flash messages
        setTimeout(() => {
            const flashMessages = document.querySelectorAll('.flash-message');
            flashMessages.forEach(el => {
                el.style.transition = 'all 0.5s ease';
                el.style.transform = 'translateX(120%)';
                el.style.opacity = '0';
                setTimeout(() => el.parentElement.remove(), 500);
            });
        }, 5000);
        
        // Close mobile menu on link click
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenuBtn.classList.remove('burger-active');
                mobileMenu.classList.remove('active');
            });
        });
        
        // Parallax effect on scroll (subtle)
        let lastScroll = 0;
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.parallax');
            
            parallaxElements.forEach(el => {
                const speed = el.dataset.speed || 0.5;
                el.style.transform = `translateY(${currentScroll * speed}px)`;
            });
            
            lastScroll = currentScroll;
        });
    </script>
    
    @stack('scripts')
</body>
</html>