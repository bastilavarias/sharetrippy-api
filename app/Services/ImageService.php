<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageService
{
    public static function uploadImage($image, $location)
    {
        $clientOriginalName = $image->getClientOriginalName();
        $formattedFileName = substr(
            $clientOriginalName,
            0,
            strrpos($clientOriginalName, '.')
        );
        $extension = $image->getClientOriginalExtension();
        $timestamp = time();
        $publicImageName = ImageService::toPublicImageName(
            $formattedFileName,
            $extension,
            $timestamp
        );
        $image->storeAs("public/{$location}", $publicImageName);

        return [
            'name' => $formattedFileName . '_' . $timestamp,
            'extension' => $extension,
            'location' => $location,
        ];
    }

    public static function deleteImage($image)
    {
        $location = $image['location'];
        $name = "{$image['name']}.{$image['extension']}";
        Storage::disk('public')->delete("{$location}/{$name}");
    }

    private static function toPublicImageName(
        $clientOriginalName,
        $extension,
        $timestamp
    ): string {
        $filename = pathinfo($clientOriginalName, PATHINFO_FILENAME);

        return $filename . '_' . $timestamp . '.' . $extension;
    }
}
