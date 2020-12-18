<?php

namespace App\Base\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class BaseController extends Controller
{
    protected $service;

    function __construct($service)
    {
        $this->service = $service;

    }

    function create(Request $request)
    {
        return $this->service->create($request);
    }

    function getAll()
    {
        return $this->service->getAll();
    }

    function get($id)
    {
        return $this->service->get($id);
    }

    function delete($id)
    {
        return $this->service->delete($id);
    }

    function update(Request $request)
    {
        return $this->service->update($request);
    }

}
