<?php

class UserRegister 
{
    public function __construct($bd){
        $this -> bd = $bd;
        $this -> a = '1234';
    }

    public function validation($data){
        $login = $data['login']; 
        $password = $data['passwordReg']; 
        $confirmPassword = $data['confirm']; 
        $email = $data['email']; 
        $name = $data['name']; 
        $loginErr = $passwordErr = $confirmPasswordErr = $emailErr = $nameErr = '';

        $response = array();

        if(strlen($login) < 6){
            $loginErr = ['login'=> 'не менее 6 символов'];
            array_push($response, $loginErr);
        }else{
            if( preg_match("/[A-Za-z]/", $text) ) {
                $loginErr = ['login' => 'логин только из букв'];
                array_push($response, $loginErr);
            }
            foreach($this->bd as $checkLogin){
                if($checkLogin['login'] === $login){
                    $loginErr = ['login'=> 'должен быть уникальным'];
                    array_push($response, $loginErr);
                }
            }
        }
        if(strlen($password) < 6){
            $passwordErr = ['password' => 'пароль не менее 6 символов'];
            array_push($response, $passwordErr);
        }
        if($password !== $confirmPassword){
            $confirmPasswordErr = ['confirm' => 'пароли должны совпадать'];
            array_push($response, $confirmPasswordErr);
        }
        if(strlen($confirmPassword) < 1){
            $confirmPasswordErr = ['confirm' => 'подтвердите пароль'];
            array_push($response, $confirmPasswordErr);
        }
        if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $email)){
            $emailErr = ['email' => 'bad email'];
            array_push($response, $emailErr);
        }
        if(strlen($email) < 1){
            $emailErr = ['email' => 'поле email не может быть пустым'];
            array_push($response, $emailErr);
        }
        if(count($response) === 0){
            $this->createUser($login, $password, $email, $name);
            echo true;
        }else{
            echo json_encode($response);
        }
    }
    protected function createUser($login, $password, $email, $name) {
        $bd = file_get_contents('../bd.json');
        $tempArray = json_decode($bd, true);
        array_push($tempArray, ['login'=> $login, 'password'=> $password = md5($password . "MyUniqueSault"), 'email'=> $email, 'name'=> $name]);
        $jsonBd = json_encode($tempArray);
        file_put_contents('../bd.json', $jsonBd);
    }
}

$user = new UserRegister(json_decode(file_get_contents('../bd.json'), true));
$user -> validation($_POST);