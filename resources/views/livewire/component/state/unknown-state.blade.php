<div class="empty-state">
    <div class="empty-state-icon">
        <i class="fas fa-question"></i>
    </div>
    <h2>{{ $title }}</h2>
    <p class="lead">
        {{ $subtitle }}
    </p>

    @if (isset($primary_button_dest) && isset($primary_button_text))
        <a href="{{ $primary_button_dest }}" class="btn btn-primary mt-4">{{ $primary_button_text }}</a>
    @endif
</div>
