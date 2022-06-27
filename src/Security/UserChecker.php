<?php

namespace App\Security;

use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Security\AccountDisabledException;


class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }

        if (!$user->isActivated()) {
            throw new AccountDisabledException();
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
    }
}