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
    <style>
        div.hakkimizda {
            display: flex;
            justify-content: space-between;
            margin: 25px;
        }

        p.hakkimizdaYazi {
            color: white;
            font-size: 20px;
            padding: 5px 30px;
            margin-right: 10px;
            margin-top: 50px;
        }

        img.hakkimizdaFoto {
            border: 1px solid white;
        }

        .hakkimizdaBaslik {
            color: white;
        }
    </style>

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

        <div class="main-box" style="position: relative" ;>
            <center>
                <div class="lineBox">
                    <h1 class="baslik" style="font-size: 34px;">Malzemeler</h1>
                </div>
                <div class="profilMenu">
                    <ul>
                        <li><a href="profilfoto.php">Profil Fotoğrafı</a></li>
                        <li><a href="parola.php">Parola Değiştir</a></li>
                        <li><a href="malzemelerim.php">Malzemeler</a></li>
                        <li><a href="yapilabilecekler.php">Yapabildiğim Tarifler</a></li>
                        <li><a href="">Seçenek 4</a></li>
                        <li><a href="">Seçenek 5</a></li>
                        <li><a href="">Seçenek 6</a></li>
                    </ul>
                </div>
                <?php
                if (isset($_SESSION["user"])) {
                    $select = "SELECT * FROM kullanici";
                    $result = $conn->query($select);

                    while ($row = $result->fetch()) {
                        if ($_SESSION["user"] == $row["kullanici_adi"]) {
                            echo "<img src='profilfoto/" . $row["kullanici_foto"] . "' class='pp'>";
                            echo "<span style='color:white; font-size: 25px;'><b>" . $row['kullanici_adi'] . "</b></span>";
                        }
                    }

                } else {
                    header("location:giris.php");
                }
                ?>
                <div class="malzemelerBox">
                    <h2 class="malzemelerBaslik">Mevcut Malzemeler</h2>
                    <ul class="malzemeler">
                        <?php
                        $select = "SELECT * FROM kullanici";
                        $result = $conn->query($select);

                        while ($row = $result->fetch()) {
                            if ($_SESSION["user"] == $row["kullanici_adi"]) {
                                $malzemeler = explode(",", $row['kullanici_malzeme']);
                            }
                        }

                        $select2 = "SELECT * FROM malzeme";
                        $selectResult2 = $conn->query($select2);

                        while ($row2 = $selectResult2->fetch()) {
                            $malzemeler2[] = $row2;
                        }

                        echo '<table class="malzemeTablo">';
                        foreach ($malzemeler as $malzeme) {
                            foreach ($malzemeler2 as $malzeme2) {
                                if ($malzeme == $malzeme2["malzeme_adi"]) {
                                    echo '
                                        <tr><td><li><img style="margin: 0px;" src="yuklenendosyalar/malzemeler/' . $malzeme2['malzeme_gorsel'] . '" height="25" class="tarifMalzemeGorsel"></td><td>
                                        <span style="color: white;padding: 5px; margin-left: 0px;">' . $malzeme2['malzeme_adi'] . '
                                        </span></li></td></tr>';
                                }
                            }
                        }
                        echo '</table>'
                            ?>
                    </ul>
                </div>
                <div class="malzemelerBox">
                    <h2 class="malzemelerBaslik">Tüm Malzemeler</h2>
                    <ul class="malzemeler">
                        <?php
                        $select = "SELECT * FROM kullanici";
                        $result = $conn->query($select);

                        while ($row = $result->fetch()) {
                            if ($_SESSION["user"] == $row["kullanici_adi"]) {
                                $malzemeler = explode(",", $row['kullanici_malzeme']);
                            }
                        }

                        $select2 = "SELECT * FROM malzeme";
                        $selectResult2 = $conn->query($select2);


                        echo '<table class="malzemeTablo">';
                        while ($row2 = $selectResult2->fetch()) {
                            foreach ($malzemeler as $malzeme) {
                                if ($row2["malzeme_adi"] == $malzeme) {
                                    echo '<form action="" method="post">';
                                    echo '<tr><td><li><img style="margin: 0px;" src="yuklenendosyalar/malzemeler/' . $row2['malzeme_gorsel'] . '" height="25" class="tarifMalzemeGorsel">
                                    </td><td><span style="color: rgb(37, 214, 37);padding: 5px; margin-left: 0px;">' . $row2["malzeme_adi"] . '</span></td><td>
                                    <input type="hidden" name="malzemeID" value="' . $row2["malzeme_id"] . '">
                                    <input type="submit" style="background-color:white; border: 1.5px solid red;" name="malzemeyiCikar" class="malzemeButon" value="-">
                                    </li></td>';
                                    echo '</form>';
                                }

                            }
                            $malz[] = $row2;
                            $malzemeler5[] = $row2["malzeme_adi"];
                        }


                        $select5 = "SELECT * FROM malzeme";
                        $result5 = $conn->query($select5);


                        foreach ($malzemeler5 as $m1) {
                            if (!in_array($m1, $malzemeler)) {
                                foreach ($malz as $row5) {
                                    if ($m1 == $row5["malzeme_adi"]) {
                                        echo '<form action="" method="post">';
                                        echo '<tr><td><li><img style="margin: 0px;" src="yuklenendosyalar/malzemeler/' . $row5['malzeme_gorsel'] . '" height="25" class="tarifMalzemeGorsel">
                                            </td><td><span style="color: red;padding: 5px; margin-left: 0px;">' . $row5["malzeme_adi"] . '</span></td><td>
                                            <input type="hidden" name="malzemeID" value="' . $row5["malzeme_id"] . '">
                                            <input type="submit" style="background-color:white; border:1.5px solid rgb(37, 214, 37);" name="malzemeyiEkle" class="malzemeButon" value="+">
                                            </li></td>';
                                        echo '</form>';
                                    }
                                }
                            }
                        }
                        echo '</table>';


                        // while($row3 = $selectResult2->fetch_assoc()) {
                        //     if ($m == $row3['malzeme_adi']) {
                        //         echo '<li><img style="margin: 1px;" src="yuklenendosyalar/malzemeler/' . $row3['malzeme_gorsel'] . '" height="25" class="tarifMalzemeGorsel">
                        //         <span style="color: green;">'.$row3["malzeme_adi"].'</span></li>';
                        //     }
                        // }
                        //}
                        
                        ?>
                    </ul>
                </div>
                <br>
                <!-- <form action="" method="post">
                    <label for="eklenecekMalzID">Malzeme Numarası:</label>
                    <input type="text" id="eklenecekMalzID" style="width:50px;" name="eklenecekMalzID"
                        class="inputText"><br>
                    <input type="submit" id="ekleBtn" name="ekle" value="EKLE" class="submitBtn"
                        style="margin-top: 10px;">
                    <input type="submit" id="cikarBtn" name="cikar" value="ÇIKAR" class="submitBtn"
                        style="margin-top: 10px;">
                </form> -->
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
<script type="text/javascript">
    document.getElementById("ekleBtn").addEventListener("click", function () {
        window.location.reload()
    });
    document.getElementById("cikarBtn").addEventListener("click", function () {
        window.location.reload()
    });
