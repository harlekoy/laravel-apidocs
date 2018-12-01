<?php

namespace Harlekoy\ApiDocs\Http\Controllers;

use Illuminate\Routing\Controller;

class SpaController extends Controller
{
    public function index()
    {
        return view('apidocs::index');
    }
}
