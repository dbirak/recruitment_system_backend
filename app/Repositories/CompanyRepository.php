<?php

namespace App\Repositories;

use App\Http\Requests\RegisterCompanyRequest;
use App\Http\Requests\UpdateCompanyProfileRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

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
            'province_id' => $request['województwo'],
            
            'description' => "",
            'localization' => json_encode(['lat' => 52.25490829401159, 'lng' => 21.014514614981326]),
        ]);

        return $user;
    }

    public function getCompanyByUserId(string $userId)
    {
        return $this->company::where('user_id', $userId)->first();
    }

    public function getCompanyProfile(string $companyId)
    {
        return $this->company::where('id', $companyId)->first();
    }

    public function updateCompanyProfile(UpdateCompanyProfileRequest $request, string $companyId)
    {
        $company = $this->company::where('id', $companyId)->first();
        $company['name'] = $request['name'];
        $company['localization'] = json_encode(json_decode($request['localization']));
        $company['street'] = $request['street'];
        $company['post_code'] = $request['post_code'];
        $company['city'] = $request['city'];
        $company['phone_number'] = $request['phone_number'];
        $company['krs'] = $request['krs'];
        $company['nip'] = $request['nip'];
        
        if ($request['description'] === null) $company['description'] = "";
        else $company['description'] = $request['description'];
        
        if ($request['contact_email'] === "null") $company['contact_email'] = null;
        else $company['contact_email'] = $request['contact_email'];

        if ($request->has('avatar')) {
            if(Storage::exists('public/avatarImage/'.$company->avatar))
                Storage::delete('public/avatarImage/'.$company->avatar);

            $image = $request['avatar'];
            $path2 = $image->store('public/avatarImage');
            $filename_image = $image->hashName();

            $company->avatar = $filename_image;
        }

        if ($request->has('background_image')) {
            if(Storage::exists('public/backgroundImage/'.$company->background_image))
                Storage::delete('public/backgroundImage/'.$company->background_image);

            $image = $request['background_image'];
            $path2 = $image->store('public/backgroundImage');
            $filename_image = $image->hashName();

            $company->background_image = $filename_image;
        }

        $company->save();

        return $company;
    }
}