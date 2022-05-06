<?php

class Member extends DB
{
    function getMember()
    {
        $query = "SELECT * FROM member";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function add($data)
    {
        $nim = $data['nim'];
        $nama = $data['nama'];
        $jurusan = $data['jurusan'];

        $query = "insert into member values ('$nim', '$nama', '$jurusan')";

        // Mengeksekusi query
        return $this->execute($query);
    }
    
    function delete($nim)
    {
        $query = "delete FROM member WHERE nim = '$nim'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function update($data){
        $nim = $data['nim'];
        $nama = $data['nama'];
        $jurusan = $data['jurusan'];
        
        $query = "update member set nama = '$nama', jurusan = '$jurusan' where nim = '$nim'";
        
        // Mengeksekusi query
        return $this->execute($query);
    } 

    function getMemberDetail($nim){
        $query = "SELECT * FROM member WHERE nim = '$nim'";

        // Mengeksekusi query
        return $this->execute($query);
    }
}
?>