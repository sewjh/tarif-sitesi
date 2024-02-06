<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
                    <td><i class='fa fa-key'></i>
                    <input type="password" name="pass" placeholder="Parola" class="inputLogin" required></td>
                </tr>
                <tr>
                    <td><input type="submit" name="login" class="submitBtn" value="Giriş Yap"></td>
                </tr>
            </table>
            <p class="kayitYazi">Hesabın yok mu? <b><a href="kayit.php">Kayıt Ol!</a></b></p>
        </form>
    </div>
    </center>
</body>
</html>
<?php
include("connection.php");

session_start();

if (isset($_POST["login"])) {
    $username = $_POST['username'];
    $password = $_POST['pass'];

    $select = "SELECT * FROM kullanici";
    $result = $conn -> query($select);
    if ($result-> rowCount() > 0) {
        while($row = $result->fetch()) {
            if ($row['kullanici_adi'] == $username && $row['kullanici_parola'] == $password) {
                if ($row['kullanici_yasakli'] == "false") {
                $permission = true;
                break;
                } else {
                    $permission = false;
                }
            } else {
                $permission = false;
            }
         }
        }
         if ($permission == true) {
            echo "<script>alert('Hoşgeldin $username!')</script>";
            $_SESSION["user"] = $username;
            $logged = true;
            $loggedUser = $username;
            header("location:profil.php");
         } else {
            echo "<script>alert('Giriş başarısız!')</script>";
         }
}
?>