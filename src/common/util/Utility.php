<?php
namespace sudoku\solver\common\util;

use sudoku\solver\common\exception\SudokuSolverException;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200201 Initial creation.
 */
class Utility
{
    /**
     * Error constants.
     */
    const ERROR_MUST_HAVE_TYPE = 'Argument must have type "%s"; got type "%s".';

    /**
     * Data type constants.
     */
    const TYPE_STRING = 'string';

    /**
     * @param mixed $input
     *
     * @return bool
     */
    public static function isString($input): bool
    {
        return static::isType($input, self::TYPE_STRING);
    }

    /**
     * @param string|null $text
     *
     * @return bool
     * @throws SudokuSolverException
     */
    public static function isStringEmptyOrNull($text = null)
    {
        if (is_null($text)) {
            return true;
        } else {
            return static::isStringEmpty($text);
        }
    }

    /**
     * @param string $text
     *
     * @return bool
     * @throws SudokuSolverException
     */
    private static function isStringEmpty($text)
    {
        static::assertIsString($text);

        if (strlen($text) > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param mixed $text
     *
     * @throws SudokuSolverException
     */
    public static function assertIsString($text)
    {
        static::assertIsType($text, self::TYPE_STRING);
    }

    /**
     * @param mixed $input
     * @param string $expectedType
     *
     * @throws SudokuSolverException
     */
    private static function assertIsType($input, $expectedType)
    {
        // no Utility::assertIsString() call to prevent infinite recursive calls.
        if (static::isType($input, $expectedType)) {
            // Everything okay
        } else {
            if (is_object($input)) {
                $actualType = get_class($input);
            } else {
                $actualType = gettype($input);
            }

            throw new SudokuSolverException(vsprintf(self::ERROR_MUST_HAVE_TYPE, [$expectedType, $actualType]));
        }
    }

    /**
     * @param mixed $input
     * @param string $expectedType
     *
     * @return bool
     */
    private static function isType($input, $expectedType): bool
    {
        return gettype($input) === $expectedType;
    }
}
