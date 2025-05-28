
<!-- // mengubah array menjadi json  -->
<?php

$data_mahasiswa = [
    [
        "nama" => "Shintarizki",
        "nim" => "2217020034",
        "email" => "shintarizkiayuutami@gmail.com"
    
    ],
    [   
        "nama" => "ayuutami",
        "nim" => "2217020034",
        "email" => "shintarizki@gmail.com"


];

$dbh = new PDO('mysql:host=localhost;dbname=db_mahasiswa', 'root', '');
$db = $dbh->prepare('SELECT * FROM mahasiswa');
$db->execute();
$mahasiswa = $db->fetchAll(PDO::FETCH_ASSOC);

// ubah mahasiswa yang jadi array menjadi json
$data = json_encode($mahasiswa);
echo $data;

?>