<?php

namespace Test\Unit;

use App\Contracts\DataTransferObjectInterface;
use App\DataTransferObjects\FileDTO;
use App\Exceptions\Files\FileNotFoundException;
use App\Exceptions\Files\UnsupportedFileCategory;
use App\Exceptions\Files\UnsupportedFileException;
use App\Factories\FileManagerFactory;
use App\FileManagers\CsvFileManager;
use Illuminate\Http\UploadedFile;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class FileManagerFactoryTest extends MockeryTestCase
{
    protected DataTransferObjectInterface $dataTransferObject;

    public function setUp(): void
    {
        //@todo refactor: create mocks
        $this->dataTransferObject = new FileDTO();

        $file = UploadedFile::fake()->create('fake_file.csv');

        $this->dataTransferObject
            ->setFileInput($file)
            ->setFileCategory('sample')
            ->setExtension('csv');
    }

    public function testFactoryReturnTheRightObject()
    {
        $fileManagerObj = FileManagerFactory::getFileManager($this->dataTransferObject);

        $this->assertInstanceOf(CsvFileManager::class, $fileManagerObj);
    }

    public function testFactoryReturnExceptionForUnsupportedCategory()
    {
        $this->expectException(UnsupportedFileCategory::class);

        $this->dataTransferObject = new FileDTO();

        $file = UploadedFile::fake()->create('fake_file.sql');

        $this->dataTransferObject
            ->setFileInput($file);

        FileManagerFactory::getFileManager($this->dataTransferObject);
    }

    public function testFactoryReturnExceptionForUnsupportedExtension()
    {
        $this->expectException(UnsupportedFileException::class);

        $this->dataTransferObject = new FileDTO();

        $file = UploadedFile::fake()->create('fake_file.sql');

        $this->dataTransferObject
            ->setFileInput($file)
            ->setFileCategory('sample')
            ->setExtension('sql');

        FileManagerFactory::getFileManager($this->dataTransferObject);
    }

    public function testFactoryReturnExceptionForFileNotUploaded()
    {
        $this->expectException(FileNotFoundException::class);

        $this->dataTransferObject = new FileDTO();

        $this->dataTransferObject
            ->setFileCategory('sample')
            ->setExtension('sql');

        FileManagerFactory::getFileManager($this->dataTransferObject);
    }

    public function testFactoryPostFixName()
    {
        $this->assertTrue(FileManagerFactory::getPostFixName() == 'FileManager');
    }
}
