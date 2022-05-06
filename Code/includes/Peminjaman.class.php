<?php

class Peminjaman extends DB
{
    function getPeminjaman()
    {
        $query = "SELECT * FROM peminjaman";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function addPeminjaman($data)
    {
        $nama = $data['nama'];
        $judul_buku = $data['judul_buku'];

        $query = "INSERT INTO peminjaman VALUES ('', '$nama', '$judul_buku', 'Sedang Dipinjam')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function deletePeminjaman($id)
    {
        $query = "DELETE FROM peminjaman WHERE id_peminjaman = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }
    
    function statusPeminjaman($id){
        $status = "Selesai Dipinjam";

        $query = "UPDATE peminjaman SET STATUS = '$status' WHERE id_peminjaman = '$id'";
        
        // Mengeksekusi query
        return $this->execute($query);
    }
}
?>