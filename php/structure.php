<?php

require_once 'config.php';

session_set_cookie_params(86400000);
session_start();


function create_header(){
    echo '<!DOCTYPE html><html lang="pt"><head>
<meta charset="UTF-8">
<title>Encomenda</title>
<link rel="stylesheet" type="text/css" href="/Encomenda/css/main.css">
<script src="/Encomenda/js/main.js"></script> 
</head><body>
';
}

function create_content($html){
    echo '<div id="content"><div id="centerbox">'.$html.'</div></div>';
}

function create_footer(){
    echo '</body></html>';
}

function create_connection(){
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);

    // Check connection
    if ($conn->connect_error) {
        create_header("","");
        create_content("Conexão à base de dados falhou" . $conn->connect_error);
        create_footer();
        die();
    }
    return $conn;
}