</script>

</html>
<?php
if (isset($_POST["malzemeyiEkle"])) {
    $malzemeID = $_POST["malzemeID"];

    $eklenecek = $_POST['malzemeID'];

    $selectKullanici = "SELECT * FROM kullanici";
    $selectMalzeme = "SELECT * FROM malzeme";

    $resultKullanici = $conn->query($selectKullanici);
    $resultMalzeme = $conn->query($selectMalzeme);


    while ($rowMalzeme = $resultMalzeme->fetch()) {
        if ($eklenecek == $rowMalzeme["malzeme_id"]) {
            $eklenecekMalzAdi = $rowMalzeme["malzeme_adi"];
            while ($rowKullanici = $resultKullanici->fetch()) {
                if ($_SESSION["user"] == $rowKullanici["kullanici_adi"]) {
                    $kullaniciMalzeme = explode(",", $rowKullanici["kullanici_malzeme"]);
                    if (in_array($eklenecekMalzAdi, $kullaniciMalzeme)) {
                        echo "<script>
                        alert('Eklemeye çalıştığınız malzeme zaten mevcut.');
                        </script>";
                    } else {
                        $kullaniciMalzeme[] = $eklenecekMalzAdi;
                        $add = "UPDATE kullanici set kullanici_malzeme = '" . implode(",", $kullaniciMalzeme) . "' where kullanici_id = " . $rowKullanici['kullanici_id'];
                        $addResult = $conn->exec($add);
                        if ($addResult) {
                            // echo "<script>
                            // alert('Malzeme ekleme başarılı.');
                            // </script>";
                            header("Refresh:0");
                        } else {
                            echo "<script>
                            alert('Malzeme ekleme başarısız.');
                            </script>";
                        }
                    }
                }
            }
        }
    }
}

