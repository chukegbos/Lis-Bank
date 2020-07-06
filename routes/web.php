<?php


/* --------------------- Common/User Routes START -------------------------------- */

Route::get('/', function () {
    return redirect()->route('login');
});


Auth::routes([ 'verify' => true ]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/account-statement', 'HomeController@accounts');

Route::group(['prefix' => 'user'], function(){
    Route::group(['prefix' => 'domestic-transfer'], function(){
        Route::get('/', 'DomesticController@index')->name('domestic-transfer');
        Route::post('/', 'DomesticController@store');
        Route::get('getuser/{account_number}', 'DomesticController@getuser')->name('getuser');
        Route::get('/viewpdf/{id}', 'DomesticController@viewpdf')->name('viewpdf');
        Route::post('/otp', 'DomesticController@otp')->name('otp'); 
    });

    Route::group(['prefix' => 'international-transfer'], function(){
        Route::get('/', 'DomesticController@interbank')->name('international-transfer');
        Route::post('/storeinterbank', 'DomesticController@storeinterbank')->name('storeinterbank');
    });

    Route::group(['prefix' => 'deposit'], function(){
        Route::get('/', 'DepositController@index')->name('deposit');
        Route::post('/create', 'DepositController@create');
        Route::get('invoice', 'DepositController@show')->name('invoice');
    });

    Route::group(['prefix' => 'pricing'], function(){
        Route::get('/', 'InvestmentController@index')->name('investments');
        Route::post('', 'InvestmentController@store');
    });

    Route::group(['prefix' => 'loan'], function(){
        Route::get('/', 'LoanController@index');
        Route::post('', 'LoanController@store');
    });

    Route::group(['prefix' => 'save'], function(){
        Route::get('/', 'VestController@index');
        Route::post('', 'VestController@store');
    });  

    Route::group(['prefix' => 'withdraw'], function(){
        Route::get('/', 'WithdrawController@index');
        Route::post('', 'WithdrawController@store');
    });

    Route::group(['prefix' => 'profile'], function(){
        Route::get('/', 'HomeController@profile')->name('profile');
        Route::post('', 'HomeController@updateprofile');
    }); 

    Route::group(['prefix' => 'setup'], function(){
        Route::get('/', 'HomeController@setup')->name('setup');
        Route::post('', 'HomeController@updatesetup');
    });  

    Route::get('support', 'HomeController@support');

    Route::get('password', 'HomeController@passwordget')->name('password');
    Route::post('password', 'HomeController@password')->name('userchangePassword');
});

/* --------------------- Common/User Routes END -------------------------------- */

/* ----------------------- Admin Routes START -------------------------------- */

    

Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function(){
    
    /**
     * Admin Auth Route(s)
     */
    Route::namespace('Auth')->group(function(){
        
        //Login Routes
        Route::get('/login','LoginController@showLoginForm')->name('login');
        Route::post('/login','LoginController@login');
        Route::post('/logout','LoginController@logout')->name('logout');

        //Register Routes
        // Route::get('/register','RegisterController@showRegistrationForm')->name('register');
        // Route::post('/register','RegisterController@register');

        //Forgot Password Routes
        Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');

        //Reset Password Routes
        Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');

        // Email Verification Route(s)
        Route::get('email/verify','VerificationController@show')->name('verification.notice');
        Route::get('email/verify/{id}','VerificationController@verify')->name('verification.verify');
        Route::get('email/resend','VerificationController@resend')->name('verification.resend');
    });

    Route::get('/dashboard','HomeController@index')->name('home')->middleware('guard.verified:admin,admin.verification.notice');

    Route::group(['prefix' => 'deposit'], function(){
        Route::get('/', 'HomeController@deposit');
        Route::get('{ref_id}', 'HomeController@approvedeposit');
        Route::delete('{id}', 'HomeController@destroy');
    });

    Route::group(['prefix' => 'investments'], function(){
        Route::get('/', 'HomeController@investments');
    });

    Route::group(['prefix' => 'schemes'], function(){
        Route::get('/', 'HomeController@schemes');
    });

    Route::group(['prefix' => 'withdraw'], function(){
        Route::get('/', 'HomeController@withdraw');
        Route::get('{id}', 'HomeController@showwithdraw');
    });

    Route::group(['prefix' => 'save'], function(){
        Route::get('/', 'HomeController@save');
    });

    Route::group(['prefix' => 'investment-plan'], function(){
        Route::get('/', 'PriceController@index');
        Route::post('', 'PriceController@create');
        Route::put('{id}', 'PriceController@update');
        Route::delete('{id}', 'PriceController@destroy');
    });

    Route::group(['prefix' => 'loan-plan'], function(){
        Route::get('/', 'PriceController@loanindex');
        Route::post('', 'PriceController@loancreate');
        Route::put('{id}', 'PriceController@loanupdate');
        Route::delete('{id}', 'PriceController@loandestroy');
    });

    Route::group(['prefix' => 'setting'], function(){
        Route::get('/', 'SettingController@index')->name('settings');
        Route::put('{id}', 'SettingController@update');
        Route::post('admin', 'SettingController@create_admin');
        Route::put('/admin/{id}', 'SettingController@update_admin');
        Route::delete('admin/{id}', 'SettingController@destroy_admin');
        Route::put('logo/{id}', 'SettingController@logoupdate');
        Route::get('/password', 'SettingController@passwordget')->name('password');
        Route::post('/password', 'SettingController@password')->name('changePassword');

        Route::post('bank', 'SettingController@bank');
        Route::put('bank/{id}', 'SettingController@update_bank');
        Route::delete('bank/{id}', 'SettingController@destroy_bank');

        Route::post('btc', 'SettingController@btc');
        Route::put('btc/{id}', 'SettingController@update_btc');
        Route::delete('btc/{id}', 'SettingController@destroy_btc');
    });

    Route::get('bank-transactions', 'HomeController@transactions');
    Route::get('/viewtransaction/{id}', 'HomeController@viewtransaction')->name('viewtransaction');
    Route::get('/searchaccount/{account_number}', 'HomeController@searchaccount')->name('searchaccount');
    Route::post('/changedate', 'HomeController@changedate')->name('changedate');
    Route::post('/changestatus', 'HomeController@changestatus')->name('changestatus');
    Route::get('searchaccount/ban/{id}', 'HomeController@ban')->name('ban');
    Route::get('searchaccount/banuser/{id}', 'HomeController@banuser')->name('banuser');
    Route::get('searchaccount/reset/{id}', 'HomeController@resett')->name('resett');
    Route::post('changepassword', 'HomeController@adminchangepassword');
    Route::post('/addfund', 'HomeController@addfund')->name('addfund');
});

Route::prefix('/admin')->name('admin.')->group(function(){
    Route::group(['prefix' => 'users'], function(){
        Route::get('/', 'UserController@index');
        Route::delete('{id}', 'UserController@destroy');
    });
});

Route::group(['prefix' => 'users'], function(){
    Route::get('{id}', 'HomeController@show');
});
/* ----------------------- Admin Routes END -------------------------------- */
