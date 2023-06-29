<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    public function index()
    {
        if (empty($this->paginate)) {
            $field = !empty($this->field) ? $this->field : '*';
            $result = $this->model->select($field)->get();
            if (count($result) == 0) {
                return $this->respone200('Result Not Found');
            } else {
                return $this->respone200('Success', $result);
            }
        }

        return $this->paginations();
    }

    public function paginations()
    {
        $field = !empty($this->field) ? $this->field : '*';
        $paginate = !empty($this->paginate) ? $this->paginate : 10;

        $result = $this->model->select($field)->paginate($paginate);

        if (count($result) == 0) {
            return $this->respone200('Result Not Found');
        } else {
            return $this->respone200('Success', $result);
        }
    }

    public function show($id)
    {
        $field = !empty($this->field) ? $this->field : '*';

        $result = $this->model->select($field)->find($id);

        if (is_null($result)) {
            return $this->respone200('Result Not Found');
        } else {
            return $this->respone200('Success', $result);
        }
    }

    public function store(Request $request)
    {
        $validator = $this->validations($request, $this->mandatory);

        if ($validator) {
            return $validator;
        }

        if (method_exists($this, 'beforeStore')) {
            $this->beforeStore($request);
        }

        $result =  $this->model->create($request->all());

        return $this->respone200('Saved Successfully', $result);
    }

    public function beforeStore(Request $request)
    {
        return $request;
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validations($request, $this->mandatory);

        if ($validator) {
            return $validator;
        }

        if (method_exists($this, 'beforeUpdate')) {
            $this->beforeUpdate($request, $id);
        }

        $this->model->find($id)->update($request->all());

        return $this->respone200('Updated Successfully');
    }

    public function beforeUpdate(Request $request, $id)
    {
        return $request;
    }

    public function destroy($id)
    {
        $result = $this->model->find($id);

        if (is_null($result)) {
            return $this->respone404('Id Not Found');
        } else {
            $result->delete();
            return $this->respone200('Deleted Successfully');
        }
    }

    public function validations($request, $rules)
    {
        $messages = [
            'required'  => 'The :attribute field is required.',
            'unique'  => 'The :attribute field is unique.',
            'password.min' => 'The :attribute must be at least 4 characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->respone401($validator->errors()->first());
        }
    }

    public function respone200($message, $data = null)
    {
        if ($data != null) {
            return response()->json([
                'status' => true,
                'message' => $message,
                'code' => 200,
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => $message,
                'code' => 200,
            ], 200);
        }
    }

    public function respone401($message, $data = null)
    {
        if ($data != null) {
            return response()->json([
                'status' => false,
                'message' => $message,
                'code' => 401,
                'data' => $data,
            ], 401);
        } else {
            return response()->json([
                'status' => false,
                'message' => $message,
                'code' => 401,
            ], 401);
        }
    }

    public function respone404($message, $data = null)
    {
        if ($data != null) {
            return response()->json([
                'status' => false,
                'message' => $message,
                'code' => 404,
                'data' => $data,
            ], 404);
        } else {
            return response()->json([
                'status' => false,
                'message' => $message,
                'code' => 404,
            ], 404);
        }
    }
}
