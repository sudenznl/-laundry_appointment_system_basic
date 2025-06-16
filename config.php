<?php 
@ob_start();
@session_start();

$host="localhost";
$veritabani_ismi="randevu_takip"; //Veritabanı ismi
$kullanici_adi="root";//kullanıcı ismi
$sifre="";//kullanıcı şifresi



try{
	$db = new PDO("mysql:host=$host;dbname=$veritabani_ismi;charset=utf8",$kullanici_adi,$sifre);
} catch(PDOException $e){
	echo "Veritabanı Bağlantı İşlemi Başarısız Oldu";
	echo $e->getMessage();
	exit;
}


$sorgu=$db->prepare("SELECT * FROM ayarlar WHERE id=1");
$sorgu->execute();
$ayarcek=$sorgu->fetch(PDO::FETCH_ASSOC);


require_once __DIR__.'/fonksiyonlar.php';

?>