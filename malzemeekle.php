<?php
include("connection.php");
session_start();
if (isset($_SESSION["user"])) {
    $sct = "SELECT * FROM kullanici";
    $sctrn = $conn->query($sct);

    while ($rw = $sctrn->fetch()) {
        if ($_SESSION['user'] == $rw['kullanici_adi']) {
            if ($rw['kullanici_rol'] != "admin") {
                header("location:index.php");
            }
        }
    }
} else {
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>

<body style="background-image: url('bgpanel.jpg');">
    <center>
        <div class="header">
            <div class="logo">
                <img src="logo.png" height="300">
            </div>
            <div class="pos">
                <form action="arama.php" method="post">
                    <div class="search">
                        <span class="glyphicon glyphicon-search search-icon"></span><input type="text" name="ara"
                            class="search-box" placeholder="Tarif ara..">
                    </div>
                </form>
                <div class="links">
                    <ul>
                        <li><a href="tarifonayla.php">Tarif Onayla</a></li>
                        <li><a href="tarifsil.php">Tarif Sil</a></li>
                        <li><a href="yasakla.php">Yasaklama İşlemleri</a></li>
                        <li><a href="malzemeekle.php">Malzeme Ekle</a></li>
                        <li><a href="mesajlar.php">Mesajlar</a></li>
                        <div class="giris-yap-btn">
                            <?php
                            if (!isset($_SESSION["user"])) {
                                echo '
                                <li><a href="giris.php"><span class="glyphicon glyphicon-user"></span></a></li>
                                ';
                            } else {
                                echo '
                                <li><a href="profil.php"><span class="glyphicon glyphicon-user"></span></a></li>
                                <li><a href="cikis.php"><span class="fa fa-power-off"></span></a></li>
                            ';
                            $sct = "SELECT * FROM kullanici";
                            $sctrn = $conn->query($sct);

                            while ($rw = $sctrn->fetch()) {
                                if ($_SESSION['user'] == $rw['kullanici_adi']) {
                                    if ($rw['kullanici_rol'] == "admin") {
                                        echo '
                                    <li><a href="panel.php"><span class="fa fa-lock"></span></a></li>
                                    ';
                                    }
                                }
                            }
                        }
                            ?>
                        </div>
                    </ul>
                </div>
            </div>
        </div>

        <div class="main-box">
            <center>
                <div class="lineBox">
                    <h1 class="baslik">Malzeme Ekle</h1>
                </div>
                <div class="tarifKutucuk">
                    <form enctype="multipart/form-data" action="" method="POST">
                        <table class="tarifEkle">
                            <tr>
                                <td>Malzeme Adı:</td>
                                <td><input type="text" name="malzemeAdi" class="inputLogin" required></td>
                            </tr>
                            <tr>
                                <td>Malzeme Görseli:</td>
                                <td><input type="FILE"
                                        style="border-radius: 7px; background-color: white; color: black;"
                                        name="malzemeGorsel" required></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input class="submitBtn" type="submit" name="yukle" value="Yukle"></td>
                            </tr>
                        </table>
                        <?php

                        if (isset($_POST["yukle"])) {
                            $malzemeAdi = $_POST['malzemeAdi'];
                            $malzemeGorsel = $_FILES['malzemeGorsel']['name'];

                            $add = "INSERT INTO malzeme (malzeme_adi, malzeme_gorsel) VALUES ('" . $malzemeAdi . "','" . $malzemeGorsel . "')";

                            if ($conn->exec($add) == TRUE) {
                                echo "<b style='color: white;'>Malzeme başarıyla eklendi.</b>";
                            }

                            $dizin = 'yuklenendosyalar/malzemeler/';
                            $yuklenecek_dosya = $dizin . basename($_FILES['malzemeGorsel']['name']);

                            if (move_uploaded_file($_FILES['malzemeGorsel']['tmp_name'], $yuklenecek_dosya)) {
                                // echo $_FILES['dosya']['name'];
                        
                            } else {
                                // echo "Dosya yüklenemedi!\n";
                            }
                        }
                        ?>
                    </form>
                </div>
            </center>
        </div>
    </center>
</body>

</html>