<?php

namespace App\Http\Controllers\api;

use App\Helper\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\user\CreateUserRequest;
use App\Http\Requests\api\user\UpdateUserRequest;
use App\Service\ImageService;
use App\Service\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public $userService;
    public $imageService;

    public function __construct()
    {
        $this->userService = new UserService;
        $this->imageService = new ImageService;
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get all user",
     *     description="Get all user",
     *     operationId="getAllUser",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success Get Data",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                    property="status",
     *                    type="string",
     *                    example="success"
     *                  ),
     *                  @OA\Property(
     *                      property="data",
     *                      type="array",
     *                      @OA\Items(
     *                      ),
     *                  ),
     *                  @OA\Property(
     *                      property="message",
     *                      type="string",
     *                      example="Success Get Data"
     *                  ),
     *              ),
     *         ),
     *     ),
     * )
     */
    public function all()
    {
        try {
            return CustomResponse::success($this->userService->all(), 'Success Get Data');
        } catch (\Throwable $th) {
            return CustomResponse::error($th->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Get user by id",
     *     description="Get user by id",
     *     operationId="getUserByIdr",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the user",
     *         required=true,
     *         in="path",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success Get Data",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                    property="status",
     *                    type="string",
     *                    example="success"
     *                  ),
     *                  @OA\Property(
     *                     property="data",
     *                     type="object",
     *                  ),
     *                  @OA\Property(
     *                      property="message",
     *                      type="string",
     *                      example="Success Get Data"
     *                  ),
     *              ),
     *         ),
     *     ),
     * )
     */
    public function findOne(int $id)
    {
        try {
            $user = $this->userService->findOne($id);
            if (!$user) {
                return CustomResponse::badRequest(null, 'User not found');
            }
            return CustomResponse::success($user, 'Success');
        } catch (\Throwable $th) {
            return CustomResponse::error($th->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Create a new user",
     *     description="Create a new user",
     *     operationId="createUser",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User data",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="User Satu"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="user.satu@gmail.com"
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
     *         response=201,
     *         description="Create User Successfully",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     example="success"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Create User Successfully"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function create(CreateUserRequest $request)
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

            return CustomResponse::success($user, 'Create User Successfully');
        } catch (\Throwable $th) {
            return CustomResponse::error($th->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/api/users/{id}?_method=PUT",
     *     summary="Update user",
     *     description="Update user",
     *     operationId="updateUser",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         description="ID of the user",
     *         required=true,
     *         in="path",
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="User data",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="User Satu Update"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="user.satu@gmail.com"
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
     *         description="Success Update Data",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     example="success"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Success Update Data"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        try {
            $user = $this->userService->findOne($id);
            if (!$user) {
                return CustomResponse::badRequest(null, 'User not found');
            }

            $imageName = '';
            if ($request->has('foto')) {
                $image = $request->file('foto');
                $imageName = $this->imageService->saveImage($image);
            }

            $password = '';
            if ($request->has('password')) {
                $password = bcrypt($request->password);
            }
            $user = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
                'foto' => $imageName,
            ];

            if ($imageName === '') {
                unset($user['foto']);
            }

            if ($password === '') {
                unset($user['password']);
            }

            $this->userService->update($user, $id);
            return CustomResponse::success(null, 'Success Update Data');
        } catch (\Throwable $th) {
            return CustomResponse::error($th->getMessage());
        }
    }


    /**
     * @OA\Post(
     *     path="/api/users/{id}?_method=Delete",
     *     summary="Delete user",
     *     description="Delete user",
     *     operationId="deleteUser",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         description="ID of the user",
     *         required=true,
     *         in="path",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success Update Data",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     example="success"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                     example="Success Update Data"
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function delete(int $id)
    {
        try {
            $user = $this->userService->findOne($id);
            if (!$user) {
                return CustomResponse::badRequest(null, 'User not found');
            }

            $this->userService->delete($user);
            return CustomResponse::success(null, 'Success Delete Data');
        } catch (\Throwable $th) {
            return CustomResponse::error($th->getMessage());
        }
    }
}
