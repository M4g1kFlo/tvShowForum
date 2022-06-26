<?php

namespace App\Controller\Trait;

Trait RoleTrait
{
    protected function checkRole(string $role)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('signin');
        }
        if (!in_array($role, $this->getUser()->getRoles())) {
            return $this->redirectToRoute('topic-all', ['errors' => 'not_right']);
        }
        return null;
    }
}