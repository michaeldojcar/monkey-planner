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

use App\Http\Middleware\CheckEmptyPwd;

Auth::routes();
Route::get('/', 'Auth\LoginController@showLoginForm')->name('root');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/register', 'Auth\RegisterController@register')->name('register');

/**
 * Logged user space.
 */
Route::group(['middleware' => ['auth', CheckEmptyPwd::class], 'as' => 'user.'], function ()
{
    Route::resource('/user/events', 'User\EventController');
    Route::resource('/user/groups', 'User\GroupController');
});

Route::get('/ucet/init-pwd', 'UserSettingsController@emptyPassword')->name('new-pwd');
Route::post('/ucet/init-pwd', 'UserSettingsController@storeNewPassword')->name('new-pwd');

/**
 * Event management.
 */
Route::group(['middleware' => ['auth', CheckEmptyPwd::class], 'as' => 'organize.'], function ()
{
    Route::get('/event/{event}/nastenka', 'Manage\DashController@dashboard')->name('dashboard');

    // Tasks.
    Route::get('/event/{event}/tasks', 'Manage\TaskController@index')->name('tasks.index');
    Route::post('/event/{event}/tasks', 'Manage\TaskController@store')->name('tasks.store');
    Route::get('/event/{event}/tasks/{task}', 'Manage\TaskController@show')->name('tasks.show');
    Route::get('/event/{event}/tasks/{task}/edit', 'Manage\TaskController@edit')->name('tasks.edit');
    Route::post('/evemt/{event}/tasks/{task}/edit', 'Manage\TaskController@update')->name('tasks.update');
    Route::get('/tasks/{task}/delete', 'Manage\TaskController@delete')->name('tasks.delete');

    Route::get('/tasks/{task}/assign_me', 'Manage\TaskController@assignMe')->name('task.assignMe');
    Route::get('/tasks/{task}/user/{user}/detach', 'Manage\TaskController@userDetach')->name('task.detach');
    Route::get('/tasks/{task}/status_update', 'Manage\TaskController@cycleStatus')->name('task.cycle');


    // To-do view
    Route::get('/event/{event}/todo', 'Manage\TaskController@todo')->name('todo');
    Route::get('/event/{event}/work_stats', 'Manage\MemberStatsController@workStats')->name('work_stats');

    // Sub groups.
    Route::get('/event/{event}/informace', 'Manage\BlockController@index')->name('blocks');

    // Program
    Route::get('/event/{event}/program', 'Manage\ProgramController@program')->name('program');
    Route::get('/event/{event}/calendar', 'Manage\ProgramController@calendar')->name('program.calendar');
    Route::get('/api/event/{event}/calendar', 'Manage\ProgramController@calendarApiIndex');
    Route::post('/api/event/{event}/calendar', 'Manage\ProgramController@storeCalendar');


    // Events
    Route::post('/event/{event}/sub-event', 'Manage\EventController@store')->name('events.store');
    Route::get('/events/{event}/sub-event/{sub_event}', 'Manage\EventController@show')->name('events.show');
    Route::get('/event/{event}/sub-event/{sub_event}/edit', 'Manage\EventController@edit')->name('events.edit');
    Route::post('/sub-event/{sub_event}/edit', 'Manage\EventController@update')->name('events.update');
    Route::get('/sub-event/{sub_event}/delete', 'Manage\EventController@delete')->name('events.delete');


    Route::get('/event_times/{id}/create', 'Manage\EventTimeController@create')->name('event_times.create');
    Route::get('/event_times/{id}/delete', 'Manage\EventTimeController@destroy')->name('event_times.destroy');

    // Event times

    // Program printable
    Route::get('/event/{event}/program/print',
        'Manage\PrintableProgramController@index')->name('program.print.index');
    Route::get('/event/{event}/program/print/master',
        'Manage\PrintableProgramController@master')->name('program.print');
    Route::get('/event/{event}/program/print/user/{user}',
        'Manage\PrintableProgramController@masterForUser')->name('program.print');
    Route::get('/event/{event}/program/print/day/{day}/user/{user}',
        'Manage\PrintableProgramController@dailyForUser')->name('program.print.daily');

    Route::get('/event/{event}/program/print/master/mass',
        'Manage\PrintableProgramController@masterMass')->name('program.print.master.mass');
    Route::get('/event/{event}/program/print/day/{day}/mass',
        'Manage\PrintableProgramController@dailyMass')->name('program.print.daily.mass');

    Route::get('/event/{event}/program/print/day/{day}/poster',
        'Manage\PrintableProgramController@dailyPoster')->name('program.print.daily.poster');

    // Role in events
    Route::get('/role/{task}/user/{user}/assign',
        'Manage\EventController@userTaskAssign')->name('event.roleAssignUser');
    Route::get('/role/{task}/user/{user}/detach', 'Manage\EventController@userTaskDetach')
         ->name('event.roleUnassignUser');

    // Quick assign/detach of event author/garant
    Route::get('/event/{event}/user/{user}/assignAuthor', 'Manage\EventController@authorAssign')
         ->name('event.authorAssignUser');
    Route::get('/event/{event}/user/{user}/detachAuthor', 'Manage\EventController@authorDetach')
         ->name('event.authorDetachUser');
    Route::get('/event/{event}/user/{user}/assignGarant', 'Manage\EventController@garantAssign')
         ->name('event.garantAssignUser');
    Route::get('/event/{event}/user/{user}/detachGarant', 'Manage\EventController@garantDetach')
         ->name('event.garantDetachUser');
    Route::post('/event/{event}/createTask',
        'Manage\EventController@taskCreateAndAssign')->name('event.task.create');

    // Event blocks
    Route::post('/event/{event}/sub-event/{sub_event}/block',
        'Manage\BlockController@storeBlock')->name('blocks.store');
    Route::get('/event/{event}/sekce/{block}/edit', 'Manage\BlockController@editBlock')->name('blocks.edit');
    Route::post('/event/{event}/sekce/{block}/update', 'Manage\BlockController@updateBlock')->name('blocks.update');
    Route::get('/event/{event}/sekce/{block}/delete', 'Manage\BlockController@deleteBlock')->name('blocks.delete');

    // Info blocks
    Route::get('/event/{event}/informace', 'Manage\BlockController@index')->name('blocks');

    // Members
    Route::get('/event/{event}/clenove', 'Manage\MemberController@index')->name('members');

    // Subgroup views
    Route::get('/event/{event}/subgroup/{subgroup}/nastenka', 'Manage\DashController@subGroupDashboard')
         ->name('dashboard.subGroup');
    Route::post('/event/{event}/subgroup/{subgroup}/addBlock', 'Manage\BlockController@storeSubGroupBlock')
         ->name('subGroup.addBlock');
});

/**
 * Admin.
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function ()
{
    Route::get('/', 'Admin\AdminController@dashboard')->name('dashboard');

    // Users
    Route::resource('users', 'Admin\UserController');
    Route::get('/users/{user}/groups', 'Admin\UserGroupController@edit')->name('users.groups');
    Route::patch('/users/{user}/groups', 'Admin\UserGroupController@update')->name('users.groups.update');

    // TODO: Group (bread)
    Route::resource('groups', 'Admin\GroupController');

    // TODO: Event (bread)
    Route::resource('events', 'Admin\EventController');
});

/**
 * Portal admin routes.
 */
//Route::get('/admin/uzivatele', 'AdminController@users')->name('admin.users');
Route::get('/admin/udalost/status/{event_id}/{user_id}/{status}', 'DashController@setUserEventStatus')
     ->name('event.participate.admin');
Route::get('/admin/udalost/{event_id}/add/members/{status}', 'DashController@addEventGroupMembersWithStatus')
     ->name('admin.event.add.members');
Route::get('/admin/udalost/{event_id}/notif', 'DashController@sendMembersSms')->name('admin.event.sms');
Route::post('/admin/udalost/sms/custom', 'DashController@sendMembersSmsCustom')->name('admin.event.sms.custom');



