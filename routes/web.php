<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Xcontroller;
use App\Http\Controllers\EController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\CatsController;

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


//fallback (if not found error:404)
// Route::fallback(function(){
//    return redirect('/');
// });  


//view page cv from resources,views,cv.blade.php
Route::get('cv',function(){
    return view('cv');
});


//link to page
Route::get('link',function(){
    $url1 = route('w');
    $url2 = route('g');
    return "<a href='$url1'> go to welcome </a> <br> <a href='$url2'> go to page </a> ";
});

Route::get('welcome',function(){
    return 'welcome to laravel';
})->name('w');

Route::get('goodbye',function(){
    return 'welcome to page';
})->name('g');


// Route::get('main',function(){
//     $url = route('w');
//     $url4 = route('h');
//     return "<a href='$url'>welcome</a> <br> <a href='$url4'>login</a>";
// });

// Route::get('welcome',function(){
//     return 'hi esraa';
// })->name('w');

// Route::get('log',function(){
//     return view('login');
// })->name('h');



//form submit

Route::get('login',function(){
    return view('login');
});

Route::post('s',function(){
    return 'submit sucess';
})->name('submit');


// Route::get('login',function(){
//   return view('login');
// });
// Route::post('s',function(){
//     return view('cv');
//   })->name('submit');



//task 3.1
// Route::post('users',[Xcontroller::class,'my_data']);


Route::get('form',function(){
    return view('form');
});


// Route::post('get_data',function(Request $request){
// $name      =$request['name'];
// $email     =$request['email'];
// $message   =$request['msg'];
// $subject   =$request['subject'];

// return 'name : '.$name .' <br>'.'email: '.$email .'<br>'.'subject : '.$subject .'<br>'.'message: '.$message;
// })->name('data');




Route::get('cars/create',[CarController::class,'create'])->name('cars.create');
Route::post('cars/store',[CarController::class,'store'])->name('cars.store');

//task4
Route::get('classes/create',[ClassesController::class,'create'])->name('classes.create');
Route::post('classes/store',[ClassesController::class,'store'])->name('classes.store');

// Route::get('cats/create',[CatsController::class,'create'])->name('cats.create');
// Route::post('cats/store',[CatsController::class,'store'])->name('cats.store');