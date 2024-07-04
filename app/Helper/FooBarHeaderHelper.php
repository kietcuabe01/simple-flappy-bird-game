<?php

namespace App\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FooBarHeaderHelper
{
    private $data = [];
    private $maxIndex = 0;

    public function setData($path)
    {
        $fi = fopen($path, 'r');
        while (!feof($fi)) {
            $line = fgets($fi);
            if (!$line) continue;

            $this->data[] = Str::trim($line);
        }
        fclose($fi);

        $this->maxIndex = count($this->data) - 1;
    }

    public function isValid(Request $request)
    {
        $offset = random_int(0, $this->maxIndex);
        return !empty($request->header($this->data[$offset]));
    }
}