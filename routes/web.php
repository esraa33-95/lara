<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Xcontroller;
use App\Http\Middleware\Test;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function () {
    return 'laravel';
});

Route::get('car/{id}', function ($id) {
    return 'number is '.$id;
});
Route::get('car/{id?}', function ($id=0) {
    return 'number is '.$id;
});
Route::get('car1/{id?}', function ($id=0) {
    return 'number is '.$id;
})->wherenumber('id');

Route::get('car2/{id?}', function ($id=0) {
    return 'number is '.$id;
})->where(['id'=>'[0-9]+']);

Route::get('car3/{name?}', function ($name=null) {
    return 'number is '.$name;
})->where(['name'=>'[a-zA-Z]+']);

Route::get('car3/{name?}', function ($name=null) {
    return 'number is '.$name;
})->wherealpha('name');

Route::get('car4/{name?}', function ($name=null) {
    return 'number is '.$name;
})->wherealphanumeric('name');

Route::get('car10/{name?}', function ($name=null) {
    return 'number is '.$name;
})->whereIn('name',['esraa','amina']);

Route::get('/car5/{name}/{age}', function ($name, $age) {
    return "name is ".$name .",age is ". $age;
})->where([
    'name'=>'[a-zA-Z]+',
    'age'=>'[0-9]+'
]);
Route::get('car6/{name}/{id?}', function ($name, $id=0) {
    return 'number is '.$name. ' and id is'.$id;
})->wherealpha('name')->wherenumber('id');


Route::get('car20/{name}/{age?}', function ($name, $age=0) {
    if($age == 0) 
    return "name is ". $name;
    else
    return "name is ".$name ." and age is ".$age;    
})->where([
    'name'=>'[a-zA-Z]+',
    'age'=>'[0-9]+'
]);

 //prefix

Route::prefix('company')->group (function() {
    Route::get('', function () {
        return 'index';
    });
    Route::get('it', function () {
        return 'it';
    });
    Route::get('users', function () {
        return 'users';
    });

});

 //task 2.1

Route::prefix('accounts')->group (function() {
    Route::get('', function () {
        return 'account index';
    });
    Route::get('admin', function () {
        return 'account admin';
    });
    Route::get('user', function () {
        return 'account user';
    });

});

// //task2.2

Route::prefix('cars')->group (function() {
    Route::get('', function () {
        return 'cars';
    });
    Route::prefix('usa')->group (function() {
        Route::get('ford', function () {
            return 'ford';
        });
        Route::get('tesla', function () {
            return 'tesla';
        });
    });
    Route::prefix('ger')->group (function() {
        Route::get('mercedes', function () {
            return 'mercedes';
        });
        Route::get('audi', function () {
            return 'audi';
        }); 
        Route::get('volkswagen', function () {
            return 'volkswagen';
        });
        
    });
});


//fallback

// Route::fallback( function () {
//     return redirect('/');
// });

 //Route::fallback(fn()=> redirect('cars'));

 //Route::fallback(fn()=> Redirect::to('cars/usa/ford'));

// Route::get('hello', function(){
//     return view('car');
// });



//  Route::view('lara','data');

//  //route name

//  Route::get('data', function () {
//     return view('data');
// });


// Route::post('receive/{id}', function ($id) {
//     return '<h1>welcome lara</h1>';
// })->name('receive');


// //controller
// Route::get('hi',[Xcontroller::class,'my_data']);

// // Route::controller(Xcontroller::class)->group( function(){
// //     Route::get('data1','my_data');
// // });

// // Route::get('data', function () {
// //     return view('data');
// // })->middleware('guest');

// // Route::middleware('auth')->group(function(){
// //     Route::prefix('account')->group (function() {
// //         Route::get('', function () {
// //             return 'account index';
// //         });
// //         Route::get('admin', function () {
// //             return 'account admin';
// //         });
// //         Route::get('user', function () {
// //             return 'account user';
// //         });
    
// //     });


//     Route::group(['middleware'=>'Test:1'], function(){
//         Route::get('data',fn()=>'welcome test');

// });







// Route::fallback(function(){
//    return redirect('/');
// });

Route::get('cv',function(){
    return view('cv');
});


Route::get('link',function(){
    $url = route('w');
    $url2 = route('g');
    return "<a href='$url'> go to welcome </a> <br> <a href='$url2'> go to page </a> ";
});

Route::get('welcome',function(){
    return 'welcome to laravel';
})->name('w');

Route::get('goodbye',function(){
    return 'welcome to page';
})->name('g');

Route::get('login',function(){
    return view('login');
});
///
Route::post('s',function(){
    return 'submit sucess';
})->name('submit');