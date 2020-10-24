<?php

namespace GameOfLifePackage\Exceptions;


class CellIndexDoesNotExists extends \Exception
{

    public function __construct($cellIndex) {
        parent::__construct('Cell index does not exists: '.$cellIndex, 500);
    }

}
