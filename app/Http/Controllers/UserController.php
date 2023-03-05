<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function all()
    {
        return view('user.index');
    }

    public function create()
    {
        return view('user.create');
    }

    public function edit(int $id)
    {
        return view('user.edit');
    }
}
