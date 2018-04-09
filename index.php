<?php 
session_start();
if( !isset($_SESSION['login']) ) {
    header('Location: login.php');
    exit;
}

require "functions.php";

// pagging
$jumPerHalaman = 3;
$jumData = count(query("SELECT * FROM buku"));
$jumHalaman = ceil($jumData / $jumPerHalaman);
$halamanAktif = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;
$awalData = ($jumPerHalaman * $halamanAktif) - $jumPerHalaman;
$buku = query("SELECT * FROM buku ORDER BY id_buku ASC Limit $awalData, $jumPerHalaman");

if( isset( $_POST["cari"] ) ) {
    $buku = cari($_POST["keyword"]);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Admin</title>
</head>
<body>

    <a href="logout.php">Logout</a>

    <h1>Daftar Buku</h1>
    <a href="tambah.php">Tambah Data Buku</a>
    <br /><br />

    <form action="" method="post">
        <input type="text" name="keyword" id="keyword" size="40" placeholder="Masukan keyword pencarian..." autocomplete="off"  autofocus>
        <button type="submit" name="cari">Cari!</button>
    </form>
    <br /><br />

<div id="pager">    
    <?php if ( $halamanAktif > 1 ) : ?>
        <a href="?halaman=<?= $halamanAktif - 1; ?>" style="text-decoration:none;">&#8810</a>
    <?php endif ; ?>

    <?php for( $i = 1; $i < $jumHalaman + 1; $i++ ) : ?>
        <?php if ( $i == $halamanAktif ) : ?>
            <a href="?halaman=<?= $i ?>" style="color: red; font-weight:bold;"><?= $i ?></a>
        <?php else : ?>
            <a href="?halaman=<?= $i ?>" style="color: gray; text-decoration:none;"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ( $halamanAktif != $jumHalaman ) : ?>
        <a href="?halaman=<?= $halamanAktif + 1; ?>" style="text-decoration:none;">&#8811</a>
    <?php endif ; ?>
</div>

<br/>

<div id="container">    
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Pengarang</th>
            <th>Tahun</th>
            <th>Penerbit</th>
            <th>Harga</th>
            <th>Stok</th>
        </tr>

        <?php $i = 1;?>
        <?php foreach( $buku as $row ) :?>
        <tr>
            <td><?= $row["id_buku"] ?></td>
            <td>
                <a href="ubah.php?id=<?= $row["id_buku"] ?>">Ubah</a> |
                <a href="hapus.php?id=<?= $row["id_buku"] ?>" onClick="return confirm('anda akan menghapus data');" >Hapus</a>
            </td>
            <td>
                <img src="img/<?= $row["foto"] ?>" alt="" width="50px" srcset="">
            </td>
            <td><?= $row["judul"] ?></td>
            <td><?= $row["kategori"] ?></td>
            <td><?= $row["pengarang"] ?></td>
            <td><?= $row["tahun"] ?></td>
            <td><?= $row["penerbit"] ?></td>
            <td><?= $row["harga"] ?></td>
            <td><?= $row["stok"] ?></td>
        </tr>
        <?php $i++; ?>
        <?php endforeach ;?>
    
    </table>
</div>

<script src="js/script.js"></script>    
</body>
</html>