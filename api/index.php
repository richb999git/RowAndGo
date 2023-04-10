<?php

// Forward Vercel requests to normal index.php

// if (substr($_SERVER['REQUEST_URI'], 0, 8) === '/contact') {
//     require __DIR__ . '/../contact.php';
// } else  if (substr($_SERVER['REQUEST_URI'], 0, 6) === '/login') {
//     require __DIR__ . '/../login.php';
// } else  if (substr($_SERVER['REQUEST_URI'], 0, 7) === '/signup') {
//     require __DIR__ . '/../signup.php';
// } else  if (substr($_SERVER['REQUEST_URI'], 0, 9) === '/addScore') {
//     require __DIR__ . '/../addScore.php';
// } else  if (substr($_SERVER['REQUEST_URI'], 0, 11) === '/viewScores') {
//     require __DIR__ . '/../viewScores.php';
// } else  if (substr($_SERVER['REQUEST_URI'], 0, 16) === '/downloadResults') {
//     require __DIR__ . '/../downloadResults.php';
// } else {
//     require __DIR__ . '/../index.php';
// }

require __DIR__ . '/../' . $_SERVER['REQUEST_URI'] . '.php';