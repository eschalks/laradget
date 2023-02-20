<?php

namespace App\Exceptions;

class AccountProviderExpired extends \Exception
{
    public function __construct()
    {
        parent::__construct('The access token to the account provider expired. Please re-authenticate.');
    }
}
