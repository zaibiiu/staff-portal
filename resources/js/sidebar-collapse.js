/**
 * Sidebar Collapse Handler for Filament v3
 *
 * Filament v3 uses CSS variables --sidebar-width / --collapsed-sidebar-width
 * set on <html> or the sidebar itself, and toggles `.fi-sidebar-open` on
 * the <aside> element.
 *
 * Collapsed = `.fi-sidebar-open` is ABSENT on desktop.
 * Expanded  = `.fi-sidebar-open` IS present.
 *
 * We do NOT force inline widths — we let Filament's own CSS vars do the work.
 * We only watch for state changes and update a helper class for our CSS overrides.
 */
(function () {
    'use strict';

    function init() {
        const sidebar = document.querySelector('aside.fi-sidebar');
        if (!sidebar) return;

        /**
         * Sync our helper class with Filament's current state.
         * We add `fi-sidebar-collapsed` when open class is absent,
         * so our CSS in sidebar-collapse.css can target it.
         */
        function syncState() {
            const isOpen = sidebar.classList.contains('fi-sidebar-open');
            if (isOpen) {
                sidebar.classList.remove('fi-sidebar-collapsed');
            } else {
                sidebar.classList.add('fi-sidebar-collapsed');
            }
        }

        // Watch class-list changes on the sidebar (Filament toggles fi-sidebar-open)
        const observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    syncState();
                }
            });
        });

        observer.observe(sidebar, {
            attributes: true,
            attributeFilter: ['class'],
        });

        // Initial sync
        syncState();
    }

    // Run after DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Also re-init on Livewire page navigations (Filament uses Livewire navigate)
    document.addEventListener('livewire:navigated', init);
})();
