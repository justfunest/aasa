<?php
namespace App\Validation\Rules;


/**
 * Class PersonalCode
 * @package App\Validation\Rules
 */
class PersonalCode extends AbstractRule
{
    const MULTIPLIER_ONE = '1234567891';
    const MULTIPLIER_TWO = '3456789123';

    public function __construct()
    {
        $this->setErrorMessage('Väli ei ole valiidne eesti isikukood!');
    }

    /**
     * @param $input
     * @return bool
     */
    public function validate($input)
    {
        if (preg_match("/^[1-8]{1}[0-9]{2}[0-1]{1}[0-9]{1}[0-3]{1}[0-9]{1}[0-9]{4}/", $input)) {

            // Validation rule https://et.wikipedia.org/wiki/Isikukood
           $checkSum = $this->getCheckSum($input);
           if ($checkSum == (int)$input[10]) {
               return true;
           }
        }
        return false;
    }

    /**
     * Calculates personal code check sum what must match last digit in personal code
     *
     * @param string $personalCode
     * @return int
     */
    private function getCheckSum($personalCode)
    {
        $reminder = $this->getReminder($personalCode);
        if ($reminder == 10) {
            $reminder = $this->getReminder(self::MULTIPLIER_TWO);
            if ($reminder == 10) {
                $reminder = 0;
            }
        }
        return $reminder;
    }

    /**
     * Calculates checkSum depending on multiplier
     *
     * @param string $personalCode
     * @param string $multiplier
     * @return int
     * @throws \Exception
     */
    private function getReminder($personalCode, $multiplier = self::MULTIPLIER_ONE)
    {
        switch($multiplier) {
            case self::MULTIPLIER_ONE:
            case self::MULTIPLIER_TWO:
                $checkSum = 0;
                for ($i = 0; $i <= 9; $i++) {
                    $checkSum += (int)$personalCode[$i] * (int)$multiplier[$i];
                }
                return $checkSum % 11;
                break;
            default:
                throw new \Exception('Not valid multiplier!');
                break;
        }
    }



}