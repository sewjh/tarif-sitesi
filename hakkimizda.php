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
                    <span class="glyphicon glyphicon-search search-icon"></span><input type="text" name="ara" class="search-box"
                        placeholder="Tarif ara..">
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
                    <h1 class="baslik" style="font-size: 34px;">Biz Kimiz?</h1>
                </div>
                <div class="hakkimizda">

                    <p class="hakkimizdaYazi">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem voluptatem quis aut obcaecati
                        vero necessitatibus perspiciatis adipisci aliquam exercitationem, veniam, ab facilis quos, quam
                        ipsum accusamus illum totam doloremque doloribus.Lorem
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic libero illo beatae magnam,
                        consectetur sed quod numquam mollitia vero accusamus nam necessitatibus animi, obcaecati error.
                        Rem quod eum consequuntur ullam.
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora ad ea sequi perferendis alias
                        aspernatur, voluptatem, quas vero pariatur doloremque eveniet. Quia minima, quasi sunt
                        temporibus nihil in aliquid omnis!
                    </p>
                    <img src="bg.jpg" height="350" class="hakkimizdaFoto">
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