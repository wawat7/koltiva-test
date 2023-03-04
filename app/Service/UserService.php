<?php

namespace App\Service;

use App\Models\User;
use App\Repository\UserRepository;

class UserService
{

    public $repository;
    public $imageService;

    public function __construct()
    {
        $this->repository = new UserRepository;
        $this->imageService = new ImageService;
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function findOne(int $id)
    {
        return $this->repository->findOne($id);
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function update(array $data, int $id)
    {
        return $this->repository->update($data, $id);
    }

    public function delete(User $user)
    {
        //remove image
        $this->imageService->removeImage(public_path('storage/images/' . $user->foto));
        return $this->repository->delete($user->id);
    }
}
