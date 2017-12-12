<?php

namespace App\Classes\Samples;

use Lib\SqlModel;

/**
*
*/
class SamplesModel
{
    private $sqlHandler;
  
    public function __construct(SqlModel $sqlModel)
    {
        $this->sqlHandler = $sqlModel;
    }

    public function getProductsWithLimitSql($limit)
    {
        $sql = "SELECT
          cart_products.product_id,
          cart_products.product_name,
          cart_products.medium_image,
          cart_products.short_desc
          FROM
          cart_products
          WHERE
          cart_products.product_id > 100 
          LIMIT $limit";

        $bindValues = array();
        $resultArray = $this->sqlHandler->fetchAll($sql, $bindValues);
        return $resultArray;
    }
}
