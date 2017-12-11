<?php

namespace Lib;

use Lib\SqlModel;

/**
 * summary
 */
class BuildErrors
{
    private $sqlHandler;

    public function __construct()
    {
        $this->sqlHandler = new SqlModel();
    }

    public function getJsonError($response)
    {
    }
}
