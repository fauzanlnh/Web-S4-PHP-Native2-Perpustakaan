<?php
    include '../connection/koneksi.php';
    session_start();
    $Kd_Peminjaman = strtoupper($_POST['Kd_Peminjaman']);
    $CaraPengembalian = $_POST['Pengembalian'];
    $Data = mysqli_query($koneksi,"SELECT Kd_Anggota, Kd_Buku, Judul_Buku, DATEDIFF(NOW(), EstimasiPengembalian) AS 'BedaTanggal', Harga 
    FROM T_Peminjaman JOIN T_Buku USING(Kd_Buku) WHERE Kd_Peminjaman = '$Kd_Peminjaman'");
    while($result = mysqli_fetch_array($Data)){
        if($result['BedaTanggal'] < 0){
            $telat = 0;
        }else{
            $telat = $result['BedaTanggal'];
        }
        $Denda = 1000 * $telat;
        $_SESSION['setKdAnggota'] = $result['Kd_Anggota'];
        $_SESSION['setKdBuku'] = $result['Kd_Buku'];
        $_SESSION['setJudul'] = $result['Judul_Buku'];
        $_SESSION['setHarga'] = $result['Harga'];
        $_SESSION['setTelat'] = $telat;
        $_SESSION['setDenda'] = $Denda;
        $Data2 = mysqli_query($koneksi,"SELECT * FROM T_Buku JOIN T_Kategori_Buku WHERE Kd_Buku = '".$result['Kd_Buku']."'");
        while($result2 = mysqli_fetch_array($Data2)){
            $_SESSION['Jdl_Buku'] = $result2['Judul_Buku'];
            $_SESSION['Nm_Pengarang'] = $result2['Nama_Pengarang'];
            $_SESSION['Nm_Penerbit'] = $result2['Nama_Penerbit'];
            $_SESSION['Kategori_Buku'] = $result2['Nama_Kategori'];
            $_SESSION['Thn_Terbit'] = $result2['Tahun_Terbit'];
            $_SESSION['No_Rak'] = $result2['No_Rak'];
            $_SESSION['Harga'] = $result2['Harga'];
        }
    } 
        
    
        
    $_SESSION['CaraPengembalian'] = $CaraPengembalian;
    header('location:../Views/Admin/V_Tambah_Pengembalian.php?pesan=PilihKdPeminjaman');
?>