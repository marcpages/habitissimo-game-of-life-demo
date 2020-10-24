<?php


namespace GameOfLifePackage;


class MatrixCell
{
    private $x;
    private $y;
    private $value;

    /**
     * MatrixCell constructor.
     * @param $x
     * @param $y
     * @param $value
     */
    public function __construct($x, $y, $value)
    {
        $this->x = $x;
        $this->y = $y;
        $this->value = $value;
    }

    /**
     * Get cell value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set cell value
     *
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

}
