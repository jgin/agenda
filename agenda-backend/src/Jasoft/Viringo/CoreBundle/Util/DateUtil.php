<?php

namespace Jasoft\Viringo\CoreBundle\Util;

class DateUtil {
    public static $DEFAULT_SERVER_DATE_FORMAT = "Y-m-d";
    public static $DEFAULT_CLIENT_DATE_FORMAT = "d-m-Y";
    public static $DEFAULT_SERVER_DATE_TIME_FORMAT = "Y-m-d H:i";
    public static $DEFAULT_CLIENT_DATE_TIME_FORMAT = "d-M-Y H:i";
    public static $DEFAULT_TIME_FORMAT = "H:i";
    
    /*
     * @param string $stringDate
     * @return DateTime
     */
    public static function parseClientFormatToTime($stringTime){
        return \DateTime::createFromFormat(static::$DEFAULT_TIME_FORMAT,$stringTime);
    }  
    /*
     * @param string $stringDate
     * @return DateTime
     */
    public static function parseClientFormatToDate($stringDate){
        return \DateTime::createFromFormat(static::$DEFAULT_CLIENT_DATE_FORMAT,$stringDate);
    }  
    /*
     * @param string $stringDate
     * @return DateTime
     */
    public static function parseServerFormatToDate($stringDate){
        return \DateTime::createFromFormat(static::$DEFAULT_SERVER_DATE_FORMAT, $stringDate);
    }  
    /*
     * @param string $stringDate
     * @return DateTime
     */
    public static function parseClientFormatToDateWithTime($stringDate){
        return \DateTime::createFromFormat(static::$DEFAULT_CLIENT_DATE_TIME_FORMAT, $stringDate);
    }  
    /*
     * @param string $stringDate
     * @return DateTime
     */
    public static function parseServerFormatToDateWithTime($stringDate){
        return \DateTime::createFromFormat(static::$DEFAULT_SERVER_DATE_TIME_FORMAT, $stringDate);
    }  
}