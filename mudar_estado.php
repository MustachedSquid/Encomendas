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

        $sql = "SELECT estado FROM Encomendas WHERE id = $id;";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $estado = $row['estado'];
            $estadoNovo = 0;
            if($estado==="0"){
                $estadoNovo=1;
            }

            $update = "UPDATE Encomendas SET estado='$estadoNovo' WHERE id = $id";

            $resultUpdate = $conn->query($update);
            if($resultUpdate){
                $update = "UPDATE Bolos SET estado='$estadoNovo' WHERE id_enc = $id";

                $resultUpdate = $conn->query($update);
                if($resultUpdate){


                    header("Location: ver.php");
                }else{
                    $html = "<p>Erro: Não foi possível alterar o estado desta encomenda. (ERRO DE ID)</p><a href='ver.php'>Voltar</a>";
                }

                header("Location: ver.php");
            }else{
                $html = "<p>Erro: Não foi possível alterar o estado desta encomenda.</p><a href='ver.php'>Voltar</a>";
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