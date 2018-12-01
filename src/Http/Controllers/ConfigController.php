<?php

namespace Harlekoy\ApiDocs\Http\Controllers;

use Illuminate\Routing\Controller;

class ConfigController extends Controller
{
    public function index()
    {
        return config('apidocs');
    }
}
