<!DOCTYPE html>
<html>
<head>
    <title>Kombinasi Soal Ujian</title>
</head>
<body>
    <h2>Program Strategi Pemilihan Pertanyaan Ujian</h2>
    <form method="post">
        <label>Soal (masukkan nilai tiap pertanyaan yang dipisah dengan koma, maksimal 10 pertanyaan):</label><br>
        <input type="text" name="soal" size="80" value="<?php echo isset($_POST['soal']) ? $_POST['soal'] : ''; ?>"><br><br>

        <label>T:</label>
        <input type="number" name="total" value="<?php echo isset($_POST['total']) ? $_POST['total'] : ''; ?>">
        <input type="submit" name="hitung" value="Hitung">
    </form>
    <hr>

<?php
    function cariKombinasi($arr, $target, $index = 0, $kombinasi = [], &$hasil = []) {
        $jumlah = array_sum($kombinasi);
        if ($jumlah == $target) {
            $hasil[] = $kombinasi;
            return;
        }
        if ($jumlah > $target || $index >= count($arr)) {
            return;
        }

        $kombinasiBaru = $kombinasi;
        $kombinasiBaru[$index + 1] = $arr[$index];
        cariKombinasi($arr, $target, $index + 1, $kombinasiBaru, $hasil);

        cariKombinasi($arr, $target, $index + 1, $kombinasi, $hasil);
    }

    if (isset($_POST['hitung'])) {
        $input = $_POST['soal'];
        $total = intval($_POST['total']);
        $nilaiSoal = array_map('intval', explode(',', $input));

        if (count($nilaiSoal) > 10) {
            echo "<b>Maksimal hanya boleh 10 pertanyaan!</b>";
            exit;
        }

        echo "<h3>SOAL</h3>";
        echo "<pre>Array\n(\n";
        foreach ($nilaiSoal as $i => $val) {
            echo "    [Pertanyaan " . ($i + 1) . "] => $val\n";
        }
        echo ")\n";
        echo "dengan Nilai Total Soal (T) = $total ?</pre>";

        // Hitung kombinasi
        $daftarKombinasi = [];
        cariKombinasi($nilaiSoal, $total, 0, [], $daftarKombinasi);

        echo "<h3>JAWABAN</h3>";
        echo "Jumlah semua Kombinasi (K) = " . count($daftarKombinasi) . "<br><br>";
        echo "Daftar Kombinasi:<br><pre>";
        foreach ($daftarKombinasi as $i => $kombinasi) {
            echo "[$i] => Array\n(\n";
            foreach ($kombinasi as $no => $nilai) {
                echo "    [Pertanyaan $no] => $nilai\n";
            }
            echo ")\n\n";
        }
        echo "</pre>";
    }
?>
</body>
</html>
