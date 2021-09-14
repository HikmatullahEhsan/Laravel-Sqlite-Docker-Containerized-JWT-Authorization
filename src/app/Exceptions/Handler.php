<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        /**
        *
        * Check JWT APIs token status
        * a:not provided
        * b:invalid (blacklisted)
        * c:expired
        **/
        if ($exception instanceof UnauthorizedHttpException) {
            // if($exception instanceof UnauthorizedHttpException) {

            //     return response()->json(['msg' => 'Un-Authorized','token_status'    =>false], 403);
            // }
            if ($exception->getPrevious() instanceof TokenExpiredException) {

                return response()->json(['msg' => 'Token expired','token_status'    =>false], 401);
            }
            else if ($exception->getPrevious() instanceof TokenInvalidException) {

                return response()->json(['msg' => 'Token is invalid','token_status'    =>false], 401);
            }
            else if ($exception->getPrevious() instanceof TokenBlacklistedException) {

                return response()->json(['msg' => 'token_blacklisted','token_status' =>false], 401);
            }else{

                return response()->json(['msg' => 'Un-Authorized','token_status'    =>false], 403);
            }
        }

        return parent::render($request, $exception);
    }
}
