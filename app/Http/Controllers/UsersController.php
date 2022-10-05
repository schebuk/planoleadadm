<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = User::get();
        return response()->json($users);
    }
}
