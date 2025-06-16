<?php require_once 'header.php';

// Eğer 'sil' parametresi varsa, bir müşteriyi sil
if (isset($_GET['sil'])) {
    // Müşteri ID'sini güvenli bir şekilde almak için intval() fonksiyonunu kullanarak tamsayıya dönüştürüyoruz
    $musteri_id = intval($_GET['musteri_id']);

    // Prepare ettiğimiz sorguda parametre yerine ? kullanıyoruz
    $sorgu = $db->prepare("DELETE FROM musteri WHERE musteri_id=?");
    
    // Sorguyu çalıştırırken, parametreyi dizi olarak veriyoruz
    $sonuc = $sorgu->execute([$musteri_id]);
    
    // Silme işlemi başarılıysa 'ok' durumunu, değilse 'no' durumunu müşteriler.php sayfasına yönlendiriyoruz
    if ($sonuc) {
        header("location:musteriler.php?durum=ok");
    } else {
        header("location:musteriler.php?durum=no");
    }
}

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="font-weight-bold text-primary">Müşteriler</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="tablo">
                        <thead>
                            <tr>
                                <th>Numara</th>
                                <th>Ad - Soyad</th>
                                <th>Mail Adresi</th>
                                <th>Telefom Numarası</th>
                                <th>Düzenle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Müşteri verilerini alırken, direkt olarak SQL sorgusu içine yerleştirmek yerine prepared statements kullanıyoruz
                            $sorgu = $db->prepare("SELECT * FROM musteri");
                            $sorgu->execute();
                            $liste = $sorgu->fetchAll(PDO::FETCH_ASSOC);

                            // Müşteri listesini döngüyle işliyoruz
                            foreach ($liste as $key => $musteri) { ?>
                                <tr>
                                    <td><?php echo $musteri['musteri_id'] ?></td>
                                    <td><?php echo $musteri['musteri_isim'] ?></td>
                                    <td><?php echo $musteri['musteri_mail'] ?></td>
                                    <td><?php echo $musteri['musteri_telefon'] ?></td>
                                    <td>
                                        <!-- Müşteri düzenleme ve silme işlemleri için linkler -->
                                        <a href="musteriduzenle.php?musteri_id=<?php echo $musteri['musteri_id'] ?>" class="btn btn-success">Edit</a>
                                        <a href="musteriler.php?sil=true&musteri_id=<?php echo $musteri['musteri_id'] ?>" class="btn btn-danger" onclick="return confirm('Bu müşteriyi silmek istediğinizden emin misiniz?')">Delete</a>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>


<script>
    $(document).ready( function () {
        $('#tablo').DataTable({
            // DataTables için dil ayarı, dildosyasi değişkeni tanımlanmadığı için hata verebilir
            'language': dildosyasi
        });
    });
</script>
