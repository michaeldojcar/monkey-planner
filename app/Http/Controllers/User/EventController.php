<?php

namespace App\Http\Controllers\User;

use App\Event;
use App\Http\Controllers\Controller;
use App\Repositories\EventRepository;
use App\Repositories\GroupRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EventController extends Controller
{
    private $eventRepository;

    public function __construct(EventRepository $event_repository)
    {
        $this->eventRepository = $event_repository;

        $this->middleware('auth');
    }

    /**
     * My events.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        // Online users counter.
        $this->updateCounter();

        return view('user.events.index', [
            'upcoming_events' => $this->eventRepository->getUserUpcomingMotherEvents(Auth::user()),
            'previous_events' => $this->eventRepository->getUserPreviousMotherEvents(Auth::user()),

            'online' => User::where('updated_at', '>', Carbon::now()->subMinutes(5))->get(),

            'groups' => Auth::user()->groups->where('parent_group_id', null),
        ]);
    }

    public function create(GroupRepository $group_repository)
    {
        return view('user.events.create', [
            'groups' => $group_repository->motherGroupsForUser(Auth::user())->get()
        ]);
    }

    public function store(Request $request)
    {
        $event                   = new Event();
        $event->name             = $request->input('name');
        $event->type             = 0;
        $event->owner_group_id   = $request->input('owner_group_id');
        $event->short            = '';
        $event->content          = '';
        $event->from             = Carbon::now();
        $event->to               = Carbon::now();
        $event->arrangement_days = 1;

        $event->save();

        return redirect()->route('organize.dashboard', $event);
    }

    public function show()
    {

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
