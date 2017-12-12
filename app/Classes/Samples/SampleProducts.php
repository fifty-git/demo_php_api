<?php

namespace App\Classes\Samples;

use App\Classes\Samples\SamplesModel;

/**
 * summary
 */
class SampleProducts
{
    private $sqlHandle;

    public function __construct(SamplesModel $samplesModel)
    {
        $this->samplesSql = $samplesModel;
    }

    public function getProductsWithLimit($limit)
    {
        $result = $this->samplesSql->getProductsWithLimitSql($limit);
        return $result;
    }
}
