<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle : 'Taslimiyah Bakery'; ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        kombu: '#354024', // Kombu Green dari palet pilihan
                        bone: '#E5D7C4',  // Bone dari palet pilihan
                        brand: {
                            900: '#152e22',
                            800: '#1b4332',
                            700: '#2d6a4f',
                            100: '#e8f5e9',
                            50: '#f4f9f5',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- CSS Efek iOS Pop-Up & Glow -->
    <style>
        /* Button Kuning Solid iOS Style */
        .btn-ios-primary {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            box-shadow: 0 4px 20px -2px rgba(245, 158, 11, 0.45), inset 0 1px 1px rgba(255, 255, 255, 0.6);
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .btn-ios-primary:hover {
            transform: translateY(-4px) scale(1.03);
            box-shadow: 0 12px 28px -2px rgba(245, 158, 11, 0.65), inset 0 1px 2px rgba(255, 255, 255, 0.8);
        }
        .btn-ios-primary:active {
            transform: translateY(0) scale(0.97);
        }

        /* Button Transparan Glassmorphism iOS Style */
        .btn-ios-glass {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px -3px rgba(0, 0, 0, 0.2), inset 0 1px 1px rgba(255, 255, 255, 0.15);
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .btn-ios-glass:hover {
            background: rgba(255, 255, 255, 0.16);
            border-color: rgba(251, 191, 36, 0.5);
            transform: translateY(-4px) scale(1.03);
            box-shadow: 0 12px 28px -3px rgba(0, 0, 0, 0.3), inset 0 1px 2px rgba(255, 255, 255, 0.3);
        }
        .btn-ios-glass:active {
            transform: translateY(0) scale(0.97);
        }

        /* Card Transparan iOS Style */
        .ios-card-glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .ios-card-glass:hover {
            transform: translateY(-3px) scale(1.02);
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(229, 215, 196, 0.4);
            box-shadow: 0 12px 40px 0 rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="bg-[#242b18] min-h-screen flex flex-col font-sans text-slate-100 antialiased">

<!-- Header Transparan Halus -->
<header class="bg-[#354024]/60 backdrop-blur-md border-b border-white/10 sticky top-0 z-50 transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 relative">
            
            <!-- Logo & Nama Brand (Fix Jalur Logo) -->
            <a href="/index.php" class="flex items-center space-x-3 group">
                <img src="assets/images/TASBEK.jpg" 
                     onerror="this.onerror=null; this.src='../assets/images/TASBEK.jpg';" 
                     alt="Taslimiyah Bakery Logo" 
                     class="w-11 h-11 rounded-full object-cover border border-amber-400/30 shadow-md group-hover:scale-105 transition-transform duration-300">
                
                <span class="font-serif font-bold text-[#E5D7C4] text-xl tracking-tight group-hover:text-amber-300 transition-colors">
                    Taslimiyah Bakery
                </span>
            </a>

            <!-- Navigasi Utama Header Normal (Teks Biasa) -->
            <nav class="hidden md:flex items-center space-x-2 sm:space-x-4 ml-auto">
                <a href="/index.php" class="px-4 py-2 rounded-full text-sm font-semibold text-[#E5D7C4] bg-white/10 hover:bg-white/20 transition-all">Beranda</a>
                <a href="/produk/list.php" class="px-4 py-2 rounded-full text-sm font-medium text-[#E5D7C4]/80 hover:text-[#E5D7C4] hover:bg-white/10 transition-all">Produk</a>
                <a href="/pelanggan/list.php" class="px-4 py-2 rounded-full text-sm font-medium text-[#E5D7C4]/80 hover:text-[#E5D7C4] hover:bg-white/10 transition-all">Pelanggan</a>
            </nav>

            <!-- Tombol Hamburger Mobile -->
            <button id="mobile-menu-btn" class="md:hidden p-2.5 rounded-xl bg-white/10 text-[#E5D7C4] focus:outline-none transition-all ml-auto border border-white/10">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>

            <!-- Pop-Up Menu Mobile Normal -->
            <div id="mobile-menu" class="hidden md:hidden absolute right-0 top-16 w-48 bg-[#354024]/95 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl p-2 z-50">
                <div class="flex flex-col space-y-1">
                    <a href="/index.php" class="px-3.5 py-2 rounded-xl text-sm font-medium text-[#E5D7C4] hover:bg-white/10 transition-colors">Beranda</a>
                    <a href="/produk/list.php" class="px-3.5 py-2 rounded-xl text-sm font-medium text-[#E5D7C4]/80 hover:bg-white/10 transition-colors">Produk</a>
                    <a href="/pelanggan/list.php" class="px-3.5 py-2 rounded-xl text-sm font-medium text-[#E5D7C4]/80 hover:bg-white/10 transition-colors">Pelanggan</a>
                </div>
            </div>

        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.lucide) {
            lucide.createIcons();
        }

        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                mobileMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', function(e) {
                if (!mobileMenu.contains(e.target) && !menuBtn.contains(e.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });
        }
    });
</script>