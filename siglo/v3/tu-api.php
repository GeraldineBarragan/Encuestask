<?php

include_once('config.php');

function escapeJsonString($value) { 
    $escapers = array("\'");
    $replacements = array("\\/");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
}

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $logs = isset($_GET['logs']) ? $_GET['logs'] : array();

    // Puedes realizar validaciones adicionales según tus requisitos

    $jsonResponse = array();

    foreach ($logs as $log) {
        $jsonLog = array(
            'l' => $log['l'],
            'fechadura' => array(
                'id' => $log['fechadura_id'],
                'registro' => $log['fechadura_registro']
            ),
            'data' => $log['data'],
            'acao' => array(
                'action' => get_log_action($log['acao'], true),
                'detalhe' => strlen($log['detalhe']) > 0 ? $log['detalhe'] : null
            ),
            'operador' => array(
                'id' => $log['idOperador'],
                'nome' => $log['op_nome']
            ),
            'remoto' => $log['remoto'] ? 'sim' : 'nao',
            'usuario' => array(
                'id' => $log['idUsuario'],
                'nome' => $log['usr_nome']
            )
        );

        $jsonResponse[] = $jsonLog;
    }

    // Realiza la solicitud POST al servicio web
    $urlWebService = 'https://techtac.hsplatform.com/webservice/?hsapi=QXXV4FK4AIpruebaEnvia';
    $postData = array('logs' => $jsonResponse);

    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($postData)
        )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($urlWebService, false, $context);

    if ($result === FALSE) {
        // Manejar el error, si es necesario
        $json = array("estatus" => 500, "msg" => "Error en la solicitud al servicio web");
    } else {
        // Manejar la respuesta del servicio web, si es necesario
        $json = json_decode($result, true);
    }

    header('Content-type: application/json');
    echo json_encode($json);
} else {
    $json = array("id" => 0, "estatus" => 1, "msg" => "REQUEST_METHOD NO ACEPTADO");
    header('Content-type: application/json');
    echo json_encode($json);
}

?>
