    <footer class="border-t border-slate-200 bg-white py-8 mt-auto text-center text-xs text-slate-500">
        &copy; 2026 Taslimiyah Bakery &mdash; by -nay
    </footer>

    <script>
        lucide.createIcons();

        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>
</body>
</html>
