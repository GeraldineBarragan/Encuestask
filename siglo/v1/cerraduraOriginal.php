<?php

include_once('config.php');

function escapeJsonString($value) { 
    $escapers = array("\'");
    $replacements = array("\\/");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
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
			$sql = "SELECT id, pin, ativo FROM operadores WHERE id = " . $id . "";			
		}
		else
		{
			$sql = "SELECT registro, pin, ativo FROM operadores WHERE registro = '" . $operador . "'";			
		}
	}
	$result = $conn -> query($sql);

	$apikey = "U64SI7RJVTGL3FWH2FP2";
	$evento = "";
	
	if ($result -> num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			$pin = $row["pin"];
			
			$sqlFechadura = "SELECT id, registro, ativa, ns FROM fechaduras WHERE registro = '" . $registro . "'";
			$resultFechadura = $conn -> query($sqlFechadura);

			if ($resultFechadura -> num_rows > 0)
			{
				while($rowFechadura = $resultFechadura->fetch_assoc())
				{
					$key = "00000000";
					$ns = $rowFechadura["ns"];
					$urlApertura = "http://localhost:8090/onyxmanager/index.php/api?debug=1&key=" . $apikey . "&act=fechaduras.abrir&ns=" . $ns . "&pin=" . $pin . "&senha=" . $clave . "&subtranca=1";
					$urlCierre = "http://localhost:8090/onyxmanager/index.php/api?debug=1&key=" . $apikey . "&act=fechaduras.fechar&ns=" . $ns . "&pin=" . $pin . "&cf=" . $clave . "";
					
					switch ($tipo)
					{
						case "1":
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, $urlApertura);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							$response = curl_exec($ch);
							$response = escapeJsonString($response);
							$response = str_replace('?', '', $response);
							$jsonFechadura = json_decode($response,true);
							print_r($urlApertura);
							#print($response);
							#print_r($jsonFechadura);
							#echo $error = json_last_error();
							
							switch ($jsonFechadura["sts"])
							{
								case "0":
									if (count($jsonFechadura["res"]["pendencias"])==0) 
									{
											if ($jsonFechadura["res"]["negado"]=="0")
											{
												$json = array("codigo" => $jsonFechadura["res"]["contrasenha"], "estatus" => 0, "msg" => "OK");
											}
											else
												$json = array("codigo" => "", "estatus" => 6, "msg" => "SOLICITUD DE APERTURA NEGADA");
									}
									else
										$json = array("codigo" => "", "estatus" => 5, "msg" => $jsonFechadura["res"]["pendencias"][0]);
									break;
								case "1":
									$json = array("codigo" => "", "estatus" => 4, "msg" => "API_ER_INVALID_KEY");
									break;							
								case "2":
									$json = array("codigo" => "", "estatus" => 4, "msg" => "API_ER_INVALID_ACT");	
									break;							
								case "3":
									$json = array("codigo" => "", "estatus" => 4, "msg" => "API_ER_INVALID_NEA");
									break;							
								case "4":
									$json = array("codigo" => "", "estatus" => 4, "msg" => "API_ER_NOT_AVAILABLE");
									break;														
							}			
							curl_close($ch);
							break;
						case "2":					
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, $urlCierre);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							$response = curl_exec($ch);
							$response = escapeJsonString($response);
							$response = str_replace('?', '', $response);
							$jsonFechadura = json_decode($response,true);
							//print_r($urlCierre);
							//print($response);
							//print_r($jsonFechadura);
							//echo $error = json_last_error();

							switch ($jsonFechadura["sts"])
							{
								case "0":
									if (count($jsonFechadura["res"]["pendencias"])==0) 
									{
											if ($jsonFechadura["res"]["negado"]=="0")
											{
												$json = array("codigo" => "", "estatus" => 0, "msg" => "CERRADO CON EXITO");
											}
											else
												$json = array("codigo" => "", "estatus" => 6, "msg" => $jsonFechadura["res"]["msg"]);
									}
									else
										$json = array("codigo" => "", "estatus" => 5, "msg" => $jsonFechadura["res"]["pendencias"][0]);
									break;
								case "1":
									$json = array("codigo" => "", "estatus" => 4, "msg" => "API_ER_INVALID_KEY");
									break;							
								case "2":
									$json = array("codigo" => "", "estatus" => 4, "msg" => "API_ER_INVALID_ACT");	
									break;							
								case "3":
									$json = array("codigo" => "", "estatus" => 4, "msg" => "API_ER_INVALID_NEA");
									break;							
								case "4":
									$json = array("codigo" => "", "estatus" => 4, "msg" => "API_ER_NOT_AVAILABLE");
									break;														
							}			
							curl_close($ch);
							break;														
					}
				}
			}
			else
			{
				$json = array("codigo" => 0, "estatus" => 3, "msg" => "NO EXISTE LA CERRADURA");
			}
			//$conn->close();
		}
	}
	else
	{
		$json = array("codigo" => 0, "estatus" => 2, "msg" => "NO EXISTE EL OPERADOR");
	}
	//$conn->close();
}
else
{
	$json = array("id" => 0, "estatus" => 1, "msg" => "REQUEST_METHOD NO ACEPTADO");
}

header('Content-type: application/json');
echo json_encode($json);

?>