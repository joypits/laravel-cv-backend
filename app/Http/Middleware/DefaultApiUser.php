<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DefaultApiUser
{
    public function handle(Request $request, Closure $next)
    {
        $user = User::firstOrCreate(
            ['email' => 'api@system.local'],
            [
                'name' => 'Static API User',
                'password' => Hash::make('secret123'),
            ]
        );

        // Force request to use this user
        $request->setUserResolver(fn() => $user);

        return $next($request);
    }
}
