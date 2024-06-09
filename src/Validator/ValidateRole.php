<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ValidateRole extends Constraint
{
    public string $message = 'One of the roles entered is incorrect.';
    public string $mode = 'strict';
}