<?php

namespace App\Exceptions;

use Exception;
use App;
use Core;
use Redirect;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        \Innovative\Core\Exceptions\ValidationException::class,
        \Innovative\Core\Exceptions\RecordNotFoundException::class,
        \Innovative\Core\Exceptions\PermissionException::class,
        \Illuminate\Session\TokenMismatchException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        App::make('innovative.core.auditor')->alert($e);

        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        // Core Exceptions
        if ( $e instanceof \Innovative\Core\Exceptions\CoreException )
        {
            Core::addError($e->getMessage());

            // Auditor::warning($e);

            if ( $e->redirect )
            {
                return $e->redirect;
            }
        }

        // Validation Exceptions
        if ( $e instanceof \Innovative\Core\Exceptions\ValidationException )
        {
            if ( $e->getMessage() )
            {
                Core::addError($e->getMessage());
            }

            try
            {
                return Redirect::back()->withInput()->withErrors($e->validator);
            }
            catch (\InvalidArgumentException $e)
            {
                return Redirect::route('error');
            }
        }

        // RecordNotFound Exceptions
        if ( $e instanceof \Innovative\Core\Exceptions\RecordNotFoundException )
        {
            $message = ( $e->getMessage() ) ?: trans('innovative/core::messages.general.record_not_found');
            Core::addError($message);

            try
            {
                return Redirect::back()->withInput();
            }
            catch (\InvalidArgumentException $e)
            {
                return Redirect::route('error');
            }
        }

        // Permission Exceptions
        if ( $e instanceof \Innovative\Core\Exceptions\PermissionException )
        {
            if ( $e->getMessage() )
            {
                Core::addError($e->getMessage());
            }

            try
            {
                return Redirect::back();
            }
            catch (\InvalidArgumentException $e)
            {
                return Redirect::route('error');
            }
        }

        // CSRF Token Mismatch Exceptions
        if ( $e instanceof \Illuminate\Session\TokenMismatchException )
        {
            Core::addError('Your session has expired. Please try logging in again.');

            return Redirect::route('login');
        }

        return parent::render($request, $e);
    }
}
