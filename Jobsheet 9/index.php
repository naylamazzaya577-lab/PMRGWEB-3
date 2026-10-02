<?php
$pageTitle = "Beranda - Taslimiyah Bakery";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle; ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- CSS Efek Glassmorphism Modern & Interactive Card -->
    <style>
        /* Glassmorphism di Banner Utama */
        .glass-btn {
            background: rgba(255, 255, 255, 0.15) !important;
            backdrop-filter: blur(12px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(12px) saturate(180%) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            color: #ffffff !important;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        }

        .glass-btn:hover {
            background: rgba(255, 255, 255, 0.28) !important;
            border-color: rgba(255, 255, 255, 0.6) !important;
            transform: translateY(-3px) scale(1.02) !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2) !important;
        }

        .glass-btn:active {
            transform: translateY(0) scale(0.97) !important;
        }

        /* Card Hover Premium */
        .card-premium {
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        }
        .card-premium:hover {
            transform: translateY(-4px) !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01) !important;
        }
    </style>
</head>
<body class="bg-[#faf8f5] min-h-screen flex flex-col font-sans text-slate-800 antialiased selection:bg-emerald-800 selection:text-white">

    <!-- HEADER / NAVIGASI CLEAN & ELEGAN -->
    <header class="bg-white/80 backdrop-blur-md border-b border-stone-200/60 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo & Brand Name -->
                <a href="index.php" class="flex items-center space-x-3 group">
                    <img src="assets/images/TASBEK.jpg" 
                         onerror="this.onerror=null; this.src='../assets/images/TASBEK.jpg';" 
                         alt="Taslimiyah Bakery Logo" 
                         class="w-10 h-10 rounded-full object-cover border border-amber-900/10 group-hover:scale-105 transition-transform shadow-sm">
                    
                    <span class="font-serif font-bold text-stone-900 text-xl tracking-tight">
                        Taslimiyah Bakery
                    </span>
                </a>

                <!-- Navigasi Menu Atas -->
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="index.php" class="px-4 py-2 rounded-full text-sm font-semibold text-emerald-900 bg-emerald-50 border border-emerald-100">Beranda</a>
                    <a href="produk/list.php" class="px-4 py-2 rounded-full text-sm font-medium text-stone-600 hover:text-stone-900 hover:bg-stone-100/70 transition-all">Produk</a>
                    <a href="pelanggan/list.php" class="px-4 py-2 rounded-full text-sm font-medium text-stone-600 hover:text-stone-900 hover:bg-stone-100/70 transition-all">Pelanggan</a>
                </nav>

                <!-- Tombol Mobile Menu -->
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-xl text-stone-600 hover:bg-stone-100 focus:outline-none">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>

            </div>
        </div>

        <!-- Menu Mobile -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-stone-100 bg-white px-4 pt-2 pb-4 space-y-1">
            <a href="index.php" class="block px-3 py-2 rounded-lg text-base font-semibold text-emerald-900 bg-emerald-50">Beranda</a>
            <a href="produk/list.php" class="block px-3 py-2 rounded-lg text-base font-medium text-stone-600 hover:bg-stone-50">Produk</a>
            <a href="pelanggan/list.php" class="block px-3 py-2 rounded-lg text-base font-medium text-stone-600 hover:bg-stone-50">Pelanggan</a>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- BANNER HERO ELEGAN (DEEP FOREST GREEN + AMBER ACCENTS) -->
        <section class="bg-gradient-to-br from-[#1b3c2d] via-[#143023] to-[#0d2218] text-white rounded-3xl p-8 sm:p-12 md:p-16 text-center relative overflow-hidden shadow-xl mb-10 border border-emerald-900/30">
            
            <!-- Soft Lighting Ornaments -->
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-amber-400/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-3xl mx-auto">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-widest text-amber-300 bg-amber-400/10 border border-amber-400/20 mb-4">
                    Artisan Bakery & Pastry
                </span>
                
                <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight mb-3 text-stone-50">
                    Taslimiyah Bakery
                </h1>
                
                <p class="text-stone-300 text-sm sm:text-base max-w-xl mx-auto mb-8 font-light leading-relaxed">
                    Sistem Manajemen & Keranjang Belanja Online.<br class="hidden sm:block">
                    Nikmati kelezatan roti berkualitas tinggi yang dibuat <span class="italic text-amber-200">fresh</span> setiap hari.
                </p>

                <!-- DUAL BUTTONS GLASSMORPHISM TRANSPARAN -->
                <div class="flex flex-wrap items-center justify-center gap-4">
                    
                    <a href="produk/list.php" class="glass-btn cursor-pointer inline-flex items-center space-x-2.5 px-6 py-3 rounded-2xl text-sm font-semibold shadow-sm">
                        <i data-lucide="shopping-bag" class="w-4 h-4 text-amber-300"></i>
                        <span>Daftar Produk</span>
                    </a>

                    <a href="pelanggan/list.php" class="glass-btn cursor-pointer inline-flex items-center space-x-2.5 px-6 py-3 rounded-2xl text-sm font-semibold shadow-sm">
                        <i data-lucide="award" class="w-4 h-4 text-amber-300"></i>
                        <span>Loyalty Member</span>
                    </a>

                </div>
            </div>
        </section>

        <!-- 4 KARTU STATISTIK (CLEAN, ELEGAN & BISA DIPENCET) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Card 1: Pricelist Roti -->
            <a href="produk/list.php" class="card-premium bg-white rounded-2xl p-6 border border-stone-200/70 shadow-sm flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold tracking-wider text-stone-400 uppercase">PRICELIST ROTI</span>
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-700 border border-amber-500/20 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                            <i data-lucide="tag" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <h3 class="font-serif font-bold text-2xl text-stone-900 mb-1">Mulai 5k</h3>
                </div>
                <p class="text-xs text-stone-500 mt-4">Terjangkau & higienis</p>
            </a>

            <!-- Card 2: Total Produk -->
            <a href="produk/list.php" class="card-premium bg-white rounded-2xl p-6 border border-stone-200/70 shadow-sm flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold tracking-wider text-stone-400 uppercase">TOTAL PRODUK</span>
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-700 border border-emerald-500/20 group-hover:bg-emerald-700 group-hover:text-white transition-colors">
                            <i data-lucide="package" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <h3 class="font-serif font-bold text-3xl text-stone-900 mb-1">6</h3>
                </div>
                <p class="text-xs text-stone-500 mt-4">Varian roti & kue siap diorder</p>
            </a>

            <!-- Card 3: Loyalty Member -->
            <a href="pelanggan/list.php" class="card-premium bg-white rounded-2xl p-6 border border-stone-200/70 shadow-sm flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold tracking-wider text-stone-400 uppercase">LOYALTY MEMBER</span>
                        <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-700 border border-blue-500/20 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <i data-lucide="users" class="w-5 h-4"></i>
                        </div>
                    </div>
                    <h3 class="font-serif font-bold text-3xl text-stone-900 mb-1">3</h3>
                </div>
                <p class="text-xs text-stone-500 mt-4">Pelanggan terdaftar aktif</p>
            </a>

            <!-- Card 4: Jam Toko -->
            <div class="card-premium bg-white rounded-2xl p-6 border border-stone-200/70 shadow-sm flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold tracking-wider text-stone-400 uppercase">JAM TOKO</span>
                        <div class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-700 border border-purple-500/20 group-hover:bg-purple-700 group-hover:text-white transition-colors">
                            <i data-lucide="clock" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <h3 class="font-serif font-bold text-xl text-stone-900 mb-1">07:00 – 21:00</h3>
                </div>
                <p class="text-xs text-stone-500 mt-4">Buka Setiap Hari</p>
            </div>

        </div>

    </main>

    <!-- FOOTER CLEAN -->
    <footer class="bg-white border-t border-stone-200/60 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-xs text-stone-400">&copy; <?= date('Y'); ?> Taslimiyah Bakery. All rights reserved.</p>
        </div>
    </footer>

    <!-- SCRIPT INITIALIZATION -->
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
            }
        });
    </script>
</body>
</html>