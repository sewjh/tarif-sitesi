<?php
session_start();
if (!isset($_SESSION['user'])) {
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

<body>
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
                        <li><a href="index.php">Ana Sayfa</a></li>
                        <li><a href="tarifler.php">Tarif Arama</a></li>
                        <li><a href="tumtarifler.php">Tarifler</a></li>
                        <li><a href="hakkimizda.php">Hakkımızda</a></li>
                        <li><a href="iletisim.php">İletişim</a></li>
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
                    <h1 class="baslik">Tarif Ekle</h1>
                </div>
                <div class="tarifKutucuk">
                    <form enctype="multipart/form-data" action="" method="POST">
                        <table class="tarifEkle">
                            <tr>
                                <td>Tarif Adı:</td>
                                <td><input type="text" name="baslik" class="inputLogin" required></td>
                            </tr>
                            <tr>
                                <td>Tarif Açıklaması:</td>
                                <td><textarea name="aciklama" class="inputLogin" rows="4" cols="50" required></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>Tarif Türü:</td>
                                <td>
                                    <select name="tur" class="inputLogin" required>
                                        <option value="kahvalti">Kahvaltı</option>
                                        <option value="ogle">Öğle Yemeği</option>
                                        <option value="aksam">Akşam Yemeği</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Tarif Görseli:</td>
                                <td><input type="FILE"
                                        style="border-radius: 7px; background-color: white; color: black;" name="dosya"
                                        required></td>
                            </tr>
                            <tr>
                                <td>Tarif Malzemeleri:</td>
                                <td>
                                    <input type="text" name="malzeme" class="inputLogin" style="width: 500px;" placeholder="Lütfen aşağıdaki malzemelere göre yazınız.">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input class="submitBtn" type="submit" name="yukle" value="Yukle"></td>
                            </tr>
                        </table>
                    </form>
                    <br>
                    <ul>
                        <h4 class="malzBaslik" style="display: inline-block";>Malzemeler</h4>
                        <?php
                        $selectMalzeme = $conn->query("SELECT * FROM malzeme");

                        echo '<table class="malzemeTablo">';
                        while ($row = $selectMalzeme->fetch()) {
                            echo '
                                        <tr><td></td><td><li style="list-style: none;"><img style="margin: 0px;" src="yuklenendosyalar/malzemeler/' . $row['malzeme_gorsel'] . '" height="25" class="tarifMalzemeGorsel">
                                        <span style="color: white;padding: 5px; margin-left: 0px;">' . $row['malzeme_adi'] . '
                                        </span></li></td></tr>';
                        }
                        echo '</table>';
                        ?>
                    </ul>
                </div>

        </div>
    </center>
    </div>
    </center>
</body>

</html>
<?php
if (isset($_POST["yukle"])) {
    $tarifBaslik = $_POST["baslik"];
    $tarifAciklama = $_POST["aciklama"];
    $tarifGorsel = $_FILES['dosya']['name'];
    $tarifTur = $_POST["tur"];
    $tarifMalzeme = $_POST["malzeme"];
    $tarifYazar = $_SESSION["user"];
    $tarih = date('Y.m.d');

    $malzemeler = explode(',', $tarifMalzeme);
    foreach ($malzemeler as $malzeme) {
        // echo "<script> alert('$malzeme'); </script>";
    }

    $add = "INSERT INTO tarif (tarif_baslik, tarif_aciklama, tarif_gorsel, tarif_yazar, tarif_tur, tarif_malzeme, tarif_tarih) VALUES ('" . $tarifBaslik . "','" . $tarifAciklama . "','" . $tarifGorsel . "','" . $tarifYazar . "','" . $tarifTur . "','" . $tarifMalzeme . "','" . $tarih . "')";

    if ($conn->exec($add) == TRUE) {
        echo "<script>alert('Tarif başarıyla moderatorlerin onayina gonderildi!')</script>";
    }

    $dizin = 'yuklenendosyalar/';
    $yuklenecek_dosya = $dizin . basename($_FILES['dosya']['name']);

    if (move_uploaded_file($_FILES['dosya']['tmp_name'], $yuklenecek_dosya)) {
        // echo $_FILES['dosya']['name'];

    } else {
        // echo "Dosya yüklenemedi!\n";
    }
}
?>