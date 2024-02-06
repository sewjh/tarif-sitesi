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
                    <span class="glyphicon glyphicon-search search-icon"></span><input type="text" name="ara" class="search-box"
                        placeholder="Tarif ara..">
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
                            $db = new PDO("mysql:host=localhost;dbname=yemek_db","root","");
                            if ($db) {
                                echo '<script>alert("tet");</script>';
                            }
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
                            $sctrn = $db -> query($sct);

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
                <div class="bannerBox">
                    <div class="banner">
                        <h3 class="bannerText">Ev hanımlarına ve öğrencilere ek gelir fırsatı olan ev yemeği hizmetimizi denediniz mi?</h3>
                    </div>
                </div>
                    <div class="lineBox">
                        <h1 class="baslik">Son Tarifler</h1>
                    </div>
                <div class="tarifler">
                <?php

                    $select = "SELECT * FROM tarif";
                    $selectResult = $db->query($select);

                    $select2 = "SELECT * FROM malzeme";
                    $selectResult2 = $db->query($select2);

                    while ($row2 = $selectResult2->fetch()) {
                        $malzemeListesi[] = $row2;
                    }

                    while ($row = $selectResult->fetch()) {
                        $malzemeListesi2 = explode(",",$row['tarif_malzeme']);
                        if ($row['tarif_izin'] == 1) {
                            echo '
                        <a href="tumtarifler.php#' . str_replace(" ", "", $row['tarif_baslik']) . '"><div class="box" style="background-image: url(yuklenendosyalar/' . $row["tarif_gorsel"] . ');">
                        <div class="tarifIcerik"><div class="tarifBaslik">' . $row["tarif_baslik"] . '</div>
                        <div class="tarifMalzemeler">';
                            // <img src="yuklenendosyalar/malzemeler/'.$row2['malzeme_gorsel'].'" height="25" class="tarifMalzemeGorsel">
                            // </div>
                            // </div></div></a>
                            foreach ($malzemeListesi as $malzeme) {
                                foreach($malzemeListesi2 as $malzeme2) {
                                    if($malzeme['malzeme_adi'] == $malzeme2) {
                                echo '<img style="margin: 1px;" src="yuklenendosyalar/malzemeler/' . $malzeme['malzeme_gorsel'] . '" height="25" class="tarifMalzemeGorsel">';
                            }}}
                            echo '</div></div></div></a>';
                        }
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