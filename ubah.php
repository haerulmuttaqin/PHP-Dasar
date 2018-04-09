<?php 
session_start();
if( !isset($_SESSION['login']) ) {
    header('Location: login.php');
    exit;
}

require "functions.php";

$id = $_GET["id"];

$buku = query("SELECT * FROM buku WHERE id_buku = $id")[0];

if( isset($_POST["submit"]) ) {

    if( ubah($_POST) > 0) {

        echo "
            <script>
                alert('data berhasil diubah');
                document.location.href = 'index.php';
            </script>
        ";
        header("Location, index.php");
    } else {
        echo mysqli_error($conn);
        echo "
            <script>
                alert('data gagal diubah');
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
    <title>Ubah</title>
    <script>
    function batal() {
        window.history.back();
    }
    </script>
</head>
<body>
    <h1>Ubah Data Buku</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $buku["id_buku"] ?>">
        <input type="hidden" name="fotoLama" value="<?= $buku["foto"] ?>">
        <ul>
            <li>
                <label for="kategori">Kategori</label>
                <input type="text" name="kategori" id="kategori" required value="<?= $buku["kategori"] ?>">
            </li>
            <li>
                <label for="judul">Judul Buku</label>
                <input type="text" name="judul" id="judul" required value="<?= $buku["judul"] ?>">
            </li>
            <li>
                <label for="pengarang">Pengarang</label>
                <input type="text" name="pengarang" id="pengarang" required value="<?= $buku["pengarang"] ?>">
            </li>
            <li>
                <label for="keterangan">Keterangan</label>
                <input type="text" name="keterangan" id="keterangan" required value="<?= $buku["keterangan"] ?>">
            </li>
            <li>
                <label for="tahun">Tahun Terbit</label>
                <input type="text" name="tahun" id="tahun" required value="<?= $buku["tahun"] ?>">
            </li>
            <li>
                <label for="penerbit">Penerbit</label>
                <input type="text" name="penerbit" id="penerbit" required value="<?= $buku["penerbit"] ?>">
            </li>
            <li>
                <label for="harga">Harga</label>
                <input type="text" name="harga" id="harga" required value="<?= $buku["harga"] ?>">
            </li>
            <li>
                <label for="stok">Stok</label>
                <input type="text" name="stok" id="stok" required value="<?= $buku["stok"] ?>">
            </li>
            <li>
                <label for="foto">Foto</label> <br />
                <img src="img/<?= $buku["foto"]; ?>" width="70" alt=""></img> <br />
                <input type="file" name="foto" id="foto">
            </li>
            <li>
                <br />
                <button type="submit" name="submit">Ubah Data</button>
            </li>
        </ul>
    </form>
    <button onClick="batal()">Batal</button>
</body>
</html>