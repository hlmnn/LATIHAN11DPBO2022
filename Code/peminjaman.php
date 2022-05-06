<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Buku.class.php");
include("includes/Member.class.php");
include("includes/Peminjaman.class.php");

$buku = new Buku($db_host, $db_user, $db_pass, $db_name);
$buku->open();
$member = new Member($db_host, $db_user, $db_pass, $db_name);
$member->open();
$peminjaman = new Peminjaman($db_host, $db_user, $db_pass, $db_name);
$peminjaman->open();

if (isset($_POST['add'])) {
    //memanggil add
    $peminjaman->addPeminjaman($_POST);
    header("location: peminjaman.php");
}

if (!empty($_GET['id_hapus'])) {
    //memanggil delete
    $peminjaman->deletePeminjaman($_GET['id_hapus']);
    header("location: peminjaman.php");
}

if (!empty($_GET['id_edit'])) {
    //memanggil update
    $peminjaman->statusPeminjaman($_GET['id_edit']);
    header("location: peminjaman.php");
}

$no = 1;
$data = null;
$peminjaman->getPeminjaman();
while (list($id_peminjaman, $id_member, $id_buku, $status) = $peminjaman->getResult()) {
    $member->getMemberDetail($id_member);
    $data_member = $member->getResult();
    
    $buku->getBukuDetail($id_buku);
    $data_buku = $buku->getResult();

    if ($status == "Selesai Dipinjam") {
        $data .= "
            <tr>
                <td>". $no ."</td>
                <td>". $data_member['nama'] ."</td>
                <td>". $data_buku['judul_buku'] ."</td>
                <td>". $status ."</td>
                <td>
                    <a href='peminjaman.php?id_hapus=". $id_peminjaman ."' class='btn btn-danger'>Hapus</a>
                </td>
            </tr>
        ";
    }else {
        $data .= "
            <tr>
                <td>". $no ."</td>
                <td>". $data_member['nama'] ."</td>
                <td>". $data_buku['judul_buku'] ."</td>
                <td>". $status ."</td>
                <td>
                    <a href='peminjaman.php?id_edit=". $id_peminjaman ."' class='btn btn-warning'>Kembalikan</a>
                    <a href='peminjaman.php?id_hapus=". $id_peminjaman ."' class='btn btn-danger'>Hapus</a>
                </td>
            </tr>
        ";
    }
    $no++;
}

$dataForm = null;
$dataForm .="
    <div class='form-row'>
    <div class='form-group col'>
        <label for='nama'>Nama Peminjam</label>
        <select class='custom-select form-control' name='nama'>
            <option selected>Open this select menu</option>
            DATA_PEMINJAM
        </select>
    </div>
    </div>
    <div class='form-row'>
    <div class='form-group col'>
        <label for='judul_buku'>Judul Buku</label>
        <select class='custom-select form-control' name='judul_buku'>
            <option selected>Open this select menu</option>
            DATA_BUKU
        </select>
    </div>
    </div>
    <button type='submit' name='add' class='btn btn-primary mt-3'>Add</button>
";

$dataBuku = null;
$buku->getBuku();
while (list($id_buku, $judul, $penerbit, $deskripsi, $status, $id_author) = $buku->getResult()) {
    $dataBuku .= "<option value='".$id_buku."'>".$judul."</option>";
}

$dataPeminjam = null;
$member->getMember();
while (list($nim, $nama, $jurusan) = $member->getResult()) {
    $dataPeminjam .= "<option value='".$nim."'>".$nama."</option>";
}

$buku->close();
$member->close();
$peminjaman->close();
$tpl = new Template("templates/peminjaman.html");
$tpl->replace("DATA_FORM", $dataForm);
$tpl->replace("DATA_PEMINJAM", $dataPeminjam);
$tpl->replace("DATA_BUKU", $dataBuku);
$tpl->replace("DATA_TABLE", $data);
$tpl->write();

?>