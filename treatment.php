<?php

$selection = $_REQUEST["selection"];
$research = $_REQUEST["research"];

try {
   $conn = new PDO("mysql:host=localhost;dbname=web-project", "webproject", "123456");
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $req = null;

   if (strcmp($selection, "musee") == 0) {
      if (preg_match("/\d{5}/", $research)) {
         $req = $conn->prepare("
         SELECT nom, adresse, codepostal, commune, latitude, longitude, telephone, courriel, siteinternet, descriptiflong
         FROM musees 
         WHERE CodePostal=:CP
         ");
         $req->bindParam(':CP', $research);
         $req->execute();
         while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $temp = hydrateMusee($data);
            echo json_encode($temp);
         }
      } else if (preg_match("/[A-z]/", $research)) {
         $req = $conn->prepare("
         SELECT nom, adresse, codepostal, commune, latitude, longitude, telephone, courriel, siteinternet, descriptiflong
         FROM musees 
         WHERE commune LIKE CONCAT('%',:commune,'%')
         ");
         $req->bindParam(':commune', $research);
         $req->execute();
         while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $temp = hydrateMusee($data);
            echo json_encode($temp);
         }
      } 
   } else if (strcmp($selection, "monumentshistoriques") == 0) {
      if (preg_match("/\d{2}/", $research)) {
         $req = $conn->prepare("
      SELECT designation, commune, latitude, longitude, description
      FROM monumentshistoriques 
      WHERE departement=:departement
      ");
         $req->bindParam(':departement', $research);
         $req->execute();
         while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $temp = hydrateMonument($data);
            echo json_encode($temp);
         }
      } else if (preg_match("/[A-z]/", $research)) {
         $req = $conn->prepare("
      SELECT designation, departement, commune, latitude, longitude, description
      FROM monumentshistoriques 
      WHERE commune LIKE CONCAT('%',:commune,'%')
      ");
         $req->bindParam(':commune', $research);
         $req->execute();
         while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $temp = hydrateMonument($data);
            echo json_encode($temp);
         }
      }
   }
} catch (PDOException $e) {
   echo "Connection failed: " . $e->getMessage();
}

function hydrateMusee($var)
{
   $data = array(
      "nom" => $var['nom'],
      "adresse" => $var['adresse'],
      "codepostal" => $var['codepostal'],
      "commune" => $var['commune'],
      "latitude" => $var['latitude'],
      "longitude" => $var['longitude'],
      "telephone" => $var['telephone'],
      "courriel" => $var['courriel'],
      "siteinternet" => $var['siteinternet'],
      "descriptiflong" => $var['descriptiflong']
   );
   return $data;
}

function hydrateMonument($var)
{
   $data = array(
      "nom" => $var['designation'],
      "commune" => $var['commune'],
      "latitude" => $var['latitude'],
      "longitude" => $var['longitude'],
      "descriptiflong" => $var['description']
   );
   return $data;
}
