<?php

namespace Jasoft\Viringo\CoreBundle\Exception;

/**
 * Description of GenericException
 *
 * @author lvercelli
 */
class GenericException extends \Exception {
    
    public function __construct($message=null, $code=null, $previous=null) {
        if (empty($message)) {
            parent::__construct();
        } elseif (empty($code)) {
            parent::__construct($message);
        } elseif (empty($previous)) {
            parent::__construct($message, $code);
        } else {
            parent::__construct($message, $code, $previous);
        }
    }
}
