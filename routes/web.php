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

Auth::routes();
Route::get('/', 'Auth\LoginController@showLoginForm')->name('root');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/register', 'Auth\RegisterController@register')->name('register');

/**
 * Logged user space.
 */
Route::group(['as' => 'user.'], function ()
{
    Route::resource('/user/events', 'User\EventController');
    Route::resource('/user/groups', 'User\GroupController');
});


/**
 * Event management.
 */
Route::group(['middleware' => 'auth'], function ()
{
    Route::get('/event/{event}/nastenka', 'Manage\DashController@dashboard')->name('organize.dashboard');

    // Tasks.
    Route::get('/event/{event}/ukoly', 'Manage\TaskController@index')->name('organize.tasks');
    Route::post('/event/{event}/ukoly', 'Manage\TaskController@store')->name('organize.tasks');
    Route::get('/event/{event}/ukol/{task}', 'Manage\TaskController@show')->name('organize.task.show');
    Route::get('/event/{event}/ukol/{task}/edit', 'Manage\TaskController@edit')->name('organize.task');
    Route::post('/event/{event}/ukol/{task}/edit', 'Manage\TaskController@update')->name('organize.task');
    Route::get('/ukol/{task}/assign_me', 'Manage\TaskController@assignMe')->name('organize.task.assignMe');
    Route::get('/ukol/{task}/user/{user}/detach', 'Manage\TaskController@userDetach')->name('organize.task.detach');
    Route::get('/ukol/{task}/status_update', 'Manage\TaskController@cycleStatus')->name('organize.task.cycle');
    Route::get('/event/{event}/ukol/{task}/delete', 'Manage\TaskController@delete')->name('organize.task.delete');

    // To-do view
    Route::get('/event/{event}/todo', 'Manage\TaskController@todo')->name('organize.todo');

    Route::get('/event/{event}/work_stats', 'Manage\MemberStatsController@workStats')->name('organize.work_stats');

    // Sub groups.
    Route::get('/event/{event}/informace', 'Manage\BlockController@index')->name('organize.blocks');

    // Sub events.
    Route::get('/event/{event}/program/', 'Manage\EventPlanController@program')->name('organize.program');
    Route::post('/event/{event}/program', 'Manage\EventPlanController@store')->name('organize.program');
    Route::get('/event/{event}/udalost/{event}', 'Manage\EventPlanController@show')->name('organize.event');
    Route::get('/event/{event}/udalost/{event}/edit', 'Manage\EventPlanController@edit')->name('organize.event.edit');
    Route::post('/event/{event}/udalost/{event}/edit',
        'Manage\EventPlanController@update')->name('organize.event.edit.store');
    Route::get('/event/{event}/udalost/{event}/delete',
        'Manage\EventPlanController@delete')->name('organize.event.delete');
    Route::post('/event/{event}/storeRole', 'Manage\EventController@storeRole')->name('organize.event.storeRole');

    // Program printable
    Route::get('/event/{event}/program/print',
        'Manage\PrintableProgramController@index')->name('organize.program.print.index');
    Route::get('/event/{event}/program/print/master',
        'Manage\PrintableProgramController@master')->name('organize.program.print');
    Route::get('/event/{event}/program/print/user/{user}',
        'Manage\PrintableProgramController@masterForUser')->name('organize.program.print');
    Route::get('/event/{event}/program/print/day/{day}/user/{user}',
        'Manage\PrintableProgramController@dailyForUser')->name('organize.program.print.daily');

    Route::get('/event/{event}/program/print/master/mass',
        'Manage\PrintableProgramController@masterMass')->name('organize.program.print.master.mass');
    Route::get('/event/{event}/program/print/day/{day}/mass',
        'Manage\PrintableProgramController@dailyMass')->name('organize.program.print.daily.mass');

    Route::get('/event/{event}/program/print/day/{day}/poster',
        'Manage\PrintableProgramController@dailyPoster')->name('organize.program.print.daily.poster');

    // Role in events
    Route::get('/role/{task}/user/{user}/assign',
        'Manage\EventController@userTaskAssign')->name('organize.event.roleAssignUser');
    Route::get('/role/{task}/user/{user}/detach', 'Manage\EventController@userTaskDetach')
         ->name('organize.event.roleUnassignUser');

    // Quick assign/detach of event author/garant
    Route::get('/event/{event}/user/{user}/assignAuthor', 'Manage\EventController@authorAssign')
         ->name('organize.event.authorAssignUser');
    Route::get('/event/{event}/user/{user}/detachAuthor', 'Manage\EventController@authorDetach')
         ->name('organize.event.authorDetachUser');
    Route::get('/event/{event}/user/{user}/assignGarant', 'Manage\EventController@garantAssign')
         ->name('organize.event.garantAssignUser');
    Route::get('/event/{event}/user/{user}/detachGarant', 'Manage\EventController@garantDetach')
         ->name('organize.event.garantDetachUser');
    Route::post('/event/{event}/createTask',
        'Manage\EventController@taskCreateAndAssign')->name('organize.event.task.create');

    // Event blocks
    Route::post('/event/{event}/udalost/{event}/addBlock',
        'Manage\EventPlanController@storeBlock')->name('organize.event.addBlock');
    Route::get('/event/{event}/sekce/{block}/edit',
        'Manage\EventPlanController@editBlock')->name('organize.block.edit');
    Route::post('/event/{event}/sekce/{block}/update', 'Manage\EventPlanController@updateBlock')
         ->name('organize.event.updateBlock');
    Route::get('/event/{event}/sekce/{block}/delete',
        'Manage\EventPlanController@deleteBlock')->name('organize.block.delete');

    // Info blocks
    // TODO:
    Route::get('/event/{event}/informace', 'Manage\BlockController@index')->name('organize.blocks');

    // Members
    Route::get('/event/{event}/clenove', 'Manage\MemberController@index')->name('organize.members');

    // Subgroup views
    Route::get('/event/{event}/subgroup/{subgroup}/nastenka', 'Manage\DashController@subGroupDashboard')
         ->name('organize.dashboard.subGroup');
    Route::post('/event/{event}/sugroup/{subgroup}/addBlock', 'Manage\BlockController@storeSubGroupBlock')
         ->name('organize.subGroup.addBlock');
});

/**
 * Admin.
 */
Route::group(['prefix' => 'admin', 'as' => 'admin'], function ()
{
    Route::get('/', 'Admin\AdminController@dashboard')->name('admin.dashboard');

    // Users
    Route::resource('users', 'Admin\UserController', ['as' => 'admin']);
    Route::get('/users/{user}/groups', 'Admin\UserGroupController@edit')->name('admin.users.groups');
    Route::patch('/users/{user}/groups', 'Admin\UserGroupController@update')->name('admin.users.groups.update');

    // TODO: Group (bread)
    Route::resource('groups', 'Admin\GroupController', ['as' => 'admin']);

    // TODO: Event (bread)
    Route::resource('events', 'Admin\EventController', ['as' => 'admin']);
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



