// Replace navbar avatar with actual user profile image
document.addEventListener('DOMContentLoaded', function() {
    replaceNavbarAvatar();
});

// Also run when Livewire updates the page
document.addEventListener('livewire:navigated', function() {
    replaceNavbarAvatar();
});

function replaceNavbarAvatar() {
    // Get the profile photo URL from the sidebar avatar
    const sidebarAvatar = document.querySelector('.sidebar-avatar img');
    
    if (sidebarAvatar && sidebarAvatar.src) {
        const imageUrl = sidebarAvatar.src;
        const userName = sidebarAvatar.alt || 'User';
        
        // Find the navbar user menu button (Filament's user menu trigger)
        const navbarAvatarButton = document.querySelector('[x-data*="userMenu"], button[aria-label*="User menu"], [aria-label*="user menu"]');
        
        if (!navbarAvatarButton) {
            // Try alternative selectors
            const alternativeButton = document.querySelector('button[type="button"] span[class*="avatar"], button[type="button"] > div > span[class*="inline-block"]');
            
            if (alternativeButton) {
                replaceAvatarContent(alternativeButton.closest('button'), imageUrl, userName);
            }
        } else {
            replaceAvatarContent(navbarAvatarButton, imageUrl, userName);
        }
    }
}

function replaceAvatarContent(button, imageUrl, userName) {
    if (!button) return;
    
    // Find the avatar span inside the button
    const avatarSpan = button.querySelector('span[class*="avatar"], span[class*="inline-block"], span[class*="rounded"], span[class*="h-9"], span[class*="w-9"]');
    
    if (avatarSpan) {
        // Check if image already exists
        if (!avatarSpan.querySelector('img')) {
            // Clear the text content (initials like "ZA")
            avatarSpan.textContent = '';
            
            // Create and add the image
            const img = document.createElement('img');
            img.src = imageUrl;
            img.alt = userName;
            img.className = 'h-full w-full object-cover rounded-full';
            
            avatarSpan.appendChild(img);
        }
    }
}
