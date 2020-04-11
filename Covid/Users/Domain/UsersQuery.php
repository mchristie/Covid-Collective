<?php

namespace Covid\Users\Domain;

interface UsersQuery
{
    public function find(UserId $userId): array;

    public function findByEmailOrPhoneNumber(?Email $email, ?PhoneNumber $phone): array;

}
