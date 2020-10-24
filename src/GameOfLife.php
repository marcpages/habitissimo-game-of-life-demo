<?php


namespace GameOfLifePackage;

include '../vendor/autoload.php';

use GameOfLifePackage\Matrix;

class GameOfLife
{

    /* @var $matrix Matrix */
    public $matrix;
    private $autoRun;
    private $render;

    /**
     * GameOfLife constructor.
     * @param array $board (multidimensional array, accepted values are 0 = died, 1 = alive)
     * @param bool $autoRun should start the game loop
     */
    public function __construct(array $board, bool $autoRun = true, bool $render = true)
    {
        $this->matrix = new Matrix($board);
        $this->autoRun = $autoRun;
        $this->render = $render;
        if ( $this->render ) {
            system('clear');
        }
        if ( $this->autoRun ) {
            $this->nextGen();
        }
    }


    /**
     * Logic of each tick of the game: set cells died or alive depending of the following conditions:
     * - Any live cell with fewer than two live neighbours dies, as if caused by under-population.
     * - Any live cell with two or three live neighbours lives on to the next generation.
     * - Any live cell with more than three live neighbours dies, as if by overcrowding.
     * - Any dead cell with exactly three live neighbours becomes a live cell, as if by reproduction.
     */
    public function nextGen() {
        $this->render();

        $cellIndexsToDie = [];
        $cellsIndexsToAlive = [];

        foreach ($this->matrix->getCells() as $cellIndex => $cell) {
            /* @var $cell MatrixCell */
            $activeNeighborCellsCount = $this->countActiveCells( $this->matrix->getNeighborCells($cellIndex) );
            $isDead = $cell->getValue() === 0;
            $cellHasToDie = !$isDead && $activeNeighborCellsCount < 2 || $activeNeighborCellsCount > 3;

            if ( $cellHasToDie && !$isDead ) {
                $cellIndexsToDie[] = $cellIndex;
            } else if ( $isDead && $activeNeighborCellsCount === 3 ) {
                $cellsIndexsToAlive[] = $cellIndex;
            }

        }

        foreach ( $cellIndexsToDie as $cellIndex ) {
            $this->matrix->updateCellValueByIndex($cellIndex, 0);
        }

        foreach ( $cellsIndexsToAlive as $cellIndex ) {
            $this->matrix->updateCellValueByIndex($cellIndex, 1);
        }

        if ( $this->autoRun ) {
            $this->nextGen();
        }
    }

    /**
     * Count active cells (value = 1) for a given array of cells
     *
     * @param $cells
     * @return int
     */
    public function countActiveCells($cells) {
        $active = 0;
        foreach ($cells as $cell) {
            /* @var $cell MatrixCell */
            if ( $cell->getValue() === 1 ) {
                $active++;
            }
        }
        return $active;
    }

    /**
     * Renders the game in the terminal
     */
    private function render() {
        if ( $this->render ) {
            print "Conway's Game of Life \n";
            print str_repeat('_', $this->matrix->getNumCols()) . "\n";
            $col = 1;
            $print_out = '|';
            foreach ($this->matrix->getCells() as $cellIndex => $cell) {
                /* @var $cell MatrixCell */

                $print_out .= ($cell->getValue() === 1 ? "▩" : " ");

                if ($col === $this->matrix->getNumCols()) {
                    print $print_out . " | \n";
                    $print_out = '|';
                    $col = 1;
                } else {
                    $col++;
                }
            }
            print str_repeat('_', $this->matrix->getNumCols()) . "\n";
            sleep(0.5);
            $this->clear();
        }
    }

    /**
     * Clears previous tick render
     */
    private function clear() {
        echo "\033[0;0H";
    }

}
