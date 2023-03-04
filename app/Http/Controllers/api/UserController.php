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

    public function all()
    {
        try {
            return CustomResponse::success($this->userService->all(), 'Success Get Data');
        } catch (\Throwable $th) {
            return CustomResponse::error($th->getMessage());
        }
    }

    public function findOne(int $id)
    {
        try {
            return CustomResponse::success($this->userService->findOne($id), 'Success');
        } catch (\Throwable $th) {
            return CustomResponse::error($th->getMessage());
        }
    }

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

            return CustomResponse::success($user, 'Registration Successfully');
        } catch (\Throwable $th) {
            return CustomResponse::error($th->getMessage());
        }

    }

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

    public function delete(int $id)
    {
        try {
            $user = $this->userService->findOne($id);
            if (!$user) {
                return CustomResponse::badRequest(null, 'User not found');
            }

            $this->userService->delete($id);
            return CustomResponse::success(null, 'Success Delete Data');
        } catch (\Throwable $th) {
            return CustomResponse::error($th->getMessage());
        }
    }
}
