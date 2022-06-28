<?php

namespace App\FileReaders;

use App\Contracts\FileReaderInterface;
use League\Csv\Exception;
use League\Csv\Reader;

class CsvReader implements FileReaderInterface
{
    protected ?Reader $reader = null;

    /**
     * @param object $fileInput
     * @return mixed
     * @throws Exception
     */
    public function fetchAll(object $fileInput): mixed
    {
        $this->setFileStreamReader($fileInput);

        $this->reader->setHeaderOffset(0);

        return $this->reader->getRecords() ?? [];
    }

    /**
     * @param object $fileInput
     * @return mixed
     * @throws Exception
     */
    public function getHeaders(object $fileInput): mixed
    {
        $this->setFileStreamReader($fileInput);

        $this->reader->setHeaderOffset(0);

        return $this->reader->getHeader();
    }

    /**
     * @param object $fileInput
     * @return void
     */
    private function setFileStreamReader(object $fileInput): void
    {
        if (null === $this->reader) {

            $fileStream = new \SplFileObject($fileInput);

            $this->reader = Reader::createFromFileObject($fileStream);
        }
    }
}
