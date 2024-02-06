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
                    <h1 class="baslik" style="font-size: 34px;">Parola Değiştir</h1>
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
                <form action="" method="post" class="parolaDegistir">
                    <label for="eskiParola">Mevcut Parola:</label><br>
                    <input type="password" id="eskiParola" name="eskiParola" class="inputText"><br>
                    <label for="yeniParola">Yeni Parola:</label><br>
                    <input type="password" id="yeniParola" name="yeniParola" class="inputText"><br>
                    <label for="yeniParolaTekrar">Tekrar Yeni Parola:</label><br>
                    <input type="password" id="yeniParolaTekrar" name="yeniParolaTekrar" class="inputText"><br>
                    <input type="submit" name="degistir" value="DEGISTIR" class="submitBtn" style="margin-top: 10px;">
                </form>
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
<?php
if (isset($_POST['degistir'])) {
    $currentPass = $_POST['eskiParola'];
    $newPass = $_POST['yeniParola'];
    $newPassRepeat = $_POST['yeniParolaTekrar'];

    $select = "SELECT * FROM kullanici";
    $result = $conn->query($select);

    while ($row = $result->fetch()) {
        if ($_SESSION["user"] == $row["kullanici_adi"]) {
            if ($currentPass == $row['kullanici_parola']) {
                if ($newPass == $newPassRepeat) {
                    $updatePass = "UPDATE kullanici set kullanici_parola = '" . $newPass . "' where kullanici_id = " . $row["kullanici_id"];
                    $result2 = $conn->exec($updatePass);
                    if ($result2) {
                        echo '
                        <script>
                        alert("Parola başarıyla değiştirildi!");
                        </script>
                        ';
                    } else {
                        echo '
                    <script>
                    alert("Bir hata meydana geldi.");
                    </script>
                    ';
                    }
                } else {
                    echo '
                    <script>
                    alert("Parolalar eşleşmiyor!");
                    </script>
                    ';
                }
            } else {
                echo '
                <script>
                alert("Mevcut parola doğru değil!");
                </script>
                ';
            }
        }
    }
}

?>