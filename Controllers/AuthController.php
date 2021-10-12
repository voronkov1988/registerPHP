<?php

class AuthController
{
    public function __construct(){
        $this -> bd = json_decode(file_get_contents('../bd.json'), true);
    }

    public function validation($data){
        
        $login = $data['login'];
        $password = $data['password'];
        $passwordHash = md5($password . "MyUniqueSault");
        $nameErr = $passwordErr = '';
        $response = array();

        if(strlen($login) < 2){
            $nameErr = ['login' => 'не менее 2 символов'];
            array_push($response, $nameErr);
            
        }
        
        foreach($this->bd as $value){
            if($login === $value['login'] ){
                $loginAuth = ['login' => true];
                array_push($response, $loginAuth);
                if($value['password'] === $passwordHash){
                    $passwordAuth = ['password' => true];
                    array_push($response, $passwordAuth);
                    $this -> auth($login);
                }else{
                    $passwordAuth = ['password' => 'пароль не совпадает'];
                    array_push($response, $passwordAuth);
                }
            }
        }
        if($response[0]['login'] !== true) {
            $loginAuth = ['login' => 'такого пользователя не существует'];
            array_push($response, $loginAuth);
        }

       
        
        if(strlen($password) < 6){
            $passwordErr = ['password' => 'не менее 6 символов'];
            array_push($response, $passwordErr);
        }

        echo json_encode($response);
    }

    protected function auth($login) {
        session_start();
        $_SESSION['group'] = $login;
    }
}


$auth = new AuthController();
$auth -> validation($_POST);