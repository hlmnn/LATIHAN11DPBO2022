<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Member.class.php");

$member = new Member($db_host, $db_user, $db_pass, $db_name);
$member->open();
$member->getMember();

$data_title = null;
$data_form = null;

if (isset($_POST['add'])) {
    //memanggil add
    $member->add($_POST);
    header("location: member.php");
}

if (!empty($_GET['id_hapus'])) {
    //memanggil delete
    $nim = $_GET['id_hapus'];
    $member->delete($nim);
    header("location: member.php");
}

if (isset($_POST['update'])) {
    //memanggil update
    $member->update($_POST);
    header("location: member.php");
}

if (!empty($_GET['id_edit'])) {
    $member->getMemberDetail($_GET['id_edit']);
    list($nim, $nama, $jurusan) = $member->getResult();
    $data_title .= "Edit Member";
    $data_form .= "
        <div class='form-row'>
            <div class='form-group col'>
                <label for='nim'>NIM</label>
                <input type='text' class='form-control' name='nim' value='". $nim ."' readonly/>
            </div>
        </div>
        <div class='form-row'>
        <div class='form-group col'>
            <label for='nama'>Nama</label>
            <input type='text' class='form-control' name='nama' value='". $nama ."' required />
        </div>
        </div>
        <div class='form-row'>
        <div class='form-group col'>
            <label for='jurusan'>Jurusan</label>
            <input type='text' class='form-control' name='jurusan' value='". $jurusan ."' required></input>
        </div>
        </div>
        <button type='submit' name='update' class='btn btn-primary mt-3'>Update</button>
    ";
} else {
    $data_title .= "Add Member";
    $data_form .= "
        <div class='form-row'>
            <div class='form-group col'>
                <label for='nim'>NIM</label>
                <input type='text' class='form-control' name='nim' required />
            </div>
        </div>
        <div class='form-row'>
        <div class='form-group col'>
            <label for='nama'>Nama</label>
            <input type='text' class='form-control' name='nama' required />
        </div>
        </div>
        <div class='form-row'>
        <div class='form-group col'>
            <label for='jurusan'>Jurusan</label>
            <input type='text' class='form-control' name='jurusan' required></input>
        </div>
        </div>
        <button type='submit' name='add' class='btn btn-primary mt-3'>Add</button>
    ";
}

$data = null;
$no = 1;
while (list($nim, $nama, $jurusan) = $member->getResult()) {
    $data .= "
    <tr>
        <td>" . $no++ . "</td>
        <td>" . $nim . "</td>
        <td>" . $nama . "</td>
        <td>" . $jurusan . "</td>
        <td>
            <a href='member.php?id_edit=" . $nim . "' class='btn btn-warning' '>Edit</a>
            <a href='member.php?id_hapus=" . $nim . "' class='btn btn-danger' '>Hapus</a>
        </td>
    </tr>";
}

$member->close();
$tpl = new Template("templates/member.html");
$tpl->replace("DATA_TITLE", $data_title);
$tpl->replace("DATA_FORM", $data_form);
$tpl->replace("DATA_TABEL", $data);
$tpl->write();