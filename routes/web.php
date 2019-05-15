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
//
//Route::get('/welcome', function () {
//    return view('welcome');
//});

Route::get('/', 'HomeController@login')->name('login');
Route::get('/refer/{fast_key}', 'HomeController@login')->name('referLogin');
//Route::get('/admin', 'HomeController@index')->name('admin_login');
Route::post('/userlogin', 'HomeController@userLogin')->name('userLogin');
Route::get('/share/score/{fast_key}', 'HomeController@userSharedScorePage');
Route::get('/userlogout', 'HomeController@getlogout')->name('logout');
Route::post('/register/{key}', 'HomeController@Adduser')->name('Adduser');
Route::post('/registered/username', 'HomeController@Useravailability')->name('Useravailability');
//Route::post('/registered', 'HomeController@Adduser')->name('Adduser');

Route::get('admin/forget', 'HomeController@forgetpassword')->name('login.password.email');
Route::get('reset/password/{token}', 'HomeController@ShowResetFormLink');
Route::get('reset/password/', 'HomeController@tokenverify')->name('reset_form');
Route::post('change/password', 'HomeController@changePassword');

Route::group(['middleware' => ['isAdmin']], function () {
    Route::get('/home', function () {
        return view('admin.home.home');
    });

    Route::get('/myprofile', 'HomeController@adminprofile');
    Route::post('/admin/profile_update', 'HomeController@profileAdminupdate')->name('adminProfileUpdate');
    Route::post('/change/admin_password', 'HomeController@changeAdminProfilePassword')->name('changeadminprofilePassword');
    Route::get('get_users_data', 'HomeController@getAllUsersdata');
    Route::get('/categories', 'Admin\CategeriesController@index')->name('category');
    Route::post('/add/category', 'Admin\CategeriesController@store')->name('addcategory');
    Route::get('/category/show', 'Admin\CategeriesController@show');
    Route::get('/category/edit', 'Admin\CategeriesController@edit');
    Route::post('/category/status', 'Admin\CategeriesController@CategoryStatus');
    Route::post('/category/destroy', 'Admin\CategeriesController@destroy');
    /* --------- Countries ------------------------- */
    Route::get('/countries', 'Admin\CountriesController@index')->name('allcountry');
    Route::get('countries/show', 'Admin\CountriesController@getCountry');
    Route::post('countries/store', 'Admin\CountriesController@addcountry')->name('saveCountry');
    Route::get('countries/edit', 'Admin\CountriesController@edit')->name('EditCountry');
    Route::post('countries/activate', 'Admin\CountriesController@activate')->name('activateCountry');
    Route::post('countries/deactivate', 'Admin\CountriesController@deactivate')->name('deactivateCountry');
    /* --------- End Countries ---------------------- */
    /* --------- Users ------------------------- */
    Route::get('/users', 'Admin\UsersController@index')->name('getusers');
    Route::post('/add/user', 'Admin\UsersController@store')->name('adduser');
    Route::get('/users/show', 'Admin\UsersController@show');
    Route::get('/user/edit', 'Admin\UsersController@edit');
    Route::post('/user/destroy', 'Admin\UsersController@UserStatus');
    Route::get('/user/report/{id}', 'Admin\UserReportController@getUserReport');
//    Route::post('/user/report/next', 'Admin\UserReportController@UserNextResult');
//    Route::post('/user/report/prev', 'Admin\UserReportController@UserPrevResult');
    Route::post('get_user/test_data', 'Admin\UserReportController@getuserTestData');

    /* -------------------------- Admin Setting route------------------------- */
    Route::get('/settings', 'Admin\SettingController@getUserSetting')->name('setting');
    Route::post('settings_test', 'Admin\SettingController@SaveTestSetting')->name('saveTestSetting');
    /* ---------------------Question ----------------- */
    /*     * ************************************Tasks Routes********************* */

    Route::get('/questions', 'Admin\QuestionController@index')->name('questionPage');
    Route::get('/getAllQuestions', 'Admin\QuestionController@getAllQuestions')->name('getAllQuestions');
    Route::post('/store_question_fill_blanks', 'Admin\QuestionController@store_question_fill_blanks')->name('store_question_fill_blanks');
    Route::post('/task_delete', 'Admin\QuestionController@delete')->name('task_delete');
    Route::post('/store_question_multi_choice', 'Admin\QuestionController@store_question_multi_choice')->name('store_question_multi_choice');
    Route::post('/store_question_arrange_order', 'Admin\QuestionController@store_question_arrange_order')->name('store_question_arrange_order');
    Route::post('/getquestionDetail', 'Admin\QuestionController@getquestionDetail')->name('getquestionDetail');
    Route::post('question/bulkupload/{id}', 'Admin\QuestionController@questionBulkUpload')->name('questionBulkUpload');
    Route::post('/questions/levels', 'Admin\QuestionController@getLevel')->name('get_level');
    Route::post('/questions/sublevels', 'Admin\QuestionController@getSubLevel')->name('get_sublevel');

    /* ---------------------interpretation category wise ----------------- */
    Route::get('/interpretation/id/{id}', 'Admin\InterpretationController@index');
//    Route::get('/interpretation/id/{id}', 'Admin\InterpretationController@index');
    Route::post('/interpretation/store', 'Admin\InterpretationController@store')->name('saveInterpetation');
    Route::post('/category/interpretation', 'Admin\InterpretationController@SaveCategoryInterpretation')->name('saveCategoryInterpetation');
    Route::get('interpretation/show/{catid}/', 'Admin\InterpretationController@show');
    Route::get('/interpretation/edit', 'Admin\InterpretationController@edit');
    Route::post('/interpretation/destroy', 'Admin\InterpretationController@deleteInterpretation');
    Route::get('/interpretation/overall', 'Admin\InterpretationController@getOverallRange');
    /* ---------------------interpretation category wise ----------------- */
    /* ---------------------interpretation overall  wise ----------------- */
    Route::get('/overall/ranges/show', 'Admin\OverallRangeController@show');
    Route::get('/overall/interpretation', 'Admin\OverallRangeController@index')->name('overall');
    Route::post('/overall/range', 'Admin\OverallRangeController@store')->name('saveRange');
    Route::get('/overallRange/edit', 'Admin\OverallRangeController@edit')->name('updateRange');
    Route::post('/overallRange/destroy', 'Admin\OverallRangeController@deleteRange');
    Route::post('saveRangeSummary', 'Admin\OverallRangeController@saveRangeSummary')->name('saveRangeSummary');
    Route::post('get_summary', 'Admin\OverallRangeController@edit');

    /* -----------------Manage overall interpretation ----------------------- */
    Route::get('/overall/range/interpretation', 'Admin\OverallInterpretationController@index')->name('overallRange');
    Route::get('interpretation/{levelid}/range/{id}', 'Admin\OverallInterpretationController@getOverallRange');
    Route::post('/overall/interpretation/store', 'Admin\OverallInterpretationController@OverAllInterpretation')->name('saveOrInterpetation');
    Route::post('/get/overall/interpretation', 'Admin\OverallInterpretationController@edit');
    /* -----------------levels Route start ----------------------- */
    Route::get('/levels', 'Admin\LevelsController@index')->name('levels_view');
    Route::get('/getlevels', 'Admin\LevelsController@getAllLevels')->name('getAllLevels');
    Route::post('/addavatar', 'Admin\LevelsController@storeAvatar')->name('storeAvatar');
    Route::get('/overall/ranges/avtars', 'Admin\LevelsController@getAvatar')->name('getAvatar');
    Route::post('/avtars/delete', 'Admin\LevelsController@DeleteAvatar')->name('DeleteAvatar');


    /* -----------------sublevels Route start ----------------------- */

    Route::post('/levels/saveage_range', 'Admin\LevelsController@store_age_range')->name('saveage_range');
    Route::post('/levels/getage_range', 'Admin\LevelsController@getage_Range')->name('getage_range');

    /* -----------------sublevels Route start ----------------------- */
    Route::get('/sublevels', 'Admin\SubLevelsController@index')->name('sublevels_view');
    Route::get('/getsublevels', 'Admin\SubLevelsController@getAllSubLevels')->name('getSubAllLevels');

    /* -----------------Semester Route start ----------------------- */
    Route::get('/semesters/{id}', 'Admin\SemesterController@index');
    Route::get('/getsemesters/{id}', 'Admin\SemesterController@getAllSemesters')->name('getAllSemesters');
    Route::post('/storesemesters', 'Admin\SemesterController@storeSemester')->name('storeSemester');
    Route::get('/get_semesters/edit', 'Admin\SemesterController@editSemester')->name('EditSemester');
    Route::post('/semesters/destroy', 'Admin\SemesterController@SemesterStatus');
    /* -----------------Semester Route end ----------------------- */
});

