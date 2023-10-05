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
        
        
        if (request('search')) {
            $search = request('search');
            
            $query->where('name', 'LIKE', '%' . request('search') . '%');
            $query->orWhere('email', 'LIKE', '%' . request('search') . '%');
            $query->orWhere('email', 'LIKE', '%' . request('search') . '%');

            $query->orWhereHas('roles', function ($roleQuery) use ($search) {
                $roleQuery->where('name', 'like', '%' . $search . '%');
            });
        }

        return $query->orderBy($column, 'asc')
            ->paginate($length)
            ->withQueryString()
            ->through(fn ($user) =>[
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles->pluck('name'),
                // 'group' => $user->group,
                'created_at' => $user->created_at
            ]);

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