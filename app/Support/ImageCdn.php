<?php

namespace App\Support;

class ImageCdn
{
    public static function isCloudinary(?string $src): bool
    {
        return (bool) preg_match('/^https:\/\/res\.cloudinary\.com\//i', trim((string) $src));
    }

    public static function url(?string $src, array $options = []): string
    {
        $value = trim((string) $src);

        if ($value === '' || ! self::isCloudinary($value)) {
            return $value;
        }

        $marker = '/upload/';
        $markerIndex = strpos($value, $marker);

        if ($markerIndex === false) {
            return $value;
        }

        $prefix = substr($value, 0, $markerIndex + strlen($marker));
        $suffix = substr($value, $markerIndex + strlen($marker));

        if (preg_match('/^(?:f_|q_|c_|w_|h_|dpr_)/', $suffix)) {
            return $value;
        }

        $transformations = array_filter([
            'f_auto',
            $options['quality'] ?? 'q_auto',
            'dpr_auto',
            ($options['mode'] ?? 'fill') === 'fit' ? 'c_fit' : 'c_fill',
            isset($options['width']) ? 'w_'.round((float) $options['width']) : null,
            isset($options['height']) ? 'h_'.round((float) $options['height']) : null,
        ]);

        return $prefix.implode(',', $transformations).'/'.$suffix;
    }

    public static function responsive(?string $src, array $options): array
    {
        $value = trim((string) $src);
        $widths = collect($options['widths'] ?? [])
            ->map(fn ($width) => max(1, (int) round((float) $width)))
            ->unique()
            ->sort()
            ->values();

        if ($value === '' || $widths->isEmpty()) {
            return [
                'src' => $value,
                'srcset' => null,
                'sizes' => $options['sizes'] ?? null,
                'width' => $options['width'] ?? null,
                'height' => $options['height'] ?? null,
            ];
        }

        $baseWidth = (int) ($options['width'] ?? $widths->last());
        $baseHeight = isset($options['height']) ? (int) $options['height'] : null;
        $mode = $options['mode'] ?? 'fill';
        $quality = $options['quality'] ?? 'q_auto';

        $srcset = null;

        if (self::isCloudinary($value)) {
            $srcset = $widths
                ->map(function (int $width) use ($value, $baseWidth, $baseHeight, $mode, $quality) {
                    $height = $baseHeight ? max(1, (int) round(($baseHeight * $width) / max(1, $baseWidth))) : null;

                    return self::url($value, [
                        'width' => $width,
                        'height' => $height,
                        'mode' => $mode,
                        'quality' => $quality,
                    ]).' '.$width.'w';
                })
                ->implode(', ');
        }

        $largestWidth = (int) $widths->last();
        $largestHeight = $baseHeight ? max(1, (int) round(($baseHeight * $largestWidth) / max(1, $baseWidth))) : null;

        return [
            'src' => self::url($value, [
                'width' => $largestWidth,
                'height' => $largestHeight,
                'mode' => $mode,
                'quality' => $quality,
            ]),
            'srcset' => $srcset,
            'sizes' => $options['sizes'] ?? null,
            'width' => $baseWidth,
            'height' => $baseHeight,
        ];
    }
}
