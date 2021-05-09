<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Inertia\Inertia;

class ActivityController extends Controller
{
    protected $activity;

    public function __construct()
    {
        $this->activity = new Activity();
    }

    public function index()
    {
        $activities = $this->activity->getFriendsActivity();

        if (count($activities->items()) === 0) {
            $followActiveMembers = false;
            $activities = $this->activity->getMyActivity();
        }

        return Inertia::render('Activity', [
            'followActiveMembers' => $followActiveMembers ?? true,
            'activities' => $activities->items(),
            'page' => ['actual' => $activities->currentPage(), 'last' => $activities->lastPage()]
        ]);
    }
}
