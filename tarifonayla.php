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
                    <span class="glyphicon glyphicon-search search-icon"></span><input type="text" name="ara" class="search-box"
                        placeholder="Tarif ara..">
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
                            include("connection.php");
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
                    <h1 class="baslik">Tarif Onayla</h1>
                </div>
                <!-- <h3 style="color:white; border-bottom: 1px solid white; width: 250px; padding-bottom: 5px;">Onay Bekleyen Tarifler</h3> -->
                <div class="tarifBilgileri">
                <?php

                    $select = "SELECT * FROM tarif";
                    $selectResult = $conn->query($select);

                    $select2 = "SELECT * FROM malzeme";
                    $selectResult2 = $conn->query($select2);

                    while ($row2 = $selectResult2->fetch()) {
                        $malzemeler[] = $row2;
                    }

                    while ($row = $selectResult->fetch()) {
                        $malzemeler2 = explode(",", $row['tarif_malzeme']);
                        if ($row['tarif_izin'] == 0) {
                            echo '<form action="" method="post">';
                            echo '
                            <div class="tarifKutusu" id="' . str_replace(" ", "", $row['tarif_baslik']) . '">
                            <span class="tarifTarih">'.$row["tarif_tarih"].'</span>
                            <span class="tarifYazar"><b>'.$row["tarif_yazar"].'</b></span>
                            <h1 class="tarifAdi">' . $row['tarif_baslik'] . '</h1>
                            <div class="posit">
                            <img src="yuklenendosyalar/' . $row['tarif_gorsel'] . '" class="tarifGorsel inb" height="300">
                            <p class="tarifAciklama inb">
                            ' . $row['tarif_aciklama'] . '</p>
                            </div>
                        </div>
                        <table class="malzemeTablo2">
                        <tr><td colspan=2 class="malzBaslik">Malzemeler</td></tr>
                            ';

                            foreach ($malzemeler as $malzeme) {
                                foreach ($malzemeler2 as $malzeme2) {
                                    if ($malzeme['malzeme_adi'] == $malzeme2) {
                                        echo '
                                        <tr><td><img style="margin: 0px; " src="yuklenendosyalar/malzemeler/' . $malzeme['malzeme_gorsel'] . '" height="25" class="tarifMalzemeGorsel tariflerMalz"></td><td>
                                        <span style="color:white; padding: 5px; margin-left: 0px;">' . $malzeme['malzeme_adi'] . '
                                        </span></td></tr>';
                                    }
                                }
                            }
                            echo '</table>';
                            echo '<br><input type="hidden" name="allowId" value="' . $row["tarif_id"] . '">
                            <input type="submit" style="color: black;" name="onayla" class="submitBtn" value="ONAYLA">';
                            echo '<input type="hidden" name="deleteId" value="' . $row["tarif_id"] . '">
                            <input type="submit" style="color: black;" name="sil" class="submitBtn" value="SİL">';
                            echo "</form>";
                        }
                    }
                    ?>
                </div>
                <div class="tarifKutucuk">
                <!-- <form action="" method="POST">
                    <table class="tarifEkle" style="margin-top: 120px;">
                        <tr>
                            <td>Tarif Numarası:</td>
                            <td><input type="text" name="allowId" class="inputLogin" required></td>
                        </tr>
                            <td></td>
                            <td><input class="submitBtn" type="submit" name="onayla" value="Onayla"></td>
                        </tr>
                    </table>
                </form> -->
                </div>
            </center>
        </div>
    </center>
</body>

</html>
<?php
if (isset($_POST['onayla'])) {
    $allowID = $_POST['allowId'];

    $update = "UPDATE tarif set tarif_izin = 1 where tarif_id = $allowID";
    $result = $conn -> exec($update);

    if ($result) {
        echo '
        <script>
        alert("Tarif başarıyla onaylandı."); 
        </script>
        ';
    }
}

if (isset($_POST['sil'])) {
    $deleteID = $_POST['deleteId'];

    $delete = "DELETE FROM tarif where tarif_id = $deleteID";
    $result = $conn -> exec($delete);

    if ($result) {
        echo '
        <script>
        alert("Tarif başarıyla silindi."); 
        </script>
        ';
        header("Refresh:0");
    }
}
?>