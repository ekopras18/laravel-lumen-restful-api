<?php

namespace App\Http\Middleware;

use Closure;
// use Illuminate\Contracts\Auth\Factory as Auth;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use DomainException;
use InvalidArgumentException;
use UnexpectedValueException;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $auth = $request->header('Authorization');

        if ($auth == '') {
            return response()
                ->json([
                    'status' => false,
                    'message' => 'Authorization header not found',
                    'code' => 401
                ], 401);
        }

        $token = explode(' ', $auth);
        if ($token[0] !== 'Bearer') {
            return response()
                ->json([
                    'status' => false,
                    'message' => 'Bearer token not found',
                    'code' => 401
                ], 401);
        }

        $token = $token[1];
        try {
            $credentials = JWT::decode($token, new Key(env('JWT_KEY'), 'HS256'));
            $data = User::find($credentials->id);
            Auth::setUser($data);
        } catch (InvalidArgumentException $e) {
            return response()
                ->json([
                    'status' => false,
                    'message' => 'Provided key is empty or malformed',
                    'code' => 401
                ], 401);
        } catch (DomainException $e) {
            return response()
                ->json([
                    'status' => false,
                    'message' => 'Algorithm is unsupported',
                    'code' => 401
                ], 401);
        } catch (SignatureInvalidException $e) {
            return response()
                ->json([
                    'status' => false,
                    'message' => 'JWT signature verification failed',
                    'code' => 401
                ], 401);
        } catch (BeforeValidException $e) {
            return response()
                ->json([
                    'status' => false,
                    'message' => 'Token invalid',
                    'code' => 401
                ], 401);
        } catch (ExpiredException $e) {
            return response()
                ->json([
                    'status' => false,
                    'message' => 'Token expired',
                    'code' => 401
                ], 401);
        } catch (UnexpectedValueException $e) {
            return response()
                ->json([
                    'status' => false,
                    'message' => 'JWT algorithm does not match provided key',
                    'code' => 401
                ], 401);
        }
        return $next($request);
    }
}
