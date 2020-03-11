<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // dd($exception);//抓錯誤訊息的關鍵，preview查錯誤代碼

        // dd($request->expectsJson());//preview
        // if ($request->expectsJson()){
        //     return response()->json('have a error');
        // }

        if($exception instanceOf TokenInvalidException){
            return response()->json('token is Invalid');
            // return response()->json(['error'  => 'Token is Invalid'],400);
        } else if ($exception instanceOf TokenBlacklistedException){
            return response()->json('Token Blacklisted');
        } else {
        return parent::render($request, $exception);
        }
        
        //TokenBlacklistedException有效期限token尚未確認error
        //Tymon\JWTAuth\Exceptions\TokenBlacklistedException已經有錯誤訊息。

        //Tymon\JWTAuth\Exceptions\TokenInvalidException
        //"exception": "Tymon\\JWTAuth\\Exceptions\\JWTException",
        //後續要再嘗試關掉這個套件

    }
}
