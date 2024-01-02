<?php
include("connection.php");
session_start();
if(isset($_SESSION["user"])) {
    $sct = "SELECT * FROM kullanici";
    $sctrn = $conn -> query($sct);

    while($rw = $sctrn -> fetch_assoc()) {
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
                        <div class="giris-yap-btn">
                        <?php
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

                            while ($rw = $sctrn->fetch_assoc()) {
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
                    <h1 class="baslik">Tarif Sil</h1>
                </div>
                <h3 style="color:white; border-bottom: 1px solid white; width: 250px; padding-bottom: 5px;">Tarifler</h3>
                <div class="tarifBilgileri">
                    <?php
                    include("connection.php");

                    $select = "SELECT * FROM tarif";
                    $result = $conn -> query($select);

                    while ($row = $result->fetch_assoc()) {
                        echo "<p style='color:white;'><b style='color: white;'>Tarif Adı:</b> ".$row['tarif_baslik']."<br><b style='color: white;'>Tarif Numarası: ".$row['tarif_id']."</b></p><br><br>";
                    }
                    ?>
                </div>
                <div class="tarifKutucuk">
                <form action="" method="POST">
                    <table class="tarifEkle">
                        <tr>
                            <td>Tarif Numarası:</td>
                            <td><input type="text" name="deleteId" class="inputLogin" required></td>
                        </tr>
                            <td></td>
                            <td><input class="submitBtn" type="submit" name="sil" value="Sil"></td>
                        </tr>
                    </table>
                </form>
                </div>
            </center>
        </div>
    </center>
</body>

</html>
<?php
if (isset($_POST["sil"])) {
    $tarifID = $_POST["deleteId"];
    
    $add = "DELETE FROM tarif where tarif_id = $tarifID";
    $result = $conn -> query($add);
                    
    if ($result) {
        echo "<script>alert('Tarif başarıyla silindi!')</script>";
    }
}
?>