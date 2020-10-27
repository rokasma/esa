<?php

namespace Rokasma\Esa;

class Column
{
    public $title;
    public $type;
    public $index;

    public function __construct($title, $type, $index) {
        $this->title = $title;
        $this->type = $type;
        $this->index = $index;
    }
}
