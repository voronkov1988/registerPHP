<?php


class AuthController
{
    public function __construct(){
        $this -> bd = json_decode(file_get_contents('../bd.json'), true);
    }

    public function validation($data){
        
        $session = $data['session'];
        // var_dump($session);
        $login = $data['login'];
        $password = $data['password'];
        $passwordHash = md5($password . "MyUniqueSault");
        $nameErr = $passwordErr = '';
        $response = array();
        // var_dump($data['session']);

        if(isset($session)) $this->sessionEnd();

        if(strlen($login) < 2){
            $nameErr = ['login' => 'не менее 2 символов'];
            array_push($response, $nameErr);
        }else {
            foreach($this->bd as $value){
                if($value['login'] !== $login){
                    $loginErr = ['login' => 'такого пользователя не существует'];
                    array_push($response, $loginErr);
                }
                if($value['login'] === $login){
                    if($value['password'] !== $passwordHash){
                        $passwordErr = ['password' => 'не правильно введен пароль'];
                        array_push($response, $passwordErr);
                    }
                }
            }
        }

        if(strlen($password) < 6){
            $passwordErr = ['password' => 'не менее 6 символов'];
            array_push($response, $passwordErr);
        }
        
        if(count($response) === 0){
            $this -> auth($login);
        }

        echo json_encode($response);
    }

    protected function sessionEnd(){
        session_destroy();
    }

    protected function auth($login) {
        session_start();
        $_SESSION['group'] = $login;
    }
}


$auth = new AuthController();
$auth -> validation($_POST);