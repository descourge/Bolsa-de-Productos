<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PdfWatermarkService
{
    public function process(
        string $pdfPath,
        string $imagePath
    )
    {
        return Http::timeout(60)
            ->attach(
                'pdf_file',
                fopen($pdfPath, 'r'),
                'document.pdf',
                [
                    'Content-Type' => 'application/pdf'
                ]
            )
            ->attach(
                'watermark_image',
                fopen($imagePath, 'r'),
                'watermark.png',
                [
                    'Content-Type' => 'image/png'
                ]
            )
            ->post(
                config('services.python.url') . '/watermark'
            );
    }
}