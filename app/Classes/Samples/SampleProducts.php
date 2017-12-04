<?php

namespace App\Classes\Samples;

use App\Classes\Samples\SamplesModel;

/**
 * summary
 */
class SampleProducts
{
    private $sqlHandle;
    private $c;

    public function __construct($c)
    {
        $this->c = $c;
        $this->samplesSql = new SamplesModel($this->c);
    }

    public function getProductsWithLimit($limit)
    {
        $result = $this->samplesSql->getProductsWithLimitSql($limit);
        return $result;
    }
}
