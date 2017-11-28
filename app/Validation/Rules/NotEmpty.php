<?php

namespace App\Validation\Rules;

/**
 * Class NotEmpty
 * @package App\Validation\Rules
 */
class NotEmpty extends AbstractRule
{
    public function __construct()
    {
        $this->setErrorMessage('Väli ei tohi olla tühi!');
    }

    /**
     * @param $input
     * @return bool
     */
    public function validate($input)
    {
        if (is_string($input)) {
            $input = trim($input);
        }
        return !empty($input);
    }
}