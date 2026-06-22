<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class CloudinaryUploader
{
    public function upload(UploadedFile $image, string $folder = 'shop-ict/products'): string
    {
        $cloudName = trim((string) config('services.cloudinary.cloud_name'));
        $apiKey = trim((string) config('services.cloudinary.api_key'));
        $apiSecret = trim((string) config('services.cloudinary.api_secret'));

        if ($cloudName === '' || $apiKey === '' || $apiSecret === '') {
            throw new RuntimeException('Cloudinary credentials are not configured.');
        }

        $timestamp = time();
        $signature = sha1("folder={$folder}&timestamp={$timestamp}{$apiSecret}");

        $response = Http::timeout(60)
            ->retry(2, 300)
            ->attach(
                'file',
                file_get_contents($image->getRealPath()),
                $image->getClientOriginalName(),
                ['Content-Type' => $image->getMimeType() ?: 'application/octet-stream'],
            )
            ->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                'api_key' => $apiKey,
                'timestamp' => $timestamp,
                'signature' => $signature,
                'folder' => $folder,
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Cloudinary rejected the image upload.');
        }

        $url = $response->json('secure_url');

        if (! is_string($url) || ! str_starts_with($url, 'https://res.cloudinary.com/')) {
            throw new RuntimeException('Cloudinary did not return a valid image URL.');
        }

        return $url;
    }
}
