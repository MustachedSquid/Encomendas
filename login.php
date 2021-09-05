<?php

require_once 'php/structure.php';

$conn = create_connection();
$isOn = false;
$html = "Erro: Um erro ocorreu.";
if (isset($_SESSION['isOn'])) {

    $isOn = $_SESSION['isOn'];
}

if ($isOn) {

    header("Location: index.php");

} else {

    if(isset($_POST['submit'])){


        $nome = $_POST['nome'];
        $password = $_POST['password'];

        $hash = hash("sha512", $password);

        $sql = "SELECT id,nome FROM Utilizadores WHERE nome LIKE '$nome' AND password LIKE '$hash';";

        if(preg_match("/^[\r\n|\n|\ráàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ!?.,a-zA-Z0-9_ ]+?$/", $nome)){
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

                $row = $result->fetch_assoc();

                if($nome = $row['nome']){


                    $_SESSION['isOn'] = true;

                    $_SESSION['id'] = $row['id'];

                    $_SESSION['nome'] = $row['nome'];

                    header("Location: index.php");

                }else{
                    $html = "Erro: Palavra passe errada";
                }


            } else {

                $html = "Erro: O utilizador não existe";
            }

        }else{
            $html = "Erro: Dados inválidos";
        }


    }else{
        $html = "Erro: Dados em falta";
    }

}

$conn->close();

create_header();

create_content($html);

create_footer();