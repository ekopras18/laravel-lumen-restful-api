<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;

class PortfolioController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(){
        return response()
            ->json([
                'status' => true,
                'message' => 'Success',
                'code' => 200,
                'data' => [
                    'name' => 'Portfolio',
                    'description' => 'This is portfolio'
                ]
            ], 200);
    }
}
