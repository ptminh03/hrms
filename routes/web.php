<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

    Route::group(['prefix' => 'auth'], function()
    {
        Route::get('/login', 'AuthController@showLogin')->name('auth.login');
        Route::post('/login', 'AuthController@processLogin');
        Route::get('/logout', 'AuthController@processLogout')->name('auth.logout');
        Route::get('change-password', 'AuthController@showChangePassword')->name('auth.change-password');
        Route::post('change-password', 'AuthController@processChangePassword');
        Route::get('reset-password', 'AuthController@showResetPassword')->name('auth.reset-password');
        Route::post('reset-password', 'AuthController@processResetPassword');
    });
    
    Route::group(['middleware' => ['auth']], function ()
    {
        Route::get('/', 'AuthController@index')->name('index');
        Route::group(['prefix' => 'leave'], function()
        {
            Route::get('my-leave', 'LeaveController@showMyLeave')->name('leave.showMyLeave');
            Route::get('{leave}/detail', 'LeaveController@showDetails')->name('leave.showDetails');
            Route::get('register', 'LeaveController@showAdd')->name('leave.showAdd');
            Route::post('register', 'LeaveController@processAdd')->name('leave.processAdd');
        });

        Route::group(['prefix' => 'employee'], function()
        {
            Route::get('profile', 'EmployeeController@showMyProfile')->name('employee.showMyProfile');
            Route::get('profile/{profile}', 'EmployeeController@showProfile')->name('employee.showProfile');
            Route::get('department', 'EmployeeController@showDepartment')->name('employee.showDepartment');
            Route::get('/', 'EmployeeController@showAdd')->name('employee.showAdd');
        });

        Route::group(['prefix' => 'news'], function()
        {
            Route::get('/add', 'NewsController@showAdd')->name('news.showAdd');
            Route::post('/add', 'NewsController@processAdd');
        });
        Route::get('asset-register', 'AssetController@showAsset');
        
    });
    
    Route::get('hr-policy', ['as' => 'hr-policy', 'uses' => 'PolicyController@showPolicy']);
    
    // Route::get('/leave-type-listing', ['as' => 'leave-type-listing', 'uses' => 'LeaveController@showLeaveType']);









    //     //Routes for add-employees
    Route::get('add-employee', ['as' => 'add-employee', 'uses' => 'EmployeeController@showAdd']);

    // Route::post('add-employee', ['as' => 'add-employee', 'uses' => 'EmpController@processEmployee']);

    // Route::get('employee-manager', ['as' => 'employee-manager', 'uses' => 'EmpController@showEmployee']);

//     Route::post('employee-manager', 'EmpController@searchEmployee');

    // Route::get('upload-emp', ['as' => 'upload-emp', 'uses' => 'EmpController@importFile']);

//     Route::post('upload-emp', ['as' => 'upload-emp', 'uses' => 'EmpController@uploadFile']);

    // Route::get('edit-emp/{id}', ['as' => 'edit-emp', 'uses' => 'EmpController@showEdit']);

//     Route::post('edit-emp/{id}', ['as' => 'edit-emp', 'uses' => 'EmpController@doEdit']);

//     Route::get('delete-emp/{id}', ['as' => 'delete-emp', 'uses' => 'EmpController@doDelete']);


/** Routes for clients **/
    // Route::get('add-client', 'ClientController@addClient')->name('add-client');

//     Route::post('add-client', 'ClientController@saveClient');

    // Route::get('list-client', 'ClientController@listClients')->name('list-client');

//     Route::get('edit-client/{clientId}', 'ClientController@showEdit')->name('edit-client');

//     Route::post('edit-client/{clientId}', 'ClientController@saveClientEdit');


//     Route::get('delete-list/{clientId}', 'ClientController@doDelete');



//Route::group(['middleware' => ['web']], function () {

// Route::group(/*['middleware' => ['guest']], */function ()
// {

//     Route::get('/', 'AuthController@showLogin');

//     Route::post('/', 'AuthController@doLogin');

    

    // Route::get('register', 'AuthController@showRegister');


// });

// Route::group(['middleware' => ['auth']], function ()
// {

