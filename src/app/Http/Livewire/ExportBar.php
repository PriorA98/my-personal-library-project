<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Enums\ExportType;
use App\Services\ExportService;

class ExportBar extends Component
{
    public $showOptions = false;
    public $selectedType = null;
    public $loading = false;

    public function toggleOptions()
    {
        $this->showOptions = !$this->showOptions;
        $this->reset('selectedType', 'loading');
    }

    public function selectType($type)
    {
        if (!ExportType::isValid($type))
            return;

        $this->selectedType = $type;
    }

    public function export($format)
    {
        if (!in_array($format, ['csv', 'xml']))
            return;

        $this->loading = true;

        $path = app(ExportService::class)->generateSingle($this->selectedType, $format);

        $this->dispatchBrowserEvent('download-file', [
            'url' => route('exports.download', ['path' => $path]),
        ]);

        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.export-bar');
    }
}
