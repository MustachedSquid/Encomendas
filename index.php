<?php

require_once 'php/structure.php';

$isOn = false;
$html = "Erro: Um erro ocorreu.";
if(isset($_SESSION['isOn'])) {

    $isOn = $_SESSION['isOn'];
}

if($isOn){
    $html = '<a href="ver.php?o=menu">Ver encomendas</a><div id="encomendadiv"><form action="adicionar_encomenda.php" method="post" name="encomendaaddform" id="encomendaaddform">
<input type="submit" name="submit" id="submitReg" value="Registar"><br>
Nome do cliente:<br>
<input type="text" class="finput" name="nomec" id="nomec"><br>

Data:<br>
<input type="date" class="finput" name="data" id="data"><br>
Hora:<br>
<input type="time" class="finput" name="hora" id="hora"><br>

Bolos:<br>

<input type="hidden" id="end" name="end">
</form><button id="add">+</button><br><br><br><br><a href="sair.php">Terminar sessão</a></div>';
}else{


    $html = '<h1>Registar encomendas</h1><br><div id="logindiv"><form method="post" action="login.php" name="loginform" id="loginform">
Nome de utilizador:<br>
<input name="nome" class="finput" id="nome" type="text"><br>
Password:<br>
<input name="password" class="finput" id="password" type="password"><br>
<input type="submit" name="submit" id="submit" value="Log in">
</form></div>';
}

create_header();

create_content($html);

create_footer();