<div>
    <button wire:click="toggleOptions">📤 Export</button>

    @if ($showOptions)
        <div style="margin-top: 10px;">
            <button class="{{ $selectedType === 'titles_authors' ? 'active' : '' }}"
                wire:click="selectType('titles_authors')">📚 Titles + Authors</button>
            <button class="{{ $selectedType === 'titles' ? 'active' : '' }}" wire:click="selectType('titles')">📕 Titles
                only</button>
            <button class="{{ $selectedType === 'authors' ? 'active' : '' }}" wire:click="selectType('authors')">👤
                Authors only</button>
        </div>

        @if ($selectedType)
            <div style="margin-top: 10px;">
                <button wire:click="export('csv')">⬇️ CSV</button>
                <button wire:click="export('xml')">⬇️ XML</button>
            </div>
        @endif
    @endif

    @if ($loading)
        <div style="margin-top: 10px;">⏳ Generating export file...</div>
    @endif
</div>

<script>
    window.addEventListener('download-file', event => {
        window.open(event.detail.url, '_blank');
    });
</script>

<style>
    .active {
        background-color: #3490dc;
        color: white;
    }
</style>
