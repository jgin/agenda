<?php

namespace Jasoft\Viringo\CoreBundle\Exception;

/**
 * Description of DuplicateEntityException
 *
 * @author lvercelli
 */
class DuplicateEntityException extends GenericException {
    
    public function __construct($message = null, $code = null, $previous = null) {
        parent::__construct($message, $code, $previous);
    }
    
}
