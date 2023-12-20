<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
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
                <div class="links">
                    <ul>
                        <li><a href="index.php">Ana Sayfa</a></li>
                        <li><a href="tarifler.php">Tarifler</a></li>
                        <li><a href="hakkimizda.php">Hakkımızda</a></li>
                        <li><a href="iletisim.php">İletişim</a></li>
                        <div class="giris-yap-btn">
                            <li><a href="giris.php"><span class="glyphicon glyphicon-user"></span></a></li>
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