//     Route::get('home', 'HomeController@index');


//     Route::get('logout', 'AuthController@doLogout');

//     Route::get('welcome', 'AuthController@welcome');

//     Route::get('not-found', 'AuthController@notFound');



//     //Routes for add-employees
//     Route::get('add-employee', ['as' => 'add-employee', 'uses' => 'EmpController@addEmployee']);

//     Route::post('add-employee', ['as' => 'add-employee', 'uses' => 'EmpController@processEmployee']);

    // Route::get('employee-manager', ['as' => 'employee-manager', 'uses' => 'EmpController@showEmployee']);

//     Route::post('employee-manager', 'EmpController@searchEmployee');

//     Route::get('upload-emp', ['as' => 'upload-emp', 'uses' => 'EmpController@importFile']);

//     Route::post('upload-emp', ['as' => 'upload-emp', 'uses' => 'EmpController@uploadFile']);

//     Route::get('edit-emp/{id}', ['as' => 'edit-emp', 'uses' => 'EmpController@showEdit']);

//     Route::post('edit-emp/{id}', ['as' => 'edit-emp', 'uses' => 'EmpController@doEdit']);

//     Route::get('delete-emp/{id}', ['as' => 'delete-emp', 'uses' => 'EmpController@doDelete']);

//     //Routes for Bank Account details

//     Route::get('bank-account-details', ['uses' => 'EmpController@showDetails']);

//     Route::post('update-account-details', ['uses' => 'EmpController@updateAccountDetail']);

//     //Routes for Team.

    // Route::get('add-team', ['as' => 'add-team', 'uses' => 'TeamController@addTeam']);

//     Route::post('add-team', ['as' => 'add-team', 'uses' => 'TeamController@processTeam']);

    // Route::get('team-listing', ['as' => 'team-listing', 'uses' => 'TeamController@showTeam']);

//     Route::get('edit-team/{id}', ['as' => 'edit-team', 'uses' => 'TeamController@showEdit']);

//     Route::post('edit-team/{id}', ['as' => 'edit-team', 'uses' => 'TeamController@doEdit']);

//     Route::get('delete-team/{id}', ['as' => 'delete-team', 'uses' => 'TeamController@doDelete']);

//     //Routes for Role.

    // Route::get('add-role', ['as' => 'add-role', 'uses' => 'RoleController@addRole']);

//     Route::post('add-role', ['as' => 'add-role', 'uses' => 'RoleController@processRole']);

    // Route::get('role-list', ['as' => 'role-list', 'uses' => 'RoleController@showRole']);

//     Route::get('edit-role/{id}', ['as' => 'edit-role', 'uses' => 'RoleController@showEdit']);

//     Route::post('edit-role/{id}', ['as' => 'edit-role', 'uses' => 'RoleController@doEdit']);

//     Route::get('delete-role/{id}', ['as' => 'delete-role', 'uses' => 'RoleController@doDelete']);

//     //Routes for Expense.

    // Route::get('add-expense', ['as' => 'add-expense', 'uses' => 'ExpenseController@addExpense']);

//     Route::post('add-expense', ['as' => 'add-expense', 'uses' => 'ExpenseController@processExpense']);

    // Route::get('expense-list', ['as' => 'expense-list', 'uses' => 'ExpenseController@showExpense']);

//     Route::get('edit-expense/{id}', ['as' => 'edit-expense', 'uses' => 'ExpenseController@showEdit']);

//     Route::post('edit-expense/{id}', ['as' => 'edit-expense', 'uses' => 'ExpenseController@doEdit']);

//     Route::get('delete-expense/{id}', ['as' => 'delete-expense', 'uses' => 'ExpenseController@doDelete']);

//     //Routes for Leave.

    // Route::get('add-leave-type', ['as' => 'add-leave-type', 'uses' => 'LeaveController@addLeaveType']);

//     Route::post('add-leave-type', ['as' => 'add-leave-type', 'uses' => 'LeaveController@processLeaveType']);


//     Route::get('edit-leave-type/{id}', ['as' => 'edit-leave-type', 'uses' => 'LeaveController@showEdit']);

