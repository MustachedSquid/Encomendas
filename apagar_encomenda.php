<?php

require_once 'php/structure.php';

$conn = create_connection();
$isOn = false;
$html = "Erro: Um erro ocorreu.";
if (isset($_SESSION['isOn'])) {

    $isOn = $_SESSION['isOn'];
}

if ($isOn) {

    if($_GET['id']) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM Encomendas WHERE id = $id;";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $delete = "DELETE FROM Encomendas WHERE id = $id";

            $resultDelete = $conn->query($delete);
            if($resultDelete){

                $delete = "DELETE FROM Bolos WHERE id_enc = $id";

                $resultDelete = $conn->query($delete);
                if($resultDelete){
                    header("Location: ver.php");
                }else{
                    $html = "<p>Erro: Não foi possível apagar esta encomenda. (ERRO DE ID)</p><a href='ver.php'>Voltar</a>";
                }

                header("Location: ver.php");
            }else{
                $html = "<p>Erro: Não foi possível apagar esta encomenda.</p><a href='ver.php'>Voltar</a>";
            }

        } else {

            $html = "Erro: Encomenda não encontrada";
        }
    }else{
        $html = "Erro: Encomenda inválida";
    }
} else {

    $html = "Erro: Acesso negado";
}

$conn->close();

create_header();

create_content($html);

create_footer();