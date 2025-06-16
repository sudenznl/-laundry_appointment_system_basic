<?php 
// 'header.php' dosyası dahil ediliyor. Bu dosya genellikle sitenin başlık, menü gibi ortak alanlarını içerir.
require_once 'header.php';

// POST yöntemi ile bir form gönderildi mi kontrol ediliyor.
if (isset($_POST['musteriekle'])) {
    // Veritabanına müşteri ekleme sorgusu hazırlanıyor.
    $sorgu=$db->prepare("INSERT INTO musteri SET 
        musteri_isim=:musteri_isim,
        musteri_mail=:musteri_mail,
        musteri_telefon=:musteri_telefon,
        musteri_adres=:musteri_adres,
        musteri_tc=:musteri_tc,
        musteri_detay=:musteri_detay
    ");
    // Sorgu çalıştırılıyor ve müşteri bilgileri veritabanına ekleniyor.
    $sonuc=$sorgu->execute(array(
        'musteri_isim' => $_POST['musteri_isim'],
        'musteri_mail' => $_POST['musteri_mail'],
        'musteri_telefon' => $_POST['musteri_telefon'],
        'musteri_adres' => $_POST['musteri_adres'],
        'musteri_tc' => $_POST['musteri_tc'],
        'musteri_detay' => $_POST['musteri_detay']
    ));

    // Eğer sorgu başarılı ise 'musteriler.php' sayfasına yönlendirme yapılıyor ve durum 'ok' olarak parametre olarak gönderiliyor.
    // Başarısız ise 'musteriler.php' sayfasına yönlendirme yapılıyor ve durum 'no' olarak parametre olarak gönderiliyor.
    if ($sonuc) {
        header("location:musteriler.php?durum=ok");
    } else {
        header("location:musteriler.php?durum=no");
    }
}
?>

<!-- Müşteri ekleme formu HTML olarak oluşturuluyor -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            
            <div class="card">
                <div class="card-header">
                    <h5>Müşteri Ekleme İşlemleri</h5>
                </div>
                <div class="card-body">
                    <form action="" method="POST" accept-charset="utf-8">
                        <!-- Müşteri bilgilerinin girileceği form alanları oluşturuluyor -->
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label>Ad - Soyad</label>
                                <input type="text" name="musteri_isim" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mail Adresi</label>
                                <input type="email" name="musteri_mail" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label>Telefon Numarası</label>
                                <input type="text" name="musteri_telefon" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Adres </label>
                                <input type="text" name="musteri_adres" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label>TC Kimlik Numarası</label>
                                <input type="text" name="musteri_tc" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12">
                                <label>Müşteri Hakkında Daha Fazla Detay</label>
                                <textarea name="musteri_detay" class="form-control"></textarea>
                            </div>
                        </div>

                        <!-- Formun gönderileceği buton -->
                        <div class="text-center mt-4">
                            <button type="submit" name="musteriekle" class="btn btn-primary btn-lg">Save</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php 
// 'footer.php' dosyası dahil ediliyor. Bu dosya genellikle sitenin alt kısmında yer alan bilgileri içerir.
require_once 'footer.php'; 
?>