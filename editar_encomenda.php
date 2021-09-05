<?php

require_once 'php/structure.php';

$conn = create_connection();
$isOn = false;
$html = "Erro: Um erro ocorreu.";
if(isset($_SESSION['isOn'])) {

    $isOn = $_SESSION['isOn'];
}

if($isOn){

    if(isset($_POST['submit'])) {

        $eId = $_POST['eId'];
        $nomecliente = $_POST['nomec'];

        $data = $_POST['data'];
        $hora = $_POST['hora'];

        /* DATA PASSA A SER OBRIGATORIA
        if(trim($data)==="" || $data === null){
            $data="null";
        }else{
            $data = "'" . $data . "'";
        }*/
        if(trim($hora)===""){
            $hora="null";
        }else{
            $hora = "'" . $hora . "'";
        }





        $sql = "UPDATE Encomendas SET `nome_cliente` = '$nomecliente', `data` = '$data', `hora` = $hora WHERE id = $eId";
        $result = $conn->query($sql);
        if($result){


                $html = '<a href="index.php">Registar outra encomenda</a><br><br><div id="verdiv"><a href="ver.php?o=datahora"><button>Ordenar por data e hora</button></a>';

                $num_array = $_POST['cNum'];
                $bolos_array = $_POST['cBolo'];
                $comentario_array = $_POST['cCom'];

                $suc = true;

                $deleteBolos = "DELETE FROM Bolos WHERE id_enc = $eId";

                $resultDelete = $conn->query($deleteBolos);
                if($resultDelete){


                    for ($i = 0;$i<count($bolos_array);$i++){

                        $preco_db = 0;
                        $preco_bolo_total = 0;
                        $sqlPreco = "SELECT bolo,preco FROM Precos WHERE bolo LIKE '$bolos_array[$i]'";

                        $resultPreco = $conn->query($sqlPreco);

                        if ($resultPreco->num_rows === 1) {

                            $rowPreco = $resultPreco->fetch_assoc();
                            $preco_db = floatval($rowPreco['preco']);

                            $preco_bolo_total = $num_array[$i] * $preco_db;
                        }



                        $insertSqlBolos = "INSERT INTO `Bolos` (`bolo`, `quantidade`, `comentario`, `id_enc`, `data`, `hora`, `estado`, `total`) VALUES ('$bolos_array[$i]', '$num_array[$i]', '$comentario_array[$i]', $eId, '$data', $hora, 0, $preco_bolo_total);";

                        $result = $conn->query($insertSqlBolos);
                        if(!$result){
                            $html = "<p>Erro: Não foi possível registar a encomenda. (ERRO DE DADOS)</p>";
                            $suc = false;
                            break;
                        }
                    }

                }else{
                    $html = "<p>Erro: ERRO DE ID ao editar a lista de bolos</p><a href='ver.php'>Voltar</a>";
                    $suc = false;
                }


                if($suc) {
                    $html = '<p>Encomenda editada com sucesso!</p><a href="ver.php">Ver encomendas</a><br><a href="index.php">Registar outra</a>';
                }

        }else{
            $html = "<p>Erro: Não foi possível editar a encomenda.</p>";
        }
    }
}else{

    $html = "Erro: Acesso negado";
}

$conn->close();

create_header();

create_content($html);

create_footer();