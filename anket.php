<?php
// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "randevu_takip";

$conn = new mysqli($servername, $username, $password, $dbname);

// Veritabanı bağlantı hatası kontrolü
if ($conn->connect_error) {
    die("Veritabanına bağlanılamadı: " . $conn->connect_error);
}

// Müşteri adlarını al
$sql = "SELECT musteri_isim FROM musteri";
$result = $conn->query($sql);
$musteriler = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $musteriler[] = $row["musteri_isim"];
    }
}

// Form gönderildiğinde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form verilerini al
    $musteri_isim = $_POST["musteri"];
    $soru1 = $_POST["soru1"];
    $soru2 = $_POST["soru2"];
    $soru3 = $_POST["soru3"];

    // Anket sonuçlarını veritabanına kaydet
    $sql = "INSERT INTO anket_sonuc (musteri_isim, soru1, soru2, soru3) VALUES ('$musteri_isim', '$soru1', '$soru2', '$soru3')";

    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Hata: " . $sql . "<br>" . $conn->error;
    }
}

// Veritabanı bağlantısını kapat
$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anket Formu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f7fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            color: #007bff;
        }

        p {
            margin-bottom: 10px;
            color: #333;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h2>Müşteri Analizi</h2>
        <p>Bir müşteri seçiniz</p>
        <select name="musteri">
            <?php foreach($musteriler as $musteri): ?>
                <option value="<?php echo $musteri; ?>"><?php echo $musteri; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <p>1- Müşteriniz randevusuna zamanında geldi mi? </p>
        <input type="radio" name="soru1" value="evet"> evet
        <input type="radio" name="soru1" value="hayir"> hayır<br><br>

        <p>2- Müşterinin çalışanlara karşı davranışları saygı çerçevesi içerisinde miydi?</p>
        <input type="radio" name="soru2" value="evet"> evet
        <input type="radio" name="soru2" value="hayir"> hayır<br><br>

        <p>3- Müşteri çamaşırhane kurallarına uydu mu?</p>
        <input type="radio" name="soru3" value="evet"> evet
        <input type="radio" name="soru3" value="hayir"> hayır<br><br>

        <input type="submit" value="Gönder">
    </form>
</body>
</html>
