<?php
$koneksi = mysqli_connect("Localhost","root","","bedugul");

function query($query){
    global $koneksi;
    $result = mysqli_query($koneksi, $query);

    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows [] = $row;
    }
    return $rows;
}

function create($data){
    global $koneksi;
    // $id=htmlspecialchars($data["id"]);
    $nama=htmlspecialchars($data["NamaKopi"]);
    $asal=htmlspecialchars($data["AsalKopi"]);
    $harga=htmlspecialchars($data["Harga"]);
    $user=$data["User"];
    $query = "INSERT INTO datakopi VALUES('','$nama','$asal','$harga', '$user')";
    mysqli_query($koneksi,$query);
    return mysqli_affected_rows($koneksi);
}

function remove($id){
    global $koneksi;
    mysqli_query($koneksi,"DELETE FROM datakopi WHERE id= '$id'");

    return mysqli_affected_rows($koneksi);
}

function update($data){
    global $koneksi;
    $id=($data['id']);
    $nama=htmlspecialchars($data['NamaKopi']);
    $asal=htmlspecialchars($data['AsalKopi']);
    $harga=htmlspecialchars($data['Harga']);

    $query = "UPDATE datakopi SET
                NamaKopi='$nama',
                AsalKopi='$asal',
                Harga=$harga
                WHERE id ='$id';
            ";
    mysqli_query($koneksi,$query);
    return mysqli_affected_rows($koneksi);
}

function search($keyword){
    $query = "SELECT * FROM datakopi WHERE
            id LIKE '%$keyword%' OR
            NamaKopi LIKE '%$keyword%' OR
            AsalKopi LIKE '%$keyword%' OR
            Harga LIKE '%$keyword%';";
    return query($query);
}

function Register($data) {
	global $koneksi;
	$username = strtolower(stripcslashes($data["username"]));
	$password = mysqli_real_escape_string($koneksi, $data["password"]);
	$password2 = mysqli_real_escape_string($koneksi, $data["password2"]);
	
	$result = mysqli_query($koneksi, "SELECT * FROM akun WHERE username = '$username'");
	if(mysqli_fetch_assoc($result)) {
		print "<script> alert('Username ini telah terdaftar, cari username lain!');</script>";
		return false;
	}
	
	if($password !== $password2) {
		print"<script> alert('Konfirmasi password gagal!');</script>";
		return false;
	}
	
	$password = password_hash($password, PASSWORD_DEFAULT);
	
	mysqli_query($koneksi, "INSERT INTO akun VALUES ('','$username','$password')");
	return mysqli_affected_rows($koneksi);
}
?>