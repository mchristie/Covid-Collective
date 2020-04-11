<?php

namespace App\Exceptions;

use Throwable;
use ReflectionClass;
use Reflection;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Covid\Users\Domain\Exceptions\UserNotFound;
use Covid\Users\Domain\Exceptions\UserAlreadyExists;
use Covid\Users\Domain\Exceptions\PhoneNumberWasInvalid;
use Covid\Users\Domain\Exceptions\PasswordNotStrongEnough;
use Covid\Users\Domain\Exceptions\NameWasInvalid;
use Covid\Users\Domain\Exceptions\EmailWasInvalid;
use Covid\Users\Domain\Exceptions\EmailOrPhoneIsRequired;
use Covid\Users\Domain\Exceptions\CodeWasInvalid;
use Covid\Shared\BaseException;

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
        switch(get_class($exception)) {
            case CodeWasInvalid::class:
            case EmailOrPhoneIsRequired::class:
            case EmailWasInvalid::class:
            case NameWasInvalid::class:
            case PasswordNotStrongEnough::class:
            case PhoneNumberWasInvalid::class:
            case UserAlreadyExists::class:
            case UserNotFound::class:
            return response(json_encode([
                    'error' => $exception->getName()
                ]), 400);
                
            default:
                return response(json_encode([
                    'error' => $exception->getMessage()
                ]), 400);
            break;

        }

        return parent::render($request, $exception);
    }

}
