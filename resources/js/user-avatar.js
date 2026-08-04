// Replace navbar avatar with actual user profile image when available.
// This is a fallback to supplement Filament's HasAvatar contract.

function replaceNavbarAvatar() {
    // Get profile image URL from the sidebar avatar (rendered server-side)
    const sidebarImg = document.querySelector('.sidebar-avatar img');
    if (!sidebarImg || !sidebarImg.src) return;

    const imageUrl = sidebarImg.src;
    const userName  = sidebarImg.alt || 'User';

    // Filament renders the navbar user menu button with specific structure.
    // Target the avatar element inside it — look for a span containing initials.
    const candidates = document.querySelectorAll(
        'header button span, header [role="button"] span, [data-dropdown-toggle] span'
    );

    candidates.forEach(function (span) {
        // Only target spans that contain text-only initials (e.g. "SJ") — no child elements
        if (span.children.length === 0 && span.textContent.trim().length >= 1 && span.textContent.trim().length <= 3) {
            // Skip if it already has an image injected
            if (span.querySelector('img')) return;

            // Inject the profile image
            span.textContent = '';
            span.style.overflow = 'hidden';

            const img = document.createElement('img');
            img.src    = imageUrl;
            img.alt    = userName;
            img.style.cssText = 'width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;';
            span.appendChild(img);
        }
    });

    // Also try Filament's fi-btn-icon-wrapper or avatar button
    const avatarWrappers = document.querySelectorAll(
        'button .fi-avatar, button [class*="avatar"], .fi-topbar button span[class*="h-"]'
    );
    avatarWrappers.forEach(function (el) {
        if (el.tagName === 'SPAN' && el.children.length === 0 && el.textContent.trim()) {
            el.textContent = '';
            el.style.overflow = 'hidden';
            const img = document.createElement('img');
            img.src  = imageUrl;
            img.alt  = userName;
            img.style.cssText = 'width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;';
            el.appendChild(img);
        }
    });
}

// Run on page load
document.addEventListener('DOMContentLoaded', function () {
    replaceNavbarAvatar();
    // Also try after a brief delay in case Livewire hasn't rendered yet
    setTimeout(replaceNavbarAvatar, 500);
});

// Run on Livewire navigation
document.addEventListener('livewire:navigated', function () {
    replaceNavbarAvatar();
    setTimeout(replaceNavbarAvatar, 300);
});

// Run on Livewire request finish (covers profile updates)
document.addEventListener('livewire:request', function () {
    setTimeout(replaceNavbarAvatar, 400);
});
