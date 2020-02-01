<?php
namespace sudoku\solver\common\util;

use Exception;

/**
 * @author Angelo Melonas <angelomelonas@gmail.com>
 * @since 20200201 Initial creation.
 */
class Settings
{
    /**
     * Error constants.
     */
    const ERROR_PATH_NOT_FOUND = 'Root path "%s" does not exist.';

    /**
     * @return string
     * @throws Exception
     */
    public static function getRootPathString(): string
    {
        $rootPath = __DIR__ . '/../../../';
        $realPath = realpath($rootPath);

        if ($realPath === false) {
            throw new Exception(vsprintf(self::ERROR_PATH_NOT_FOUND, [$rootPath]));
        } else {
            return $realPath;
        }
    }
}
