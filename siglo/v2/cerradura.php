<?php

include_once('config.php');
// Asegura que PHP use la hora de Ciudad de México
date_default_timezone_set('America/Mexico_City');


// Códigos de acción para cierre/apertura de cerradura
define('ACTION_ABERTURA',        1);
define('ACTION_FECHAMENTO',      2);
define('ACTION_FECHAMENTO_FOR',  4);


function escapeJsonString($value) { 
    $escapers = array("\'");
    $replacements = array("\\/");
    return str_replace($escapers, $replacements, $value);
}

function acompletarValor($pDato)
{
    $lStrReturn = "";
    if (strlen($pDato) < 2) {
        $lStrReturn = str_pad($pDato,2,"0",STR_PAD_LEFT);
    }
    return $lStrReturn;
}

if($_SERVER['REQUEST_METHOD'] == "GET")
{
    $id = isset($_GET['id']) ? $conn->real_escape_string($_GET['id']) : "";
    $operador = isset($_GET['operador']) ? $conn->real_escape_string($_GET['operador']) : "";
    $registro = isset($_GET['registro']) ? $conn->real_escape_string($_GET['registro']) : "";
    $clave = isset($_GET['clave']) ? $conn->real_escape_string($_GET['clave']) : "";
    $tipo = isset($_GET['tipo']) ? $conn->real_escape_string($_GET['tipo']) : "";

    if ($id != '' || $operador != '')
    {
        if ($id != '')
        {
            $sql = "SELECT id, pin FROM operadores WHERE id = " . $id;
        }
        else
        {
            $sql = "SELECT id, pin FROM operadores WHERE registro = '" . $operador . "'";
        }
    }

    $result = $conn->query($sql);
    $apikey = "U64SI7RJVTGL3FWH2FP2";

    if ($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $pin = $row["pin"];

            $sqlFechadura = "SELECT id, registro, ativa, ns FROM fechaduras WHERE registro = '" . $registro . "'";
            $resultFechadura = $conn->query($sqlFechadura);

            if ($resultFechadura->num_rows > 0)
            {
                while($rowFechadura = $resultFechadura->fetch_assoc())
                {
                    $ns = $rowFechadura["ns"];
                    $idFe = $rowFechadura["id"];

                    $urlApertura = 
                        "http://localhost/onyxmanager/index.php/api?debug=1"
                        . "&key="     . $apikey
                        . "&act=fechaduras.abrir"
                        . "&ns="      . $ns
                        . "&pin="     . $pin
                        . "&senha="   . $clave
                        . "&subtranca=1";

                    $urlCierre = 
                        "http://localhost/onyxmanager/index.php/api?debug=1"
                        . "&key="     . $apikey
                        . "&act=fechaduras.fechar"
                        . "&ns="      . $ns

                        
                        . "&pin="     . $pin
                        . "&cf="      . $clave;

                    switch ($tipo)
                    {
                        case "1": // Apertura
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $urlApertura);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $response = curl_exec($ch);
                            curl_close($ch);
                            $response = escapeJsonString(str_replace('﻿', '', $response));
                            $jsonFechadura = json_decode($response,true);

                            switch ($jsonFechadura["sts"]) {
                                case "0":
                                    if (count($jsonFechadura["res"]["pendencias"])==0) {
                                        if ($jsonFechadura["res"]["negado"]=="0") {
                                            $json = ["codigo"=>$jsonFechadura["res"]["contrasenha"], "estatus"=>0, "msg"=>"OK"];
                                        } else {
                                            $json = ["codigo"=>"", "estatus"=>6, "msg"=>"SOLICITUD DE APERTURA NEGADA"];
                                        }
                                    } else {
                                        $json = ["codigo"=>"", "estatus"=>5, "msg"=>$jsonFechadura["res"]["pendencias"][0]];
                                    }
                                    break;
                                default:
                                    $json = ["codigo"=>"", "estatus"=>4, "msg"=>"API_ER_" . strtoupper($jsonFechadura["sts"])];
                                    break;
                            }
                            break;

                        case "2": // Cierre normal
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $urlCierre);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $response = curl_exec($ch);
                            curl_close($ch);
                            $response = escapeJsonString(str_replace('﻿', '', $response));
                            $jsonFechadura = json_decode($response,true);

                            switch ($jsonFechadura["sts"]) {
                                case "0":
                                    if (count($jsonFechadura["res"]["pendencias"])==0) {
                                        if ($jsonFechadura["res"]["negado"]=="0") {
                                            $json = ["codigo"=>"", "estatus"=>0, "msg"=>"CERRADO CON EXITO"];
                                        } else {
                                            $json = ["codigo"=>"", "estatus"=>6, "msg"=>$jsonFechadura["res"]["msg"]];
                                        }
                                    } else {
                                        $json = ["codigo"=>"", "estatus"=>5, "msg"=>$jsonFechadura["res"]["pendencias"][0]];
                                    }
                                    break;
                                default:
                                    $json = ["codigo"=>"", "estatus"=>4, "msg"=>"API_ER_" . strtoupper($jsonFechadura["sts"])];
                                    break;
                            }
                            break;
                            }
                        }
                    } else {
                        $json = ["codigo"=>0, "estatus"=>3, "msg"=>"NO EXISTE LA CERRADURA"];
                    }
                }
            } else {
                $json = ["codigo"=>0, "estatus"=>2, "msg"=>"NO EXISTE EL OPERADOR"];
            }
        }
        else
        {
            $json = ["id"=>0, "estatus"=>1, "msg"=>"REQUEST_METHOD NO ACEPTADO"];
        }

        header('Content-type: text/plain'); // importante, no "application/json"
         echo base64_encode(json_encode($json))
        ?>