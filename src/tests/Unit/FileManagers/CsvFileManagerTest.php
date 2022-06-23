<?php

namespace Test\Unit;

use App\Contracts\DataTransferObjectInterface;
use App\Contracts\FileValidatorInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class CsvFileManagerTest extends MockeryTestCase
{
    protected DataTransferObjectInterface $fileDTO;

    protected FileValidatorInterface $fileValidator;

    protected function setUp(): void
    {
        $this->markTestSkipped('must be revisited.');

        //@todo refactor: create mocks
        $file = UploadedFile::fake()->create('fake_file.csv');

        $request = new Request();
        $request->files->set('file', $file);

        $this->fileDTO = $this->fileDTO->createFromRequest($request);
    }

    public function testProcess()
    {
        $this->markTestSkipped('must be revisited.');
    }

    public function testValidate()
    {
        // make file validator
        $this->markTestSkipped('must be revisited.');

    }

    public function testExceptions()
    {
        // with data providers
        $this->markTestSkipped('must be revisited.');
    }
}
