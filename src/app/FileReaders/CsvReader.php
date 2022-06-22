<?php

namespace App\FileReaders;

use App\Contracts\FileReaderInterface;
use League\Csv\Exception;
use League\Csv\Reader;

class CsvReader implements FileReaderInterface
{
    /**
     * @param object $fileInput
     * @return mixed
     * @throws Exception
     */
    public function fetchAll(object $fileInput): mixed
    {
        $fileStream = new \SplFileObject($fileInput);
        $reader = Reader::createFromFileObject($fileStream);

        $reader->setHeaderOffset(0);

        return $reader->getRecords() ?? [];
    }

    /**
     * @param object $fileInput
     * @return mixed
     * @throws Exception
     */
    public function getHeaders(object $fileInput): mixed
    {
        $fileStream = new \SplFileObject($fileInput);
        $reader = Reader::createFromFileObject($fileStream);

        $reader->setHeaderOffset(0);

        return $reader->getHeader();
    }
}
