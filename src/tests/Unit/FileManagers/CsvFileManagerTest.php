<?php

namespace Test\Unit;

use App\Contracts\DataTransferObjectInterface;
use App\Contracts\FileValidatorInterface;
use App\DataTransferObjects\FileDTO;
use App\Exceptions\Files\UnsupportedFileException;
use App\FileManagers\CsvFileManager;
use App\FileReaders\CsvReader;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class CsvFileManagerTest extends MockeryTestCase
{
    protected DataTransferObjectInterface $dataTransferObject;

    protected FileValidatorInterface $fileValidator;

    protected function setUp(): void
    {
        //@todo refactor: create mocks
        $file = UploadedFile::fake()->create('fake_file.csv');
        $this->dataTransferObject = new FileDTO();

        $request = new Request();
        $request->files->set('file', $file);

        $this->dataTransferObject->createFromRequest($request);
    }

    public function testFileExtensionNotMatchingExpectedValue()
    {
        $this->expectException(UnsupportedFileException::class);

        $file = UploadedFile::fake()->create('fake_file.sql');

        $request = new Request();
        $request->files->set('file', $file);
        $request->request->set('category', 'sample');

        $this->dataTransferObject->createFromRequest($request);

        $fileManager = new CsvFileManager();
        $fileManager->process($this->dataTransferObject);
    }

    public function testGetFileReaderReturnCorrectValue()
    {
        $file = UploadedFile::fake()->create('fake_file.csv');

        $request = new Request();
        $request->files->set('file', $file);
        $request->request->set('category', 'staff');

        $this->dataTransferObject->createFromRequest($request);

        $fileManager = new CsvFileManager();

        $this->assertInstanceOf(CsvReader::class, $fileManager->getFileReader());
        $this->assertInstanceOf(
            FileValidatorInterface::class,
            $fileManager->getFileValidator($this->dataTransferObject));
    }
}
