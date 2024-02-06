<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
                            session_start();
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
                    <h1 class="baslik">Tüm Tarifler</h1>
                </div>
                <div class="tumTarifler">
                    <?php
                    include("connection.php");

                    $select = "SELECT * FROM tarif";
                    $selectResult = $conn->query($select);

                    $select2 = "SELECT * FROM malzeme";
                    $selectResult2 = $conn->query($select2);

                    while ($row2 = $selectResult2->fetch()) {
                        $malzemeler[] = $row2;
                    }

                    while ($row = $selectResult->fetch()) {
                        $malzemeler2 = explode(",", $row['tarif_malzeme']);
                        if ($row['tarif_izin'] == 1) {
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
                            if (isset($_SESSION["user"])) {

                                $select = "SELECT * FROM kullanici";
                                $result = $conn->query($select);

                                while ($row = $result->fetch()) {
                                    if ($_SESSION["user"] == $row["kullanici_adi"]) {
                                        $malzemeler4 = explode(",", $row['kullanici_malzeme']);
                                    }
                                }

                                $select2 = "SELECT * FROM malzeme";
                                $selectResult2 = $conn->query($select2);

                                while ($row2 = $selectResult2->fetch()) {
                                    $malz[] = $row2;
                                    $malzemeler5[] = $row2["malzeme_adi"];
                                }

                                $select5 = "SELECT * FROM malzeme";
                                $result5 = $conn->query($select5);

                                
                                foreach ($malzemeler as $malzeme) {
                                    foreach ($malzemeler2 as $malzeme2) {
                                        if ($malzeme['malzeme_adi'] == $malzeme2) {
                                            if (in_array($malzeme2, $malzemeler4)) {
                                                echo '<tr><td><img style="margin: 0px;" src="yuklenendosyalar/malzemeler/' . $malzeme['malzeme_gorsel'] . '" height="25" class="tarifMalzemeGorsel tariflerMalz">
                                                </td><td><span style="color: rgb(37, 214, 37); padding: 5px; margin-left: 0px;">' . $malzeme["malzeme_adi"] . '</span></td><td style="border:0;"><i style="color:white; margin-top: -15px;" class="material-icons">done</i></td></tr>';
                                            } else {
                                                echo '<tr><td><img style="margin: 0px;" src="yuklenendosyalar/malzemeler/' . $malzeme['malzeme_gorsel'] . '" height="25" class="tarifMalzemeGorsel tariflerMalz">
                                                </td><td><span style="color: red; text-decoration: line-through; padding: 5px; margin-left: 0px;">' . $malzeme["malzeme_adi"] . '</span></td></tr>';
                                            }
                                        }
                                    }
                                }
                                $malzemeler5 = array();
                                $malz = array();
                                echo "</table>";
                            } else {
                                foreach ($malzemeler as $malzeme) {
                                    foreach ($malzemeler2 as $malzeme2) {
                                        if ($malzeme['malzeme_adi'] == $malzeme2) {
                                            echo '<tr><td><img style="margin: 0px;" src="yuklenendosyalar/malzemeler/' . $malzeme['malzeme_gorsel'] . '" height="25" class="tarifMalzemeGorsel tariflerMalz">
                                            </td><td><span style="color: white; padding: 5px; margin-left: 0px;">' . $malzeme["malzeme_adi"] . '</span></td></tr>';
                                        }
                                    }
                                }
                                echo "</table>";
                            }
                            
                        }
                    }
                    ?>
                </div>
        </div>
    </center>
    </div>
    </center>
    <?php
    if (isset($_SESSION["user"])) {
        echo '
            <a href="tarifekle.php"><div class="siparisSiteButon">
            TARİF EKLE
            </div></a>
            ';
    }
    ?>
</body>

</html>