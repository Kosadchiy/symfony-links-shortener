<?php

namespace App\Validator;

use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ConfirmPasswordValidator
{
    public function validate($object, ExecutionContextInterface $context)
    {
        if ($object->getPassword() !== $object->confirm) {
            $context->buildViolation('Confirmation must be equal to password.')
                ->atPath('confirm')
                ->addViolation()
            ;
        }
    }
}