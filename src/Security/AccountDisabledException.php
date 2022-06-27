<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\AccountStatusException;



class AccountDisabledException extends AccountStatusException
{
    public function getMessageKey()
    {
        return 'Votre compte est désactivé.';
    }
}