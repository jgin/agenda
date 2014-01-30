<?php

namespace Jasoft\Viringo\CoreBundle\Exception;

/**
 * Description of DuplicateEntityException
 *
 * @author lvercelli
 */
class EntityValidationException extends GenericException {
    
    /**
     *
     * @var \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    protected $errors;

    /**
     * 
     * @param \Symfony\Component\Validator\ConstraintViolationListInterface $errors
     */
    public function __construct($errors = null) {
        $this->errors=$errors;
        parent::__construct((string)$errors);
    }

    public function getErrors() {
        return $this->errors;
    }
    
}
