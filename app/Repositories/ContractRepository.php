<?php

namespace App\Repositories;

use App\Models\Contract;

class ContractRepository {

    protected $contract;

    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }

    public function getAllContracts()
    {
        return $this->contract::all();
    }
}