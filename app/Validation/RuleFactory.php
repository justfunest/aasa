<?php

namespace App\Validation;

/**
 * Class RuleFactory
 */
class RuleFactory
{

    /**
     * @param $ruleName
     * @param array $arguments
     * @return \App\Validation\Validatable
     * @throws \Slim\Exception\SlimException
     */
    public static function create($ruleName, array $arguments = []) {
        $ruleNameSpace = 'App\\Validation\\Rules\\';
        $className = $ruleNameSpace . ucfirst($ruleName);

        if (!class_exists($className)) {
            throw new \Exception('Validation rule ' . $ruleName . ' does not exist!');
        }

        $reflection = new \ReflectionClass($className);

        return $reflection->newInstanceArgs($arguments);
    }
}