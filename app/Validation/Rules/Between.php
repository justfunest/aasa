<?php

namespace App\Validation\Rules;

use League\Flysystem\Exception;

/**
 * Class Between
 * @package App\Validation\Rules
 */
class Between extends AbstractRule
{
    private $minValue;
    private $maxValue;


    /**
     * Between constructor.
     * @param null $minValue
     * @param null $maxValue
     * @throws Exception
     */
    public function __construct($minValue = null, $maxValue = null)
    {
        $this->minValue = $minValue;
        $this->maxValue = $maxValue;

        if (!is_null($minValue) && !is_null($maxValue) && $minValue > $maxValue) {
            throw new Exception('minValue is bigger then maxValue');
        }

        $this->setErrorMessage('Väärtus peab jääma ' . $minValue . ' ja ' . $maxValue . ' vahele');
    }

    /**
     * @param $input
     * @return bool
     */
    public function validate($input)
    {
        return $this->minValue <= $input && $this->maxValue >= $input;
    }

}