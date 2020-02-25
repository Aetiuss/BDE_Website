<?php

namespace App\Data;

class SearchData
{

    /**
     * @var int
     */
    public $page = '1';

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
