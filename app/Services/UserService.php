<?php
namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\Welcome;
class UserService{

    private UserRepository $userRepository;

    /**
     * [_construct]
     * @param [type]    $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Función para obtener todos los trabajadores
     */
    public function getUsers(){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $workers = $this->userRepository->getUsers();
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido obtener los usuarios";
            return $result;
        }

        if(empty($workers)){
            $result['message'] = "No se ha encontrado ningún usuario";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Usuarios encontrados",
            'data'       => $workers
        );

        return $result;
    }

    /**
     * Función para obtener un trabajador
     * @param int       $id
     * 
     * 
     */
    public function getUser($id){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $worker = $this->userRepository->getUser($id);
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido obtener el usuario";
            return $result;
        }

        if(empty($worker)){
            $result['message'] = "No se ha encontrado ningún usuario";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Usuario encontrado",
            'data'       => $worker
        );

        return $result;
    }

    /**
     * Función para actualizar un usuario
     */
    public function updateUser(int $id, $name, $username, $email, $rol, $avatar){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $this->userRepository->updateUser($id, $name, $username, $email, $rol, $avatar);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido actualizar el usuario";
            return $result;
        }


        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Usuario actualizado correctamente",
            'data'       => null
        );

        return $result;
    }

    /**
     * Función para crear un usuario
     */
    public function createUser($name, $username, $email, $password, $role, $avatar){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $user = $this->userRepository->createUser($name,  $username, 
                                              $email, $password,
                                              $role,  $avatar);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido crear el usuario";
            return $result;
        }


        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Usuario creado correctamente",
            'data'       => $user
        );

        return $result;
    }

    /**
     * Función para eliminar un usuario
     */
    public function deleteUser(int $id){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $user = $this->userRepository->deleteUser($id);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido borrar el usuario";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Usuario eliminado",
            'data'       => $user
        );
        
        return $result;
    }

    /**
     * Función para validar parámetros de un usuario
     */
    public function validateParams(Request $request){
        $request->validate([
            'name'=>'required|max:255',
            'username'=>['required','max:255','min:5', Rule::unique('users', 'username')],
            'email'=>'required|email|max:255|unique:users,email',
            'password'=>'required|min:7|max:255',
            'role' => 'required'
        ]);
    }
    

    /**
     * Función para mandar el correo de bienvenida
     */
    public function sendWelcomeMail($name, $email, $password){
        $mail = new Welcome($name, $email, $password);
        Mail::to($email)->send($mail);
    }

    public function validateUsername($username){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
        );

        try {
            $response = $this->userRepository->getUsername($username);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido realizar la comparación";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Operación realizada",
            'data'       => $response
        );
        
        return $result;
    }
    
    public function validateEmail($email){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
        );

        try {
            $response = $this->userRepository->getEmail($email);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido realizar la comparación";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Operación realizada",
            'data'       => $response
        );
        
        return $result;
    }

    public function validateEditUsername($username, $id){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        
        try {
            $user = User::where('username',$username) -> first();
            if($user == null){
                $result["status"]       = true;
                $result["statusCode"]   = 200;
                $result["message"]      = "No hay nadie con ese usuario";
                $result["data"]         = true;
                return $result;
            }

            $response = $this->userRepository->getEditUsername($username, $id);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido realizar la comparación";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Operación realizada",
            'data'       => $response
        );
        
        return $result;
    }

    public function validateEditEmail($email, $id){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        
        try {
            $user = User::where('email',$email) -> first();
            if($user == null){
                $result["status"]       = true;
                $result["statusCode"]   = 200;
                $result["message"]      = "No hay nadie con ese correo";
                $result["data"]         = true;
                return $result;
            }

            $response = $this->userRepository->getEditEmail($email, $id);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido realizar la comparación";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Operación realizada",
            'data'       => $response
        );
        
        return $result;
    }
}