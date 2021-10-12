<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <?php
            if(!$_SESSION['group']){
                echo '<div class="forms col-4 offset-1">
                <button class="btn btn-danger col-4 h-50" type="button" data-bs-toggle="modal" data-bs-target="#registration">регистрация</button>
                <button class="btn btn-info col-4 h-50" type="button" data-bs-toggle="modal" data-bs-target="#authorization">авторизация</button>
            </div>';
            }
       
            if($_SESSION['group']){
                echo '<div class="userCabinet col-4 offset-4">
                <img class="userPhoto" src="./img/fotoME.jpg" alt="">
                <span class="helloUser">'. 'привет ' . $_SESSION['group'].'</span>
                <form action="logout.php">
                    <input class="btn btn-info" type="submit" name="sessionEnd"  value="выйти" />
                </form>
            </div>';
            }
        ?>
        
    </header>
    <!-- Modal authorization -->
    
    <div class="modal fade" id="authorization" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">форма авторизации</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="formAuthorization">
                        <input class="inpLogin" type="text" placeholder="login" name="login">
                        <span class="err AuthLoginError"></span>
                        <input type="password" placeholder="password" name="password">
                        <span class="err AuthPasswordError"></span>
                        <input class="submit submitAuth" type="submit">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal registration -->
    <div class="modal fade" id="registration" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Форма регистрации</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="formRegistration">
                        <input type="inputs text" placeholder="login" name="login">
                        <span class="err LoginError"></span>
                        <input type="password" placeholder="password" name="passwordReg">
                        <span class="err passwordError"></span>
                        <input type="password" placeholder="confirm password" name="confirm">
                        <span class="err confirmError"></span>
                        <input type="inputs email" placeholder="email" name="email">
                        <span class="err emailError"></span>
                        <input type="inputs text" placeholder="name" name="username">
                        <span class="err nameError"></span>
                        <input class="submit submitRegistration" type="submit" value="submit">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>