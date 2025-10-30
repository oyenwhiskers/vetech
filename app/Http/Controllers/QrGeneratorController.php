<?php

namespace App\Http\Controllers;

use BaconQrCode\Renderer\GDLibRenderer;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class QrGeneratorController extends Controller
{
    /**
     * Generate a QR code as PNG data using GDLibRenderer.
     *
     * @param string $data The data to encode
     * @param int $size The image size in pixels
     * @return string PNG image binary
     */
    public static function generateQrCode($data, $size = 400)
    {
        $renderer = new GDLibRenderer($size);
        $writer = new Writer($renderer);
        return $writer->writeString($data);
    }

    /**
     * Generate QR code, save as PNG to public storage, and return a public URL.
     *
     * @param string $data      The string to encode
     * @param int $size         Size in pixels
     * @param string|null $filename  Optional filename (auto if null)
     * @return string           Public URL to the QR code image
     */
    public static function generateQrCodeAndSave($data, $size = 400, $filename = null)
    {
        $folder = 'qrcodes';
        $filename = $filename ?: (md5($data.'_'.$size).'.png');
        $path = "$folder/$filename";

        $renderer = new GDLibRenderer($size);
        $writer = new Writer($renderer);
        // Write to a string, then store (do not write directly to disk for storage portability)
        $imageData = $writer->writeString($data);
        Storage::disk('public')->put($path, $imageData);
        return "storage/$path";
    }

    /**
     * Generate and return a QR code as PNG over HTTP.
     * @param  Request  $request
     * @return Response
     */
    public function generate(Request $request)
    {
        $data = $request->input('data', 'Hello, QR!');
        $size = $request->input('size', 400);
        $qrPng = self::generateQrCode($data, $size);

        return response($qrPng, 200)
            ->header('Content-Type', 'image/png');
    }
}
