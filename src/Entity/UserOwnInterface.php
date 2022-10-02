<?php

namespace App\Entity;

interface UserOwnInterface
{
    public function getUser(): ?User;
    public function setUser(?User $user): self;
}