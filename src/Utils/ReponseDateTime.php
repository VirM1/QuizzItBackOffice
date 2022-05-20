<?php

namespace App\Utils;

class ReponseDateTime extends \DateTime
{
    public function __toString()
    {
        return $this->format('U');
    }

    static function fromDateTime(\DateTime $dateTime) {
        return new static($dateTime->format('c'));
    }
}