<?php

namespace App\Data;

class SearchData
{

    /**
     * @var string
     */
    public $q = "";


    /**
     * @var Category[]
     */
    public $categories = [];

    /**
     * @var nullinteger
     */
    public $max;

    /**
     * @var nullinteger
     */
    public $min;

    public function __toString()
    {
        return $this->title;
    }
}
