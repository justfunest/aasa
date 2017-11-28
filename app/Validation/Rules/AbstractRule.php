<?php

namespace App\Validation\Rules;

use App\Validation\Validatable;

abstract class AbstractRule implements Validatable
{

    /**
     * @var string
     */
    protected $errorMessage = '';

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param string $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

}