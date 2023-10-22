<?php

namespace App\Repositories;

use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\RegisterCompanyRequest;
use App\Http\Requests\SearchCompanyRequest;
use App\Http\Requests\UpdateCompanyProfileRequest;
use App\Models\Announcement;
use App\Models\Comment;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class CompanyRepository
{
    protected $company;
    protected $announcement;
    protected $user;
    protected $comment;

    public function __construct(Company $company, User $user, Announcement $announcement, Comment $comment)
    {
        $this->company = $company;
        $this->user = $user;
        $this->announcement = $announcement;
        $this->comment = $comment;
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

    public function getCompanyAnnouncements(string $id)
    {
        return $this->announcement::where('company_id', $id)->orderby('created_at', 'desc')->paginate(5);
    }

    public function getCompanyComments(string $id)
    {
        return $this->comment::where('company_id', $id)->orderby('created_at', 'desc')->paginate(8);
    }

    public function getCompanyAllComments(string $id)
    {
        return $this->comment::where('company_id', $id)->get();
    }

    public function getCompanyCommentsWithoutUserComment(string $id, string $userId)
    {
        return $this->comment::where('company_id', $id)->whereNot('user_id', $userId)->orderby('created_at', 'desc')->paginate(8);
    }

    public function getUserComment(string $id, string $userId)
    {
        return $this->comment::where('company_id', $id)->where('user_id', $userId)->first();
    }

    public function storeCompanyComment(AddCommentRequest $request, string $userId)
    {
        $newComment = new Comment();
        $newComment->comment = $request['komentarz'];
        $newComment->rating = $request['rating'];
        $newComment->company_id = $request['company_id'];
        $newComment->user_id = $userId;
        $newComment->save();

        return $newComment;
    }

    public function updateCompanyComment(AddCommentRequest $request, string $commentId)
    {
        $comment = $this->comment::where('id', $commentId)->first();
        $comment->comment = $request['komentarz'];
        $comment->rating = $request['rating'];
        $comment->save();

        return $comment;
    }

    public function getCommentById($commentId)
    {
        return $this->comment::where('id', $commentId)->first();
    }

    public function destroyCompanyComment($commentId)
    {
        $this->comment::where('id', $commentId)->delete();
    }

    public function searchCompany(SearchCompanyRequest $request)
    {
        $query = Company::query();

        if (empty($request['nazwa']) && empty($request['krs']) && empty($request['nip']) && $request['województwo'] === 0) {
            return $companies = Company::paginate(20);
        }

        if ($request['województwo'] !== 0) {
            $query->where('province_id', $request['województwo']);
        } 

        if (!empty($request['nazwa'])) {
            $query->where('name', 'LIKE', "%".$request['nazwa']."%");
        } 

        if (!empty($request['krs'])) {
            $query->where('krs', 'LIKE', "%".$request['krs']."%");
        } 

        if (!empty($request['nip'])) {
            $query->where('nip', 'LIKE', "%".$request['nip']."%");
        } 

        return $companies = $query->paginate(20);
    }

    public function getTwoLatestComments(string $companyId)
    {
        return $this->comment::where('company_id', $companyId)->orderby('created_at', 'desc')->limit(2)->get();
    }

    public function getCommentsCountByRating(string $companyId, int $rating)
    {
        return $this->comment::where('company_id', $companyId)->where('rating', $rating)->count();
    }

}