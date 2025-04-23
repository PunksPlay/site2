<?php
// footer.php — закрывает <main>, выводит футер и <script>, закрывает </body></html>
?>
</main>
<footer class="bg-[#141414] text-neutral-500 text-center py-4 mt-auto border-t border-neutral-800">
    <img class="h-7 inline-flex mr-3" src="/assets/uploads/_ico_18.svg" alt="18+">
    &copy; <?= date('Y') ?> CYBER RIFT PROJECT. Использование любых материалов сайта без согласования с администрацией запрещено.
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        document.querySelectorAll('.submenu-button').forEach(button => {
            button.addEventListener('click', () => {
                button.nextElementSibling.classList.toggle('hidden');
            });
        });
    });
</script>
</body>
</html>