/* ------Start Parent and child dashboard routes ---------------- */
Route::group(['middleware' => ['CheckUserType']], function () {
    Route::get('welcome', 'HomeController@welcomePage')->name('welcomePage');
    Route::post('updateAgeGender', 'HomeController@updateGenderAgeAfterLogin')->name('updateAgeGender');
    Route::get('overview', 'Admin\ParentsController@index')->name('overview');
    Route::post('/overview/levels', 'Admin\ParentsController@getLevel')->name('get_level');
    Route::get('manage_request/{type}', 'Admin\ParentsController@manageRequestPage')->name('manageRequestPage');
    Route::get('user/request/{type}', 'Admin\ParentsController@getAllUserRequest')->name('getAllUserRequest');
    Route::post('/untag/friend', 'Admin\ParentsController@UntagUser');
    Route::get('insight', 'Admin\ParentsController@insight')->name('insight');
    Route::post('/sublevels/get_semester', 'Admin\ParentsController@getSemester')->name('get_semester');
    Route::post('insight/getSublevelSemresult', 'Admin\ParentsController@getSublevelSemresult')->name('getSublevelSemresult');
    Route::get('compare', 'Admin\ParentsController@compare')->name('compare');
    /* -------- Start test routes---------------- */
    Route::get('taketest', 'Admin\TestResultsController@test_view')->name('taketest');
    Route::get('result', 'Admin\TestResultsController@getresult')->name('result');
    Route::post('test/calculate_score', 'Admin\TestResultsController@CalculateResultData')->name('calculate_score');
    Route::post('taketest/gettest_levels', 'Admin\TestResultsController@GetLevelData')->name('gettest_levels');
    
    /* -------- End test routes---------------- */

    /* ------- Start for add child from parent ---------- */
    Route::get('child', 'Admin\TagController@childPage')->name('tagging');
    Route::post('user/testdata', 'Admin\TagController@userTestData');
    Route::get('child/{id}', 'Admin\TagController@childPage')->name('nextuserData');
    /* Route::get('nextchild/{id}/', ['as' => 'nextchild', 'uses' => 'Admin\TagController@nextchild']);
      Route::get('prevchild/{id}/', ['as' => 'prevchild', 'uses' => 'Admin\TagController@prevchild']); */
    Route::get('addchild', 'Admin\TagController@addchild')->name('addchild');
    Route::post('addchild/register', 'Admin\TagController@saveChild')->name('saveChild');
    Route::get('tagchild', 'Admin\TagController@tagchild')->name('tagchild');
    /* Route::post('tagchild/next', 'Admin\TagController@nextresult');
      Route::post('tagchild/prev', 'Admin\TagController@prevresult'); */
    /* ------- End add child from parent ----------- */

    /* -------- Start tagging system for parent and child --- */
    Route::post('referfriend/refer_friends', 'Admin\TagController@referFriend')->name('refer_friends');
    Route::post('child/addfreind', 'Admin\TagController@childFriend');
    /* -------- End tagging system for parent and child ----- */

    /* ------------start next and previous insight links ---------- */
    /* Route::post('insight/next', 'Admin\ParentsController@nextresult');
      Route::post('insight/prev', 'Admin\ParentsController@prevresult'); */
    /* ------------end next and previous insight links ------------ */


    Route::get('/profile', 'HomeController@profile')->name('profilePage');
    //Route::post('/get_chart_data', 'HomeController@getchartData')->name('getchartData');
    Route::post('/get_user_data', 'HomeController@getUserData')->name('getUserData');
    Route::post('/request_response', 'HomeController@responseUserRequest')->name('responseUserRequest');
    Route::post('/test/request', 'Admin\ParentsController@sendTestRequest')->name('sendTestRequest');
    Route::post('change_notification_status', 'HomeController@ChangeNotificationStatus');
    Route::post('markNotificationRead', 'HomeController@MarkAllNotificationRead');

    Route::post('/get_chart_data', 'HomeController@getchartData')->name('getchartData');
    Route::post('/get_chart_sub_data', 'HomeController@getchartSubLevelData')->name('getchartSubLevelData');
    Route::post('/get_global_chart_data', 'HomeController@globalRankingChartData')->name('getglobalchartdata');

    Route::post('user/rankdata', 'Admin\ParentsController@getUserRankData')->name('getUserRankData');

    /* ------ Start Compare view routes ----------------- */
    /* Route::post('compare/nextchild', 'Admin\ParentsController@nextchild');
      Route::post('compare/prevchild', 'Admin\ParentsController@prevchild'); */

    /* ------ End compare view routes ------------------- */

    /*     * **********************Upadte profile ************ */
    Route::post('/profileupdate', 'HomeController@profileupdate')->name('profileUpdate');
    Route::post('/changepassword', 'HomeController@changeprofilePassword')->name('changeprofilePassword');

    /* ----------------refer friend -------------------- */
    Route::post('refer_friend', 'ReferFriendsController@ReferAFriend')->name('referFriend');
    /* ------------------- change instructor image-------------- */
    Route::post('/instructor/imageUpdate', 'Admin\ParentsController@InstructorImageUpdate')->name('InstructorImageUpdate');
});

