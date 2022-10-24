<?php

function date_dataBase($date)
{
    $date_convert = explode("/", $date);
    return $date_convert[2] . "-" . $date_convert[1] . "-" . $date_convert[0];
}

function date_brasil($date)
{
    $date_convert = explode("-", $date);
    return $date_convert[2] . "/" . $date_convert[1] . "/" . $date_convert[0];
}

function number_brasil($number, $decimals = -1)
{
    if ($decimals == -1) {
        $decimals = 2;
    }
    if ($number === 0) {
        $number = '0.00';
    }
    if ($number == null) {
        return null;
    }
    return number_format($number, $decimals, ",", ".");
}

function number_database($number)
{
    // Remove os pontos da casa do Milhar
    $number = str_replace(".", "", $number);
    // Troca a , pelo .
    $number = str_replace(",", ".", $number);

    if ($number == "") {
        $number = 0;
    }

    return $number;
}


function msgError($codError, $tipo, $candidato, $data)
{
    echo '<pre style="color:red;">Error #' . $codError . '...................................................................<br>Tipo: ' . $tipo . ' | Candidato ' . $candidato . ' | Json Data: ' . $data . '</pre>';
}

function msgSuccess($tipo, $candidato, $data)
{
    echo '<pre style="color:green;">Sucesso...................................................................<br>Tipo: ' . $tipo . ' | Candidato ' . $candidato . ' | Atualizado: ' . $data . '</pre>';
}