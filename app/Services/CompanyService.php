<?php

namespace App\Services;

use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterCompanyRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateCompanyProfileRequest;
use App\Http\Resources\AnnouncementCollection;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CompanyProfileResource;
use App\Http\Resources\UserResource;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CompanyService {

    protected $userRepository;
    protected $companyRepository;

    public function __construct(UserRepository $userRepository, CompanyRepository $companyRepository)
    {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
    }

    public function getCompanyProfile(string $userId)
    {
        $company = $this->companyRepository->getCompanyByUserId($userId);

        $res = $this->companyRepository->getCompanyProfile($company['id']);

        if(!$res) throw new Exception("Przedsiębiorstwo nie istnieje!");

        return new CompanyProfileResource($res);
    }

    public function updateCompanyProfile(UpdateCompanyProfileRequest $request, string $userId)
    {
        $company = $this->companyRepository->getCompanyByUserId($userId);

        $res = $this->companyRepository->getCompanyProfile($company['id']);

        if(!$res) throw new Exception("Przedsiębiorstwo nie istnieje!");

        $res = $this->companyRepository->updateCompanyProfile($request, $company['id']);

        return new CompanyProfileResource($res);
    }

    public function showCompanyProfileForUser(string $companyId)
    {
        $res = $this->companyRepository->getCompanyProfile($companyId);

        if(!$res) throw new Exception("Przedsiębiorstwo nie istnieje!");

        return new CompanyProfileResource($res);
    }

    public function getCompanyAnnouncements(string $id)
    {
        $res = $this->companyRepository->getCompanyAnnouncements($id);
        return new AnnouncementCollection($res);
    }

    public function getCompanyComments(string $id)
    {
        $res = $this->companyRepository->getCompanyComments($id);
        $info['can_send_comment'] = false;
        $info['have_comment'] = false;
        $info['comment'] = null;

        return new CommentCollection($res, $info);
    }

    public function getCompanyCommentsForUsers(string $id, string $userId)
    {
        $res = $this->companyRepository->getCompanyCommentsWithoutUserComment($id, $userId);

        $userComment = $this->companyRepository->getUserComment($id, $userId);

        if(!$userComment)
        {
            $info['can_send_comment'] = true;
            $info['have_comment'] = false;
            $info['comment'] = null;
        }
        else {
            $info['can_send_comment'] = false;
            $info['have_comment'] = true;
            $info['comment'] = new CommentResource($userComment);
        }

        return new CommentCollection($res, $info);
    }

    public function storeCompanyComment(AddCommentRequest $request, string $userId)
    {
        $userComment = $this->companyRepository->getUserComment($request['company_id'], $userId);

        if($userComment) throw new Exception("Komentarz już został dodany!");

        $newComment = $this->companyRepository->storeCompanyComment($request, $userId);

        return new CommentResource($newComment);
    }

    public function updateCompanyComment(AddCommentRequest $request, string $userId, string $commentId)
    {
        $userComment = $this->companyRepository->getUserComment($request['company_id'], $userId);

        if($userComment['user_id'] !== intval($userId)) throw new Exception("Brak dostępu do zasobu!");

        $updatedComment = $this->companyRepository->updateCompanyComment($request, $commentId);

        return new CommentResource($updatedComment);
    }

    public function destroyCompanyComment(string $userId, string $commentId)
    {
        $userComment = $this->companyRepository->getCommentById($commentId);

        if(!$userComment) throw new Exception("Komentarz nie istnieje!");
        if($userComment['user_id'] !== intval($userId)) throw new Exception("Brak dostępu do zasobu!");

        $this->companyRepository->destroyCompanyComment($commentId);

        return ['message' => "Komentarz został usunięty!"];
    }
}