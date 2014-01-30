<?php

namespace Jasoft\Viringo\CoreBundle\Exception;

/**
 * Description of UndefinedSystemConfigParamException
 *
 * @author lvercelli
 */
class UndefinedSystemConfigParamException extends GenericException {
    
    public function __construct($message = null, $code = null, $previous = null) {
        parent::__construct($message, $code, $previous);
    }
    
}
