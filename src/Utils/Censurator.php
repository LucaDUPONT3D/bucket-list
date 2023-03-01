<?php

namespace App\Utils;

class Censurator
{
    const CENSURED_WORDS = ['prout','slip','cheval','chien','coq'];

    public function purify(String $string)
    {
        return str_ireplace(self::CENSURED_WORDS, '*', $string);
    }

}
