<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function show($image_key)
    {
        Log::info('image_key: ' . $image_key);

        $url = Storage::temporaryUrl(
            $image_key,
            now()->addMinutes(10),
            [
                'ResponseContentType' => 'application/octet-stream',
                'ResponseContentDisposition' => 'attachment; filename=' . $image_key,
            ]
        );

        Log::info('url: ' . $url);


        return redirect($url);
    }
}
