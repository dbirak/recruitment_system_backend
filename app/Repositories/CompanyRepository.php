<?php

namespace App\Repositories;

use App\Http\Requests\RegisterCompanyRequest;
use App\Models\Company;
use App\Models\User;

class CompanyRepository
{
    protected $company;
    protected $user;

    public function __construct(Company $company, User $user)
    {
        $this->company = $company;
        $this->user = $user;
    }

    public function create(RegisterCompanyRequest $request)
    {
        $user = User::create([
            'name' => $request['imię'],
            'surname' => $request['nazwisko'],
            'email' => $request['email'],
            'password' => bcrypt($request['hasło']),
            'role_id' => 2
        ]);

        $company = Company::create([
            'name' => $request['nazwa'],
            'street' => $request['ulica'],
            'post_code' => $request['kod pocztowy'],
            'city' => $request['miasto'],
            'krs' => $request['krs'],
            'regon' => $request['regon'],
            'nip' => $request['nip'],
            'phone_number' => $request['numer telefonu'],
            'user_id' => $user->id,
            'province_id' => $request['województwo']
        ]);

        return $user;
    }

    public function getCompanyByUserId(string $userId)
    {
        return $this->company::where('user_id', $userId)->first();
    }
}