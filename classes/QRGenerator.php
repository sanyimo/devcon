<?php

namespace Classes;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class QRGenerator
{
    public static function generate(string $data): string
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($data)
            ->size(180)
            ->margin(10)
            ->build();

        return 'data:image/png;base64,' . base64_encode($result->getString());
    }
}