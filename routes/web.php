<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Xcontroller;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ContactController;
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
// Route::get('form',function(){
//     return view('form');
// });



//car project
//create
Route::get('cars/create',[CarController::class,'create'])->name('cars.create');
Route::post('cars/store',[CarController::class,'store'])->name('cars.store');
//index
Route::get('cars1',[CarController::class,'index'])->name('cars1.index');
//edit
Route::get('cars1/{id}/edit',[CarController::class,'edit'])->name('cars1.edit');
//update
Route::put('cars1/{id}/update',[CarController::class,'update'])->name('cars1.update');

//show
Route::get('cars1/{id}/show',[CarController::class,'show'])->name('cars1.show');

//destroy delete
//Route::get('cars1/{id}/delete',[CarController::class,'destroy'])->name('cars1.destroy');

//request delete
 Route::delete('cars1/{id}/destroy',[CarController::class,'destroy'])->name('cars1.delete');

//showsoftdeleted
Route::get('cars1/trashed',[CarController::class,'showDeleted'])->name('cars1.showDeleted');

//restore
Route::patch('cars/{id}/restore',[CarController::class,'restore'])->name('cars1.restore');

//forcedelete
 Route::delete('cars/{id}/force',[CarController::class,'forceDelete'])->name('cars1.forceDelete');

 //upload
 Route::get('cars/upload',[CarController::class,'uploadForm']);
 Route::post('cars/uploadform',[CarController::class,'upload'])->name('upload');

 

// });

//classes project
//Route::prefix('classes')->controller(ClassesController::class)->as('classes.')->group(function(){
Route::group([
'controller'=>ClassesController::class,
'prefix'=>'classes',
'as'=>'classes.',
],function(){
//create
Route::get('create','create')->name('create');
//store
Route::post('store','store')->name('store');
//index
Route::get('','index')->name('index');
//edit
Route::get('{id}/edit','edit')->name('edit');
//update
Route::put('{id}/update','update')->name('update');
//show
Route::get('{id}/show','show')->name('show');
//request delete
Route::delete('delete','destroy')->name('destroy');
//trashed
Route::get('trashed','showDeleted')->name('showDeleted');
//task7
//restore
Route::patch('{id}/restore','restore')->name('restore');
//forcedelete
Route::delete('{id}/forcedelete','forceDelete')->name('forceDelete');
//upload image
Route::get('uploadform','uploadForm');
Route::post('upload','upload')->name('upload');

});



//resource
//Route::resource('classes', ClassesController::class);
//example 
Route::get('index',[XController::class,'index']);



//task9(products project)

Route::group([
    'controller'=>ProductsController::class,
    'as'=>'products.',
    'prefix'=>'product',
],function(){
Route::get('create','create')->name('create');
Route::post('store','store')->name('store');
Route::get('index','index')->name('index');
Route::get('{id}/edit','edit')->name('edit');
Route::put('{id}/update','update')->name('update');

});

//task10
Route::group([
    'prefix'=>'fashion',
    'controller'=>PublicController::class,
     'as'=>'fashion.'
],function(){
Route::get('index','index')->name('index')->middleware('verified');
Route::get('about','about')->name('about');
Route::get('testone','test')->name('test');
});

//traversal path
Route::get('/download', function (Illuminate\Http\Request $request) {
    $file = $request->input('file');
    $path = public_path('assets/images/' . $file);
    if (file_exists($path)) {
        return response()->download($path);
    } else {
        abort(404, 'File not found');
    }
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//authentication
Auth::Routes(['verify' => true]);



//mail
Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('contact', [ContactController::class, 'send'])->name('contact.send');