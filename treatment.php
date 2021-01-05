<?php

$selection = $_REQUEST["selection"];
$research = $_REQUEST["research"];

try {
   $conn = new PDO("mysql:host=localhost;dbname=web-project", "webproject", "123456");
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $req = null;

   if (strcmp($selection,"musee") == 0){
      if(preg_match("/\d{5}/",$research)) {
         $req = $conn->prepare("
         SELECT nom, adresse, codepostal, commune, latitude, longitude, telephone, courriel, siteinternet, descriptiflong
         FROM musees 
         WHERE CodePostal=:CP
         ");
         $req->bindParam(':CP', $research);
         $req->execute();
         while($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $temp = hydrateMusee($data);
            echo json_encode($temp);
         }
      } else if(preg_match("/[A-z]/",$research)) {
         $req = $conn->prepare("
         SELECT nom, adresse, codepostal, commune, latitude, longitude, telephone, courriel, siteinternet, descriptiflong
         FROM musees 
         WHERE commune or nom LIKE CONCAT('%',:commune,'%')
         ");
         $req->bindParam(':commune', $research);
         $req->execute();
         while($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $temp = hydrateMusee($data);
            echo json_encode($temp);
      }
   } else if(strcmp($selection,"monumentshistoriques") == 0) {

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
      "codepostal" => $var['codepostal'],
      "commune" => $var['departement'],
      "latitude" => $var['latitude'],
      "longitude" => $var['longitude'],
      "descriptiflong" => $var['description']
   );
   return $data;
}
