<?php

namespace App\EventListener;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BeforeUserCreated
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function prePersist(User $user)
    {
        $encodedPassword = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encodedPassword);
    }
}