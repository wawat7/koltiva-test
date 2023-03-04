<?php

namespace App\Repository;

use App\Models\User;

class UserRepository
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function findOne(int $id)
    {
        return User::find($id);
    }

    public function all()
    {
        return User::all();
    }

    public function update(array $data, int $id)
    {
        return User::whereId($id)->update($data);
    }

    public function delete(int $id)
    {
        return User::destroy($id);
    }
}
