<?php

require_once 'php/structure.php';

session_destroy();
session_abort();

$html = '<p>Sessão terminada</p><br><a href="index.php">Voltar</a>';

create_header();
create_content($html);
create_footer();
