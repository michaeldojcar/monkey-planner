<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\EventRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * @var EventRepository
     */
    private $eventRepository;


    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }


    public function dashboard()
    {
        // Online users counter.
        $this->updateCounter();

        return view('user.dashboard.index', [
            'upcoming_events' => $this->eventRepository->getUserUpcomingMotherEvents(Auth::user()),
            'previous_events' => $this->eventRepository->getUserPreviousMotherEvents(Auth::user()),

            'online' => User::where('updated_at', '>', Carbon::now()->subMinutes(5))->get(),

            'groups' => Auth::user()->groups->where('parent_group_id', null),
        ]);
    }

    /**
     * Refresh updated_at for authenticated user.
     */
    private function updateCounter()
    {
        $user             = Auth::user();
        $user->updated_at = Carbon::now('europe/prague');
        $user->save();
    }
}
