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

    /**
     * @OA\Post(
     *     path="/api/login",
     *     operationId="loginUser",
     *     tags={"Authentication"},
     *     summary="Login User",
     *     description="Login user with email and password",
     *     @OA\RequestBody(
     *         description="Login object",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="wawatprigala00@gmail.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="password"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     example="success"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                     @OA\Property(
     *                         property="access_token",
     *                         type="string",
     *                         example="token_user"
     *                     ),
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="User login successfully"
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */

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

    /**
     * @OA\Post(
     *     path="/api/register",
     *     operationId="registerUser",
     *     tags={"Authentication"},
     *     summary="Register User",
     *     description="Register User",
     *     @OA\RequestBody(
     *         required=true,
     *         description="User data and profile picture",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Wawat Prigala"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="wawatprigala00@gmail.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="password"
     *                 ),
     *                 @OA\Property(
     *                     property="foto",
     *                     type="string",
     *                     format="binary"
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     example="success"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Registration Successfully"
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function register(RegisterRequest $request)
    {
        try {
            $image = $this->utils->base64ToFile($request->foto);
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


    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return CustomResponse::success(null, 'You have been logged out successfully.');

        } catch (\Throwable $th) {
            return CustomResponse::error($th->getMessage());
        }
    }
}
