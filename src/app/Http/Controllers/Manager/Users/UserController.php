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

    public function list()
    {

        $length = request()->input('length');
        
        $column = request()->input('column') ? request()->input('column') : 'id'; 

        $query = User::query();

        if(request()->input('search')) {
            $search = request()->input('search');
            $query->where('name', 'LIKE', "%{$search}%");
            $query->orWhere('email', 'LIKE', "%{$search}%");
        }

        return $query->orderBy($column, 'asc')
            ->paginate($length)
            ->withQueryString()
            ->through(fn ($user) =>[
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'group' => $user->group,
                'created_at' => $user->created_at
            ]);


        // $users = User::all();
        // return Inertia::render('Manager/Users/List', [
        //     'users' => $users
        // ]);
    }

}