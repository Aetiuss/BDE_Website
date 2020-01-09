<?php

namespace App\Data;

class SearchData
{

    /**
     * @par string
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
}
