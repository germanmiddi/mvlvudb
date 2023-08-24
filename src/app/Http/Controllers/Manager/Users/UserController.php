<?php

namespace App\Http\Controllers\Manager\Users;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return Inertia::render('Manager/Users/Index', [
            'users' => $users
        ]);
    }
}