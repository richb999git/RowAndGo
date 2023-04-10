<?php

// Forward Vercel requests to normal index.php
//require __DIR__ . '/../index.php';


if (substr($_SERVER['REQUEST_URI'], 0, 8) === '/contact') {
    require __DIR__ . '/../contact.php';
} else {
    require __DIR__ . '/../index.php';
}