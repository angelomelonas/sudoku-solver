<?php
namespace App\common\object;

use App\common\exception\SudokuSolverException;
use App\common\util\Utility;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200201 Initial creation.
 */
class FileContent
{
    /**
     * Error constants.
     */
    const ERROR_FILE_CONTENT_INVALID = 'File content "%s" is invalid.';

    /**
     * @var string
     */
    protected $fileContentString;

    /**
     * @param string $fileContentString
     *
     * @throws SudokuSolverException
     */
    public function __construct(string $fileContentString)
    {
        if (static::isValidFileContentString($fileContentString)) {
            $this->fileContentString = $fileContentString;
        } else {
            throw new SudokuSolverException(vsprintf(self::ERROR_FILE_CONTENT_INVALID, [$fileContentString]));
        }
    }

    /**
     * @param string $fileNameString
     *
     * @return bool
     */
    public static function isValidFileContentString($fileNameString)
    {
        return Utility::isString($fileNameString);
    }

    /**
     * @return string
     */
    public function getFileContentString()
    {
        return $this->fileContentString;
    }
}
