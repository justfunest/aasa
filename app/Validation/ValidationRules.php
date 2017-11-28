<?php

namespace App\Validation;

/**
 * Class RuleSet
 * @package App\Validation
 * @method static ValidationRules notEmpty
 * @method static ValidationRules contains
 * @method static ValidationRules between
 * @method static ValidationRules personalCode
 * @method static ValidationRules fullName
 */
/**
 * Class ValidationRules
 * @package App\Validation
 */
class ValidationRules
{
    const MATCH_ALL = 1;
    const MATCH_ONE = 2;

    private $rules = [];
    private $errors = [];
    private $matchingCondition = self::MATCH_ALL;

    public function __call($ruleName, $arguments) {
        return $this->addRule(RuleFactory::create($ruleName, $arguments));
    }

    public static function __callStatic($ruleName, $arguments)
    {
        $ruleSet = new static();
        return $ruleSet->__call($ruleName, $arguments);
    }


    /**
     * @param Validatable $rule
     * @return $this
     */
    public function addRule(Validatable $rule) {
        $this->rules[] = $rule;
        return $this;
    }

    public function setMatchingCondition($condition) {
        switch ($condition) {
            case self::MATCH_ALL:
            case self::MATCH_ONE:
                $this->matchingCondition = $condition;
        }
        return $this;
    }

    public function validate($input) {
        $this->errors = [];

        foreach ($this->rules as $rule) {
           $isRuleValid = $rule->validate($input);
           if ($this->matchingCondition == self::MATCH_ONE && $isRuleValid) {
               return true;
           }
           /** @var $rule Validatable */
           if (!$isRuleValid) {
               $this->errors[] = $rule->getErrorMessage();
           }
        }

        if (count($this->errors)) {
            return false;
        }

        return true;
    }


    public function getErrors() {
        return $this->errors;
    }
}