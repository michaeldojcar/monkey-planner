<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Public routes.
 */

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserGroupController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Inventory\ItemController;
use App\Http\Controllers\Inventory\ItemPlaceController;
use App\Http\Controllers\Inventory\ItemStateController;
use App\Http\Controllers\Inventory\SearchController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\Manage\BlockController;
use App\Http\Controllers\Manage\DashController;
use App\Http\Controllers\Manage\EventController as ManageEventController;
use App\Http\Controllers\Manage\EventTimeController;
use App\Http\Controllers\Manage\MemberController;
use App\Http\Controllers\Manage\MemberStatsController;
use App\Http\Controllers\Manage\PrintableProgramController;
use App\Http\Controllers\Manage\ProgramController;
use App\Http\Controllers\Manage\TaskController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\EventController;
use App\Http\Controllers\User\GroupController;
use App\Http\Controllers\User\InventoryController as UserInventoryController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckEmptyPwd;

Auth::routes();
Route::get('/', [LoginController::class, 'showLoginForm'])->name('root');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

/**
 * Logged user space.
 */
Route::group([
    'middleware' => [Authenticate::class, CheckEmptyPwd::class],
    'as'         => 'user.',
], function ()
{
    Route::get('/user/dash', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::resource('/user/events', EventController::class);
    Route::resource('/user/groups', GroupController::class);
    Route::get('/user/inventories', [UserInventoryController::class, 'index'])->name('inventories.index');
});

Route::get('/ucet/init-pwd', [UserSettingsController::class, 'emptyPassword'])->name('new-pwd');
Route::post('/ucet/init-pwd', [UserSettingsController::class, 'storeNewPassword'])->name('new-pwd');

/**
 * Single inventory (item place).
 */
Route::group([
    'middleware' => [Authenticate::class, CheckEmptyPwd::class],
    'as'         => 'inventory.',
    'prefix' => '/inventory/{group_id}'
], function ()
{
    Route::get('/dashboard', [\App\Http\Controllers\Inventory\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/search', [SearchController::class, 'search'])->name('search');

    Route::resource('/item_places', ItemPlaceController::class);
    Route::resource('/item-states', ItemStateController::class);
    Route::resource('/items', ItemController::class);
    Route::resource('/categories', ItemCategoryController::class);
    Route::post('/items/upload-photo', [ItemController::class, 'uploadPhoto'])->name('items.upload-photo');


});

/**
 * Single event management.
 */
Route::group([
    'middleware' => [Authenticate::class, CheckEmptyPwd::class],
    'as'         => 'organize.',
], function ()
{
    Route::get('/event/{event}/nastenka', [DashController::class, 'dashboard'])->name('dashboard');

    // Tasks.
    Route::get('/event/{event}/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/event/{event}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/event/{event}/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/event/{event}/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::post('/event/{event}/tasks/{task}/edit', [TaskController::class, 'update'])->name('tasks.update');
    Route::get('/tasks/{task}/delete', [TaskController::class, 'delete'])->name('tasks.delete');

    Route::get('/tasks/{task}/assign_me', [TaskController::class, 'assignMe'])->name('task.assignMe');
    Route::get('/tasks/{task}/user/{user}/detach', [TaskController::class, 'userDetach'])->name('task.detach');
    Route::get('/tasks/{task}/status_update', [TaskController::class, 'cycleStatus'])->name('task.cycle');


    // To-do view
    Route::get('/event/{event}/todo', [TaskController::class, 'todo'])->name('todo');
    Route::get('/event/{event}/work_stats', [MemberStatsController::class, 'workStats'])->name('work_stats');

    // Sub groups.
    Route::get('/event/{event}/informace', [BlockController::class, 'index'])->name('blocks');

    // Program
    Route::get('/event/{event}/program', [ProgramController::class, 'program'])->name('program');
    Route::get('/event/{event}/day/{day}', [ProgramController::class, 'programForDay'])->name('program.day');
    Route::get('/event/{event}/calendar', [ProgramController::class, 'calendar'])->name('program.calendar');
    Route::get('/api/event/{event}/calendar', [ProgramController::class, 'calendarApiIndex']);
    Route::post('/api/event/{event}/calendar', [ProgramController::class, 'storeCalendar']);


    // Events
    Route::post('/event/{event}/sub-event', [ManageEventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/sub-event/{sub_event}', [ManageEventController::class, 'show'])->name('events.show');
    Route::get('/event/{event}/sub-event/{sub_event}/edit', [ManageEventController::class, 'edit'])->name('events.edit');
    Route::post('/sub-event/{sub_event}/edit', [ManageEventController::class, 'update'])->name('events.update');
    Route::get('/sub-event/{sub_event}/delete', [ManageEventController::class, 'delete'])->name('events.delete');


    Route::get('/event_times/{id}/create', [EventTimeController::class, 'create'])->name('event_times.create');
    Route::get('/event_times/{id}/delete', [EventTimeController::class, 'destroy'])->name('event_times.destroy');

    // Event times

    // Program printable
    Route::get('/event/{event}/program/print',
        [PrintableProgramController::class, 'index'])->name('program.print.index');
    Route::get('/event/{event}/program/print/master',
        [PrintableProgramController::class, 'master'])->name('program.print');
    Route::get('/event/{event}/program/print/user/{user}',
        [PrintableProgramController::class, 'masterForUser'])->name('program.print');
    Route::get('/event/{event}/program/print/day/{day}/user/{user}',
        [PrintableProgramController::class, 'dailyForUser'])->name('program.print.daily');

    Route::get('/event/{event}/program/print/master/mass',
        [PrintableProgramController::class, 'masterMass'])->name('program.print.master.mass');
    Route::get('/event/{event}/program/print/day/{day}/mass',
        [PrintableProgramController::class, 'dailyMass'])->name('program.print.daily.mass');

    Route::get('/event/{event}/program/print/day/{day}/poster',
        [PrintableProgramController::class, 'dailyPoster'])->name('program.print.daily.poster');

    // Role in events
    Route::get('/role/{task}/user/{user}/assign',
        [EventController::class, 'userTaskAssign'])->name('event.roleAssignUser');
    Route::get('/role/{task}/user/{user}/detach', [ManageEventController::class, 'userTaskDetach'])
        ->name('event.roleUnassignUser');

    // Quick assign/detach of event author/garant
    Route::get('/event/{event}/user/{user}/assignAuthor', [ManageEventController::class, 'authorAssign'])
        ->name('event.authorAssignUser');
    Route::get('/event/{event}/user/{user}/detachAuthor', [ManageEventController::class, 'authorDetach'])
        ->name('event.authorDetachUser');
    Route::get('/event/{event}/user/{user}/assignGarant', [ManageEventController::class, 'garantAssign'])
        ->name('event.garantAssignUser');
    Route::get('/event/{event}/user/{user}/detachGarant', [ManageEventController::class, 'garantDetach'])
        ->name('event.garantDetachUser');
    Route::post('/event/{event}/createTask',
        [ManageEventController::class, 'taskCreateAndAssign'])->name('event.task.create');

    // Event blocks
    Route::post('/event/{event}/sub-event/{sub_event}/block',
        [BlockController::class, 'storeBlock'])->name('blocks.store');
    Route::get('/event/{event}/sekce/{block}/edit', [BlockController::class, 'editBlock'])->name('blocks.edit');
    Route::post('/event/{event}/sekce/{block}/update', [BlockController::class, 'updateBlock'])->name('blocks.update');
    Route::get('/event/{event}/sekce/{block}/delete', [BlockController::class, 'deleteBlock'])->name('blocks.delete');

    // Info blocks
    Route::get('/event/{event}/informace', [BlockController::class, 'index'])->name('blocks');

    // Members
    Route::get('/event/{event}/clenove', [MemberController::class, 'index'])->name('members');

    // Subgroup views
    Route::get('/event/{event}/subgroup/{subgroup}/nastenka', [DashController::class, 'subGroupDashboard'])
        ->name('dashboard.subGroup');
    Route::post('/event/{event}/subgroup/{subgroup}/addBlock', [BlockController::class, 'storeSubGroupBlock'])
        ->name('subGroup.addBlock');
});

/**
 * Admin.
 */
Route::group([
    'prefix'     => 'admin',
    'as'         => 'admin.',
    'middleware' => [Authenticate::class, CheckEmptyPwd::class],
], function ()
{
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Users
    Route::resource('users', UserController::class);
    Route::get('/users/{user}/groups', [UserGroupController::class, 'edit'])->name('users.groups');
    Route::patch('/users/{user}/groups', [UserGroupController::class, 'update'])->name('users.groups.update');

    // TODO: Group (bread)
    Route::resource('groups', 'Admin\GroupController');
});

/**
 * Portal admin routes.
 */
//Route::get('/admin/uzivatele', 'AdminController::class, 'users'])->name('admin.users');


//Route::get('/admin/udalost/status/{event_id}/{user_id}/{status}', [DashController::class, 'setUserEventStatus'])
//    ->name('event.participate.admin');
//Route::get('/admin/udalost/{event_id}/add/members/{status}', [DashController::class, 'addEventGroupMembersWithStatus'])
//    ->name('admin.event.add.members');
//Route::get('/admin/udalost/{event_id}/notif', [DashController::class, 'sendMembersSms'])->name('admin.event.sms');
//Route::post('/admin/udalost/sms/custom', [DashController::class, 'sendMembersSmsCustom'])->name('admin.event.sms.custom');
//
//

