<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ValidateRoleValidator extends ConstraintValidator
{
    const ROLES = ['ROLE_ADMIN', 'ROLE_USER'];

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof ValidateRole) {
            throw new UnexpectedTypeException($constraint, ValidateRole::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_array($value)) {
            throw new UnexpectedValueException($value, 'array');
        }

        foreach ($value as $role) {
            if (!in_array($role, self::ROLES)) {
                $this->context->buildViolation($constraint->message)
                    ->setCode('MET_UN_CODE_RANDOM')
                    ->addViolation();
            }
        }
    }
}