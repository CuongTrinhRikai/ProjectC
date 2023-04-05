<?php

use App\Model\System\BuildingAdmin;
use App\Model\System\BuildingAdminMansion;
use App\Model\System\CheckInCheckOut;
use App\Model\System\Contractor;
use App\Model\System\Guide;
use App\Model\System\Mansion;
use App\Model\System\Manual;
use App\Model\System\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Spatie\TranslationLoader\LanguageLine;

Route::get('/', function () {
    return redirect(route('login.form'));
});
Route::get(PREFIX, function () {
    return redirect(route('login.form'));
});

Route::group(['namespace' => 'System', 'prefix' => PREFIX, 'middleware' => ['language']], function () {



    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login.form');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
    Route::get('forgot-password', 'Auth\ForgotPasswordController@showRequestForm')->name('forgot.password');
    Route::post('forgot-password', 'Auth\ForgotPasswordController@handleForgotPassword')->name('post.forgot.password');
    Route::get('/reset-password/{email}/{token}', 'Auth\ResetPasswordController@showSetResetForm')->name('reset.password');
    Route::post('/reset-password', 'Auth\ResetPasswordController@handleSetResetPassword');
    Route::get('/set-password/{email}/{token}', 'Auth\ResetPasswordController@showSetResetForm')->name('set.password');
    Route::post('/set-password', 'Auth\ResetPasswordController@handleSetResetPassword');
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['middleware' => ['auth', 'antitwofa']], function () {
        Route::get('/login/verify', 'Auth\VerificationController@showVerifyPage');
        Route::post('/login/verify', 'Auth\VerificationController@verify')->name('verify.post');
        Route::get('/login/send-again', 'Auth\VerificationController@sendAgain')->name('verify.send.again');
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('change-password', 'user\UserController@changePassword')->name('change.password');
    });

    Route::group(['middleware' => ['auth', 'permission', 'twofa', 'reset.password']], function () {

        Route::get('/home', 'indexController@index')->name('home');
        Route::resource('/roles', 'user\RoleController', ['except' => ['show','create','edit','destroy']]);

        Route::resource('/users', 'user\UserController');
        Route::get('/users/{id}/show', 'user\UserController@show');

        Route::get('/profile', 'profile\ProfileController@index')->name('profile');
        Route::put('/profile/{id}', 'profile\ProfileController@update');

        Route::post('users/reset-password/{id}', 'user\UserController@passwordReset')->name('user.reset-password');

        Route::get('/login-logs', 'logs\LoginLogsController@index');
        Route::get('/activity-logs', 'logs\LogsController@index');

        Route::resource('/languages', 'language\LanguageController', ['except' => ['show', 'edit', 'update']]);
        Route::get('/languages/set-language/{lang}', 'language\LanguageController@setLanguage')->name('set.lang');
        Route::get('/country-language/{country_id}', 'countryLanguage\countryLanguageController@getLanguages');

        Route::resource('/translations', 'language\TranslationController', ['except' => ['show', 'edit', 'create']]);
        Route::get('/translations/download-sample', 'language\TranslationController@downloadSample');
        Route::get('/translations/download/{group}', 'language\TranslationController@downloadExcel');
        Route::post('/translations/upload/{group}', 'language\TranslationController@uploadExcel');

        Route::resource('/email-templates', 'systemConfig\emailTemplateController', ['except' => ['show', 'create', 'store']]);

        Route::resource('/configs', 'systemConfig\configController');

        Route::resource('/categories', 'category\categoryController', ['except' => ['show']]);
        Route::resource('categories/{id}/sub-category', 'category\SubCategoryController');
        Route::get('/clear-lang', function () {
            LanguageLine::truncate();
        });

        Route::get('/mail-test/create', 'MailTestController@create');
        Route::post('/mail-test', 'MailTestController@sendEmail');

        Route::resource('/contractors', 'contractor\ContractorController');
        Route::get('/contractors/{id}/show', 'contractor\ContractorController@show');

        Route::resource('/mansions', 'mansion\MansionController');
        Route::get('/mansions/{id}/show', 'mansion\MansionController@show');
        Route::get('/mansions/{id}/qr-code', 'mansion\MansionController@generateQRCode');

        Route::get('/guides/change-status', 'guide\GuideController@changeStatus');
        Route::resource('/guides', 'guide\GuideController');
        Route::get('/guides/{id}/show', 'guide\GuideController@show');

        Route::resource('/building', 'buildingAdmin\BuildingAdminController');
        Route::get('/building/{id}/show', 'buildingAdmin\BuildingAdminController@show');
        Route::post('building/reset-password/{id}', 'buildingAdmin\BuildingAdminController@passwordReset')->name('building.reset-password');
        Route::get('/building/reset-token/{id}', 'buildingAdmin\BuildingAdminController@tokenReset');

        Route::get('/test', 'manual\ManualController@testing');
        Route::post('/upload-video-signed-url/{id}', 'manual\ManualController@getUploadSignedUrlupdate');


        Route::post('/remove-s3-file', 'manual\ManualController@removeS3File');
        Route::post('/manuals-check-unique', 'manual\ManualController@checkUnique');
        Route::post('/upload-video-signed-url', 'manual\ManualController@getUploadSignedUrl');
        Route::resource('/manuals', 'manual\ManualController');
        Route::get('/manuals/{id}/show', 'manual\ManualController@show');

        Route::get('/update-manual-status/{id}', 'manual\ManualController@updateStatus');

        Route::resource('/notifications', 'notification\NotificationController', ['except' => ['show']]);
        Route::get('/notifications/{id}/show', 'notification\NotificationController@show');

        Route::get('/info-display/download', 'infoDisplay\InformationController@downloadExcel');
        Route::get('/info-display/{id}/show', 'infoDisplay\InformationController@show');
        Route::resource('/info-display', 'infoDisplay\InformationController', ['except' => ['create']]);


        Route::get('get-mansion/{id}', 'mansion\MansionController@getMansionWhereContractorId')->name('get-mansion');
        Route::get('get-mansion-edit/{id}', 'mansion\MansionController@getMansionEditBuildingAdmin')->name('get-mansion-edit');

//        Route::delete('/info-display/{id}', 'infoDisplay\InformationController@destroy');


//        Route::get('/clear-table', function () {
//            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
//
//            Guide::truncate();
//            Contractor::truncate();
//            BuildingAdmin::truncate();
//            BuildingAdminMansion::truncate();
//            CheckInCheckOut::truncate();
//            Mansion::truncate();
//            Manual::truncate();
//            Notification::truncate();
//           \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
//        });


    });
});
