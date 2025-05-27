<div>
    @if(!empty($message))
        <div class="alert alert-{{ $type }}">
            <div class="alert-content">
                {{ $message }}
            </div>
        </div>
    @endif
</div> 