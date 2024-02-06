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
                <?php

                ?>
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
                    <h1 class="baslik">Yapabileceğim Tarifler</h1>
                </div>
                <div class="tarifler">
                    <?php
                    include("connection.php");

                    if (isset($_SESSION["user"])) {
                        $eslesenMalzeme = 0;

                        $select = "SELECT * FROM tarif";
                        $selectResult = $conn->query($select);

                        $select2 = "SELECT * FROM malzeme";
                        $selectResult2 = $conn->query($select2);

                        $select3 = "SELECT * FROM kullanici";
                        $selectResult3 = $conn->query($select3);

                        while ($row2 = $selectResult2->fetch()) {
                            $malzemeListesi[] = $row2;
                            $malzList[] = $row2["malzeme_adi"];
                        }

                        while ($rowK = $selectResult3->fetch()) {
                            if ($_SESSION["user"] == $rowK["kullanici_adi"]) {
                                $kullaniciMalzemeler = explode(",", $rowK["kullanici_malzeme"]);
                            }
                        }

                        while ($rowT = $selectResult->fetch()) {
                            $tarifMalzemelerEski = explode(",", $rowT["tarif_malzeme"]);
                            foreach($tarifMalzemelerEski as $tarifMalzeme) {
                                if (in_array($tarifMalzeme, $malzList)) {
                                    $tarifMalzemeler[] = $tarifMalzeme;
                                }
                            }
                            foreach ($kullaniciMalzemeler as $kullaniciMalzeme) {
                                if (in_array($kullaniciMalzeme, $tarifMalzemeler)) {
                                    $eslesenMalzeme++;
                                }
                            }
                            if (count($tarifMalzemeler) == $eslesenMalzeme) {
                                if ($rowT['tarif_izin'] == 1) {
                                    echo '
                                    <a href="tumtarifler.php#' . str_replace(" ", "", $rowT['tarif_baslik']) . '"><div class="box" style="background-image: url(yuklenendosyalar/' . $rowT["tarif_gorsel"] . ');">
                                    <div class="tarifIcerik"><div class="tarifBaslik">' . $rowT["tarif_baslik"] . '</div>
                                    <div class="tarifMalzemeler">';
                                    // <img src="yuklenendosyalar/malzemeler/'.$row2['malzeme_gorsel'].'" height="25" class="tarifMalzemeGorsel">
                                    // </div>
                                    // </div></div></a>
                                    foreach ($malzemeListesi as $malzeme) {
                                        foreach ($tarifMalzemeler as $malzeme2) {
                                            if ($malzeme['malzeme_adi'] == $malzeme2) {
                                                echo '<img style="margin: 1px;" src="yuklenendosyalar/malzemeler/' . $malzeme['malzeme_gorsel'] . '" height="25" class="tarifMalzemeGorsel">';
                                            }
                                        }
                                    }
                                    echo '</div></div></div></a>';


                                }
                            }
                            $eslesenMalzeme = 0;
                            $tarifMalzemeler = array();
                        }
                    } else {
                        header("location:index.php");
                    }
                    ?>
                    <div class="lineBox">
                        <h1 class="baslik">1 Eksik Malzeme</h1>
                    </div>
                    <?php
                    if (isset($_SESSION["user"])) {
                        $malzemeListesi = array();
                        $eslesenMalzeme = 0;

                        $select = "SELECT * FROM tarif";
                        $selectResult = $conn->query($select);

                        $select2 = "SELECT * FROM malzeme";
                        $selectResult2 = $conn->query($select2);

                        $select3 = "SELECT * FROM kullanici";
                        $selectResult3 = $conn->query($select3);

                        while ($row2 = $selectResult2->fetch()) {
                            $malzemeListesi[] = $row2;
                        }

                        while ($rowK = $selectResult3->fetch()) {
                            if ($_SESSION["user"] == $rowK["kullanici_adi"]) {
                                $kullaniciMalzemeler = explode(",", $rowK["kullanici_malzeme"]);
                            }
                        }

                        while ($rowT = $selectResult->fetch()) {
                            $tarifMalzemelerEski = explode(",", $rowT["tarif_malzeme"]);
                            foreach($tarifMalzemelerEski as $tarifMalzeme) {
                                if (in_array($tarifMalzeme, $malzList)) {
                                    $tarifMalzemeler[] = $tarifMalzeme;
                                }
                            }
                            foreach ($kullaniciMalzemeler as $kullaniciMalzeme) {
                                if (in_array($kullaniciMalzeme, $tarifMalzemeler)) {
                                    $eslesenMalzeme++;
                                }
                            }
                            if ((count($tarifMalzemeler)-1) == $eslesenMalzeme) {
                                if ($rowT['tarif_izin'] == 1) {
                                    echo '
                                    <a href="tumtarifler.php#' . str_replace(" ", "", $rowT['tarif_baslik']) . '"><div class="box" style="background-image: url(yuklenendosyalar/' . $rowT["tarif_gorsel"] . ');">
                                    <div class="tarifIcerik"><div class="tarifBaslik">' . $rowT["tarif_baslik"] . '</div>
                                    <div class="tarifMalzemeler">';
                                    // <img src="yuklenendosyalar/malzemeler/'.$row2['malzeme_gorsel'].'" height="25" class="tarifMalzemeGorsel">
                                    // </div>
                                    // </div></div></a>
                                    foreach ($malzemeListesi as $malzeme) {
                                        foreach ($tarifMalzemeler as $malzeme2) {
                                            if ($malzeme['malzeme_adi'] == $malzeme2) {
                                                echo '<img style="margin: 1px;" src="yuklenendosyalar/malzemeler/' . $malzeme['malzeme_gorsel'] . '" height="25" class="tarifMalzemeGorsel">';
                                            }
                                        }
                                    }
                                    echo '</div></div></div></a>';


                                }
                            }
                            
                            $eslesenMalzeme = 0;
                            $tarifMalzemeler = array();
                        }
                    } else {
                        header("location:index.php");
                    }
                    ?>
                </div>
            </center>
        </div>
    </center>
    <div>
        <?php
        if (isset($_SESSION["user"])) {
            echo '
            <a href="tarifekle.php"><div class="siparisSiteButon">
            TARİF EKLE
            </div></a>
            ';
        }
        ?>
    </div>
</body>

</html>