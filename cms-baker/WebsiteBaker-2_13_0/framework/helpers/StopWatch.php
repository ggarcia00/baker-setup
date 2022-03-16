<?php
namespace bin\helpers;

class StopWatch
{
    const DECIMALS        = 4;
    const DEC_POINT       = ',';
    const THOUSANDS_SEP   = '.';

    private static $fTimeStart = 0.00;
    private static $fTotal = 0.00;
    private static $oTimezone;

    public static function setTimeZone($sTimezone='UTC')
    {
        $oRetval = null;
        try {
            $oRetval   = new \dateTime();// null,new \DateTimeZone($sTimezone)
            $oRetval->setTimezone(new \DateTimezone($sTimezone));
            self::$oTimezone = $oRetval;
        } catch(Exception $e) {
            echo $e->getMessage().'<br />';
        }
        return $oRetval->getOffset();
    }

    public static function start()
    {
        self::$fTimeStart = \microtime(true);
        self::$fTotal      = 0.00;
        $dateTime = new \DateTime(null, new \DateTimeZone('Europe/Amsterdam'));

    }

    public static function stop()
    {
        $fTimeEnd = (\microtime(true)-self::$fTimeStart);
        return "Execution time: ".\number_format($fTimeEnd, self::DECIMALS, self::DEC_POINT,self::THOUSANDS_SEP)."\n";
    }
}
