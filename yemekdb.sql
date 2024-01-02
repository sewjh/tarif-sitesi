-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 01 Oca 2024, 21:11:38
-- Sunucu sürümü: 10.4.28-MariaDB
-- PHP Sürümü: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `yemek_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici`
--

CREATE TABLE `kullanici` (
  `kullanici_id` int(11) NOT NULL,
  `kullanici_adi` varchar(24) NOT NULL,
  `kullanici_eposta` varchar(64) NOT NULL,
  `kullanici_parola` varchar(64) NOT NULL,
  `kullanici_yetki` int(11) NOT NULL DEFAULT 1,
  `kullanici_rol` varchar(32) NOT NULL DEFAULT 'üye',
  `kullanici_foto` varchar(64) NOT NULL DEFAULT 'default.jpeg',
  `kullanici_malzeme` varchar(500) NOT NULL,
  `kullanici_yasakli` varchar(12) NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanici`
--

INSERT INTO `kullanici` (`kullanici_id`, `kullanici_adi`, `kullanici_eposta`, `kullanici_parola`, `kullanici_yetki`, `kullanici_rol`, `kullanici_foto`, `kullanici_malzeme`, `kullanici_yasakli`) VALUES
(1, 'semih', 'semih@gmail.com', 'test123', 1, 'admin', 'default.jpeg', ',sıvı yağ,pirinç,tuz,tavuk,un,süt,yumurta,yoğurt,soğan,kıyma,patates,havuç,maydonoz', 'false'),
(2, 'semih2', 'semih2@outlook.com', '123456', 1, 'üye', 'default.jpeg', '', 'false'),
(3, 'semih20', 'semih20@outlook.com', '1234', 1, 'üye', 'default.jpeg', '', 'false'),
(4, 'semih20', 'semih123@google.com', '123', 1, 'üye', 'default.jpeg', '', 'false'),
(6, 'semih201', 'semih20@outlook.com.tr', '123sss', 1, 'üye', 'yaprak.jpg', 'domates,tuz,un,yumurta,havuç,patates,süt,yoğurt,limon,sıvı yağ,mantar,maydonoz', 'false'),
(7, 'semih112', 'semmmmih@google.com.tr', 'asdf1515', 1, 'üye', 'default.jpeg', '', 'false'),
(8, 'test', 'testuser@google.com', 'test1', 1, 'üye', 'yumurta.png', 'tuz,süt,yumurta,domates,yaprak,havuç,salça,tavuk', 'false'),
(9, 'burak123', 'burak@burak.com', '123456', 1, 'üye', 'vesikalik.jpg', '', 'true'),
(10, 'denemehesap', 'deneme@denemehesap.com', 'deneme1234', 1, 'üye', 'default.jpeg', 'patates,süt,tuz,yaprak,yoğurt,soğan,sıvı yağ,yumurta,salça,maydonoz,limon,zeytinyağı,mantar', 'false');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `malzeme`
--

CREATE TABLE `malzeme` (
  `malzeme_id` int(11) NOT NULL,
  `malzeme_adi` varchar(16) NOT NULL,
  `malzeme_gorsel` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `malzeme`
--

INSERT INTO `malzeme` (`malzeme_id`, `malzeme_adi`, `malzeme_gorsel`) VALUES
(4, 'tuz', 'tuz.png'),
(5, 'yoğurt', 'yogurt.png'),
(7, 'mercimek', 'mercimek.png'),
(8, 'soğan', 'sogan.png'),
(10, 'patates', 'patates.png'),
(11, 'havuç', 'havuc.png'),
(12, 'süt', 'sut.png'),
(13, 'yumurta', 'yumurta.png'),
(14, 'sıvı yağ', 'siviyag.png'),
(15, 'un', 'un.png'),
(16, 'dereotu', 'dereotu.png'),
(17, 'yaprak', 'yaprak.png'),
(18, 'limon', 'limon.png'),
(19, 'zeytinyağı', 'zeytinyagi.png'),
(20, 'pirinç', 'pirinc.png'),
(21, 'maydonoz', 'maydonoz.png'),
(22, 'salça', 'salca.png'),
(23, 'kıyma', 'kiyma.png'),
(24, 'tavuk', 'tavuk.png'),
(25, 'domates', 'domates.png'),
(26, 'mantar', 'mantar.png');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tarif`
--

CREATE TABLE `tarif` (
  `tarif_id` int(11) NOT NULL,
  `tarif_baslik` varchar(32) NOT NULL,
  `tarif_aciklama` varchar(3000) NOT NULL,
  `tarif_gorsel` varchar(128) NOT NULL,
  `tarif_yazar` varchar(64) NOT NULL,
  `tarif_izin` int(11) NOT NULL DEFAULT 0,
  `tarif_tur` varchar(32) NOT NULL,
  `tarif_malzeme` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `tarif`
--

INSERT INTO `tarif` (`tarif_id`, `tarif_baslik`, `tarif_aciklama`, `tarif_gorsel`, `tarif_yazar`, `tarif_izin`, `tarif_tur`, `tarif_malzeme`) VALUES
(5, 'Mercimek Çorbası', 'Yaz kış demeden her mevsim, her zaman, her durumda elimizin gittiği tariftir mercimek çorbası tarifi. En çok sevilen çorbalardan biridir o! Bu yüzden zamansız çorbadır. Belki de bütün yemek tarifleri için böyledir.\r\n\r\nHatta ezogelin çorbasıyla olan mücadelesini bir kenara koyarsanız, zamansız çorbaların en güzeli, en birincisi. Bunları söylüyoruz çünkü şimdiye kadar \"en güzel mercimek çorbası\" tarifini arayıp bulamadıysanız lezzetli ve pratik bu tencerede mercimek çorbası yapımı tam size göre!\r\n\r\nLafı uzatmadan \"Mercimek çorbası nasıl yapılır?\", \"Mercimek çorbası nasıl pişirilir?\" diye merak edenleri ev usulü mercimek çorbası tarifimize alalım. Adım adım resimli anlatımı ve videosuyla her eve mis gibi kokan, şifalı mercimek çorbasını davet edelim.\r\n\r\nAfiyetler olsun diyelim, eğer sizin de kendinize özel mercimek çorbası pişirme yöntemleriniz varsa yorumlarda tüm okuyucularımızla paylaşmanızı isteyelim.\r\n\r\nNot: \"Mercimek çorbası tamam da ben daha fazla çorba çeşidi de görmek istiyorum\" diyenleri şöyle alalım: Çorba Tarifleri!', 'merco.webp', '-', 1, 'aksam', 'mercimek,soğan,patates,havuç,maydonoz'),
(6, 'Tavuklu Krep Bohçası', 'Öncelikle krepi hazırlıyoruz: Yumurtayı bir kasede çırpıyoruz.\r\nÜzerine sıvı yağı, sütü, unu, tuzu ekleyip çırpıcı ile iyice karıştırıyoruz.\r\nDereotunu ince kıyıp karışıma ekliyoruz.\r\nTeflon tavayı ısıtıyoruz, kepçe ile karışımdan döküp her iki tarafını da pişiriyoruz.\r\nSoğumaya bırakıyoruz.\r\nİç malzeme için patatesi küp doğrayıp az yağda kızartıyoruz.\r\nSoğanı yemeklik doğrayıp sıvı yağda kavuruyoruz.\r\nEti ekleyip suyunu çekinceye kadar pişiriyoruz.\r\nSalçayı ekliyoruz.\r\n5 dk daha kavurup patatesi bezelyeyi tuzu ekleyip bir süre daha çevirip ocaktan alıyoruz.\r\nBir kase üzerine krepi alıyoruz.\r\nİç malzemeden koyup bohça şeklinde katlıyoruz.\r\nKürdan ile kapatıyoruz.\r\nTepsiye ters çeviriyoruz.\r\nTüm kreplere aynı işlemi uyguluyoruz.\r\nBeşamel sos için: Tereyağı ve unu pembeleşinceye kadar kavuruyoruz.\r\nSütü, tuzu ekleyip koyulaşıncaya kadar karıştırıyoruz.\r\nTepsideki bohçaların üzerine beşamel sostan paylaştırıyoruz.\r\nEn son üzerine Kaşar peyniri rendesi ekliyoruz.\r\nPeynirler eriyip kızarana kadar fırında tutuyoruz (yaklaşık 15-20 dk).\r\nNot: İç malzeme çeşitlendirilebilir. Ben bazen kırmızı biber, yeşil biber, hazır garnitür yada havuç, patlıcan ekliyorum. Kesinlikle denemenizi öneririm\r\n\r\nAfiyet olsun', 'tavukkrep.jpg', '-', 1, 'ogle', 'süt,yumurta,sıvı yağ,tuz,un,dereotu,su'),
(7, 'Yaprak Sarması', 'Öncelikle salamura yapraklar 2-3 dakika sıcak suda bekletilir, yıkanır ve süzgece alınır.\r\nGeniş bir kabın içerisine soğanlar rendelenir.\r\nÜzerine zeytinyağı dökülür.\r\nPirinç yıkanarak  kabın içerisine eklenir.\r\nBaharatlar, salça ve tuzu da ilave edildikten sonra ince kıyılmış maydanozu da eklenerek karıştırılır.(çiğden bir iç harç olacak)\r\nYaprağın geniş kısmına iç harçtan konulur ve rulo gibi iki yanlardan kapatarak sarılır. Bu işleme yaprak bitene kadar devam edilir.\r\nSardığımız yaprakların üzerine zeytinyağı ve limon dilimleri ekleyip yaklaşık 5-6 su bardağı kadar da sıcak su ilave edilerek kısık ateşte pişirilir.(üzerine sarmalar dağılmasın diye tencere kapağından biraz küçük ebatta bir kase kapatabilirsiniz.)\r\nAfiyet olsun…', 'yaprak.jpg', '-', 1, 'aksam', 'yaprak,limon,zeytinyağı,soğan,pirinç,maydonoz,salça'),
(8, 'Mantı', 'Derince bir karıştırma kabına 3,5 su bardağı un , 1 çay kaşığı tuz ekleyelim.\r\nKarıştırarak unun ortasına bir çukur açalım.\r\nOrtasına 1 adet yumurtayı ekleyelim ve karıştırmaya devam edelim.\r\nKarıştırırken 1 su bardağı ılık suyu yavaş yavaş ekleyelim.\r\nHamurun ne çok sert ne de yumuşak olacak bir kıvama gelene kadar yoğuralım.\r\nHazır olan hamurun üzerini streç film ile kapatalım ve dinlendirelim.\r\nHamur dinlenirken uygun bir karıştırma kabına 250 gram az yağlı kıyma ekleyelim.\r\nArdından 1 adet orta boy soğan, yarım çay kaşığı karabiber, 1 çay kaşığı tuz, yarım çay kaşığı pul biber ekleyelim ve güzelce karıştıralım.\r\nUn serptiğimiz tezgaha hamuru alalım, yoğurarak hamuru toparlayalım. Hamuru 3 eşit parçaya ayıralım.\r\nAyırdığımız hamurları bezeler haline getirelim. Un serptiğimiz tezgahta hazırladığımız bezeleri teker teker yufkadan kalın olacak şekilde oklava ile açalım.\r\nAçtığımız hamuru bir bıçak ile küçük kareler halinde keselim. Kesiğimiz karelerin ortasına hazırladığımız kıyma karışımında ufak parçalar halinde koyalım.\r\nHamurun 4 köşesini ortada birleştirerek mantı şeklini verelim. Altını unladığımız bir tepsiye şekil verdiğimiz mantıları toplayalım ve tepsiyi dondurucuya alarak donduralım.\r\nDondurucudan aldığımız mantıları koroplast çift kilitli poşetlere koyarak daha sonra pişirmek üzere buzlukta saklayabilirsiniz. Uygun bir tencerede suyu kaynatalım.\r\nBuzluktan aldığımız mantıları da suya ekleyerek 15-20 dakika kadar pişirelim. Uygun bir sos tavasına 2 yemek kaşığı tereyağı ekleyelim, ardından 2 yemek kaşığı salçayı da ekleyip güzelce karıştıralım.\r\nHazırladığımız salçalı sosu pişen mantıların içine ekleyelim ve karıştırarak pişirmeye devam edelim. Pişen mantıları derince bir tabağa alalım üzerine sarımsaklı veya normal yoğurt dökelim. Mantı tarifimiz hazır. Pul biber, nane ve sumak ekleyerek servis edebilirisiniz.', 'manti.webp', '-', 1, 'aksam', 'un,tuz,yumurta,kıyma,soğan,yoğurt'),
(11, 'Çubuk Simit', 'Süt ve suyu ocağa koyup ılıtalım.\r\nIlıyınca üzerine toz maya ve şekeri döküp karıştırıyoruz.\r\n5 dakika böyle beklesin maya kabarsın yapacağımız kabın içine dökelim.\r\nYumurta ,sıvı yağı da ekleyip karıştıralım ,unu ve tuzu yavaş yavaş ekleyip yumuşak bir hamur yoğuralım.\r\nÜzerini kaptıp 1 saat bekletelim mayala nan hamuru orta boy bezelere bölelim.\r\nBezeleri uzun şeritler yapıp iki elimizle burgu yapar gibi buralım hepsini yapıp bir kenara bırakalım.\r\nPekmezi su ile karıştırıp önce pekmezli suya sonra susama bulayıp fırın tepsisine aralıklı yerleştirelim.\r\n200 derece fırında kızarana kadar pişiriyoruz.', 'cubuksimit.jpg', '-', 1, 'kahvalti', 'süt,un,yumurta,tuz,sıvı yağ'),
(12, 'Tavuklu Pilav', 'İlk olarak tavuklarımızı haşlamak için tencereye koyuyoruz ve üzerini bir parmak geçecek şekilde su ekleyerek kaynamaya bırakıyoruz.\r\nHaşlanan tavuklarımızı soğuması için kenara alıyoruz.\r\nBiraz soğuduğunda tavuklarımızı tiftikliyeceğiz.\r\nBu sırada pirinçlerimizi de ılık suya koyup nişastasının çıkmasını bekliyoruz.\r\nPilav tenceresine yağımızı ekleyip eridiğinde şehriyelerimizi kavuruyoruz.\r\nŞehriyelerin rengi değişip, kokusu çıktığında pirinçlerimizi de ekliyoruz ve 5-10 dakika kadar daha kavuruyoruz.\r\nDaha sonra pirinçimizin üzerine tiftiklediğimiz tavuğumuzu ekliyoruz.\r\n1 bardak tavuk suyu ve 2 bardak kaynamış suyunu da ekledikten sonra tuz ve karabiberi de ilave edip bir kere karıştırıyoruz ve kapağını kapatarak kısık ateşte pişmeye bırakıyoruz. Ben pilav pişirirken çok fazla karıştırmıyorum size de böyle tavsiye ederim.\r\nPilavımız suyunu çekip tane tane olduğunda altını kapatıp, kapağın üzerine demlenmesi için kağıt havlu koyuyoruz. Servis yaparken havluyu alarak afiyetle pilavımızı yiyoruz. Ellerinize sağlık.', 'tavuklupilav.jpg', '-', 1, 'aksam', 'pirinç,tuz,sıvı yağ,tavuk');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `kullanici`
--
ALTER TABLE `kullanici`
  ADD PRIMARY KEY (`kullanici_id`);

--
-- Tablo için indeksler `malzeme`
--
ALTER TABLE `malzeme`
  ADD PRIMARY KEY (`malzeme_id`);

--
-- Tablo için indeksler `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`tarif_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `kullanici`
--
ALTER TABLE `kullanici`
  MODIFY `kullanici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `malzeme`
--
ALTER TABLE `malzeme`
  MODIFY `malzeme_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Tablo için AUTO_INCREMENT değeri `tarif`
--
ALTER TABLE `tarif`
  MODIFY `tarif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
