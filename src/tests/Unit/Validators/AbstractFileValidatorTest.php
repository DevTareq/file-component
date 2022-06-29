<?php

namespace Test\Unit;

use App\Contracts\DataTransferObjectInterface;
use App\DataTransferObjects\FileDTO;
use App\FileReaders\CsvReader;
use App\Validators\Files\StaffFileValidator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class AbstractFileValidatorTest extends MockeryTestCase
{
    protected DataTransferObjectInterface $dataTransferObject;

    protected array $csvContent;

    protected UploadedFile $fileInput;

    protected CsvReader $fileReader;

    protected function setUp(): void
    {
        $this->dataTransferObject = new FileDTO();
        $this->fileReader = new CsvReader();

        $this->dataTransferObject->setExtension('csv');
    }

    public function testValidateMultipleReturnStructure()
    {
        $this->dataTransferObject
            ->setFileInput($this->getSampleFile('sample1.csv'))
            ->setFileCategory('ingredient');

        $fileValidatorMock = $this->getMockBuilder(StaffFileValidator::class)
            ->addMethods([])
            ->getMock();

        Validator::shouldReceive('make')
            ->andReturn(\Mockery::mock([
                'fails' => true,
                'errors' => new MessageBag(['errors' => 'some message']),
                'all' => []]));

        $validation = $fileValidatorMock->validate($this->dataTransferObject, $this->fileReader);

        $this->assertArrayHasKey('errors', $validation[0]);
        $this->assertArrayHasKey('record', $validation[0]);
    }

    public function testLogicalRuleValidationHasNoErrors()
    {
        $this->dataTransferObject
            ->setFileInput($this->getSampleFile('sample2.csv'))
            ->setFileCategory('staff')
            ->setExtension('csv');

        $fileValidatorMock = $this->getMockBuilder(StaffFileValidator::class)
            ->addMethods([])
            ->getMock();

        Validator::shouldReceive('make')->andReturn(\Mockery::mock(['fails' => false]));

        $validation = $fileValidatorMock->validate($this->dataTransferObject, $this->fileReader);

        $this->assertArrayNotHasKey('errors', $validation);
    }

    /**
     * @param string $fileName
     * @return UploadedFile
     */
    private function getSampleFile(string $fileName): UploadedFile
    {
        return new UploadedFile(
            dirname(__FILE__) . '/Fixtures/' . $fileName,
            $fileName,
            'text/csv',
            null,
            false,
            TRUE
        );
    }
}
