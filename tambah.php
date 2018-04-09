<?php 
session_start();
if( !isset($_SESSION['login']) ) {
    header('Location: login.php');
    exit;
}

require "functions.php";
if( isset($_POST["submit"]) ) {

    if( tambah($_POST) > 0) {
        echo "
            <script>
                alert('data berhasil ditambahkan');
                document.location.href = 'index.php';
            </script>
        ";
        //header("Location, index.php");
    } else {
        echo mysqli_error($conn);
        echo "
            <script>
                alert('data gagal ditambahkan');
            </script>
        ";
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Tambah Data Buku</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="kategori">Kategori</label>
                <input type="text" name="kategori" id="kategori" required>
            </li>
            <li>
                <label for="judul">Judul Buku</label>
                <input type="text" name="judul" id="judul" required>
            </li>
            <li>
                <label for="pengarang">Pengarang</label>
                <input type="text" name="pengarang" id="pengarang" required>
            </li>
            <li>
                <label for="keterangan">Keterangan</label>
                <input type="text" name="keterangan" id="keterangan" required>
            </li>
            <li>
                <label for="tahun">Tahun Terbit</label>
                <input type="text" name="tahun" id="tahun" required>
            </li>
            <li>
                <label for="penerbit">Penerbit</label>
                <input type="text" name="penerbit" id="penerbit" required>
            </li>
            <li>
                <label for="harga">Harga</label>
                <input type="text" name="harga" id="harga" required>
            </li>
            <li>
                <label for="stok">Stok</label>
                <input type="text" name="stok" id="stok" required>
            </li>
            <li>
                <label for="foto">Foto</label>
                <input type="file" name="foto" id="foto">
            </li>
            <li>
                <button type="submit" name="submit">Simpan</button>
            </li>
        </ul>
    </form>
</body>
</html>