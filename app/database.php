<?php
//BD Novo
$servername = $dbConfig ['db_host'];
$username =  $dbConfig ['db_user'];
$password = $dbConfig ['db_pass'];
$dbname = $dbConfig ['db_name'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



function select($column, $table, $where = null, $orderBy = null, $limit = null) {

    global $conn;

    $where = ($where == null) ? '' : ' WHERE ' . $where;
    $orderBy = ($orderBy == null) ? '' : ' ORDER BY ' . $orderBy;
    $limit = ($limit == null) ? '' : ' LIMIT ' . $limit;

    $result = $conn->query("SELECT {$column} FROM {$table} {$where} {$orderBy} {$limit}");
    if (isset($result->num_rows) && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}

function select_fetch($column, $table, $where = null, $orderBy = null, $limit = null) {

    global $conn;

    $where = ($where == null) ? '' : ' WHERE ' . $where;
    $orderBy = ($orderBy == null) ? '' : ' ORDER BY ' . $orderBy;
    $limit = ($limit == null) ? '' : ' LIMIT ' . $limit;

    $result = $conn->query("SELECT {$column} FROM {$table} {$where} {$orderBy} {$limit}");
    if (isset($result->num_rows) && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $return[] = $row;
        }
        return $return;
    } else {
        return false;
    }
}

function update($tabela, $campos, $valores, $where = null) {

    global $conn;

    $camposUpdate = $valoresUpdate = '';
    foreach ($campos as $campo) {
        // Se o campo exisste ele atualiza a Proposta
        if (isset($valores[$campo]) && $valores[$campo] !== null) {
            $valoresUpdate = "'" . $valores[$campo] . "', ";
            $camposUpdate .= " " . $campo . "=" . $valoresUpdate;
        }
    }
    $update = "UPDATE `{$tabela}` SET " . substr($camposUpdate, 0, -2) . " {$where}";
    if (!$conn->query($update)) {
        return false;
    }
    return true;
}