Route::group(['middleware' => ['CheckUserType'], 'prefix' => 'parent'], function () {
    Route::get('overview', 'Admin\ParentsController@parentOverview')->name('parent_overview');
    Route::get('taketest', 'Admin\TestResultsController@parent_test_view')->name('parent_taketest');
    Route::get('insight', 'Admin\ParentsController@parentInsight')->name('parent_insight');
    Route::post('get_chart_data', 'HomeController@parentchartData')->name('parentchartData');
    Route::post('user/testdata', 'Admin\TagController@parentTestData')->name('parentTestData');
    Route::get('compare', 'Admin\ParentsController@parentCompare')->name('parent_compare');
    Route::post('test/calculate_score', 'Admin\TestResultsController@ParentCalculateResultData')->name('parent_calculate_score');
    Route::post('/get_global_chart_data', 'HomeController@parentGlobalRankingChartData')->name('parent_globalchartdata');
    Route::post('/instructor/imageUpdate', 'Admin\ParentsController@InstructorImageUpdate')->name('InstructorImageUpdate');
//     Route::get('test', 'Admin\TestResultsController@ParentCalculateResultData')->name('calculate_score');
});
Route::group(['middleware' => ['isAdmin'], 'prefix' => 'parent'], function() {
    /* ------------------parent category route--------------- */
    Route::get('/categories', 'Admin\Parent\CategeriesController@index')->name('parent_category');
    Route::post('/add/category', 'Admin\Parent\CategeriesController@store')->name('parent_addcategory');
    Route::get('/category/show', 'Admin\Parent\CategeriesController@show');
    Route::get('/category/edit', 'Admin\Parent\CategeriesController@edit');
    Route::post('/category/status', 'Admin\Parent\CategeriesController@CategoryStatus');
    Route::post('/category/destroy', 'Admin\Parent\CategeriesController@destroy');
    /* -----------------parent question route------------- */
    Route::get('/questions', 'Admin\Parent\QuestionController@index')->name('parent_questionPage');
    Route::get('/getAllQuestions', 'Admin\Parent\QuestionController@getAllQuestions')->name('parent_getAllQuestions');
    Route::post('/store_question_fill_blanks', 'Admin\Parent\QuestionController@store_question_fill_blanks')->name('parent_store_question_fill_blanks');
    Route::post('/task_delete', 'Admin\Parent\QuestionController@delete')->name('parent_task_delete');
    Route::post('/store_question_multi_choice', 'Admin\Parent\QuestionController@store_question_multi_choice')->name('parent_store_question_multi_choice');
    Route::post('/store_question_arrange_order', 'Admin\Parent\QuestionController@store_question_arrange_order')->name('parent_store_question_arrange_order');
    Route::post('/getquestionDetail', 'Admin\Parent\QuestionController@getquestionDetail')->name('parent_getquestionDetail');
    Route::post('question/bulkupload/{id}', 'Admin\Parent\QuestionController@questionBulkUpload')->name('parent_questionBulkUpload');
    /* -----------------user report -------------- */
    Route::get('/user/report/{id}', 'Admin\Parent\UserReportController@getUserReport');
    Route::post('get_user/test_data', 'Admin\Parent\UserReportController@getuserTestData');
   

    /* -----------------Manage overall interpretation ----------------------- */
    Route::get('/overall/range/interpretation', 'Admin\Parent\OverallInterpretationController@index')->name('ParentOverallRange');
    Route::get('interpretation/range/{id}', 'Admin\Parent\OverallInterpretationController@getOverallRange');
    Route::post('overall/interpretation/store', 'Admin\Parent\OverallInterpretationController@OverAllInterpretation');
    Route::post('/get/overall/interpretation', 'Admin\Parent\OverallInterpretationController@edit');

    /* ---------------------interpretation category wise ----------------- */
    Route::get('/interpretation/id/{id}', 'Admin\Parent\InterpretationController@index');
    /* ---------------------interpretation category wise ----------------- */
//    Route::get('/interpretation/id/{id}', 'Admin\InterpretationController@index');
    Route::post('/interpretation/store', 'Admin\Parent\InterpretationController@store')->name('ParentsaveInterpetation');
    Route::post('/category/interpretation', 'Admin\Parent\InterpretationController@SaveCategoryInterpretation')->name('ParentsaveCategoryInterpetation');
    Route::get('interpretation/show/{catid}/', 'Admin\Parent\InterpretationController@show');
    Route::get('/interpretation/edit', 'Admin\Parent\InterpretationController@edit');
    Route::post('/interpretation/destroy', 'Admin\Parent\InterpretationController@deleteInterpretation');
    Route::get('/interpretation/overall', 'Admin\Parent\InterpretationController@getOverallRange');
});
