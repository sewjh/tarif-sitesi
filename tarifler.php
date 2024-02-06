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
                <div class="recipeSearch-box">
                    <div>
                        <form action="" method="post">
                            <select name="recipeType" class="recipeSearchSelect">
                                <option value="hepsi">Tümü</option>
                                <option value="kahvalti">Kahvaltı</option>
                                <option value="ogle">Öğle Yemeği</option>
                                <option value="aksam">Akşam Yemeği</option>
                            </select>
                            <input type="text" name="recipeName" class="recipeSearchText"
                                placeholder="Aramak istediğiniz tarifi yazınız...">
                            <input type="submit" value="Ara" name="search" class="recipeSearchButton">
                            <input type="submit" value="Türüne Göre Ara" name="typeSearch"
                                class="recipeSearchButton recipeTypeSearchButton">
                        </form>
                    </div>
                </div>
                <div class="lineBox">
                    <h1 class="baslik">Tarifler</h1>
                </div>
                <div class="tarifler">
                    <?php
                    include("connection.php");

                    if (isset($_POST['search'])) {
                        $aramaSonucu = $_POST['recipeName'];

                        $filterSelect = "SELECT * FROM tarif where tarif_baslik like '%" . $aramaSonucu . "%'";
                        $filterResult = $conn->query($filterSelect);


                        $select2 = "SELECT * FROM malzeme";
                        $selectResult2 = $conn->query($select2);

                        while ($row2 = $selectResult2->fetch()) {
                            $malzemeListesi[] = $row2;
                        }

                        while ($row = $filterResult->fetch()) {
                            $malzemeListesi2 = explode(",", $row['tarif_malzeme']);
                            if ($row['tarif_izin'] == 1) {
                                echo '
                            <a href="tumtarifler.php#' . str_replace(" ", "", $row['tarif_baslik']) . '"><div class="box" style="background-image: url(yuklenendosyalar/' . $row["tarif_gorsel"] . ');">
                            <div class="tarifIcerik"><div class="tarifBaslik">' . $row["tarif_baslik"] . '</div>
                            <div class="tarifMalzemeler"></a>';
                                // <img src="yuklenendosyalar/malzemeler/'.$row2['malzeme_gorsel'].'" height="25" class="tarifMalzemeGorsel">
                                // </div>
                                // </div></div></a>
                                foreach ($malzemeListesi as $malzeme) {
                                    foreach ($malzemeListesi2 as $malzeme2) {
                                        if ($malzeme['malzeme_adi'] == $malzeme2) {
                                            echo '<img style="margin: 1px;" src="yuklenendosyalar/malzemeler/' . $malzeme['malzeme_gorsel'] . '" height="25" class="tarifMalzemeGorsel">';
                                        }
                                    }
                                }
                                echo '</div></div></div>';
                            }
                        }

                    } else if (isset($_POST['typeSearch'])) {
                        $tarifTur = $_POST['recipeType'];

                        if ($tarifTur == "hepsi") {
                            $filterSelect = "SELECT * FROM tarif";
                        } else {
                            $filterSelect = "SELECT * FROM tarif where tarif_tur like '" . $tarifTur . "'";
                        }
                        $filterResult = $conn->query($filterSelect);


                        $select2 = "SELECT * FROM malzeme";
                        $selectResult2 = $conn->query($select2);

                        while ($row2 = $selectResult2->fetch()) {
                            $malzemeListesi[] = $row2;
                        }

                        while ($row = $filterResult->fetch()) {
                            $malzemeListesi2 = explode(",", $row['tarif_malzeme']);
                            if ($row['tarif_izin'] == 1) {
                                echo '
                            <a href="tumtarifler.php#' . str_replace(" ", "", $row['tarif_baslik']) . '"><div class="box" style="background-image: url(yuklenendosyalar/' . $row["tarif_gorsel"] . ');">
                            <div class="tarifIcerik"><div class="tarifBaslik">' . $row["tarif_baslik"] . '</div>
                            <div class="tarifMalzemeler"></a>';
                                // <img src="yuklenendosyalar/malzemeler/'.$row2['malzeme_gorsel'].'" height="25" class="tarifMalzemeGorsel">
                                // </div>
                                // </div></div></a>
                                foreach ($malzemeListesi as $malzeme) {
                                    foreach ($malzemeListesi2 as $malzeme2) {
                                        if ($malzeme['malzeme_adi'] == $malzeme2) {
                                            echo '<img style="margin: 1px;" src="yuklenendosyalar/malzemeler/' . $malzeme['malzeme_gorsel'] . '" height="25" class="tarifMalzemeGorsel">';
                                        }
                                    }
                                }
                                echo '</div></div></div>';
                            }
                        }
                    } else {

                        $select = "SELECT * FROM tarif ORDER BY tarif_baslik ASC";
                        $selectResult = $conn->query($select);

                        $select2 = "SELECT * FROM malzeme";
                        $selectResult2 = $conn->query($select2);

                        while ($row2 = $selectResult2->fetch()) {
                            $malzemeListesi[] = $row2;
                        }

                        while ($row = $selectResult->fetch()) {
                            $malzemeListesi2 = explode(",", $row['tarif_malzeme']);
                            if ($row['tarif_izin'] == 1) {
                                echo '
                        <a href="tumtarifler.php#' . str_replace(" ", "", $row['tarif_baslik']) . '"><div class="box" style="background-image: url(yuklenendosyalar/' . $row["tarif_gorsel"] . ');">
                        <div class="tarifIcerik"><div class="tarifBaslik">' . $row["tarif_baslik"] . '</div>
                        <div class="tarifMalzemeler"></a>';
                                // <img src="yuklenendosyalar/malzemeler/'.$row2['malzeme_gorsel'].'" height="25" class="tarifMalzemeGorsel">
                                // </div>
                                // </div></div></a>
                                foreach ($malzemeListesi as $malzeme) {
                                    foreach ($malzemeListesi2 as $malzeme2) {
                                        if ($malzeme['malzeme_adi'] == $malzeme2) {
                                            echo '<img style="margin: 1px;" src="yuklenendosyalar/malzemeler/' . $malzeme['malzeme_gorsel'] . '" height="25" class="tarifMalzemeGorsel">';
                                        }
                                    }
                                }
                                echo '</div></div></div>';
                            }
                        }
                    }

                    ?>

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