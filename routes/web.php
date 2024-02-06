<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LivestockController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\LanguageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//RUTAS DE INICIO
Route::get('/', [AppController::class, 'portal'])->name('portal');
Route::get('/homepage', [AppController::class, 'home'])->name('home')->middleware('auth');
Route::post('change-language', [LanguageController::class, 'change'])->name('languageChange');

//RUTAS DE CRUD TRABAJADORES
Route::get('/users', [UserController::class, 'index'])->middleware('auth');
Route::get('getUser/{user:id}', [UserController::class, 'getUser'])->middleware('auth');
Route::get('getUsers', [UserController::class, 'getUsers'])->middleware('auth');
Route::post('/users/create', [UserController::class, 'store'])->middleware('auth');
Route::post('validateUsername/{user:username}', [UserController::class,'validateUsername'])->middleware('auth');
Route::post('validateEditUsername/{user:usernameuser}/{id}', [UserController::class,'validateEditUsername'])->middleware('auth');
Route::post('validateEditEmail/{user:emailuser}/{id}', [UserController::class,'validateEditEmail'])->middleware('auth');
Route::post('validateEmail/{user:email}', [UserController::class,'validateEmail'])->middleware('auth');
Route::post('/users/update/{user:id}', [UserController::class, 'update'])->middleware('auth');
Route::get('/users/delete/{user:id}',[UserController::class,'delete'])->middleware('auth');

//RUTAS DE MI PERFIL
Route::get('/about', [UserController::class, 'about'])->middleware('auth');

//RUTAS DE INCIDENCIAS
Route::get('/issues/{user:id}', [IssueController::class, 'index'])->middleware('auth');
Route::get('getAnimalPendingIssues', [IssueController::class, 'getAnimalPendingIssues'])->middleware('auth');
Route::get('getMachinePendingIssues', [IssueController::class, 'getMachinePendingIssues'])->middleware('auth');
Route::get('getFieldPendingIssues', [IssueController::class, 'getFieldPendingIssues'])->middleware('auth');
Route::get('getOtherPendingIssues', [IssueController::class, 'getOtherPendingIssues'])->middleware('auth');
Route::get('getAnimalClosedIssues', [IssueController::class, 'getAnimalClosedIssues'])->middleware('auth');
Route::get('getMachineClosedIssues', [IssueController::class, 'getMachineClosedIssues'])->middleware('auth');
Route::get('getFieldClosedIssues', [IssueController::class, 'getFieldClosedIssues'])->middleware('auth');
Route::get('getOtherClosedIssues', [IssueController::class, 'getOtherClosedIssues'])->middleware('auth');
Route::post('/issues/report', [IssueController::class, 'store'])->middleware('auth');
Route::get('/issue/{incidencia:id}', [IssueController::class,'show'])->middleware('auth');
Route::post('/issue/{incidencia:id}', [CommentController::class, 'store'])->middleware('auth');
Route::post('/issue/close/{incidencia:id}',[IssueController::class, 'close'])->middleware('auth');
Route::get('/num_issues', [IssueController::class,'all'])->middleware('auth');

//RUTAS DE GANADO
Route::get('/livestock', [LivestockController::class, 'index'])->name('livestocks')->middleware('auth');
Route::get('types', [LivestockController::class, 'show'])->middleware('auth');
Route::get('/getAnimal/{animal:id}', [AnimalController::class, 'getAnimal'])->middleware('auth');
Route::get('/getObservations/{animal:id}', [AnimalController::class, 'getObservations'])->middleware('auth');
Route::post('/livestock/add', [LivestockController::class, 'store'])->middleware('auth');
Route::get('/livestock/{code}', [AnimalController::class, 'show'])->middleware('auth');
Route::post('validateCode/{livestock:type}/{animal:code}', [AnimalController::class,'validateCode'])->middleware('auth');
Route::post('validateSell/{livestock:type}/{agemin}/{agemax}/{weightmin}/{weightmax}', [AnimalController::class,'validateSell'])->middleware('auth');
Route::post('sell/{livestock:type}/{agemin}/{agemax}/{weightmin}/{weightmax}/{n_animals_sell}', [AnimalController::class,'sell'])->middleware('auth');
Route::post('/treatAnimal/{animal:id}',[AnimalController::class,'treat'])->middleware('auth');
Route::post('/notifyPatology/{animal:id}',[AnimalController::class,'patology'])->middleware('auth');
Route::post('/animals/add', [AnimalController::class, 'store'])->middleware('auth');
Route::post('/updateAnimalParams/{animal:id}',[AnimalController::class,'update'])->middleware('auth');
Route::post('/animals/delete/{animal:id}',[AnimalController::class,'delete'])->middleware('auth');
Route::get('/observations/{animal:id}',[AnimalController::class,'observations'])->middleware('auth');
Route::get('sick',[AnimalController::class,'sick_animals'])->middleware('auth');
Route::get('treatment',[AnimalController::class,'treated_animals'])->middleware('auth');

//RUTAS DE TAREAS
Route::get('/tasks',[TaskController::class,'index'])->middleware('auth');
Route::get('/tasks/show/{id}',[TaskController::class,'show'])->middleware('auth');
Route::post('/tasks/add',[TaskController::class,'store'])->middleware('auth');
Route::post('/tasks/update/{id}',[TaskController::class,'update'])->middleware('auth');
Route::post('/tasks/delete/{task:id}',[TaskController::class,'delete'])->middleware('auth');


//RUTAS DE LOGIN
Route::get('sessions', function (){
    return view('welcome');
});
Route::get('login', [SessionsController::class,'create'])->middleware('guest');
Route::post('login', [SessionsController::class,'store'])->middleware('guest');
Route::get('logout',[SessionsController::class,'destroy']);

//RUTA DE CALENDARIO
Route::controller(EventController::class)->group(function(){
    Route::get('fullcalender', 'index')->middleware('auth');
    Route::get('/getEvents','getEvents')->middleware('auth');
    Route::get('/getType/{event:id}', 'type')->middleware('auth');
    Route::post('/delete/{event:title}/{titleTask}', 'delete')->middleware('auth');

});
