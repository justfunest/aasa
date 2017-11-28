<?php

namespace App\Validation;


Interface Validatable
{
    /**
     * @param $input
     * @return bool
     */
    public function validate($input);

    public function getErrorMessage();

    public function setErrorMessage($errorMessage);
}