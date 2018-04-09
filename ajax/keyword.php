<?php

require "../functions.php";
$keyword = $_GET['keyword'];

$buku = query("SELECT * FROM buku 
                WHERE 
                judul LIKE '%$keyword%' OR
                pengarang LIKE '%$keyword%' OR
                keterangan LIKE '%$keyword%' OR
                tahun LIKE '%$keyword%' OR
                penerbit LIKE '%$keyword%' OR
                harga LIKE '%$keyword%' OR
                stok LIKE '%$keyword%' OR
                kategori LIKE '%$keyword%'
                ");

?>

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