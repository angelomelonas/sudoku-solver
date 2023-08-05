<?php
namespace App\common\object;

use App\common\exception\SudokuSolverException;
use App\common\util\Utility;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200201 Initial creation.
 */
class FilePath
{
    /**
     * Error constants.
     */
    const ERROR_FILE_PATH_INVALID = 'File path "%s" is invalid.';

    /**
     * @var string
     */
    protected $filePathString;

    /**
     * @param string $filePathString
     *
     * @throws SudokuSolverException when the file name is not valid.
     */
    public function __construct($filePathString)
    {
        if (static::isValidFilePathString($filePathString)) {
            $this->filePathString = $filePathString;
        } else {
            throw new SudokuSolverException(vsprintf(self::ERROR_FILE_PATH_INVALID, [$filePathString]));
        }
    }

    /**
     * @param string $filePathString
     *
     * @return bool
     */
    public static function isValidFilePathString($filePathString): bool
    {
        return Utility::isString($filePathString);
    }

    /**
     * @return string
     */
    public function getFilePathString(): string
    {
        return $this->filePathString;
    }
}
