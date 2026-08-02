<div class="brand-logo-wrapper">
    <img src="{{ asset('logo.svg') }}" alt="Staff Portal" class="brand-logo-img">
</div>

<style>
    .brand-logo-wrapper {
        display: flex;
        align-items: center;
    }

    .brand-logo-img {
        height: 2.5rem;
        width: auto;
        object-fit: contain;
    }

    /* Collapsed sidebar - smaller logo */
    .fi-sidebar:not(.fi-sidebar-open) .brand-logo-img {
        height: 2rem;
    }
</style>
