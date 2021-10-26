<?php

namespace Tests\Unit\Middlewares;

use App\Http\Middleware\CheckAdmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class CheckAdminMiddlewareTest extends TestCase
{
    /** @test */
    public function doesnt_show_forbidden_error_for_admin_users()
    {
        $adminUser = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $request = Request::create('/', 'GET');

        $request->setUserResolver(function () use ($adminUser) {
            return $adminUser;
        });

        $middleware = new CheckAdmin();

        $res = $middleware->handle($request, function () {
            return 'next request';
        });

        $this->assertEquals('next request', $res);
    }

    /**
     * @test
     *
     *
     */
    public function forbidden_error_for_non_admin_users()
    {
        $guestUser = User::factory()->create(['role' => User::ROLE_GUEST]);

        $request = Request::create('/', 'GET');

        $request->setUserResolver(function () use ($guestUser) {
            return $guestUser;
        });

        $this->expectExceptionMessage('Forbidden!');
        $middleware = new CheckAdmin();

        $middleware->handle($request, function () {});
    }
}
