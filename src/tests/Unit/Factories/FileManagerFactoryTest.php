<?php

namespace Test\Unit;

use App\Contracts\DataTransferObjectInterface;
use App\DataTransferObjects\FileDTO;
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
            ->setExtension('csv');
    }

    public function testFactoryReturnTheRightObject()
    {
        $fileManagerObj = fileManagerFactory::getFileManager($this->dataTransferObject);

        $this->assertInstanceOf(CsvFileManager::class, $fileManagerObj);
    }

    public function testFactoryPostFixName()
    {
        $this->assertTrue(fileManagerFactory::getPostFixName() == 'FileManager');
    }
}
