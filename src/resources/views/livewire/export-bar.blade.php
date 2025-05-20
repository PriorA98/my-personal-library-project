<div>
    <button wire:click="toggleOptions">📤 Export</button>

    @if ($showOptions)
        <div style="margin-top: 10px;">
            <button wire:click="selectType('titles_authors')"
                class="{{ $selectedType === 'titles_authors' ? 'active' : '' }}">📚 Titles + Authors</button>
            <button wire:click="selectType('titles')" class="{{ $selectedType === 'titles' ? 'active' : '' }}">📕 Titles
                only</button>
            <button wire:click="selectType('authors')" class="{{ $selectedType === 'authors' ? 'active' : '' }}">👤
                Authors only</button>
        </div>

        @if ($selectedType)
            <div style="margin-top: 10px;">
                <button wire:click="preview('csv')">⬇️ Preview CSV</button>
                <button wire:click="preview('xml')">⬇️ Preview XML</button>
            </div>
        @endif
    @endif

    @if ($loading)
        <div style="margin-top: 10px;">⏳ Generating preview...</div>
    @endif

    @if ($previewContent)
        <div class="preview-modal">
            <h3>Preview ({{ strtoupper($previewFormat) }})</h3>
            <pre>{{ $previewContent }}</pre>
            <button wire:click="confirmDownload">✅ Confirm & Download</button>
            <button wire:click="cancelPreview">❌ Cancel</button>
        </div>
    @endif
</div>

<script>
    window.addEventListener('download-file', event => {
        window.open(event.detail.url, '_blank');
    });
</script>