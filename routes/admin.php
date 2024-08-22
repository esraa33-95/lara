<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClassesController;


Route::group([
    'controller'=>ClassesController::class,
    'prefix'=>'classes',
    'as'=>'classes.',
    //apply custom middleware isAdmin + custom routes 
    'middleware'=>['web','verified','isAdmin'],
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


 