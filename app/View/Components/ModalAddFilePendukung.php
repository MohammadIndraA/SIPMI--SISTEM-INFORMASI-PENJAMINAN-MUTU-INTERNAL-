<?php

namespace App\View\Components;

use App\Models\KategoriDokumen;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalAddFilePendukung extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $kategori_dokumens = KategoriDokumen::all();
        return view('components.modal-add-file-pendukung', compact('kategori_dokumens'));
    }
}
