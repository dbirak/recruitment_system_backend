<?php

namespace App\Repositories;

use App\Http\Requests\AddAnnouncementRequest;
use App\Models\Announcement;
use App\Models\Step;
use Carbon\Carbon;

class AnnouncementRepository {

    protected $announcement;
    protected $step;

    public function __construct(Announcement $announcement, Step $step)
    {
        $this->announcement = $announcement;
        $this->step = $step;
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
}