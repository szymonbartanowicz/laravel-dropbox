<?php

namespace App\Http\Controllers;

use App\Customer;
use App\File;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
{
    protected $service;

    public function __construct(CustomerService $service)
    {
        $this->service = $service;
    }

    public function connect()
    {
        return $this->service->connect();
    }
    public function setDbxCredentials()
    {
        return $this->service->setDbxCredentials();
    }
}
