<?php
session_start();
unset($_SESSION['result']);
?>
<!doctype html>
<html lang="hu">
<head>
<meta charset="utf-8">
<title>Informatika Szakág Teszt - Kezdés</title>
<style>
body {
  margin:0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(135deg,#0f172a,#1e293b);
  color:#e6eef6;
  display:flex;
  justify-content:center;
  align-items:center;
  height:100vh;
}
.card {
  background: rgba(30,41,59,0.95);
  padding:50px 40px;
  border-radius:20px;
  box-shadow:0 15px 35px rgba(0,0,0,0.5);
  max-width:500px;
  width:90%;
  text-align:center;
  animation: fadeIn 1s ease-out;
}
h1 {
  font-size:2.5em;
  color:#3ddad7;
  margin-bottom:20px;
}
p {
  font-size:1.1em;
  margin-bottom:30px;
  line-height:1.5em;
}
input[type="text"] {
  padding:12px 16px;
  width:80%;
  border-radius:50px;
  border:none;
  margin-bottom:20px;
  font-size:1em;
  outline:none;
  transition:0.3s;
}
input[type="text"]:focus {
  box-shadow:0 0 10px #3ddad7;
}
button {
  background: linear-gradient(90deg,#06b6d4,#3ddad7);
  border:none;
  padding:14px 30px;
  border-radius:50px;
  color:#fff;
  font-size:1.2em;
  font-weight:bold;
  cursor:pointer;
  transition:0.3s;
  box-shadow:0 8px 20px rgba(0,0,0,0.3);
}
button:hover {
  transform: scale(1.05);
  box-shadow:0 12px 30px rgba(0,0,0,0.5);
}
@keyframes fadeIn {
  0% { opacity:0; transform:translateY(20px);}
  100% { opacity:1; transform:translateY(0);}
}
</style>
</head>
<body>
<div class="card">
  <h1>Üdvözöllek!</h1>
  <p>Ez a rövid teszt segít megtalálni, melyik informatika szakág illik leginkább hozzád. Add meg a neved és kezdjük a tesztet!</p>
  <form action="index.php" method="get">
    <input type="text" name="username" placeholder="Add meg a neved" required>
    <br>
    <button type="submit">Kezdés</button>
  </form>
</div>
</body>
</html>
