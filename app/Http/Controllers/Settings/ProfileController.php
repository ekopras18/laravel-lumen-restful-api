<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new User;
        $this->mandatory = array(
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
        );
    }

    public function index()
    {
        return $this->respone200('Success', Auth::user());
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validations($request, $this->mandatory);

        if ($validator) {
            return $validator;
        }

        // Check User ID
        $check = $this->model->find($id);
        if($check == ''){
            return $this->respone404('We can`t find a user ');
        }

        $data = [
            'name' => $request->name,
            'username' => str_replace(" ", "", $request->username),
            'email' => $request->email,
        ];

        $this->model->find($id)->update($data);

        return $this->respone200('Success Updated', $data);

    }

}
