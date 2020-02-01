<?php
namespace sudoku\solver\common\exception;

use Exception;
use PHPUnit\Framework\Constraint\ExceptionMessage;
use Throwable;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200201 Initial creation.
 */
class SudokuSolverException extends Exception
{
    /**
     * Exception constants.
     */
    const EMPTY_STRING = '';
    const EXCEPTION_CODE_DEFAULT = 0;

    /**
     * @param ExceptionMessage|string $message
     * @param Throwable|null $previous
     */
    public function __construct($message = self::EMPTY_STRING, Throwable $previous = null)
    {
        parent::__construct($message, self::EXCEPTION_CODE_DEFAULT, $previous);
    }
}
