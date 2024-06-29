<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Resources\SchoolResource;
use App\Repositories\SchoolRepository;
use App\Traits\ResponseAPI;

class SchoolController extends ApiController
{
    use ResponseAPI;
    private $schoolRepository;

    public function __construct(SchoolRepository $schoolRepository)
    {
        $this->schoolRepository = $schoolRepository;
    }

    public function index()
    {
        $rawData = $this->schoolRepository->showAll();
        $data = SchoolResource::collection($rawData);
        return $this->requestSuccessData($data);
    }
}
