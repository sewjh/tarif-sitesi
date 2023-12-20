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
                    <h1 class="baslik">Malzeme Ekle</h1>
                </div>
                <div class="tarifKutucuk">
                <form enctype="multipart/form-data" action="" method="POST">
                    <table class="tarifEkle">
                        <tr>
                            <td>Malzeme Adı:</td>
                            <td><input type="text" name="malzemeAdi" class="inputLogin" required></td>
                        </tr>
                        <tr>
                            <td>Malzeme Görseli:</td>
                            <td><input type="FILE" style="border-radius: 7px; background-color: white; color: black;" name="malzemeGorsel" required></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input class="submitBtn" type="submit" name="yukle" value="Yukle"></td>
                        </tr>
                    </table>
                    <?php
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "yemek_db";

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if (isset($_POST["yukle"])) {
    $malzemeAdi = $_POST['malzemeAdi'];
    $malzemeGorsel = $_FILES['malzemeGorsel']['name'];

    $add = "INSERT INTO malzeme (malzeme_adi, malzeme_gorsel) VALUES ('".$malzemeAdi."','".$malzemeGorsel."')";
                    
    if ($conn -> query($add) == TRUE) {
        echo "<b style='color: white;'>Malzeme başarıyla eklendi.</b>";
    }

    $dizin = 'yuklenendosyalar/malzemeler/';
    $yuklenecek_dosya = $dizin . basename($_FILES['malzemeGorsel']['name']);

    if (move_uploaded_file($_FILES['malzemeGorsel']['tmp_name'], $yuklenecek_dosya)) {
        // echo $_FILES['dosya']['name'];

    } else {
        // echo "Dosya yüklenemedi!\n";
    }
}
?>
                </form>
                </div>
            </center>
        </div>
    </center>
</body>

</html>
