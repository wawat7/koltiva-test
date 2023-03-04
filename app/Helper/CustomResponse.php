<?php

namespace App\Helper;

class CustomResponse{

    public static function success($data, $message = null)
    {
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => $message ?? 'Success get data'
        ], 200);
    }

    public static function update($request, $message = null) {
        return response()->json([
            'status' => 'success',
            'data' => $request,
            'message' => $message ?? 'Success Update Data'
        ], 200);
    }

    public static function create($data, $message = null)
    {
        if ($data) {
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'message' => $message ?? 'Success Create Data'
            ], 201);
        } else {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => $message ?? 'Failed Create Data'
            ], 500);
        }
    }

    public static function delete($data, $message = null)
    {
        if($data) {
            return response()->json([
                'status' => 'success',
                'data' => null,
                'message' => $message ?? 'Success Delete Data'
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => $message ?? 'Failed Delete Data'
            ], 500);
        }
    }

    public static function notFound($message = null)
    {
        return response()->json([
            'status' => 'not found',
            'data' => null,
            'message' => $message ?? 'Data Not Found'
        ], 404);
    }

    public static function badRequest($data = null, $message = "Bad Request")
    {
        return response()->json([
            'status' => 'Bad Request',
            'data' => $data,
            'message' => $message
        ], 400);
    }

    public static function error($message = "Server Error")
    {
        return response()->json([
            'status' => 'error',
            'data' => null,
            'message' => $message
        ], 500);
    }

    public static function forbidden($message = null)
    {
        return response()->json([
            'status' => 'forbidden',
            'data' => null,
            'message' => $message ?? 'Forbidden'
        ], 403);
    }

    public static function unauthorized($message = null)
    {
        return response()->json([
            'status' => 'unauthorized',
            'data' => null,
            'message' => $message ?? 'Unauthorized'
        ], 401);
    }
}
