<?php

namespace App\Controller\Rules;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class RuleValidator
{
    public function __construct(private ValidatorInterface $validator) {}

    public function validate(object $dto): ?array
    {
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            $errorMessages = [];

            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }

            return $errorMessages;
        }

        return null;
    }
}
