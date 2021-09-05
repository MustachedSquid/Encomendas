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





        $sql = "INSERT INTO `Encomendas` (`estado`, `nome_cliente`, `data`, `hora`) VALUES (0, '$nomecliente', '$data', $hora);";

        $result = $conn->query($sql);
        if($result){

            $sqlEncId = "SELECT max(id) as eId FROM Encomendas";

            $result = $conn->query($sqlEncId);

            if ($result->num_rows === 1) {

                $html = '<a href="index.php">Registar outra encomenda</a><br><br><div id="verdiv"><a href="ver.php?o=datahora"><button>Ordenar por data e hora</button></a>';
                $row = $result->fetch_assoc();

                $eId = $row['eId'];

                $num_array = $_POST['cNum'];
                $bolos_array = $_POST['cBolo'];
                $comentario_array = $_POST['cCom'];

                $preco_total = 0;

                $suc = true;
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

                if($suc) {
                    $html = '<p>Encomenda registada com sucesso!</p><a href="ver.php">Ver encomendas</a><br><br><a href="index.php">Registar outra encomenda</a>';

                    $html = $html . get_new_enc($conn, $eId);
                }
            }else{
                $html = "<p>Erro: Não foi possível registar a encomenda. (ERRO DE ID)</p>";
            }
        }else{
            $html = "<p>Erro: Não foi possível registar a encomenda.</p>";
        }
    }
}else{

    $html = "Erro: Acesso negado";
}

$conn->close();

create_header();

create_content($html);

create_footer();

function get_new_enc($conn, $id){
    $sql = "SELECT * FROM Encomendas WHERE id = $id;";

    $result = $conn->query($sql);

    if ($result->num_rows === 1) {

        $html = '<br><br><div id="verdiv">';
        while ($row = $result->fetch_assoc()) {

            $id = $row['id'];

            $nome = $row['nome_cliente'];
            $estadoN = $row['estado'];
            $data = $row['data'];
            $hora = $row['hora'];

            $dia = date('l', strtotime($data));

            switch ($dia) {
                case "Monday":
                    $dia = "Segunda-feira";
                    break;
                case "Tuesday":
                    $dia = "terça-feira";
                    break;
                case "Wednesday":
                    $dia = "Quarta-feira";
                    break;
                case "Thursday":
                    $dia = "Quinta-feira";
                    break;
                case "Friday":
                    $dia = "Sexta-feira";
                    break;
                case "Saturday":
                    $dia = "Sabado";
                    break;
                case "Sunday":
                    $dia = "Domingo";
                    break;

            }

            $dataF = date('d/m/Y', strtotime($data));


            $html = $html . '<div class="verencdivbor">';

            $html = $html . "<br>Nome: " . $nome;
            //$html = $html . "<br>Dia: $dia";
            $html = $html . "<br>Data e hora: <b>$dia</b> " . $dataF . " " . $hora;
            $html = $html . "<br><br>Bolos: <div id='dpdiv'>";

            $sqlInd = "SELECT bolo,quantidade,comentario,total FROM `Bolos` WHERE id_enc = $id";
            $resultInd = $conn->query($sqlInd);

            $preco_total = 0;
            if ($resultInd->num_rows > 0) {
                while ($rowInd = $resultInd->fetch_assoc()) {
                    $bolo = $rowInd['bolo'];
                    $quantInd = $rowInd['quantidade'];
                    $com = $rowInd['comentario'];
                    $preco_bolo = $rowInd['total'];

                    $preco_total += $preco_bolo;

                    $html = $html . "<br> - $bolo: $quantInd ($com) - [ $preco_bolo € ]";
                }
            }

            $html = $html . "</div>";
            $html = $html . "<br><p>(!NÃO CONTA BOLOS GRANDES!) Preço total: $preco_total €</p>";
            $html = $html . "</div>";
        }
        $html = $html . '</table></div>';
    }else{
        $html = "<p>Erro: Não foi possivél confirmar se a encomenda foi adicionada!</p>";
    }

    return $html;
}
