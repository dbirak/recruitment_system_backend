<?php

namespace Tests\Unit;

use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class AuthServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function corretLoginUserTest(): void
    {
        // $loginUserRequest = Mockery::mock(LoginUserRequest::class);
        // $loginUserRequest->shouldReceive('input')->with('email')->andReturn('kowal@gmail.com');
        // $loginUserRequest->shouldReceive('input')->with('password')->andReturn('kowal12@');

        // $user = new User();
        // $userRepository = Mockery::mock(UserRepository::class);
        // $userRepository->shouldReceive('findByEmail')->once()->with('test@example.com')->andReturn($user);
        // $userRepository->shouldReceive('comparePassword')->with('password123', $user)->andReturn(true);
        // $userRepository->shouldReceive('createToken')->with($user)->andReturn($user->createToken('token')->plainTextToken);
    }
}
