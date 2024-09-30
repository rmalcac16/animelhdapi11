<?php

namespace App\Livewire\External\Voe;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class MoveFiles extends Component
{
    public $folderId = 0;
    public $destinationFolderId;
    public $files = [];
    public $selectedFiles = [];
    public $selectAll = false;

    public $sortField = 'name';
    public $sortDirection = 'asc'; 


    private $apiKey = 'mknVw7z3Xggw6i23Sye2Y1HbsmoykKhusAtri3PU34CPKsEKtE0boHZFuvIwTcfN';

    public function mount()
    {
        
    }

    public function updatingSelectAll($value)
    {
        if ($value) {
            $this->selectedFiles = collect($this->files)->pluck('file_code')->toArray();
        } else {
            $this->selectedFiles = [];
        }
    }

    public function updatedSelectedFiles()
    {
        $this->selectAll = count($this->selectedFiles) === count($this->files);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->getFiles();
    }

    public function getFiles()
    {
        $response = Http::get('https://voe.sx/api/folder/list', [
            'key' => $this->apiKey,
            'fld_id' => $this->folderId,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['result']['files']['data'])) {
                $this->files = $data['result']['files']['data'];

                $this->files = collect($this->files)->sortBy(function ($file) {
                    return strtolower($file[$this->sortField] ?? '');
                }, SORT_REGULAR, $this->sortDirection === 'desc')->values()->toArray();

                $this->selectedFiles = [];
                $this->selectAll = false;
            } else {
                $this->files = [];
                session()->flash('message', 'No se encontraron archivos en esta carpeta.');
            }
        } else {
            $this->files = [];
            session()->flash('message', 'No se pudo obtener la lista de archivos de la API.');
        }
    }

    public function updatedFolderId()
    {
        $this->getFiles();
    }

    public function moveSelectedFiles()
    {

        if (empty($this->selectedFiles)) {
            session()->flash('message', 'No ha seleccionado ningún archivo para mover.');
            return;
        }

        if (!$this->destinationFolderId) {
            session()->flash('message', 'Por favor, ingrese el ID de la carpeta de destino.');
            return;
        }

        $successCount = 0;
        $failureCount = 0;

        foreach ($this->selectedFiles as $fileCode) {
            $response = Http::get('https://voe.sx/api/file/set_folder', [
                'key' => $this->apiKey,
                'file_code' => $fileCode,
                'fld_id' => $this->destinationFolderId,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if ($data['success']) {
                    $successCount++;
                } else {
                    $failureCount++;
                }
            } else {
                $failureCount++;
            }
        }

        $message = "Archivos movidos exitosamente: $successCount. Fallidos: $failureCount.";
        session()->flash('message', $message);

        $this->getFiles();

        $this->selectedFiles = [];
        $this->selectAll = false;
    }

    public function render()
    {
        return view('livewire.external.voe.move-files');
    }
}