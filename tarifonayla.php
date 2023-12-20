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
                    <h1 class="baslik">Tarif Onayla</h1>
                </div>
                <h3 style="color:white; border-bottom: 1px solid white; width: 250px; padding-bottom: 5px;">Onay Bekleyen Tarifler</h3>
                <div class="tarifBilgileri">
                <?php
                    include("connection.php");

                    $select = "SELECT * FROM tarif";
                    $selectResult = $conn->query($select);

                    $select2 = "SELECT * FROM malzeme";
                    $selectResult2 = $conn->query($select2);

                    while ($row2 = $selectResult2->fetch_assoc()) {
                        $malzemeler[] = $row2;
                    }

                    while ($row = $selectResult->fetch_assoc()) {
                        $malzemeler2 = explode(",", $row['tarif_malzeme']);
                        if ($row['tarif_izin'] == 0) {
                            echo '
                            <div class="tarifKutusu" id="' . str_replace(" ", "", $row['tarif_baslik']) . '">
                            <h1 class="tarifAdi">' . $row['tarif_baslik'] . ' ('.$row['tarif_id'].')</h1>
                            <div class="posit">
                            <img src="yuklenendosyalar/' . $row['tarif_gorsel'] . '" class="tarifGorsel inb" height="300">
                            <p class="tarifAciklama inb">
                            ' . $row['tarif_aciklama'] . '</p>
                            </div>
                        </div>
                        <h3 class="malzBaslik">Malzemeler</h3>
                            ';

                            foreach ($malzemeler as $malzeme) {
                                foreach ($malzemeler2 as $malzeme2) {
                                    if ($malzeme['malzeme_adi'] == $malzeme2) {
                                        echo '
                                        <img style="margin: 1px;" src="yuklenendosyalar/malzemeler/' . $malzeme['malzeme_gorsel'] . '" height="25" class="tarifMalzemeGorsel">
                                        ' . $malzeme['malzeme_adi'] . '
                                        <br>';
                                    }
                                }
                            }

                        }
                    }
                    ?>
                </div>
                <div class="tarifKutucuk">
                <form action="" method="POST">
                    <table class="tarifEkle" style="margin-top: 120px;">
                        <tr>
                            <td>Tarif Numarası:</td>
                            <td><input type="text" name="allowId" class="inputLogin" required></td>
                        </tr>
                            <td></td>
                            <td><input class="submitBtn" type="submit" name="onayla" value="Onayla"></td>
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
if (isset($_POST['onayla'])) {
    $allowID = $_POST['allowId'];

    $update = "UPDATE tarif set tarif_izin = 1 where tarif_id = $allowID";
    $result = $conn -> query($update);

    if ($result) {
        echo '
        <script>
        alert("Tarif başarıyla onaylandı."); 
        </script>
        ';
    }
}
?>