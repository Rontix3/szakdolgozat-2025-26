<?php
session_start();

// Kategóriák inicializálása
$categories = [
    "theoretical" => ["name"=>"Elméleti informatika", "score"=>0],
    "software"    => ["name"=>"Szoftverfejlesztés (web/mobil/játék)", "score"=>0],
    "hardware"    => ["name"=>"Hardver / Robotika", "score"=>0],
    "data_ai"     => ["name"=>"Adattudomány / Mesterséges intelligencia", "score"=>0],
    "security"    => ["name"=>"Kiberbiztonság / Hálózatok", "score"=>0],
    "devops"      => ["name"=>"Rendszerüzemeltetés / DevOps", "score"=>0],
    "business"    => ["name"=>"Gazdasági / Alkalmazott informatika", "score"=>0]
];

// Kérdés-kategória mapping
$mapping = [
    1=>["theoretical"],2=>["software"],3=>["software"],4=>["hardware"],5=>["data_ai"],
    6=>["security"],7=>["software","business"],8=>["business"],9=>["devops"],10=>["data_ai"],
    11=>["theoretical"],12=>["software"],13=>["software"],14=>["hardware"],15=>["data_ai"],
    16=>["security"],17=>["devops"],18=>["business"],19=>["hardware"],20=>["devops"],
    21=>["theoretical"],22=>["software"],23=>["security"],24=>["software"],25=>["software"],
    26=>["security"],27=>["business"],28=>["devops"],29=>["data_ai","business"],30=>["theoretical"]
];

// Pontszámok számítása
foreach($_POST as $qid => $value){
    if(strpos($qid,'q') === 0){
        $num = intval(substr($qid,1));
        $val = intval($value);
        if(isset($mapping[$num])){
            foreach($mapping[$num] as $cat){
                $categories[$cat]["score"] += $val;
            }
        }
    }
}

// Top kategória meghatározása
usort($categories, function($a,$b){return $b["score"] - $a["score"];});
$_SESSION["result"] = ["top"=>$categories[0], "all"=>$categories];

// Mentés MySQL-be
$username = isset($_POST['username']) ? trim($_POST['username']) : "Ismeretlen";
$score = $categories[0]["score"];
$top_category = $categories[0]["name"];

try {
    // Csatlakozás, saját adatbázisadatok
    $pdo = new PDO("mysql:host=localhost;dbname=informatica_test;charset=utf8", "root", "ÚJ_JELSZÓ"); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("INSERT INTO users (name, score, top_category) VALUES (:name, :score, :top)");
    $stmt->execute([
        ':name'=>$username,
        ':score'=>$score,
        ':top'=>$top_category
    ]);

} catch(PDOException $e){
    // Hibák kiírása debug célból
    echo "Adatbázis hiba: ".$e->getMessage();
    exit;
}

// Átirányítás az eredmény oldalra
header("Location: eredmeny.php");
exit;
