<?php
session_start();
$username = isset($_GET['username']) ? htmlspecialchars($_GET['username']) : "Ismeretlen";
?>
<!doctype html>
<html lang="hu">
<head>
<meta charset="utf-8">
<title>Informatika Szakág Teszt</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
body {
  font-family: Arial, sans-serif;
  background: url("tokaj.jpg") no-repeat center center fixed;
  background-size: cover;
  color:#e6eef6;
  margin:0;
  padding:20px;
}
.card {
  max-width:900px;
  margin:30px auto;
  background: rgba(17,24,39,0.78);
  padding:24px;
  border-radius:12px;
  box-shadow:0 8px 20px rgba(0,0,0,0.6);
}
.q {
  margin:16px 0;
  padding:16px;
  background:#1f2937;
  border-radius:12px;
  opacity:0;
  transform:translateY(20px);
  animation: slideUp 0.6s forwards;
  transition: transform 0.3s, box-shadow 0.3s;
}
.q:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(0,0,0,0.3); }
.q:nth-child(odd){ animation-delay:0.12s; }
.q:nth-child(even){ animation-delay:0.18s; }
@keyframes slideUp { to { opacity:1; transform:translateY(0);} }

.radio-group {display:flex; gap:8px; margin-top:8px; flex-wrap:wrap;}
input[type="radio"] { display: none; }

label {
  display:inline-block; padding:8px 14px; border-radius:50px; color:#022; font-weight:bold;
  cursor:pointer; position:relative; overflow:hidden; transition: all 0.18s; background:#0f1724;
  user-select:none;
}
label:hover { transform: scale(1.05); box-shadow:0 4px 12px rgba(0,0,0,0.3); }

/* külön színek választáskor (id vége alapján) */
input[id$="_1"]:checked + label { background:#ef4444; color:#fff; }
input[id$="_2"]:checked + label { background:#f59e0b; color:#fff; }
input[id$="_3"]:checked + label { background:#eab308; color:#022; }
input[id$="_4"]:checked + label { background:#10b981; color:#fff; }
input[id$="_5"]:checked + label { background:#3b82f6; color:#fff; }

/* pop effekt */
input[type="radio"]:checked + label { animation: pop 0.28s; box-shadow: 0 0 10px rgba(255,255,255,0.06); }
@keyframes pop { 0% { transform: scale(1); } 50% { transform: scale(1.22); } 100% { transform: scale(1.12); } }

button {
  background:#06b6d4; border:none; padding:12px 16px; border-radius:12px; cursor:pointer;
  font-weight:bold; margin-top:12px; transition:0.18s; color:#022;
}
button:hover { background:#0891b2; transform: translateY(-2px); }

/* progress */
.progress-container {width:100%; height:14px; background:#0b1220; border-radius:8px; margin-bottom:20px; position:sticky; top:10px; z-index:100;}
.progress-bar {height:100%; width:0%; background:#06b6d4; border-radius:8px; transition: width 0.25s;}

/* animated warning (no display toggles: opacity + transform only) */
#warning {
  position: fixed;
  bottom: 18px;
  left: 50%;
  transform: translateX(-50%) translateY(20px);
  background: #ef4444;
  color: #fff;
  padding: 12px 20px;
  border-radius: 12px;
  font-weight: 700;
  box-shadow: 0 8px 24px rgba(0,0,0,0.5);
  z-index: 1000;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.45s ease, transform 0.45s ease;
}
#warning.show {
  opacity: 1;
  transform: translateX(-50%) translateY(0);
  pointer-events: auto;
}
#warning.hide {
  opacity: 0;
  transform: translateX(-50%) translateY(20px);
  pointer-events: none;
}

/* responsive */
@media (max-width:720px){
  .card{ margin:16px; padding:16px; }
  label { padding:8px 12px; }
}
</style>
</head>
<body>
<div class="card">
  <h1>Informatikai szakág-választó teszt</h1>
  <p>Válaszolj 1–5-ig minden kérdésre!</p>

  <div class="progress-container"><div class="progress-bar" id="progress"></div></div>

  <form id="quizForm" action="quiz.php" method="POST" autocomplete="off">
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

// Toggle rádió behavior (kattintás ismét törli a választ)
const radios = document.querySelectorAll("input[type=radio]");
radios.forEach(radio => {
  radio.addEventListener('click', function(e){
    if(this.dataset.waschecked === "true"){
      this.checked = false;
      this.dataset.waschecked = "false";
      // trigger change event manually
      this.dispatchEvent(new Event('change', { bubbles: true }));
    } else {
      this.dataset.waschecked = "true";
    }
    // reset siblings' dataset
    let siblings = this.closest('.radio-group').querySelectorAll('input[type=radio]');
    siblings.forEach(sib => { if(sib!==this) sib.dataset.waschecked="false"; });
    updateProgress();
  });
  radio.addEventListener("change", updateProgress);
});

// Update progress bar width
function updateProgress(){
  let checked = document.querySelectorAll("input[type=radio]:checked").length;
  const percent = Math.round((checked/totalQuestions)*100);
  progressBar.style.width = percent + "%";
}

// Initialize progress on load
updateProgress();

// Submit check: only when user clicks Kiértékelés
form.addEventListener("submit", function(e){
  let checked = document.querySelectorAll("input[type=radio]:checked").length;
  if(checked < totalQuestions){
    e.preventDefault();
    // show warning with animation (opacity + transform)
    warning.classList.remove("hide");
    warning.classList.add("show");

    // after 3s hide (animated)
    setTimeout(() => {
      warning.classList.remove("show");
      warning.classList.add("hide");
    }, 3000);

    // scroll down to warning so user sees it (smooth)
    window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
  }
});
</script>
</body>
</html>
