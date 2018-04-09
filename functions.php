<?php 
$conn = mysqli_connect("localhost", "root", "root", "lib");

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row; 
    }
    return $rows;
}

function tambah($data){
    global $conn;
    $id_buku = 0; //nilai default yang akan diubah menjadi auto_increment
    $kategori = htmlspecialchars($data["kategori"]);
    $judul = htmlspecialchars($data["judul"]);
    $pengarang = htmlspecialchars($data["pengarang"]);
    $keterangan = htmlspecialchars($data["keterangan"]);
    $tahun = htmlspecialchars($data["tahun"]);
    $penerbit = htmlspecialchars($data["penerbit"]);
    $harga = htmlspecialchars($data["harga"]);
    $stok = htmlspecialchars($data["stok"]);

    $gambar = upload();

    if( !$gambar ) {
        return false;
    }

    $query = "INSERT INTO `buku` VALUES
    ('$id_buku','$judul','$pengarang','$tahun','$penerbit','$keterangan','$gambar','$kategori','$harga','$stok')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload() {

    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    // cek error / gambar tidak ada yg di upload
    if ($error === 4) {
        echo "
            <script>
                alert('pilih gambar terlebih dahulu!');
            </script>
        ";
        return false;
    }

    // cek extensi
    $extensiGambarValid = ['jpg','jpeg','png'];
    $extensiGambar = explode('.', $namaFile);
    $extensiGambar = strtolower(end($extensiGambar));
    
    if ( !in_array($extensiGambar, $extensiGambarValid) ) {
        echo "
            <script>
                alert('pilih tipe file gambar!');
            </script>
        ";
        return false;
    }

    // cek ukuran
    if ( $ukuranFile > 1000000 ) {
        echo "
            <script>
                alert('ukuran gambar terlalu besar!');
            </script>
        ";
        return false;
    }

    // generete nama file 
    $namaFileBaru = uniqid();
    $namaFileBaru .= ".";
    $namaFileBaru .= $extensiGambar;

    // upload
    move_uploaded_file($tmpName, 'img/'.$namaFileBaru);

    return $namaFileBaru;

}

function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM buku WHERE id_buku = $id");
    return mysqli_affected_rows($conn);
}

function ubah($data) {
    global $conn;
    $id_buku = $data["id"];
    $kategori = htmlspecialchars($data["kategori"]);
    $judul = htmlspecialchars($data["judul"]);
    $pengarang = htmlspecialchars($data["pengarang"]);
    $keterangan = htmlspecialchars($data["keterangan"]);
    $tahun = htmlspecialchars($data["tahun"]);
    $penerbit = htmlspecialchars($data["penerbit"]);
    $harga = htmlspecialchars($data["harga"]);
    $stok = htmlspecialchars($data["stok"]);
    $fotoLama = htmlspecialchars($data["fotoLama"]);

    // cek user update foto atau tidak
    if( $_FILES['foto']['error'] === 4 ) {
        $foto = $fotoLama;
    } else {
        $foto = upload();
    }

    $query = "UPDATE buku SET
                kategori = '$kategori',
                judul = '$judul',
                pengarang = '$pengarang',
                keterangan = '$keterangan',
                tahun = '$tahun',
                penerbit = '$penerbit',
                harga = '$harga',
                stok = '$stok',
                foto = '$foto'
                WHERE id_buku = $id_buku
            ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function cari($keyword) {
    global $conn;
    $query = "SELECT * FROM buku 
                WHERE 
                judul LIKE '%$keyword%' OR
                pengarang LIKE '%$keyword%' OR
                keterangan LIKE '%$keyword%' OR
                tahun LIKE '%$keyword%' OR
                penerbit LIKE '%$keyword%' OR
                harga LIKE '%$keyword%' OR
                stok LIKE '%$keyword%' OR
                kategori LIKE '%$keyword%'
            ";

    return query($query);
}

function registrasi($data) {
    global $conn;

    $username = strtolower( stripslashes($data['username']) );
    $password = mysqli_real_escape_string($conn, $data['password']);
    $password2 = mysqli_real_escape_string($conn, $data['password2']);

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

    if( mysqli_fetch_assoc($result) ) {
        echo "
            <script>
                alert('username sudah ada!');
            </script>
        ";
        return false;
    }

    // cek kofir pass
    if( $password !== $password2 ) {
        echo "
            <script>
                alert('konfirmasi password tidak sesuai!');
            </script>
        ";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    // insert
    mysqli_query($conn, "INSERT INTO user VALUES(0, '$username', '$password')");

    return mysqli_affected_rows($conn);

}

?>