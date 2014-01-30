<?php

namespace Jasoft\Viringo\CoreBundle\Exception;

/**
 * Description of NonPersistedEntityUpdatiingException
 *
 * @author lvercelli
 */
class NonPersistedEntityUpdatiingException extends GenericException {
    
    public function __construct($message = null, $code = null, $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
