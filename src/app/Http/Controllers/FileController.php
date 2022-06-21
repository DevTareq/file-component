<?php

namespace App\Http\Controllers;

use App\Contracts\DataTransferObjectInterface;
use App\Contracts\FileManagerFactoryInterface;
use App\DataTransferObjects\FileDTO;
use App\Factories\FileManagerFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class FileController extends BaseController
{
    /**
     * @param FileManagerFactoryInterface $fileManager
     * @param DataTransferObjectInterface $dataTransferObject
     */
    public function __construct(
        protected FileManagerFactoryInterface $fileManager,
        protected DataTransferObjectInterface $dataTransferObject
    ) {}

    /**
     * @param ?array $results
     * @return mixed
     */
    public function index(?array $results = null): mixed
    {
        return view('upload', ['home' => true]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\View\View|\Laravel\Lumen\Application
     * @throws \Throwable
     */
    public function upload(Request $request)
    {
        //@todo: DTO
        $fileManager = FileManagerFactory::getFileManager($request);
        $results = $fileManager->process($request);

        return view('upload', compact('results'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function uploadApi(Request $request)
    {
        $fileDTO = $this->dataTransferObject->createFromRequest($request);

        $fileManager = FileManagerFactory::getFileManager($fileDTO);

        $results = $fileManager->process($fileDTO);

        if (empty($results)) {
            return $this->responseRequestSuccess();
        }

        return $this->responseRequestError($results);
    }

    /**
     * @return JsonResponse
     */
    protected function responseRequestSuccess(): JsonResponse
    {
        return response()->json(['data' => ['status' => 'success']], 201);
    }

    /**
     * @param $data
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function responseRequestError($data, int $statusCode = 400): JsonResponse
    {
        return response()->json(['data' => $data, 'code' => $statusCode], $statusCode);
    }
}
