<?php

namespace App\Services;

use App\Models\CoalLine;

interface ParserInterface
{
    /**
     * @param string $content
     * @return CoalLine[]
     */
    public function parse(string $content): array;
}
