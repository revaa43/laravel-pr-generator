{{-- resources/views/components/layouts/scripts.blade.php --}}
<script>
    (function () {
        // ─── Element References ────────────────────────────────────────────
        const sidebar        = document.getElementById('sidebar');
        const mainContent    = document.getElementById('mainContent');
        const mobileOverlay  = document.getElementById('mobileOverlay');
        const mobileMenuBtn  = document.getElementById('mobileMenuBtn');
        const toggleCollapse = document.getElementById('toggleCollapse');
        const userMenuBtn    = document.getElementById('userMenuBtn');
        const userDropdown   = document.getElementById('userDropdown');
        const brandContent   = document.getElementById('brandContent');
        const logoImg        = document.getElementById('logoImg');
        const navTexts       = document.querySelectorAll('.nav-text');
        const navBadges      = document.querySelectorAll('.nav-badge');
        const navLinks       = document.querySelectorAll('.nav-link');
        const collapseIcon   = toggleCollapse ? toggleCollapse.querySelector('svg') : null;

        // ─── State ────────────────────────────────────────────────────────
        let isCollapsed  = localStorage.getItem('sidebarCollapsed') === 'true';
        let isMobileOpen = false;

        // ─── Tooltip Setup ────────────────────────────────────────────────
        // Create a single floating tooltip element
        const tooltip = document.createElement('div');
        tooltip.id = 'sidebarTooltip';
        tooltip.style.cssText = `
            position: fixed;
            left: 0;
            top: 0;
            background: #1e293b;
            color: #f8fafc;
            font-size: 12px;
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 6px;
            pointer-events: none;
            z-index: 9999;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.15s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        `;
        document.body.appendChild(tooltip);

        function attachTooltips() {
            navLinks.forEach(link => {
                const textEl = link.querySelector('.nav-text');
                if (!textEl) return;
                const label = textEl.textContent.trim();

                link.addEventListener('mouseenter', (e) => {
                    if (!isCollapsed) return;
                    const rect = link.getBoundingClientRect();
                    tooltip.textContent = label;
                    tooltip.style.left  = (rect.right + 10) + 'px';
                    tooltip.style.top   = (rect.top + rect.height / 2 - 14) + 'px';
                    tooltip.style.opacity = '1';
                });

                link.addEventListener('mouseleave', () => {
                    tooltip.style.opacity = '0';
                });
            });
        }

        // ─── Collapse / Expand ────────────────────────────────────────────
        function collapseSidebar(save = true) {
            sidebar.classList.add('w-20', 'sidebar-collapsed');
            sidebar.classList.remove('w-64');

            mainContent.classList.add('lg:ml-20');
            mainContent.classList.remove('lg:ml-64');

            // Hide brand text, keep logo visible but smaller
            if (brandContent) brandContent.classList.add('hidden');

            if (logoImg) {
                logoImg.classList.add('logo-collapsed');
                logoImg.classList.remove('logo-expanded');
            }

            // Rotate collapse button icon to point right
            if (collapseIcon) {
                collapseIcon.style.transform = 'rotate(180deg)';
            }

            if (save) {
                localStorage.setItem('sidebarCollapsed', 'true');
                isCollapsed = true;
            }

            // Hide tooltip when sidebar expands
            tooltip.style.opacity = '0';
        }

        function expandSidebar(save = true) {
            sidebar.classList.remove('w-20', 'sidebar-collapsed');
            sidebar.classList.add('w-64');

            mainContent.classList.remove('lg:ml-20');
            mainContent.classList.add('lg:ml-64');

            if (brandContent) brandContent.classList.remove('hidden');

            if (logoImg) {
                logoImg.classList.remove('logo-collapsed');
                logoImg.classList.add('logo-expanded');
            }

            // Reset collapse button icon direction
            if (collapseIcon) {
                collapseIcon.style.transform = 'rotate(0deg)';
            }

            // Hide tooltip when sidebar expands
            tooltip.style.opacity = '0';

            if (save) {
                localStorage.setItem('sidebarCollapsed', 'false');
                isCollapsed = false;
            }
        }

        // ─── Mobile ───────────────────────────────────────────────────────
        function openMobileSidebar() {
            sidebar.classList.remove('-translate-x-full');
            mobileOverlay.classList.remove('hidden');
            isMobileOpen = true;
        }

        function closeMobileSidebar() {
            sidebar.classList.add('-translate-x-full');
            mobileOverlay.classList.add('hidden');
            isMobileOpen = false;
        }

        // ─── Initialization ───────────────────────────────────────────────
        function initializeSidebarState() {
            if (window.innerWidth >= 1024) {
                // Desktop
                if (isCollapsed) {
                    collapseSidebar(false);
                } else {
                    expandSidebar(false);
                }
            } else {
                // Mobile — always start hidden
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('w-20', 'sidebar-collapsed');
                sidebar.classList.add('w-64');
            }
        }

        // ─── Event Listeners ──────────────────────────────────────────────

        // Desktop collapse toggle
        toggleCollapse?.addEventListener('click', () => {
            if (isCollapsed) {
                expandSidebar();
            } else {
                collapseSidebar();
            }
        });

        // Mobile menu open
        mobileMenuBtn?.addEventListener('click', () => {
            if (isMobileOpen) {
                closeMobileSidebar();
            } else {
                openMobileSidebar();
            }
        });

        // Close mobile via overlay
        mobileOverlay?.addEventListener('click', () => {
            closeMobileSidebar();
        });

        // Close mobile on resize to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                closeMobileSidebar();
                // Re-apply desktop collapsed state
                if (isCollapsed) {
                    collapseSidebar(false);
                } else {
                    expandSidebar(false);
                }
            } else {
                // On mobile, always restore full-width sidebar (collapsed state irrelevant)
                sidebar.classList.remove('w-20', 'sidebar-collapsed');
                sidebar.classList.add('w-64');
                if (!isMobileOpen) {
                    sidebar.classList.add('-translate-x-full');
                }
            }
        });

        // User dropdown
        userMenuBtn?.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdown?.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!userMenuBtn?.contains(e.target) && !userDropdown?.contains(e.target)) {
                userDropdown?.classList.add('hidden');
            }
        });

        // Close mobile sidebar when a nav link is clicked (SPA-like UX)
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (isMobileOpen) {
                    closeMobileSidebar();
                }
            });
        });

        // ─── Run ──────────────────────────────────────────────────────────
        initializeSidebarState();
        attachTooltips();

        // Also re-init after Livewire navigates (for SPAs using Livewire navigate)
        document.addEventListener('livewire:navigated', () => {
            initializeSidebarState();
        });
    })();
</script>