<?php
/**
 * Created by PhpStorm.
 * User: justfun
 * Date: 26.11.17
 * Time: 15:26
 */

namespace App\Validation\Rules;


/**
 * Class Contains
 * @package App\Validation\Rules
 */
class Contains extends AbstractRule
{
    private $containsValue;

    /**
     * Contains constructor.
     * @param string $containsValue
     */
    public function __construct($containsValue = null)
    {
        $this->containsValue = $containsValue;
        $this->setErrorMessage('Väli peab sisaldama sõna "' . $containsValue .'"');
    }

    /**
     * @param $input
     * @return bool
     */
    public function validate($input)
    {
        return false !== mb_strpos($input, $this->containsValue, 0, mb_detect_encoding($input));
    }
}

