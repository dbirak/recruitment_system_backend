<?php

namespace App\Services;

use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterCompanyRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\SearchCompanyRequest;
use App\Http\Requests\UpdateCompanyProfileRequest;
use App\Http\Resources\AnnouncementCollection;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyProfileResource;
use App\Http\Resources\UserResource;
use App\Repositories\AnnouncementRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\FileTaskRepository;
use App\Repositories\OpenTaskRepository;
use App\Repositories\StepRepository;
use App\Repositories\TestTaskRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CompanyService {

    protected $userRepository;
    protected $companyRepository;
    protected $announcementRepository;
    protected $stepRepository;

    protected $testTaskRepository;
    protected $openTaskRepository;
    protected $fileTaskRepository;

    public function __construct(UserRepository $userRepository, CompanyRepository $companyRepository, AnnouncementRepository $announcementRepository, StepRepository $stepRepository, TestTaskRepository $testTaskRepository, OpenTaskRepository $openTaskRepository, FileTaskRepository $fileTaskRepository)
    {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
        $this->announcementRepository = $announcementRepository;
        $this->stepRepository = $stepRepository;

        $this->testTaskRepository = $testTaskRepository;
        $this->openTaskRepository = $openTaskRepository;
        $this->fileTaskRepository = $fileTaskRepository;
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

    public function searchCompany(SearchCompanyRequest $request)
    {
        return new CompanyCollection($this->companyRepository->searchCompany($request));
    }

    public function getStatistics(string $userId)
    {
        $company = $this->companyRepository->getCompanyByUserId($userId);

        $res['company_id'] = $company['id'];
        $res['announcement_count'] = $this->announcementRepository->getAnnouncementsCountByCompanyId($company['id']);

        $activeAnnouncements = 0;
        $inAnnouncements = 0;
        $endedAnnouncements = 0;

        $announcements = $this->announcementRepository->getAnnouncememntByCompanyId($company['id']);

        foreach ($announcements as $announcement)
        {
            $steps = $this->stepRepository->getStepsFromAnnouncement($announcement['id']);

            if($steps[0]['is_active'] === 1) $activeAnnouncements++;
            if($steps[count($steps) - 1]['is_active'] === 0) $endedAnnouncements++;
            if($steps[count($steps) - 1]['is_active'] !== 0 && $steps[0]['is_active'] === 0) $inAnnouncements++;
        }

        $res['active_announcement_count'] = $activeAnnouncements;
        $res['in_announcement_count'] = $inAnnouncements;
        $res['end_announcement_count'] = $endedAnnouncements;

        $res['comments'] = CommentResource::collection($this->companyRepository->getTwoLatestComments($company['id']));
        
        $res['five_star_comments_count'] = $this->companyRepository->getCommentsCountByRating($company['id'], 5);
        $res['four_star_comments_count'] = $this->companyRepository->getCommentsCountByRating($company['id'], 4);
        $res['three_star_comments_count'] = $this->companyRepository->getCommentsCountByRating($company['id'], 3);
        $res['two_star_comments_count'] = $this->companyRepository->getCommentsCountByRating($company['id'], 2);
        $res['one_star_comments_count'] = $this->companyRepository->getCommentsCountByRating($company['id'], 1);
        
        $res['comments_counter'] = $res['five_star_comments_count'] + $res['four_star_comments_count'] + $res['three_star_comments_count'] + $res['two_star_comments_count'] + $res['one_star_comments_count'];

        $comments = $this->companyRepository->getCompanyAllComments($company['id']);

        if(count($comments) === 0) $res['avarage_star'] = "-";
        else
        {
            $avg = 0;
            foreach ($comments as $comment)
            {
                $avg += $comment['rating'];
            }

            $avg = round($avg / count($comments), 2); 
            $res['avarage_star'] = $avg;
        }

        $testsCount = $this->testTaskRepository->getTestsCountById($userId);
        $openTasksCount = $this->openTaskRepository->getOpenTasksCountById($userId);
        $fileTasksCount = $this->fileTaskRepository->getFileTasksCountById($userId);

        $res['modules_count'] = $testsCount + $openTasksCount + $fileTasksCount;
        $res['tests_count'] = $testsCount;
        $res['open_tasks_count'] = $openTasksCount;
        $res['file_tasks_count'] = $fileTasksCount;
        
        return $res;
    }
}