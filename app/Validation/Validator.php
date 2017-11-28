<?php

namespace App\Validation;


/**
 * Class Validator
 * @package App\Validation
 */
class Validator
{

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @param $request
     * @param array $rules
     * @return bool
     */
    public function validateRequest($request, array $rules = [])
    {
        $this->errors = [];
        foreach  ($rules as $field => $validationRules) {
            /** @var $validationRules ValidationRules */

            if (!$validationRules instanceof ValidationRules) {
                throw new \Exception($field . ' value must be instance of App\Validation\ValidationRules');
            }

            $isValid = $validationRules->validate($request->getParam($field));

            if (!$isValid) {
                $this->errors[$field] = $validationRules->getErrors();
            }
        }

        $_SESSION['form_validation_errors'] = $this->errors;

        return count($this->errors) ? false : true;
    }

    /**
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }
}