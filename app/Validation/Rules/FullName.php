<?php

namespace App\Validation\Rules;


class FullName extends AbstractRule
{
    /**
     * Contains constructor.
     * @param string $containsValue
     */
    public function __construct()
    {
        $this->setErrorMessage('Väli peab sisaldama ees- ja perekonnanime');
    }

    /**
     * @param $input
     * @return bool
     */
    public function validate($input)
    {
        return preg_match("/^\s*[a-z]+\s+[a-z]+(\s*|(\s+[a-z]+)*)$/", $input);
    }
}