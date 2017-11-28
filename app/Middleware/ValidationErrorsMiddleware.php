<?php

namespace App\Middleware;

class ValidationErrorsMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if (isset($_SESSION['form_validation_errors'])) {
            $this->container->view->addGlobal('errors', $_SESSION['form_validation_errors']);
            unset($_SESSION['form_validation_errors']);
        }

        $response = $next($request, $response);

        return $response;
    }
}