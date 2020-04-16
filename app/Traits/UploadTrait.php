<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

trait UploadTrait
{
    public function uploadAvatar(UploadedFile $image, $title='')
    {
        $image_name = ($title ? $title . '_' : '') . time() . '.' . $image->extension();

        $image_resize = Image::make($image->getRealPath());
        $image_resize->resize(1000, 1000, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image_resize->save(storage_path('app/public/avatars/' . $image_name));

        return $image_name;
    }

    public function deleteAvatar($image_name)
    {
        if ($image_name == '') {
            return true;
        }
        return Storage::disk('public')->delete('avatars/' . $image_name);
    }
}