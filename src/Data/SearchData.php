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
     * @var Date
     */
    public $dateMin;

    /**
     * @var Date
     */
    public $dateMax;
}
