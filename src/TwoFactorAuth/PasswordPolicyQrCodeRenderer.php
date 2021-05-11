<?php


namespace OxidProfessionalServices\PasswordPolicy\TwoFactorAuth;


use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class PasswordPolicyQrCodeRenderer
{
    /**
     * @param string $dataUrl
     * @return string writes QR Code
     */
    public function generateQrCode(string $dataUrl)
    {
        $renderer = new ImageRenderer(new RendererStyle(200), new SvgImageBackEnd());
        $writer = new Writer($renderer);
        return $writer->writeString($dataUrl);
    }

}