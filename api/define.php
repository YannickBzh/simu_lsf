<?php
    /*session_start();
    if (empty($_SESSION['csrf_token'])) {
        $token = bin2hex(random_bytes(32));
      $_SESSION['csrf_token'] = $token;
    }*/
    
    if (!defined('UTILISATEURS')) {
        define('UTILISATEURS', 'lesitefrancais_simulateur_v2');
    }
    if (!defined('ACCESS')) {
        define('ACCESS', '!_xgjBrwuL22');
    }
    if (!defined('HOST')) {
        define('HOST', 'localhost');
    }