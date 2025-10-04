<?php
session_start();
if(!isset($_SESSION['result'])){
    // ha nincs eredmény, visszahívjuk a kezdőlapra
    header('Location: landing.php');
    exit;
}
$result = $_SESSION['result'];
$top = $result['top'];
$all = $result['all'];
?>
<!doctype html>
<html lang="hu">
<head>
<meta charset="utf-8">
<title>Eredményed - Informatika Szakág Teszt</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
body {
  margin:0;
  font-family: Arial, sans-serif;
  background: url("tokaj.jpg") no-repeat center center fixed;
  background-size: cover;
  color:#e6eef6;
}
.container {
  max-width:800px;
  margin:40px auto;
  background: rgba(17,24,39,0.78);
  padding:28px;
  border-radius:14px;
  box-shadow:0 12px 40px rgba(0,0,0,0.6);
  text-align:left;
}
h1 { color:#3ddad7; margin:0 0 12px; }
p { margin:8px 0; }
.bar { width:100%; height:18px; background:#0b1220; border-radius:10px; margin:8px 0; overflow:hidden; }
.bar-inner { height:100%; width:0%; border-radius:10px; transition: width 1s ease-out; background: linear-gradient(90deg,#06b6d4,#3ddad7);}

/* top3 pulzáló — jobbra pulzálás (transform-origin: left) */
.bar-inner.top3 {
  background: linear-gradient(90deg,#f59e0b,#f97316);
  transform-origin: left;
  animation: pulseRight 1.4s infinite ease-in-out;
  /* finomabb pulzus, hogy ne túlzott legyen */
}
@keyframes pulseRight {
  0% { transform: scaleX(1); }
  50% { transform: scaleX(1.03); } /* csak 3% nyúlás */
  100% { transform: scaleX(1); }
}

.top-summary { display:flex; flex-direction:column; gap:8px; }
.top-summary .main { display:flex; align-items:center; justify-content:space-between; }

.footer-links { margin-top:18px; }
a.button {
  display:inline-block; padding:10px 16px; border-radius:10px; background:#06b6d4; color:#022; font-weight:700;
  text-decoration:none; margin-right:10px;
}
a.button:hover{ transform: translateY(-3px); box-shadow:0 8px 16px rgba(0,0,0,0.4); }
@media (max-width:700px){
  .container{ margin:16px; padding:18px; }
}
</style>
</head>
<body>
<div class="container">
  <h1>Az eredményed</h1>
  <p><strong>Leginkább illő szakág:</strong> <?php echo htmlspecialchars($top['name']); ?> (<?php echo intval($top['score']); ?> pont)</p>

  <h2>Pontozás összesen</h2>
  <?php
    $max = 1;
    foreach($all as $c) { $max = max($max, intval($c['score'])); }
    foreach($all as $i => $c){
      $score = intval($c['score']);
      $percent = $max ? round(($score / $max) * 100) : 0;
      $classes = ($i < 3) ? "bar-inner top3" : "bar-inner";
      echo "<p style='margin:6px 0; font-weight:600;'>{$c['name']}: {$score} pont</p>";
      echo "<div class='bar'><div class='{$classes}' data-width='{$percent}'></div></div>";
    }
  ?>

  <div class="footer-links">
    <a class="button" href="landing.php">Újrakezdés</a>
  </div>
</div>

<script>
// animate bars on load
window.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.bar-inner').forEach(el => {
    const w = el.dataset.width || 0;
    // kis késleltetés, hogy legyen sima animációs indulás
    setTimeout(()=> { el.style.width = w + '%'; }, 120);
  });
});
</script>
</body>
</html>
