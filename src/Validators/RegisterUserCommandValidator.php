<?php

namespace TailgateApi\Validators;

use Respect\Validation\Validator as V;
use TailgateApi\Validators\User\PasswordMatches;
use TailgateApi\Validators\User\UniqueEmail;
use Tailgate\Domain\Model\User\UserViewRepositoryInterface;

class RegisterUserCommandValidator extends AbstractRespectValidator
{
    private $userViewRepository;

    public function __construct(UserViewRepositoryInterface $userViewRepository)
    {
        $this->userViewRepository = $userViewRepository;
    }

    protected function addRules($command)
    {
        V::with("TailgateApi\Validators\User\\");

        $this->rules['password'] = V::notEmpty()->stringType()->length(6, 100)->PasswordMatches($command->getConfirmPassword())->setName('Password');
        $this->rules['email'] = V::notEmpty()->email()->length(4, 100)->UniqueEmail($this->userViewRepository)->setName('Email');
    }
}
