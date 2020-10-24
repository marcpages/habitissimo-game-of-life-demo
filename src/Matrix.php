<?php


namespace GameOfLifePackage;

include '../vendor/autoload.php';

use GameOfLifePackage\MatrixCell;
use GameOfLifePackage\Exceptions\CellIndexDoesNotExists;

class Matrix
{

    private $cells = [];
    private $numRows = 0;
    private $numCols = 0;

    /**
     * Matrix constructor.
     * @param $board
     */
    public function __construct($board)
    {
        $this->numRows = count($board);
        $this->parseCells($board);
    }

    /**
     * Get matrix cells
     *
     * @return array
     */
    public function getCells(): array
    {
        return $this->cells;
    }

    /**
     * Total number of rows
     *
     * @return int
     */
    public function getNumRows(): int
    {
        return $this->numRows;
    }

    /**
     * Total number of cols
     *
     * @return int
     */
    public function getNumCols(): int

    {
        return $this->numCols;
    }

    /**
     * Get matrix cell by index
     *
     * @param $index
     * @return \GameOfLifePackage\MatrixCell
     * @throws CellIndexDoesNotExists
     */
    public function getCellByIndex($index): MatrixCell

    {
        if ( !array_key_exists( $index, $this->getCells() ) ) {
            throw new CellIndexDoesNotExists();
        }

        return $this->getCells()[$index];
    }

    /**
     * Update matrix cell value by its index
     *
     * @param $index
     * @param $value
     * @throws CellIndexDoesNotExists
     */
    public function updateCellValueByIndex($index, $value): void

    {
        /* @var $cell MatrixCell */
        $cell = $this->getCellByIndex($index);
        $cell->setValue( $value );

        $this->cells[$index] = $cell;
    }


    /**
     * Get neighbor cells of an specific cell
     *
     * @param $cellIndex
     * @return MatrixCell[]
     */
    public function getNeighborCells($cellIndex): array
    {
        $topCellIndex = $cellIndex - $this->getNumCols();
        $bottomCellIndex = $cellIndex + $this->getNumCols();

        $neighborCellIndexs = [
            $topCellIndex - 1,     $topCellIndex,     $topCellIndex + 1,
            $cellIndex - 1,                           $cellIndex + 1,
            $bottomCellIndex - 1,  $bottomCellIndex,  $bottomCellIndex + 1,
        ];

        $existingNeighborCells = [];

        $cells = $this->getCells();
        foreach ($neighborCellIndexs as $index) {
            if ( array_key_exists( $index,  $cells) ) {
                $existingNeighborCells[] = $cells[$index];
            }
        }

        return $existingNeighborCells;
    }

    /**
     * Save multidimensional array as cell objects
     *
     * @param $board
     */
    private function parseCells($board): void
    {
        foreach ($board as $x => $cols) {
            $this->numCols = count($cols);
            foreach ($cols as $y => $value) {
                $this->cells[] = new MatrixCell($x, $y, $value);
            }
        }
    }


}
