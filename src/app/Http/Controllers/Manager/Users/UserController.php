<?php

namespace App\Http\Controllers\Manager\Users;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

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

    public function store(Request $request){
    
        $randomPassword = Str::random(10); 

        $user = User::create([
            'name' => request()->input('name'),
            'email' => request()->input('email'),
            // 'group' => request()->input('group'),
            'password' => bcrypt($randomPassword) 
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function checkUser(){
        $user = User::where('email', request()->input('email'))->first();
        if($user){
            return response()->json([
                'status' => 'error',
                'message' => 'Email already exists'
            ]);
        }else{
            return response()->json([
                'status' => 'success',
                'message' => 'Email is available'
            ]);
        }
    }

}