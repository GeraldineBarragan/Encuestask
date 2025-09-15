<?php

include_once('config.php');

if($_SERVER['REQUEST_METHOD'] == "GET")
{
	$operador = isset($_GET['operador']) ? $conn->real_escape_string($_GET['operador']) : "";
	$clave = isset($_GET['clave']) ? $conn->real_escape_string($_GET['clave']) : "";

	$sql = "SELECT id, registro, nome, ativo, clave FROM operadores WHERE registro = '" . $operador . "'";
	$result = $conn -> query($sql);

	if ($result -> num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			if ($row["ativo"] == 1) {
				if ($clave!="")
				{		
					if (md5($clave)==$row["clave"])
					{		
						$json = array("id" => $row["id"], "estatus" => 0, "msg" => "OK");
					}
					else 
					{		
						$json = array("id" => 0, "estatus" => 4, "msg" => "CLAVES INCORRECTAS");
					}
				}
				else 
				{		
					$json = array("id" => 0, "estatus" => 3, "msg" => "CLAVES INVÁLIDAS");
				}
		     }
			
			 else {
                $json = array("id" => 0, "estatus" => 5, "msg" => "Operador Ináctivo");
            }
		}
	}
	else
	{
		$json = array("id" => 0, "estatus" => 2, "msg" => "NO EXISTE EL OPERADOR");
	}
	$conn->close();
}
else
{
	$json = array("id" => 0, "estatus" => 1, "msg" => "REQUEST_METHOD NO ACEPTADO");
}

header('Content-type: application/json');
echo json_encode($json);

?>
