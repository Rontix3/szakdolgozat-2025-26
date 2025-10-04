<?php
// landing.php
session_start();
// töröljük az előző eredményt, ha volt
unset($_SESSION['result']);
?>
<!doctype html>
<html lang="hu">
<head>
  <meta charset="utf-8">
  <title>Informatika Szakág Teszt - Kezdés</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      /* Javított háttér útvonal a web rootból */
      background: url("tokaj.jpg") no-repeat center center fixed;
      background-size: cover;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #e6eef6;
    }

    .card {
      width: 90%;
      max-width: 600px;
      background: rgba(17,24,39,0.72); /* sötét áttetsző háttér */
      padding: 36px;
      border-radius: 16px;
      box-shadow: 0 12px 40px rgba(2,6,23,0.6);
      text-align: center;
      animation: fadeIn 0.6s ease;
    }

    h1 {
      margin: 0 0 10px;
      color: #3ddad7;
      font-size: 28px;
    }

    p {
      margin: 0 0 20px;
      color: #dbeafe;
    }

    .intro-text {
      margin-bottom: 20px;
      color: #dbeafe;
      font-size: 15px;
      line-height: 1.5;
      text-align: left;
    }

    input[type="text"] {
      width: 85%;
      padding: 12px 14px;
      border-radius: 999px;
      border: none;
      outline: none;
      font-size: 16px;
      margin-top: 12px;
    }

    input[type="text"]:focus {
      box-shadow: 0 0 18px rgba(61,218,215,0.18);
    }

    button {
      margin-top: 18px;
      padding: 12px 28px;
      border-radius: 999px;
      border: none;
      background: linear-gradient(90deg,#06b6d4,#3ddad7);
      color: #042a2a;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 10px 25px rgba(3,7,18,0.45);
      transition: transform .18s ease, box-shadow .18s ease;
      font-size: 16px;
    }

    button:hover {
      transform: translateY(-3px);
      box-shadow: 0 16px 30px rgba(3,7,18,0.55);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: none; }
    }

    @media (max-width: 480px) {
      .card {
        padding: 20px;
      }
      h1 {
        font-size: 20px;
      }
      .intro-text {
        font-size: 14px;
      }
      input[type="text"] {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <div class="card">
    <h1>Informatika szakág-választó teszt</h1>
    <p class="intro-text">
      Rontó Adrián vagyok, és a szakdolgozatom központi témája a technikumokban folyó informatika oktatásának fejlesztése. Ennek keretében egy olyan személyiségtesztet dolgoztam ki, amely segít a diákoknak az egyéni adottságaiknak leginkább megfelelő informatikai szakág kiválasztásában. Célom az volt, hogy a hatékonyabb pályaorientációval növeljem a tanulók motivációját és szakmai sikerességét.
    </p>
    <form action="index.php" method="get" autocomplete="off">
      <input type="text" name="username" placeholder="Add meg a neved" required>
      <br>
      <button type="submit">Kezdés</button>
    </form>
  </div>
</body>
</html>