//     Route::post('edit-leave-type/{id}', ['as' => 'edit-leave-type', 'uses' => 'LeaveController@doEdit']);

//     Route::get('delete-leave-type/{id}', ['as' => 'delete-leave-type', 'uses' => 'LeaveController@doDelete']);


//     Route::post('apply-leave', ['as' => 'apply-leave', 'uses' => 'LeaveController@processApply']);


    // Route::get('total-leave-list', ['as' => 'total-leave-list', 'uses' => 'LeaveController@showAllLeave']);

//     Route::post('total-leave-list', 'LeaveController@searchLeave');

//     Route::get('leave-drafting', ['as' => 'leave-drafting', 'uses' => 'LeaveController@showLeaveDraft']);

//     Route::post('leave-drafting', ['as' => 'leave-drafting', 'uses' => 'LeaveController@createLeaveDraft']);

//     //Routes for Attendance.

    // Route::get('attendance-upload', ['as' => 'attendance-upload', 'uses' => 'AttendanceController@importAttendanceFile']);

//     Route::post('attendance-upload', ['as' => 'attendance-upload', 'uses' => 'AttendanceController@uploadFile']);

    // Route::get('attendance-manager', ['as' => 'attendance-manager', 'uses' => 'AttendanceController@showSheetDetails']);

//     Route::post('attendance-manager', ['as' => 'attendance-manager', 'uses' => 'AttendanceController@searchAttendance']);

//     Route::get('delete-file/{id}', ['as' => 'delete-file', 'uses' => 'AttendanceController@doDelete']);

//     //Routes for Assets.

    // Route::get('add-asset', ['as' => 'add-asset', 'uses' => 'AssetController@addAsset']);

//     Route::post('add-asset', ['as' => 'add-asset', 'uses' => 'AssetController@processAsset']);

    // Route::get('asset-listing', ['as' => 'asset-listing', 'uses' => 'AssetController@showAsset']);

//     Route::get('edit-asset/{id}', ['as' => 'edit-asset', 'uses' => 'AssetController@showEdit']);

//     Route::post('edit-asset/{id}', ['as' => 'edit-asset', 'uses' => 'AssetController@doEdit']);

//     Route::get('delete-asset/{id}', ['as' => 'delete-asset', 'uses' => 'AssetController@doDelete']);

    // Route::get('assign-asset', ['as' => 'assign-asset', 'uses' => 'AssetController@doAssign']);

//     Route::post('assign-asset', ['as' => 'assign-asset', 'uses' => 'AssetController@processAssign']);

    // Route::get('assignment-listing', ['as' => 'assignment-listing', 'uses' => 'AssetController@showAssignment']);

//     Route::get('edit-asset-assignment/{id}', ['as' => 'edit-asset-assignment', 'uses' => 'AssetController@showEditAssign']);

//     Route::post('edit-asset-assignment/{id}', ['as' => 'edit-asset-assignment', 'uses' => 'AssetController@doEditAssign']);

//     Route::get('delete-asset-assignment/{id}', ['as' => 'delete-asset-assignment', 'uses' => 'AssetController@doDeleteAssign']);


//     Route::get('download-forms', ['as' => 'download-forms', 'uses' => 'IndexController@showForms']);

//     Route::get('download/{name}', 'DownloadController@downloadForms');

//     Route::get('calendar', 'AuthController@calendar');

//     //Routes for Leave and Holiday.

//     Route::post('get-leave-count', 'LeaveController@getLeaveCount');

//     Route::post('approve-leave', 'LeaveController@approveLeave');

//     Route::post('disapprove-leave', 'LeaveController@disapproveLeave');

//     Route::get('add-holidays', 'LeaveController@showHolidays');

//     Route::post('add-holidays', 'LeaveController@processHolidays');

//     Route::get('holiday-listing', 'LeaveController@showHoliday');

//     Route::get('edit-holiday/{id}', 'LeaveController@showEditHoliday');

//     Route::post('edit-holiday/{id}', 'LeaveController@doEditHoliday');

//     Route::get('delete-holiday/{id}', 'LeaveController@deleteHoliday');

// });

Auth::routes();
