<?php

namespace Covid\Users\Domain;

use Broadway\Domain\AggregateRoot;

interface UserRepository
{
    public function find($id): User;

    public function save(AggregateRoot $payment);
}
