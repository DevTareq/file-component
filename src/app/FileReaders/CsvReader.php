<?php

namespace App\FileReaders;

use App\Contracts\FileReaderInterface;
use League\Csv\Reader;

class CsvReader implements FileReaderInterface
{
    /**
     * @param string $path
     * @return mixed
     * @throws \League\Csv\Exception
     */
    public function fetchAll(string $path): mixed
    {
        $reader = Reader::createFromPath($path, 'r');

        $reader->setHeaderOffset(0);

        return $reader->getRecords() ?? [];
    }

    /**
     * @param string $path
     * @return mixed
     * @throws \League\Csv\Exception
     */
    public function getHeaders(string $path): mixed
    {
        $reader = Reader::createFromPath($path, 'r');
        $reader->setHeaderOffset(0);

        return $reader->getHeader();
    }
}
