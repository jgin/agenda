<?php

namespace Jasoft\Viringo\CoreBundle\Controller\Domain;

/**
 * Description of ContentTypes
 *
 * @author lvercelli
 */
class ContentTypes {
    
    const HTML='text/html';
    const PDF='application/pdf';
    const DOC='application/msword';
    const XLS='application/vnd.ms-excel';
    const JSON='application/json';
    
    public static function getContentTypeByFormatStr($format) {
        switch ($format) {
            case 'html' : return self::HTML;
            case 'pdf' : return self::PDF;
            case 'doc' : return self::DOC;
            case 'xls' : return self::XLS;
            case 'json' : return self::JSON;
            default: return null;
        }
    }
    
}
