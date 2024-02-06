<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        div.iletisim {}

        p.iletisimYazi {
            color: white;
            font-size: 20px;
            padding: 5px 30px;
            position: relative;
        }

        .iletisimBaslik {
            color: white;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            position: relative;
        }

        .contact-form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            max-width: 500px;
        }

        .baslikForm {
            color: white;
        }

        .iletisimYazi {
            color: white;
            border-bottom: 1px solid white;
            border-top: 1px solid white;
        }

        .iletisim-form {
            width: 500px;
        }

        div.iletisim {}
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

        <div class="main-box">
            <center>
                <div class="lineBox">
                    <h1 class="baslik" style="font-size: 34px;">Bize Ulaşın</h1>
                </div>
                <div class="iletisim">

                    <p class="iletisimYazi">
                        "Size en lezzetli yemek tarifleri sunabilmek için titizlikle çalışıyoruz!
                        Sorularınız, önerileriniz veya özel istekleriniz varsa bize ulaşmaktan çekinmeyin.
                        Mutfak deneyimimizi sizinle paylaşmaktan mutluluk duyarız."
                    </p><br>
                    <form class="iletisim-form" action="" method="post">
                        <input type="text" class="inputLog" name="iletisim_ad" placeholder="Adınız" required><br>
                        <input type="email" class="inputLog" name="iletisim_email" placeholder="Email Adresiniz"
                            required><br>
                        <textarea name="iletisim_mesaj" rows="6" placeholder="Mesajınız" required></textarea><br>
                        <button type="submit" class="subBtn" name="submit">Gönder</button>
                    </form>
                </div>
            </center>
        </div>
        <?php

        ?>
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
if (isset($_POST["submit"])) {
    $adsoyad = $_POST["iletisim_ad"];
    $eposta = $_POST["iletisim_email"];
    $mesaj = $_POST["iletisim_mesaj"];

    $add = $conn -> exec("INSERT INTO mesaj (mesaj_adsoyad,mesaj_eposta,mesaj_mesaj) values ('$adsoyad', '$eposta', '$mesaj')");
    if ($add) {
        echo "<script> alert('Mesaj başarıyla gönderildi.'); </script>";
    }
}
?>