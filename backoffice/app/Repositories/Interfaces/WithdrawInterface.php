<?php

namespace App\Repositories\Interfaces;

interface WithdrawInterface{
    public function makeWithdraw($data): bool;
}
