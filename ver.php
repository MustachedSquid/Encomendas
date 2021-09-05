<?php

require_once 'php/structure.php';

$conn = create_connection();
$isOn = false;
$html = "Erro: Um erro ocorreu.";
if (isset($_SESSION['isOn'])) {

    $isOn = $_SESSION['isOn'];
}

if ($isOn) {

    $qd = false;
    $menu = false;
    $pesquisar = false;
    $sqlend = ", data, hora ";
    $sqlwhere = "";
    if(isset($_GET['o'])){
        /* Já não é utilizado
        if($_GET['o'] === "datahora"){
            $sqlend = ", data, hora ";
        }*/

        if($_GET['o'] === "menu"){
            $menu = true;
        }

        if($_GET['o'] === "dia"){
            $qd = true;
        }
    }

    if (isset($_POST['pesq'])){
        $qd = false;
        $menu = false;
        $pesquisar = true;
    }

    if($menu){
        $hojeFormat = date("Y-m-d");
        $html = '<a href="index.php">Registar outra encomenda</a><br><br><a href="ver.php?o=dia"><button>Ver quantidade por dia</button></a><br><br><a href="ver.php"><button>Ver todas as encomendas</button></a>';
        $html = $html . '<form method="post" action="ver.php"><input type="date" name="campoData" id="campoData" value="'.$hojeFormat.'"><input type="submit" name="pesq" value="Pesquisar por dia"></form>';

    }else if(!$qd) {

        if($pesquisar){

            $diaP = $_POST['campoData'];
            $sqlwhere = "WHERE data LIKE '$diaP'";

        }

        $sql = "SELECT * FROM Encomendas $sqlwhere ORDER BY estado $sqlend;";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            //<div id="verdiv"><a href="ver.php?o=datahora"><button>Ordenar por data e hora</button></a>
            $html = '<a href="index.php">Registar outra encomenda</a><br><br><a href="ver.php?o=dia"><button>Ver quantidade por dia</button></a>';
            while ($row = $result->fetch_assoc()) {

                $id = $row['id'];

                $nome = $row['nome_cliente'];
                $estadoN = $row['estado'];
                $data = $row['data'];
                $hora = $row['hora'];

                $dia = date('l', strtotime($data));

                switch ($dia){
                    case "Monday":
                        $dia ="Segunda-feira";
                        break;
                    case "Tuesday":
                        $dia ="Terça-feira";
                        break;
                    case "Wednesday":
                        $dia ="Quarta-feira";
                        break;
                    case "Thursday":
                        $dia ="Quinta-feira";
                        break;
                    case "Friday":
                        $dia ="Sexta-feira";
                        break;
                    case "Saturday":
                        $dia ="Sábado";
                        break;
                    case "Sunday":
                        $dia ="Domingo";
                        break;

                }

                $dataF = date('d/m/Y', strtotime($data));

                $estado = "";
                $apagar = false;
                if ($estadoN === "0") {
                    $estado = "Por fazer";
                } else {
                    $estado = "Entregue";
                    $apagar = true;
                }

                $html = $html . '<div class="verencdivbor">';

                $html = $html . "<br>Estado: <a class='cs$estadoN' href='mudar_estado.php?id=$id'>$estado</a>";
                $html = $html . "<br>Nome: " . $nome;
                //$html = $html . "<br>Dia: $dia";
                $html = $html . "<br>Data e hora: <b>$dia</b> " . $dataF . " " . $hora;
                $html = $html . "<br><br>Bolos: <div class='dpdiv'>";

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

                $sqlPrecosTotal = "SELECT bolo,sum(quantidade) as Q,sum(total) as T FROM `Bolos` WHERE id_enc = $id AND estado = 0 AND bolo NOT LIKE 'KG%' GROUP BY bolo";

                $rpt = $conn->query($sqlPrecosTotal);

                $html = $html . "<div id='precos'>";
                if($result->num_rows > 0) {
                    $dfq = 0;
                    $quq = 0;
                    $anq = 0;
                    $drq = 0;
                    $moq = 0;
                    $paq = 0;
                    $alq = 0;

                    $dfp = 0.0;
                    $qup = 0.0;
                    $anp = 0.0;
                    $drp = 0.0;
                    $mop = 0.0;
                    $pap = 0.0;
                    $alp = 0.0;

                    while ($rptr = $rpt->fetch_assoc()) {
                        $b = $rptr['bolo'];
                        $q = $rptr['Q'];
                        $t = $rptr['T'];

                        switch ($b){
                            case "Doce Fino":

                                $dfq = $q;
                                $dfp = $t;

                                break;

                            case "Queijinhos":

                                $quq = $q;
                                $qup = $t;

                                break;

                            case "Animais":

                                $anq = $q;
                                $anp = $t;

                                break;

                            case "D. Rodrigo":

                                $drq = $q;
                                $drp = $t;

                                break;

                            case "Morgadinho":

                                $moq = $q;
                                $mop = $t;

                                break;

                            case "Papo-seco":

                                $paq = $q;
                                $pap = $t;

                                break;

                            case "Almendrado":

                                $alq = $q;
                                $alp = $t;

                                break;


                        }

                    }

                    $html = $html . "<ul id='precosInd'><li>Doce Fino: $dfq * 0.80€ = $dfp €</li>";
                    $html = $html . "<li>Queijinhos: $quq * 0.90€ = $qup €</li>";
                    $html = $html . "<li>Animais: $anq * 1.00€ = $anp €</li>";
                    $html = $html . "<li>D. Rodrigos: $drq * 0.90€ = $drp €</li>";
                    $html = $html . "<li>Morgadinhos: $moq * 1.00€ = $mop €</li>";
                    $html = $html . "<li>Papo-secos: $paq * 0.80€ = $pap €</li>";
                    $html = $html . "<li>Almendrados: $alq * 0.50€ = $alp €</li></ul>";

                }else{
                    $html = $html . "Erro ao calcular os preços individuais.";
                }

                $html = $html . "<br><p>Preço total: $preco_total €</p></div>";


                if ($apagar) {
                    $html = $html . '<br><a href="apagar_encomenda.php?id=' . $id . '"><button id="botApagar">Apagar encomenda</button></a>';
                }else{

                    $html = $html . '<br><a href="editar.php?id=' . $id . '"><button id="botEditar">Editar encomenda</button></a>';
                }

                $html = $html . "</div>";
            }
            $html = $html . '</table></div>';


        } else {

            $html = '<a href="index.php">Registar outra encomenda</a><br><br>Não existem encomendas registadas.';
        }
    }else {

        //Mostrar quantidade por dia

        $sql = "SELECT sum(quantidade) as Q,data FROM `Bolos` WHERE estado != 1 GROUP BY data ";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $html = '<a href="index.php">Registar outra encomenda</a><br><br><div id="verdiv"><a href="ver.php"><button>Ver encomendas</button></a>';
            while ($row = $result->fetch_assoc()) {

                $data = $row['data'];
                $quantidade = $row['Q'];

                $dia = date('l', strtotime($data));

                switch ($dia){
                    case "Monday":
                        $dia ="Segunda-feira";
                        break;
                    case "Tuesday":
                        $dia ="terça-feira";
                        break;
                    case "Wednesday":
                        $dia ="Quarta-feira";
                        break;
                    case "Thursday":
                        $dia ="Quinta-feira";
                        break;
                    case "Friday":
                        $dia ="Sexta-feira";
                        break;
                    case "Saturday":
                        $dia ="Sabado";
                        break;
                    case "Sunday":
                        $dia ="Domingo";
                        break;

                }

                $dataF = date('d/m/Y', strtotime($data));
                $html = $html . '<div class="verencdivbor">';

                $html = $html . "<br>Dia: $dataF ($dia)";
                $html = $html . "<br>Quantidade total: <b>$quantidade</b><div class='dpdiv'>";

                $sqlInd = "SELECT sum(quantidade) as Q,bolo FROM `Bolos` WHERE data LIKE '$data' AND estado != 1 GROUP BY bolo ";
                $resultInd = $conn->query($sqlInd);

                if ($resultInd->num_rows > 0) {
                    while ($rowInd = $resultInd->fetch_assoc()) {
                        $bolo = $rowInd['bolo'];
                        $quantInd = $rowInd['Q'];
                        $html = $html . "<br>$bolo: $quantInd";
                    }
                }


                $html = $html . "</div>";

                $html = $html . '';

                $html = $html . "<br>Quantidade da manhã: <div class='dpmdiv'>";

                $sqlInd = "SELECT sum(quantidade) as Q,bolo FROM `Bolos` WHERE data LIKE '$data' AND estado != 1 AND hora <= '14:00:00' GROUP BY bolo ";
                $resultInd = $conn->query($sqlInd);

                if ($resultInd->num_rows > 0) {
                    while ($rowInd = $resultInd->fetch_assoc()) {
                        $bolo = $rowInd['bolo'];
                        $quantInd = $rowInd['Q'];
                        $html = $html . "<br>$bolo: $quantInd";
                    }
                }


                $html = $html . "</div>";

                $html = $html . '';

                $html = $html . "<br>Quantidade da tarde: <div class='dpndiv'>";

                $sqlInd = "SELECT sum(quantidade) as Q,bolo FROM `Bolos` WHERE data LIKE '$data' AND estado != 1 AND hora > '14:00:00' GROUP BY bolo ";
                $resultInd = $conn->query($sqlInd);

                if ($resultInd->num_rows > 0) {
                    while ($rowInd = $resultInd->fetch_assoc()) {
                        $bolo = $rowInd['bolo'];
                        $quantInd = $rowInd['Q'];
                        $html = $html . "<br>$bolo: $quantInd";
                    }
                }


                $html = $html . "</div></div>";
            }
            $html = $html . '</table></div>';

        }
    }
} else {

    $html = "Erro: Acesso negado";
}

$conn->close();

create_header();

create_content($html);

create_footer();