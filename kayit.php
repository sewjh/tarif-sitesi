<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <center>
    <div class="loginBox">
        <form action="" method="post" style="">
            <table border="0">
                <tr>
                    <td><i class="fa fa-user" style="padding-left: 10px; padding-right: 7px;"></i>
                    <input type="text" name="username" placeholder="Kullanıcı Adı" class="inputLogin" required></td>
                </tr>
                <tr>
                    <td><i class="fa fa-envelope"></i>
                    <input type="text" name="email" placeholder="E-Posta" class="inputLogin" required></td>
                </tr>
                <tr>
                    <td><i class='fa fa-key'></i>
                    <input type="password" name="pass" placeholder="Parola" class="inputLogin" required></td>
                </tr>
                <tr>
                    <td><i class='fa fa-key'></i>
                    <input type="password" name="passR" placeholder="Tekrar Parola" class="inputLogin" required></td>
                </tr>
                <tr>
                    <td><input type="submit" name="register" class="submitBtn" value="Kayıt Ol"></td>
                </tr>
            </table>
            <p class="kayitYazi">Hesabın zaten var mı? <b><a href="giris.php">Giris Yap!</a></b></p>
        </form>
    </div>
    </center>
</body>
</html>
<?php
include("connection.php");

if (isset($_POST["register"])) {
    $permission = true;
    
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["pass"];
    $password_confirm = $_POST["passR"];

    $select = "SELECT * FROM kullanici";
        $result = $conn -> query($select);
            while($row = $result->fetch()) {
            $test = $row['kullanici_adi'];
                if ($row['kullanici_adi'] == $username) {
                    $permission = false;
                }
             } if($permission == true) {
                    if ($password == $password_confirm) {
                        $add = "INSERT INTO kullanici (kullanici_adi, kullanici_eposta, kullanici_parola) VALUES ('".$username."','".$email."','".$password."')";
                    
                        if ($conn -> exec($add) == TRUE) {
                            echo "<script>alert('Başarıyla kayıt olundu!')</script>";
                        }
                 } else {
                    echo "
                    <script>
                    alert('Parolalar eşleşmiyor!');
                    </script>";
                }
            } else {
                echo "
                <script>
                alert('$username adli kullanici zaten bulunmakta!');
                </script>";
            }
        }
?>