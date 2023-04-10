<?php

// Forward Vercel requests to normal index.php
//require __DIR__ . '/../index.php';


if (str_starts_with($_SERVER['REQUEST_URI'], '/contact')) {
    require __DIR__ . '/../contact.php';
} else {
    require __DIR__ . '/../index.php';
}