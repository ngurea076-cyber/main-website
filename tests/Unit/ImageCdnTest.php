<?php

namespace Tests\Unit;

use App\Support\ImageCdn;
use PHPUnit\Framework\TestCase;

class ImageCdnTest extends TestCase
{
    public function test_it_adds_cloudinary_delivery_transformations(): void
    {
        $url = ImageCdn::url(
            'https://res.cloudinary.com/demo/image/upload/v1/sample.jpg',
            ['width' => 520, 'height' => 520, 'mode' => 'fit', 'quality' => 'q_auto:eco'],
        );

        $this->assertSame(
            'https://res.cloudinary.com/demo/image/upload/f_auto,q_auto:eco,dpr_auto,c_fit,w_520,h_520/v1/sample.jpg',
            $url,
        );
    }

    public function test_it_leaves_non_cloudinary_images_unchanged(): void
    {
        $url = ImageCdn::url('/storage/products/example.jpg', ['width' => 520]);

        $this->assertSame('/storage/products/example.jpg', $url);
    }

    public function test_it_builds_a_responsive_cloudinary_srcset(): void
    {
        $image = ImageCdn::responsive('https://res.cloudinary.com/demo/image/upload/v1/sample.jpg', [
            'width' => 400,
            'height' => 200,
            'widths' => [200, 400],
            'mode' => 'fit',
        ]);

        $this->assertStringContainsString('w_200,h_100', $image['srcset']);
        $this->assertStringContainsString(' 400w', $image['srcset']);
        $this->assertSame(400, $image['width']);
        $this->assertSame(200, $image['height']);
    }
}
