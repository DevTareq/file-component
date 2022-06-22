<?php

namespace Test\Unit;

use App\Contracts\DataTransferObjectInterface;
use App\DataTransferObjects\FileDTO;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class FileDtoTest extends MockeryTestCase
{
    protected DataTransferObjectInterface $fileDto;

    protected function setUp(): void
    {
        $this->fileDto = new FileDTO();
    }

    public function testCreateFromRequestReturnsCorrectValues()
    {
        // @todo refactor: add mocks
        $file = UploadedFile::fake()->create('fake_file.csv');

        $request = new Request();
        $request->files->set('file', $file);

        $fileDtoObject = $this->fileDto->createFromRequest($request);

        $this->assertEquals('csv', $fileDtoObject->getExtension());
        $this->assertIsObject($fileDtoObject->getFileInput());
    }
}
