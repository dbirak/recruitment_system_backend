<?php

namespace App\Repositories;

use App\Http\Requests\AddAnnouncementRequest;
use App\Http\Requests\SearchAnnouncementRequest;
use App\Http\Resources\AnnouncementCollection;
use App\Models\Announcement;
use App\Models\Company;
use App\Models\Step;
use Carbon\Carbon;

class AnnouncementRepository {

    protected $announcement;
    protected $step;
    protected $company;

    public function __construct(Announcement $announcement, Step $step, Company $company)
    {
        $this->announcement = $announcement;
        $this->step = $step;
        $this->company = $company;
    }

    public function createAnnouncement(AddAnnouncementRequest $request, string $companyId)
    {
        $announcement = new Announcement();
        $announcement->name = $request['nazwa'];
        $announcement->description = $request['opis'];
        $announcement->duties = json_encode($request['obowiazki']);
        $announcement->requirements = json_encode($request['wymagania']);
        $announcement->offer = json_encode($request['oferta']);
        $announcement->expiry_date = $request['data_zakonczenia'];
        $announcement->min_earn = $request['min_wynagrodzenie'];
        $announcement->max_earn = $request['max_wynagrodzenie'];
        $announcement->earn_time_id = $request['typ_wynagrodzenia'] == 0 ? null : $request['typ_wynagrodzenia'];
        $announcement->contract_id = $request['umowa'];
        $announcement->company_id = intval($companyId); 
        $announcement->category_id = $request['kategoria'];
        $announcement->work_time_id = $request['czas_pracy'];
        $announcement->work_type_id = $request['typ_pracy'];
        $announcement->save();

        return $announcement;
    }

    public function getPopularAnnouncement()
    {
        return $this->announcement::where('expiry_date', '>=', Carbon::now()->setTimezone('Europe/Warsaw')->format('Y-m-d'))->orderBy('created_at', 'desc')->limit(8)->get();
    }

    public function getAnnouncementById(string $id)
    {
        return $this->announcement::where("id", $id)->where('expiry_date', '>=', Carbon::now()->setTimezone('Europe/Warsaw')->format('Y-m-d'))->first();
    }

    public function getAnnouncementByIdWhitoutExpiryDate(string $id)
    {
        return $this->announcement::where("id", $id)->first();
    }

    public function getAllAnnouncements()
    {
        return new AnnouncementCollection($this->announcement::paginate(2));
    }

    public function searchAnnouncement(SearchAnnouncementRequest $request)
    {
        $query = Announcement::query();

        if (empty($request['umowa']) && empty($request['typ_pracy']) && empty($request['czas_pracy']) && $request['kategoria'] === 0 && empty($request['nazwa']) && $request['min_wynagrodzenie'] === null && $request['max_wynagrodzenie'] === null && $request['typ_wynagrodzenia'] === 0) {
            return $announcements = Announcement::where('expiry_date', '>=', Carbon::now()->setTimezone('Europe/Warsaw')->format('Y-m-d'))->paginate(10);
        } 
        
        if (!empty($request['umowa'])) {
            $query->whereIn('contract_id', $request['umowa']);
        }   

        if (!empty($request['typ_pracy'])) {
            $query->whereIn('work_type_id', $request['typ_pracy']);
        } 

        if (!empty($request['czas_pracy'])) {
            $query->whereIn('work_time_id', $request['czas_pracy']);
        } 

        if ($request['kategoria'] !== 0) {
            $query->where('category_id', $request['kategoria']);
        } 

        if (!empty($request['nazwa'])) {
            $query->where('name', 'LIKE', "%".$request['nazwa']."%");

            $companies = $this->company::where("name", "LIKE", "%".$request['nazwa']."%")->get();

            $ids = [];
            foreach($companies as $company)
            {
                array_push($ids, (int) $company['id']);
            }
              
            if(!empty($ids)) $query->orWhereIn('company_id', $ids);
        } 

        if($request['min_wynagrodzenie'] !== null) {
            $query->where('min_earn', ">=", $request['min_wynagrodzenie']);
        }

        if($request['max_wynagrodzenie'] !== null) {
            $query->where('max_earn', "<=", $request['max_wynagrodzenie']);
        }

        if ($request['typ_wynagrodzenia'] !== 0) {
            $query->where('earn_time_id', $request['typ_wynagrodzenia']);
        }

        $query->where('expiry_date', '>=', Carbon::now()->setTimezone('Europe/Warsaw')->format('Y-m-d'));

        return $announcements = $query->paginate(6);
    }
}