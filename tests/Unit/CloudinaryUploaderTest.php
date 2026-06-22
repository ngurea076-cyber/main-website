<?php

namespace Tests\Unit;

use App\Services\CloudinaryUploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Tests\TestCase;

class CloudinaryUploaderTest extends TestCase
{
    public function test_it_uploads_an_image_to_the_configured_cloudinary_account(): void
    {
        config()->set('services.cloudinary', [
            'cloud_name' => 'demo-cloud',
            'api_key' => 'demo-key',
            'api_secret' => 'demo-secret',
        ]);

        Http::fake([
            'api.cloudinary.com/*' => Http::response([
                'secure_url' => 'https://res.cloudinary.com/demo-cloud/image/upload/v1/shop-ict/products/example.jpg',
            ]),
        ]);

        $image = UploadedFile::fake()->create('example.jpg', 20, 'image/jpeg');
        $url = app(CloudinaryUploader::class)->upload($image);

        $this->assertSame(
            'https://res.cloudinary.com/demo-cloud/image/upload/v1/shop-ict/products/example.jpg',
            $url,
        );

        Http::assertSent(fn ($request) => $request->url() === 'https://api.cloudinary.com/v1_1/demo-cloud/image/upload');
    }

    public function test_it_refuses_to_upload_without_credentials(): void
    {
        config()->set('services.cloudinary', [
            'cloud_name' => null,
            'api_key' => null,
            'api_secret' => null,
        ]);

        $this->expectException(RuntimeException::class);

        app(CloudinaryUploader::class)->upload(
            UploadedFile::fake()->create('example.jpg', 20, 'image/jpeg'),
        );
    }
}
