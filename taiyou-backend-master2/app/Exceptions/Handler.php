<?php

namespace App\Exceptions;

use App\Exceptions\Api\ApiGenericException;
use App\Traits\Api\ResponseTrait;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseTrait;
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
     * @param \Throwable $exception
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
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {

        if ($exception instanceof PermissionDeniedException) {
            $title = translate('Error Permission Denied');
            return response()->view('system.errors.permissionDenied', ['title' => $title], 401);
        }
        if ($exception instanceof NotFoundHttpException) {
            $title = translate('Not found');
            return response()->view('system.errors.pageNotFound', ['title' => $title], 404);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            $title = translate('Method not allowed.');
            return response()->view('system.errors.methodNotAllowed', ['title' => $title], 405);
        }
        if ($exception instanceof ResourceNotFoundException) {
            return redirect()->back()->withErrors(['alert-danger' => 'Record was not found in our system.']);
        }
        if ($exception instanceof NotDeletableException) {
            return redirect()->back()->withErrors(['alert-danger' => $exception->message]);
        }
        if ($exception instanceof CustomGenericException) {
            return redirect()->back()->withErrors([$exception->alert => $exception->message]);
        }
        if ($exception instanceof ApiGenericException) {
            return $this->setStatusCode($exception->statusCode)->respondWithError($exception->message);
        }
        if (get_class($exception) === \Laravel\Passport\Exceptions\OAuthServerException::class) {
            return response(['message' => $exception->getMessage()], 401);
        }


        return parent::render($request, $exception);
    }
}
