@props([
    'tile' => [],
    'variant' => 'hub',
])

@php
    $title       = $tile['title'] ?? '';
    $description = $tile['description'] ?? '';
    $icon        = $tile['icon'] ?? 'fas fa-cube';
    $color       = $tile['color'] ?? 'bg-gradient-primary';
    $href        = $tile['href'] ?? '#';
    $cta         = $tile['cta'] ?? 'Open';
    $badge       = $tile['badge'] ?? null;
    $badgeId     = $tile['badge_id'] ?? null;
    $status      = $tile['status'] ?? null;
    $showBadge   = $badgeId || ($badge !== null && $badge !== '' && $badge !== 0 && $badge !== '0');
@endphp

<a href="{{ $href }}" class="module-link d-block h-100" title="{{ $title }}">
    <div class="card module-card h-100 {{ $variant === 'launcher' ? 'text-center' : '' }}">
        <div class="card-body {{ $variant === 'launcher' ? 'py-4' : 'd-flex flex-column' }}">
            <div class="d-flex align-items-start {{ $variant === 'launcher' ? 'flex-column align-items-center' : '' }}">
                <span class="module-icon {{ $color }} {{ $variant === 'hub' ? 'mr-3 flex-shrink-0' : '' }}">
                    <i class="{{ $icon }}"></i>
                </span>
                <div class="{{ $variant === 'hub' ? 'flex-grow-1 min-width-0' : 'w-100' }}">
                    <div class="d-flex align-items-center justify-content-{{ $variant === 'launcher' ? 'center' : 'between' }} mb-1">
                        <h5 class="module-title mb-0">{{ $title }}</h5>
                        @if($showBadge)
                            <span @if($badgeId) id="{{ $badgeId }}" @endif
                                  class="module-badge badge badge-warning ml-2 {{ empty($badge) ? 'd-none' : '' }}">
                                {{ $badge }}
                            </span>
                        @endif
                    </div>
                    @if($status)
                        <span class="badge badge-light border mb-2">{{ $status }}</span>
                    @endif
                    <p class="module-desc mb-2 mb-md-3">{{ $description }}</p>
                </div>
            </div>
            <span class="btn btn-sm {{ $color }} text-white mt-auto {{ $variant === 'launcher' ? '' : 'align-self-start' }}">
                {{ $cta }} <i class="fas fa-arrow-right ml-1"></i>
            </span>
        </div>
    </div>
</a>
