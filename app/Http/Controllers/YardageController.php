<?php

namespace App\Http\Controllers;


use App\Http\Resources\YardageResource;

class YardageController extends Controller
{
    public function index()
    {
        return YardageResource::collection(auth()->user()->yardages()->paginate(15));
    }

}
