<?php
include("connection.php");
session_start();
if(isset($_SESSION["user"])) {
    $sct = "SELECT * FROM kullanici";
    $sctrn = $conn -> query($sct);

    while($rw = $sctrn -> fetch()) {
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
                    <h1 class="baslik">Kontrol Paneli</h1>
                </div>
                <?php
                echo '<span style="color:white;">Giriş yapan admin: <b>'.$_SESSION["user"].'</b></span>'
                ?>
            </center>
        </div>
    </center>
</body>

</html>

<?php
if (isset($_POST["yasakla"])) {
    $yasaklanacak = $_POST["yasaklanacakKullanici"];

    $manitamacokasigim = "UPDATE kullanici set kullanici_yasakli = 'true' where kullanici_adi = '" . $yasaklanacak . "'";
    $result = $conn->exec($manitamacokasigim);
}
if (isset($_POST["yasakkaldir"])) {
    $yasaklanacak = $_POST["yasaklanacakKullanici"];

    $manitamacokasigim = "UPDATE kullanici set kullanici_yasakli = 'false' where kullanici_adi = '" . $yasaklanacak . "'";
    $result = $conn->exec($manitamacokasigim);
}
?>