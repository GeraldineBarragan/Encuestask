<?php

include_once('config.php');
session_start();			

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$operador = isset($_POST['operador']) ? $conn->real_escape_string($_POST['operador']) : "";
	$clave = isset($_POST['clave']) ? $conn->real_escape_string($_POST['clave']) : "";

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
						$_SESSION['nombre'] = $row["nome"];
						$_SESSION['resultado'] = 0;
						$_SESSION['id'] = $row["id"];
						$_SESSION['operador'] = $row["registro"];
    					$_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s");
						header('Location: ../../../api/onyxweb/formulario.php');
					}
					else 
					{		
						$_SESSION['resultado'] = "CLAVE INCORRECTA";
						header('Location: ../../../api/onyxweb/formulario.php');
					}
				}
				else 
				{		
					$_SESSION['resultado'] = "CLAVE INCORRECTA";
				 	header('Location: ../../../api/onyxweb/formulario.php');
				}
		     }
			
			 else {
                $_SESSION['resultado'] = "OPERADOR INACTIVO";
			    header('Location: ../../../api/onyxweb/formulario.php');
            }
		}
	}
	else
	{
		$_SESSION['resultado'] = "NO EXISTE EL OPERADOR";
		header('Location: ../../../api/onyxweb/formulario.php');
	}
	$conn->close();
}
else
{
	$_SESSION['resultado'] = "REQUEST_METHOD NO ACEPTADO";
	header('Location: ../../../api/onyxweb/formulario.php');
}

header('Content-type: application/json');
echo json_encode($json);

?>
