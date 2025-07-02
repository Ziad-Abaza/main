<?php

namespace App\Traits;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

trait QrCodeGenerator
{
    /**
     * Generate a QR code for the given ID
     *
     * @param string $id
     * @param int $size
     * @param string $format
     * @param string $errorCorrection
     * @return string
     */
    public function generateQrCode($id = null, $size = 200, $format = 'png', $errorCorrection = 'H')
    {
        $id = $id ?? $this->id;

        if (empty($id)) {
            throw new \InvalidArgumentException('ID is required to generate QR code');
        }

        $renderer = new ImageRenderer(
            new RendererStyle($size, 4),  // Add margin of 4 modules
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($id);

        // SVG is already a text format, no need for base64
        return 'data:image/svg+xml;charset=utf-8,' . rawurlencode($qrCode);
    }

    /**
     * Generate a QR code HTML img tag
     *
     * @param string $id
     * @param int $size
     * @param array $attributes
     * @param string|null $name
     * @param string $format
     * @param string $errorCorrection
     * @return string
     */
    public function qrCodeImg($id = null, $size = 200, $attributes = [], $name = null, $format = 'png', $errorCorrection = 'H')
    {
        try {
            $src = $this->generateQrCode($id, $size, $format, $errorCorrection);

            $attributeString = '';
            foreach ($attributes as $key => $value) {
                $attributeString .= " {$key}=\"{$value}\"";
            }

            $nameHtml = '';
            if ($name || (isset($this->user) && $this->user)) {
                $displayName = $name ?? ($this->user ? $this->user->name : null);
                if ($displayName) {
                    $nameHtml = "<div class=\"text-center mb-2\"><strong>{$displayName}</strong></div>";
                }
            }

            return "{$nameHtml}<img src=\"{$src}\" width=\"{$size}\" height=\"{$size}\"{$attributeString}>";
        } catch (\Exception $e) {
            return "<div class=\"alert alert-danger\">Error generating QR code: {$e->getMessage()}</div>";
        }
    }

    /**
     * Generate a downloadable QR code image
     *
     * @param string $id
     * @param int $size
     * @param string $format
     * @param string $errorCorrection
     * @return \Illuminate\Http\Response
     */
    public function downloadQrCode($id = null, $size = 200, $format = 'png', $errorCorrection = 'H')
    {
        $id = $id ?? $this->id;

        if (empty($id)) {
            throw new \InvalidArgumentException('ID is required to generate QR code');
        }

        $renderer = new ImageRenderer(
            new RendererStyle($size, 4),  // Add margin of 4 modules
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($id);

        $headers = [
            'Content-Type' => 'image/svg+xml',
            'Content-Disposition' => 'attachment; filename="qrcode.svg"',
        ];

        return response($qrCode, 200, $headers);
    }
}