if (isset($_POST["malzemeyiCikar"])) {
    $malzemeID = $_POST["malzemeID"];

    $eklenecek = $_POST['malzemeID'];

    $selectKullanici = "SELECT * FROM kullanici";
    $selectMalzeme = "SELECT * FROM malzeme";

    $resultKullanici = $conn->query($selectKullanici);
    $resultMalzeme = $conn->query($selectMalzeme);


    while ($rowMalzeme = $resultMalzeme->fetch()) {
        if ($eklenecek == $rowMalzeme["malzeme_id"]) {
            $eklenecekMalzAdi = $rowMalzeme["malzeme_adi"];
            while ($rowKullanici = $resultKullanici->fetch()) {
                if ($_SESSION["user"] == $rowKullanici["kullanici_adi"]) {
                    $kullaniciMalzeme = explode(",", $rowKullanici["kullanici_malzeme"]);
                    if (!in_array($eklenecekMalzAdi, $kullaniciMalzeme)) {
                        echo "<script>
                        alert('Çıkarmaya çalıştığınız malzeme mevcut değil.');
                        </script>";
                    } else {
                        foreach ($kullaniciMalzeme as $key => $value) {
                            if ($eklenecekMalzAdi == $value) {
                                unset($kullaniciMalzeme[$key]);
                            }
                        }
                        $add = "UPDATE kullanici set kullanici_malzeme = '" . implode(",", $kullaniciMalzeme) . "' where kullanici_id = " . $rowKullanici['kullanici_id'];
                        $addResult = $conn->exec($add);
                        if ($addResult) {
                            header("Refresh:0");
                        } else {
                            echo "<script>
                            alert('Malzeme çıkarma başarısız.');
                            </script>";
                        }
                    }
                }
            }
        }
    }
}

if (isset($_POST['ekle'])) {
    $eklenecek = $_POST['eklenecekMalzID'];

    $selectKullanici = "SELECT * FROM kullanici";
    $selectMalzeme = "SELECT * FROM malzeme";

    $resultKullanici = $conn->query($selectKullanici);
    $resultMalzeme = $conn->query($selectMalzeme);


    while ($rowMalzeme = $resultMalzeme->fetch()) {
        if ($eklenecek == $rowMalzeme["malzeme_id"]) {
            $eklenecekMalzAdi = $rowMalzeme["malzeme_adi"];
            while ($rowKullanici = $resultKullanici->fetch()) {
                if ($_SESSION["user"] == $rowKullanici["kullanici_adi"]) {
                    $kullaniciMalzeme = explode(",", $rowKullanici["kullanici_malzeme"]);
                    if (in_array($eklenecekMalzAdi, $kullaniciMalzeme)) {
                        echo "<script>
                        alert('Eklemeye çalıştığınız malzeme zaten mevcut.');
                        </script>";
                    } else {
                        $kullaniciMalzeme[] = $eklenecekMalzAdi;
                        $add = "UPDATE kullanici set kullanici_malzeme = '" . implode(",", $kullaniciMalzeme) . "' where kullanici_id = " . $rowKullanici['kullanici_id'];
                        $addResult = $conn->exec($add);
                        if ($addResult) {
                            // echo "<script>
                            // alert('Malzeme ekleme başarılı.');
                            // </script>";
                            header("Refresh:0");
                        } else {
                            echo "<script>
                            alert('Malzeme ekleme başarısız.');
                            </script>";
                        }
                    }
                }
            }
        }
    }
}

if (isset($_POST['cikar'])) {
    $eklenecek = $_POST['eklenecekMalzID'];

    $selectKullanici = "SELECT * FROM kullanici";
    $selectMalzeme = "SELECT * FROM malzeme";

    $resultKullanici = $conn->query($selectKullanici);
    $resultMalzeme = $conn->query($selectMalzeme);


    while ($rowMalzeme = $resultMalzeme->fetch()) {
        if ($eklenecek == $rowMalzeme["malzeme_id"]) {
            $eklenecekMalzAdi = $rowMalzeme["malzeme_adi"];
            while ($rowKullanici = $resultKullanici->fetch()) {
                if ($_SESSION["user"] == $rowKullanici["kullanici_adi"]) {
                    $kullaniciMalzeme = explode(",", $rowKullanici["kullanici_malzeme"]);
                    if (!in_array($eklenecekMalzAdi, $kullaniciMalzeme)) {
                        echo "<script>
                        alert('Çıkarmaya çalıştığınız malzeme mevcut değil.');
                        </script>";
                    } else {
                        foreach ($kullaniciMalzeme as $key => $value) {
                            if ($eklenecekMalzAdi == $value) {
                                unset($kullaniciMalzeme[$key]);
                            }
                        }
                        $add = "UPDATE kullanici set kullanici_malzeme = '" . implode(",", $kullaniciMalzeme) . "' where kullanici_id = " . $rowKullanici['kullanici_id'];
                        $addResult = $conn->exec($add);
                        if ($addResult) {
                            echo "<script>
                            alert('Malzeme çıkarma başarılı.');
                            </script>";
                        } else {
                            echo "<script>
                            alert('Malzeme çıkarma başarısız.');
                            </script>";
                        }
                    }
                }
            }
        }
    }
}
?>