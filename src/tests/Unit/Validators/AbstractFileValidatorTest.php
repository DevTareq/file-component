<?php

namespace Test\Unit;

use App\Contracts\DataTransferObjectInterface;
use App\DataTransferObjects\FileDTO;
use App\FileReaders\CsvReader;
use App\Validators\Files\StaffFileValidator;
use Illuminate\Http\UploadedFile;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class AbstractFileValidatorTest extends MockeryTestCase
{
    protected DataTransferObjectInterface $dataTransferObject;

    protected function setUp(): void
    {
        $file = UploadedFile::fake()->create('fake_file.csv');

        $this->dataTransferObject = new FileDTO();

        $this->dataTransferObject
            ->setFileInput($file)
            ->setFileCategory('ingredient')
            ->setExtension('csv');
    }

    public function testFileValidatorRules()
    {
        $this->markTestSkipped();

        // todo: Refactor - create Mocks
        // todo: use dataProviders
//        $fileValidator = new StaffFileValidator();
//        $fileReader = new CsvReader();
//
//        $fileValidator->validate($this->dataTransferObject, $fileReader);
    }

    public function testLogicalRuleValidationAccessibility()
    {
        $this->markTestSkipped();
    }

    public function testWithoutLogicalRuleValidation()
    {
        $this->markTestSkipped();
    }
}
