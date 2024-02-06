<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /*
     * Función para renderizar la vista de trabajadores
     */
    public function index(){
        return view('users.index');
    }

     /*
     * Función para renderizar la vista de about
     */
    public function about(){
        return view('components/about');
    }


    /*
     * Función para obtener usuarios
     */
    public function getUsers(){
        $users = $this->userService->getUsers();
        return $users;
    }

   
    /*
     * Función para obtener un usuario
     */
    public function getUser($id){
        $user = $this->userService->getUser($id);
        return $user;
    }

    /*
     * Función para crear usuarios
     */
    public function store(){
        $this->userService->validateParams(request());

        if(request()->hasFile('avatar')){
            $file =request()->file('avatar');
            $path = 'avatar/';
            $fileName = time().'-'.$file->getClientOriginalName();
            $upload = request()->file('avatar')->move($path, $fileName);
            $avatar = $path.$fileName;
        }else{
            $file = "default_avatar.png";
            $path = 'img/';
            $avatar = $path.$file;
        } 

        

        $user = $this->userService->createUser(request()->get('name'),
                                               request()->get('username'),
                                               request()->get('email'),
                                               request()->get('password'),
                                               request()->get('role'),
                                               $avatar);
        
        $this->userService->sendWelcomeMail(request('name'), request('email'), request('password'));

        return $user;
    }

    /*
     * Función para actualizar usuarios
     */
    public function update($id){
        request()->validate([
            'nameuser'=>'required|max:255',
            'usernameuser'=>['required','max:255','min:5'],
            'emailuser'=>'required|email|max:255',
            'userrole' => 'required'
        ]);
        

        if(request()->hasFile('avatar')){
            $file =request()->file('avatar');
            $path = 'avatar/';
            $fileName = time().'-'.$file->getClientOriginalName();
            $upload = request()->file('avatar')->move($path, $fileName);
            $avatar = $path.$fileName;
        }else{
            $file = "default_avatar.png";
            $path = 'img/';
            $avatar = $path.$file;
        }
        
        $user = $this->userService->updateUser($id,request()->get('nameuser'),
                                                request()->get('usernameuser'),
                                                request()->get('emailuser'),
                                                request()->get('userrole'),
                                                $avatar);

        return $user;
    }

    /*
     * Función para eliminar usuarios
     */
    public function delete($id){
        $user = $this->userService->deleteUser($id);
        return $user;
    }

    /*
     * Función para comprobar si existe el username
     */
    public function validateUsername($username){
        $response = $this->userService->validateUsername($username);
        return $response;
    }

    /*
     * Función para comprobar si existe el email
     */
    public function validateEmail($email){
        $response = $this->userService->validateEmail($email);
        return $response;
    }

    /*
     * Función para comprobar si existe el username al editar
     */
    public function validateEditUsername($usernameuser, $id){
        $response = $this->userService->validateEditUsername($usernameuser, $id);
        return $response;
    }

    /*
     * Función para comprobar si existe el email al editar
     */
    public function validateEditEmail($emailuser, $id){
        $response = $this->userService->validateEditEmail($emailuser, $id);
        return $response;
    }

}
