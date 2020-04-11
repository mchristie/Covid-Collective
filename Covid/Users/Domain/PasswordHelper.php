<?php

namespace Covid\Users\Domain;

interface PasswordHelper
{
    public function hash(Password $password): HashedPassword;

    public function check(HashedPassword $hashedPassword, Password $password): bool;
}
