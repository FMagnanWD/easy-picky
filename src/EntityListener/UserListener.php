<?php

namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserListener 
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function prePersist(User $user)
    {
        $this->saltPassword($user);    
    }

    public function preUpdate(User $user)
    {
        $this->saltPassword($user);
    }

    public function saltPassword($user){
        if(null === $user->getPlainTextPassword()){
            return;
        }
        $user->setPassword(
            $this->hasher->hashPassword(
                $user,
                $user->getPlainTextPassword()
            )
        );

    }

}