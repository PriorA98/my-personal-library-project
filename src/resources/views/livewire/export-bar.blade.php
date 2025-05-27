<div class="export-bar">

    <!-- Export Toggle -->
    <button wire:click="toggleOptions" class="btn-black full-width">Export</button>

    @if ($showOptions)
        <!-- Export Type Selection -->
        <div class="export-types">
            <button wire:click="selectType('titles')"
                class="btn-toggle {{ $selectedType === 'titles' ? 'active' : '' }}">Titles</button>
            <button wire:click="selectType('titles_authors')"
                class="btn-toggle {{ $selectedType === 'titles_authors' ? 'active' : '' }}">Titles + Authors</button>
            <button wire:click="selectType('authors')"
                class="btn-toggle {{ $selectedType === 'authors' ? 'active' : '' }}">Authors</button>
        </div>

        @if ($selectedType)
            <!-- Format Preview Buttons -->
            <div class="export-preview-buttons">
                <button wire:click="preview('csv')"
                    class="btn-toggle {{ $previewFormat === 'csv' ? 'active' : '' }}">Preview CSV</button>
                <button wire:click="preview('xml')"
                    class="btn-toggle {{ $previewFormat === 'xml' ? 'active' : '' }}">Preview XML</button>
            </div>
        @endif
    @endif

    @if ($loading)
        <div class="export-loading">Generating preview...</div>
    @endif

    @if ($previewContent)
        <div class="preview-section">
            <p class="preview-label">Preview ({{ strtoupper($previewFormat) }})</p>
            <textarea readonly class="preview-content">{{ $previewContent }}</textarea>

            <div class="export-actions">
                <button wire:click="confirmDownload" class="btn-black">Download</button>
                <button wire:click="cancelPreview" class="btn-black">Cancel</button>
            </div>
        </div>
    @endif
</div>

<script>
    window.addEventListener('download-file', event => {
        window.open(event.detail.url, '_blank');
    });
</script>
