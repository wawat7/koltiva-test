<?php

namespace App\Http\Controllers\api;

use App\Helper\CustomResponse;
use App\Helper\Utility;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\auth\LoginRequest;
use App\Http\Requests\api\auth\RegisterRequest;
use App\Service\ImageService;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public $utils;
    public $userService;
    public $imageService;

    public function __construct()
    {
        $this->utils = new Utility;
        $this->userService = new UserService;
        $this->imageService = new ImageService;
    }

    public function login(LoginRequest $request)
    {
        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                return CustomResponse::success([
                    'access_token' => $user->createToken(config('app.jwt_secret'))->plainTextToken
                ], 'User login successfully.');
            }

            return CustomResponse::badRequest(null, 'your credential is wrong !');
        } catch (\Throwable $th) {
            return CustomResponse::error($th->getMessage());
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $image = $request->file('foto');
            $imageName = $this->imageService->saveImage($image);

            $user = $this->userService->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'foto' => $imageName,
            ]);

            return CustomResponse::success($user, 'Registration Successfully');
        } catch (\Throwable $th) {
            return CustomResponse::error($th->getMessage());
        }
    }
}
