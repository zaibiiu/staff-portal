/**
 * Sidebar Collapse Handler for Filament v5
 * AGGRESSIVE approach - Forces proper width changes
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('🔧 Sidebar collapse script loaded');
    
    // Find the sidebar element - try multiple selectors
    const sidebar = document.querySelector('aside.fi-sidebar') || 
                   document.querySelector('aside[class*="sidebar"]') || 
                   document.querySelector('nav.fi-sidebar') ||
                   document.querySelector('[data-sidebar]');
    
    if (!sidebar) {
        console.warn('❌ Sidebar element not found');
        return;
    }

    console.log('✅ Sidebar found:', sidebar);

    // Function to force width
    function forceWidth(width) {
        sidebar.style.setProperty('width', width, 'important');
        sidebar.style.setProperty('min-width', width, 'important');
        sidebar.style.setProperty('max-width', width, 'important');
        sidebar.style.setProperty('flex-basis', width, 'important');
        console.log(`🔄 Forced width to: ${width}`);
    }

    // Function to check if sidebar should be collapsed
    function isCollapsed() {
        const style = sidebar.getAttribute('style') || '';
        const dataCollapsed = sidebar.getAttribute('data-collapsed');
        const ariaExpanded = sidebar.getAttribute('aria-expanded');
        const hasCollapsedClass = sidebar.classList.contains('collapsed') || 
                                 sidebar.classList.contains('fi-sidebar-collapsed');
        
        // Check if style contains small width values
        const hasSmallWidth = style.includes('4.') || 
                             style.includes('5.') || 
                             style.includes('72') || 
                             style.includes('80') ||
                             style.includes('4rem') ||
                             style.includes('5rem');
        
        return dataCollapsed === 'true' || 
               ariaExpanded === 'false' || 
               hasCollapsedClass ||
               hasSmallWidth;
    }

    // Function to apply state
    function applyState() {
        const collapsed = isCollapsed();
        
        if (collapsed) {
            forceWidth('4.5rem');
            sidebar.classList.add('fi-sidebar-collapsed');
        } else {
            forceWidth('17rem');
            sidebar.classList.remove('fi-sidebar-collapsed');
        }
    }

    // MutationObserver - watch EVERYTHING
    const observer = new MutationObserver(function(mutations) {
        console.log('👀 Mutation detected');
        applyState();
    });

    // Observe ALL changes
    observer.observe(sidebar, {
        attributes: true,
        attributeOldValue: true,
        childList: false,
        subtree: false
    });

    // Watch for ANY click on page
    document.addEventListener('click', function(e) {
        console.log('🖱️ Click detected');
        setTimeout(applyState, 50);
        setTimeout(applyState, 150);
        setTimeout(applyState, 300);
    }, true);

    // Aggressive interval check every 250ms
    setInterval(applyState, 250);

    // Initial state
    setTimeout(applyState, 100);
    setTimeout(applyState, 500);
    setTimeout(applyState, 1000);

    console.log('✅ Sidebar collapse handler initialized');
});
