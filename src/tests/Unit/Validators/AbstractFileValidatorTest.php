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

    protected array $csvContent;

    protected function setUp(): void
    {
        $file = UploadedFile::fake()->create('fake_file.csv');

        $this->dataTransferObject = new FileDTO();

        $this->dataTransferObject
            ->setFileInput($file)
            ->setFileCategory('ingredient')
            ->setExtension('csv');

        // @todo use fixture file
        $this->csvContent = json_decode(file_get_contents(dirname(__FILE__) . '/Fixtures/sample1.json'));
    }

    public function testValidateMultipleReturnStructure()
    {
        // shoul return array of errors and record
        $fileValidator = new StaffFileValidator();

        $results = $fileValidator->validateMultiple($this->csvContent);

        $fileReader = new CsvReader();
    }

    public function testValidateOnceReturnStructure()
    {
        // should return array of errors and record

    }

    public function testHasErrorMethodReturnStructure()
    {
        // should return array of errors id there is any
        // should return array of data only if no errors

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
