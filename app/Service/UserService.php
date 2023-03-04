<?php

namespace App\Service;

use App\Repository\UserRepository;

class UserService
{
    public $repository;


    public function __construct()
    {
        $this->repository = new UserRepository;
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

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
