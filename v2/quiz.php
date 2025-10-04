<?php
session_start();

/* 
  Kiegyensúlyozott kategóriák
*/
$categories = [
    "theoretical" => ["name"=>"Elméleti informatika", "score"=>0],
    "software"    => ["name"=>"Szoftverfejlesztés (web/mobil/játék)", "score"=>0],
    "hardware"    => ["name"=>"Hardver / Robotika", "score"=>0],
    "data_ai"     => ["name"=>"Adattudomány / Mesterséges intelligencia", "score"=>0],
    "security"    => ["name"=>"Kiberbiztonság / Hálózatok", "score"=>0],
    "devops"      => ["name"=>"Rendszerüzemeltetés / DevOps", "score"=>0],
    "business"    => ["name"=>"Gazdasági / Alkalmazott informatika", "score"=>0]
];

/*
  Új mapping: minden kategóriához kb. ugyanannyi kérdés
  (30 kérdés → kb. 4–5 kérdés/kategória)
*/
$mapping = [
    1=>["theoretical"],2=>["software"],3=>["hardware"],4=>["data_ai"],5=>["security"],
    6=>["devops"],7=>["business"],8=>["theoretical"],9=>["software"],10=>["hardware"],
    11=>["data_ai"],12=>["security"],13=>["devops"],14=>["business"],15=>["theoretical"],
    16=>["software"],17=>["hardware"],18=>["data_ai"],19=>["security"],20=>["devops"],
    21=>["business"],22=>["theoretical"],23=>["software"],24=>["hardware"],25=>["data_ai"],
    26=>["security"],27=>["devops"],28=>["business"],29=>["software","business"],30=>["theoretical","hardware"]
];

/* Feldolgozás: POST q1..q30 */
foreach($_POST as $key => $value){
    if(strpos($key,'q')===0){
        $num = intval(substr($key,1));
        $val = intval($value);
        if(isset($mapping[$num])){
            $cats = $mapping[$num];
            $val_per_cat = $val / count($cats); // pont felosztása több kategóriára
            foreach($cats as $cat){
                $categories[$cat]['score'] += $val_per_cat;
            }
        }
    }
}

/* Sorbarendezés csökkenő pontszám szerint */
usort($categories, function($a,$b){ return $b['score'] - $a['score']; });

/* Ha döntetlen van az első helyen, véletlenszerűen válassz */
$topScore = $categories[0]['score'];
$topCandidates = array_filter($categories, function($c) use ($topScore){
    return $c['score'] === $topScore;
});
$topCandidates = array_values($topCandidates);
$topCategory = $topCandidates[array_rand($topCandidates)];

/* Session-be mentés */
$_SESSION['result'] = [
    'top' => $topCategory,
    'all' => $categories
];

/* Adatbázis mentés */
$dbHost = 'localhost';
$dbName = 'informatica_test';
$dbUser = 'root';
$dbPass = 'ÚJ_JELSZÓ'; // cseréld a sajátodra

try {
    $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $username = isset($_POST['username']) ? trim($_POST['username']) : 'Ismeretlen';
    $score = $topCategory['score'];
    $top_name = $topCategory['name'];

    $stmt = $pdo->prepare("INSERT INTO users (name, score, top_category) VALUES (:name, :score, :top)");
    $stmt->execute([
        ':name' => $username,
        ':score' => $score,
        ':top' => $top_name
    ]);

} catch(PDOException $e){
    error_log("DB hiba (quiz.php): ".$e->getMessage());
}

/* Átirányítás az eredmény oldalra */
header("Location: eredmeny.php");
exit;
?>
