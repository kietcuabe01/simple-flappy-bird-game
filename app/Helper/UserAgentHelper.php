<?php

namespace App\Helper;

use Illuminate\Support\Str;

class UserAgentHelper
{
    private $data = [];

    public function setData($path)
    {
        $fi = fopen($path, 'r');
        while (!feof($fi)) {
            $line = fgets($fi);
            if (!$line) continue;

            $this->data[] = Str::trim($line);
        }
        fclose($fi);
    }

    public function isValid($browser)
    {
        return in_array($browser, $this->data);
    }
}