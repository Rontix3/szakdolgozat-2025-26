<?php
session_start();
$username = isset($_GET['username']) ? htmlspecialchars($_GET['username']) : "Ismeretlen";
?>
<!doctype html>
<html lang="hu">
<head>
<meta charset="utf-8">
<title>Informatika Szakág Teszt</title>
<style>
body { font-family: Arial, sans-serif; background: linear-gradient(135deg,#0f172a,#1e293b); color:#e6eef6; margin:0; padding:20px;}
.card {max-width:800px; margin:auto; background:#1e293b; padding:20px; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.4);}
.q {margin:16px 0; padding:16px; background:#334155; border-radius:12px;
    opacity:0; transform:translateY(20px); animation: slideUp 0.6s forwards; transition: transform 0.3s, box-shadow 0.3s;}
.q:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(0,0,0,0.3); }
.q:nth-child(odd){animation-delay:0.2s;}
.q:nth-child(even){animation-delay:0.4s;}
@keyframes slideUp {to {opacity:1; transform:translateY(0);}}
.radio-group {display:flex; gap:8px; margin-top:8px;}
input[type="radio"] { display: none; }
label {
  display:inline-block; padding:8px 14px; border-radius:50px; color:#022; font-weight:bold;
  cursor:pointer; position:relative; overflow:hidden; transition: all 0.3s; background:#1e293b;
}
label:hover { transform: scale(1.05); box-shadow:0 4px 12px rgba(0,0,0,0.3); }
input[id$="_1"]:checked + label { background:#ef4444; color:#fff; }
input[id$="_2"]:checked + label { background:#f59e0b; color:#fff; }
input[id$="_3"]:checked + label { background:#eab308; color:#022; }
input[id$="_4"]:checked + label { background:#10b981; color:#fff; }
input[id$="_5"]:checked + label { background:#3b82f6; color:#fff; }
input[type="radio"]:checked + label { animation: pop 0.3s; box-shadow: 0 0 12px #fff; }
@keyframes pop { 0% { transform: scale(1); } 50% { transform: scale(1.3); } 100% { transform: scale(1.2); } }

button {background:#06b6d4; border:none; padding:12px 16px; border-radius:12px; cursor:pointer; font-weight:bold; margin-top:12px; transition:0.3s;}
button:hover {background:#0891b2;}

.progress-container {width:100%; height:14px; background:#334155; border-radius:8px; margin-bottom:20px; position:sticky; top:10px; z-index:100;}
.progress-bar {height:100%; width:0%; background:#06b6d4; border-radius:8px; transition: width 0.4s;}

#warning {
  position: fixed;
  bottom: 10px;
  left: 50%;
  transform: translateX(-50%) translateY(20px);
  background: #ef4444;
  color: #fff;
  padding: 12px 20px;
  border-radius: 12px;
  font-weight: bold;
  box-shadow: 0 4px 12px rgba(0,0,0,0.4);
  z-index: 200;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.6s ease, transform 0.6s ease;
}
#warning.show {
  opacity: 1;
  transform: translateX(-50%) translateY(0);
  pointer-events: auto;
}
#warning.hide {
  opacity: 0;
  transform: translateX(-50%) translateY(20px);
}
</style>
</head>
<body>
<div class="card">
  <h1>Informatikai szakág-választó teszt</h1>
  <p>Válaszolj 1–5-ig minden kérdésre!</p>
  <div class="progress-container"><div class="progress-bar" id="progress"></div></div>
  <form id="quizForm" action="quiz.php" method="POST">
    <input type="hidden" name="username" value="<?= $username ?>">

<?php
$questions = [
    "Élvezem a bonyolult logikai problémák megoldását.",
    "Szeretek saját alkalmazásokat készíteni.",
    "Érdekel a vizuális design és a felhasználói élmény.",
    "Szeretem megérteni a hardver működését.",
    "Szeretek adatokból következtetéseket levonni.",
    "Érdekel a rendszerek biztonsága, védelem a hackerektől.",
    "Szívesen dolgozom csapatban.",
    "Érdekel, hogyan segíthet az informatika a vállalatoknak.",
    "Fontos számomra a rendszerek stabil működése.",
    "Lenyűgöz a mesterséges intelligencia.",
    "Szeretem a matematikai bizonyításokat.",
    "Szívesen építenék mobilappokat.",
    "Érdekel a játékfejlesztés.",
    "Szívesen szerelnék össze robotokat.",
    "Érdekel a gépi tanulás.",
    "Izgalmasnak tartom a vírusok és kiberfenyegetések elleni védelmet.",
    "Szeretem optimalizálni a meglévő rendszereket.",
    "Fontos számomra a költséghatékonyság IT rendszerekben.",
    "Szívesen programoznék beágyazott rendszereket.",
    "Érdekel, hogyan lehet automatizálni folyamatokat.",
    "Élvezem a matematikai modellek készítését.",
    "Szívesen tanulok új programozási nyelveket.",
    "Érdekel a géphálózatok működése.",
    "Szeretem nyomon követni a legújabb technológiai trendeket.",
    "Szívesen fejlesztenék webes alkalmazásokat.",
    "Fontosnak tartom a felhasználói adatok védelmét.",
    "Szívesen dolgoznék nagyvállalat informatikai rendszerein.",
    "Érdekel, hogyan lehet sok szervert hatékonyan működtetni.",
    "Szívesen foglalkoznék üzleti adatelemzéssel.",
    "Élvezem a kutatást és új algoritmusok feltalálását."
];

foreach($questions as $i => $q){
    echo "<div class='q'><p><strong>".($i+1).".</strong> $q</p>";
    echo "<div class='radio-group'>";
    for($j=1; $j<=5; $j++){
        echo "<input type='radio' name='q".($i+1)."' id='q".$i."_".$j."' value='$j'>";
        echo "<label for='q".$i."_".$j."'>$j</label>";
    }
    echo "</div></div>";
}
?>

<button type="submit">Kiértékelés</button>
</form>
</div>

<div id="warning">Még nem töltötted ki az összes kérdést!</div>

<script>
const totalQuestions = 30;
const progressBar = document.getElementById("progress");
const warning = document.getElementById("warning");
const form = document.getElementById("quizForm");

// Toggle rádiók
const radios = document.querySelectorAll("input[type=radio]");
radios.forEach(radio => {
  radio.addEventListener('click', function(){
    if(this.dataset.waschecked === "true"){ 
      this.checked = false; 
      this.dataset.waschecked = "false"; 
    } else { 
      this.dataset.waschecked = "true"; 
    }
    let siblings = this.closest('.radio-group').querySelectorAll('input[type=radio]');
    siblings.forEach(sib => { if(sib!==this) sib.dataset.waschecked="false"; });
    updateProgress();
  });
  radio.addEventListener("change", updateProgress);
});

// Progress bar frissítés
function updateProgress(){
  let checked = document.querySelectorAll("input[type=radio]:checked").length;
  progressBar.style.width = Math.round((checked/totalQuestions)*100) + "%";
}

// Inicializálás
updateProgress();

// Submit ellenőrzés animált figyelmeztetéssel
form.addEventListener("submit", function(e){
  let checked = document.querySelectorAll("input[type=radio]:checked").length;
  if(checked < totalQuestions){
    e.preventDefault();
    warning.classList.remove("hide");
    warning.classList.add("show");

    // 3 másodperc múlva eltűnik animáltan
    setTimeout(() => {
      warning.classList.remove("show");
      warning.classList.add("hide");
    }, 3000);

    window.scrollTo({top:document.body.scrollHeight, behavior:"smooth"});
  }
});
</script>
</body>
</html>
