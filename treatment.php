<?php

$selection = $_REQUEST["selection"];
$research = $_REQUEST["research"];

try {
   require_once('connection.php');
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
      SELECT designation, commune, latitude, longitude, description, catégorie, auteur, propriétaire, siècle
      FROM monumentshistoriques 
      WHERE département=:departement
      ");
         $req->bindParam(':departement', $research);
         $req->execute();
         while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $temp = hydrateMonument($data);
            echo json_encode($temp);
         }
      } else if (preg_match("/[A-z]/", $research)) {
         $req = $conn->prepare("
      SELECT designation, département, commune, latitude, longitude, description, catégorie, auteur, propriétaire, siècle
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

// Créé un objet JSON musée à partir des données de la requête
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
      "descriptiflong" => $var['descriptiflong'],
      "categorie" => "musee"
   );
   return $data;
}

// Créé un objet JSON monument à partir des données de la requête
function hydrateMonument($var)
{
   $data = array(
      "nom" => $var['designation'],
      "commune" => $var['commune'],
      "latitude" => $var['latitude'],
      "longitude" => $var['longitude'],
      "descriptiflong" => $var['description'],
      "categorie" => $var['catégorie'],
      "proprietaire" => $var['propriétaire'],
      "siecle" => $var['siècle'],
      "auteur" => $var['auteur']
   );
   return $data;
}
