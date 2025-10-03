<?php
session_start();
if(!isset($_SESSION["result"])){
    echo "Nincs eredmény. <a href='landing.php'>Vissza a teszthez</a>";
    exit;
}
$result = $_SESSION["result"];
$top = $result["top"];
$all = $result["all"];
?>
<!doctype html>
<html lang="hu">
<head>
<meta charset="utf-8">
<title>Eredményed - Informatika Szakág Teszt</title>
<style>
body { font-family: Arial, sans-serif; background: linear-gradient(135deg,#0f172a,#1e293b); color:#e6eef6; margin:0; padding:20px;}
.card {max-width:700px; margin:auto; background:#1e293b; padding:30px; border-radius:16px; box-shadow:0 8px 30px rgba(0,0,0,0.5); text-align:center;}
h1 {color:#3ddad7; font-size:2.2em; margin-bottom:16px;}
p {font-size:1.1em; margin:8px 0;}
.bar {width:100%; height:18px; background:#334155; border-radius:10px; margin:6px 0;}
.bar-inner {height:100%; width:0%; border-radius:10px; transition: width 1s; background:#06b6d4;}
.bar-inner.top3 {
    background:#f59e0b;
    animation: pulse 1.2s infinite;
    transform-origin: left;
}
@keyframes pulse {
  0% { transform: scaleX(1); }
  50% { transform: scaleX(1.03); }
  100% { transform: scaleX(1); }
}
a {color:#06b6d4; text-decoration:none; display:inline-block; margin-top:16px;}
a:hover {text-decoration:underline;}
</style>
</head>
<body>
<div class="card">
  <h1>Az eredményed</h1>
  <p><strong>Leginkább illő szakág:</strong> <?= htmlspecialchars($top["name"]) ?> (<?= $top["score"] ?> pont)</p>
  <h2>Pontozás összesen:</h2>
<?php
$max = max(array_column($all,"score"));
foreach($all as $i => $cat){
    $percent = $max ? round(($cat["score"]/$max)*100) : 0;
    $classes = ($i<3) ? "bar-inner top3" : "bar-inner";
    echo "<p>{$cat["name"]}: {$cat["score"]} pont</p>";
    echo "<div class='bar'><div class='{$classes}' data-width='{$percent}'></div></div>";
}
?>
  <p><a href="landing.php">Újrakezdés</a></p>
</div>
<script>
window.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".bar-inner").forEach(el => {
    const width = el.dataset.width;
    setTimeout(()=>{ el.style.width = width + "%"; }, 200);
  });
});
</script>
</body>
</html>
