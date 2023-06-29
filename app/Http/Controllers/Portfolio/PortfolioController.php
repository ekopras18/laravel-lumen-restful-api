<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Portfolio;
        $this->field = array(
            'id as id',
            'name as name',
            'description as description',
            'images as images',
            'date as date',
            'link as link',
        );
        $this->mandatory = array(
            'name' => 'required',
            'description' => 'required',
            'images' => 'required',
            'date' => 'required',
        );
    }

    // public function beforeStore(Request $request)
    // {
    //     $request->merge([
    //         'testField' => $request->testValue,
    //     ]);
    // }

    // public function beforeUpdate(Request $request, $id)
    // {
    //     $request->merge([
    //         'testField' => $request->testValue,
    //     ]);
    // }
}
