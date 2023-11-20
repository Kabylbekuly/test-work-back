<?php

namespace App\Services\Ckeditor;


use App\Models\Nomenclature\ProductDimension;
use App\Models\Nomenclature\ProductFile;
use App\Services\CrudService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Storage;

class CkeditorService extends CrudService
{
    public function uploadFile(UploadedFile $file, $request)
    {
        $file = Storage::put('uploads', $file);
        $CKEditorFuncNum = $request->input('CKEditorFuncNum');
        @header('Content-type: text/html; charset=utf-8');
        $url = env('APP_URL_STORAGE') . '/' . $file;
        $msg = 'Image successfully uploaded';
        $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url','$msg')</script>";
        return $response;

        return [
            "uploaded" => 1,
            "fileName" => 'asdsas',
            'url' => env('APP_URL_STORAGE') . '/' . $file,
            'response' => $response,
        ];
    }
}
