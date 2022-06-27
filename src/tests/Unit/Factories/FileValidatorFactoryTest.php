<?php

namespace Test\Unit;

use App\Contracts\DataTransferObjectInterface;
use App\DataTransferObjects\FileDTO;
use App\Exceptions\Files\FileNotFoundException;
use App\Exceptions\Files\UnsupportedFileException;
use App\Factories\FileValidatorFactory;
use App\Validators\Files\StaffFileValidator;
use Illuminate\Http\UploadedFile;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class FileValidatorFactoryTest extends MockeryTestCase
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
        $this->dataTransferObject->setFileCategory('staff');

        $fileValidatorObj = FileValidatorFactory::make($this->dataTransferObject);

        $this->assertInstanceOf(StaffFileValidator::class, $fileValidatorObj);
    }

    public function testFactoryReturnExceptionForFileNotUploaded()
    {
        $this->expectException(FileNotFoundException::class);

        $this->dataTransferObject = new FileDTO();

        $this->dataTransferObject
            ->setFileCategory('sample')
            ->setExtension('sql');

        FileValidatorFactory::make($this->dataTransferObject);
    }

    public function testFactoryReturnExceptionForUnsupportedExtension()
    {
        $this->expectException(UnsupportedFileException::class);

        $this->dataTransferObject->setFileCategory('sample');

        FileValidatorFactory::make($this->dataTransferObject);
    }

    public function testFactoryPostFixName()
    {
        $this->assertTrue(FileValidatorFactory::getPostFixName() == 'FileValidator');
    }
}
