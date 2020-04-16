<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    public function uploadAvatar(UploadedFile $image, $title='')
    {
        $image_name = ($title ? $title . '_' : '') . time() . '.' . $image->extension();
        $file = $image->storeAs('avatars', $image_name, 'public');
        return $image_name;
    }
}