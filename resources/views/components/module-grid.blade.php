@props([
    'tiles' => [],
    'variant' => 'hub',
    'emptyTitle' => 'No modules assigned',
    'emptyMessage' => 'Your account does not have access to any items in this section.',
])

@if(count($tiles))
    <div class="row module-grid">
        @foreach($tiles as $tile)
            <div class="module-hub-item {{ $variant === 'launcher' ? 'col-lg-4 col-md-6' : 'col-xl-3 col-lg-4 col-md-6' }} mb-4"
                 data-hub-text="{{ strtolower(($tile['title'] ?? '').' '.($tile['description'] ?? '')) }}">
                <x-module-card :tile="$tile" :variant="$variant" />
            </div>
        @endforeach
    </div>
@else
    <div class="card module-empty">
        <div class="card-body text-center py-5">
            <i class="fas fa-th-large fa-2x text-muted mb-3"></i>
            <h4 class="mb-2">{{ $emptyTitle }}</h4>
            <p class="text-muted mb-0">{{ $emptyMessage }}</p>
        </div>
    </div>
@endif
