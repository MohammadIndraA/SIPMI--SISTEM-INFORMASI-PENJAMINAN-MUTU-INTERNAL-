<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

if(! function_exists('upload')) {
    function uploadDokumen($directory, $file, $filename= "") 
    {
        $extensi = $file->getClientOriginalExtension();
        $filename = "{$filename}_" . date('Ymdhis'). ".{$extensi}";

        Storage::disk('public')->putFileAs("/$directory",$file,$filename);
        return "/$directory/$filename";
    }
}
if(! function_exists('uploadGD')) {
   function uploadDokumenGoogleDrive($directory, $file, $filename = "")
{
    $extensi = $file->getClientOriginalExtension();
    $filename = "{$filename}_" . date('YmdHis') . ".{$extensi}";

    $pathInDrive = "{$directory}/{$filename}";
  Storage::disk('google')->put($filename, File::get($file->getRealPath()));
    return $pathInDrive;
}

}

 function generateAddButton($id, $title = 'Tambah Standar', $type='daftar-standar', $class = 'btn-warning', $icon = 'uil-comment-plus')
{
    return '
    <button onclick="addStandar(\'' . $id . '\', \'' . $type . '\')" class="btn ' . $class . ' btn-flat btn-sm" title="' . $title . '">
        <i class="' . $icon . '"></i>
    </button>';
}
 function generateEditButton($id, $title = 'Edit Standar', $type='daftar-standar', $class = 'btn-primary', $icon = 'uil-comment-plus')
{
    return '
    <button onclick="editStandar(\'' . $id . '\', \'' . $type . '\')" class="btn ' . $class . ' btn-flat btn-sm" title="' . $title . '">
        <i class="' . $icon . '"></i>
    </button>';
}
 function deleteButton($id, $title = 'Delete', $type='hapus-standar' ,$class = 'btn-danger', $icon = 'dripicons-trash')
{
    return '
    <button onclick="deleteFunc(\'' . $id . '\', \''. $type . '\' )" class="btn ' . $class . ' btn-flat btn-sm" title="' . $title . '">
        <i class="' . $icon . '"></i>
    </button>';
}
