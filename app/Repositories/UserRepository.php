<?php

namespace App\Repositories;
use App\Models\User;
use Illuminate\Http\Request;

class UserRepository {
    
    public function getUsers(){
        return User::all();
    }

    public function getUser($id){
        return User::find($id);
    }

    public function createUser($name, $username, $email, $password, $rol, $avatar){
            User::create([
                'name'      => $name,
                'username'  => $username,
                'email'     => $email,
                'password'  => $password,
                'rol'       => $rol,
                'avatar'    => $avatar
            ])->assignRole($rol);   
    }

    public function updateUser(int $id, $name, $username, $email, $rol, $avatar){
        $user = $this->getUser($id);
        $user->name = $name;
        $user->username = $username;
        $user->email = $email;
        $user->rol = $rol;
        if($avatar != null){
            $user->avatar = $avatar;
        }
        $user->syncRoles($rol);
        $user->save();
    }

    public function deleteUser(int $id){
        $user = User::find($id);
        $user->syncRoles([]);
        $user->delete();
    }

    public function getUsername(string $username){
        $user = User::where('username',$username) -> first();

        if(empty($user)){
            return true;
        }else{
            return false;
        }
    }

    public function getEmail(string $email){
        $user = User::where('email',$email) -> first();
        
        if(empty($user)){
            return true;
        }else{
            return false;
        }
    }

    public function getEditUsername(string $username, int $id){
        $user = User::where('id','!=',$id)->where('username', $username)->first();

        if(empty($user)){
            return true;
        }else{
            return false;
        }
    }

    public function getEditEmail(string $email, int $id){
        $user = User::where('id','!=',$id)->where('email', $email)->first();

        if(empty($user)){
            return true;
        }else{
            return false;
        }
    }

}