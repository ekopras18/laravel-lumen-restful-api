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
            '*'
        );
        $this->mandatory = array(
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
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
