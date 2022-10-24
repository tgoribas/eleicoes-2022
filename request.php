<?php

require 'app/configApp.php';
date_default_timezone_set('America/Sao_Paulo');

$refresh['seconds'] = '30';
$refresh['url'] = 'request.php';

$tipo[9722] = 'Federal';
$tipo[9724] = 'Presidente';

// $jsonTSE [] = "https://resultados-sim.tse.jus.br/teste/ele2022/9722/dados-simplificados/br/br-c0001-e009722-r.json"; // FED - BR
// $jsonTSE [] = "https://resultados-sim.tse.jus.br/teste/ele2022/9722/dados-simplificados/sp/sp-c0001-e009722-r.json"; // FED - BR
// $jsonTSE [] = "https://resultados-sim.tse.jus.br/teste/ele2022/9724/dados-silificados/sp/sp-c0003-e009724-r.json"; // EST - SPmp
// $jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/br/br-c0001-e000545-r.json"; // EST - SP

$jsonTSE [] = "docs/json/json-f-br.json";
$jsonTSE [] = "docs/json/json-f-sp.json";
$jsonTSE [] = "docs/json/json-e-sp.json";
?>

<html>
    <head>
        <title>Request TSE</title>
        <meta http-equiv="refresh" content="<?php echo $refresh['seconds']?>;URL='<?php echo $refresh['url']?>'">
    </head>
    <body style="background: #222; color:#FFF; ">
<?php

echo '<pre style="color:#29b9ff;">Atualizado: ' . date('H:i:s') . '</pre>';
foreach ($jsonTSE as $tse) {

    $apu = json_decode(file_get_contents($tse));

    echo '<br><pre>. Resquest ' . $tipo[$apu->ele] . ' - (' . $apu->cdabr . ') .........................................................................</pre>';
    echo '<pre>. File: ';print_r($tse);echo '</pre>';
    // echo '<pre>';
    // print_r($apu);
    // echo '</pre>';
    // Tipo de Elição (Federal ou Estadual)
    // Federal ==> Oficial = 545 || Teste = 9722
    // Estadual => Oficial = 547 || Teste = 9724
    $apuracao['tipo_apuracao'] = null;
    $apuracao['tipo_apuracao'] = ($apu->ele == 9722) ? 'f' : $apuracao['tipo_apuracao'];
    $apuracao['tipo_apuracao'] = ($apu->ele == 9724) ? 'e' : $apuracao['tipo_apuracao'];

    $apuracao['abrang_apuracao'] = $apu->cdabr;
    $apuracao['date_apuracao'] = date_dataBase($apu->dg);
    $apuracao['time_apuracao'] = $apu->hg;
    // Eleitores
    $apuracao['eleit_total_apuracao'] = $apu->e; // Quantidade total de eleitores da abrangencia
    $apuracao['eleit_apu_apuracao'] = $apu->ea; // Quantidade de eleitores apurados
    $apuracao['eleit_napu_apuracao'] = $apu->ena; // Quantidade de eleitores não apurados
    // Porcentagem
    $apuracao['por_eleit_apu_apuracao'] = number_database($apu->pea); // Porcentagem de Eleitores apurados
    $apuracao['por_eleit_napu_apuracao'] = number_database($apu->pena); // Porcentagem de Eleitores não apurados
    // Secao
    $apuracao['por_sec_apu_apuracao'] = number_database($apu->pst); // Porcentagem de Seções eleitorais apuradas

    // Verifica se já começou a apuracao
    if ($apuracao['por_sec_apu_apuracao'] > 0) {
        // Faz um foreach pelos candidatos
        foreach ($apu->cand as $cand) {

            $insert = false;

            // Pega os dados do candidato
            if ($candidato = select('candidato', " tse_sqcand='{$cand->sqcand}' AND candidatura_candidato='{$apuracao['tipo_apuracao']}'")) {
                $apuracao['fk_candidato'] = $candidato['id_candidato']; // Quantidade de votos apurados para o candidato
                $apuracao['votos_apu_apuracao'] = $cand->vap; // Porcentagem de votos apurados para o candidato
                $apuracao['por_apu_apuracao'] = number_database($cand->pvap); // Porcentagem de votos apurados para o candidato

                // Pega o dado de apuração mais recente
                if ($select_apuracao = select('apuracao', " tipo_apuracao='{$apuracao['tipo_apuracao']}' AND  abrang_apuracao='{$apuracao['abrang_apuracao']}' AND fk_candidato={$apuracao['fk_candidato']}", "date_apuracao DESC, time_apuracao DESC", ' 0,1')) {
                    if (!($apuracao['date_apuracao'] == $select_apuracao['date_apuracao'] && $apuracao['time_apuracao'] == $select_apuracao['time_apuracao'])) {
                        // Não é o dado mais recente
                        $insert = true;
                    } else {
                        echo '<pre>. Recente</pre>';
                        break;
                    }
                } else {
                    // Não existe dados, faz o insert.
                    $insert = true;
                }

                if ($insert) {
                    if ($conn->query("INSERT INTO apuracao (fk_candidato) VALUES ('" .  $apuracao['fk_candidato'] . "')")) {
                        $lastID = $conn->insert_id;
                        if (update('apuracao', array_keys($apuracao), $apuracao, " WHERE `id_apuracao` = '" . $lastID . "'")) {
                            msgSuccess($apuracao['tipo_apuracao'] . ' / ' . $apuracao['abrang_apuracao'], $cand->nm, date_brasil($apuracao['date_apuracao']) . ' ' . $apuracao['time_apuracao']);
                        } else {
                            msgError('2', $apuracao['tipo_apuracao'] . ' / ' . $apuracao['abrang_apuracao'], $cand->nm, date_brasil($apuracao['date_apuracao']) . ' ' . $apuracao['time_apuracao']);
                        }
                    } else {
                        msgError('1', $apuracao['tipo_apuracao'] . ' / ' . $apuracao['abrang_apuracao'], $cand->nm, date_brasil($apuracao['date_apuracao']) . ' ' . $apuracao['time_apuracao']);
                    }
                }
            }
        }
    }
}
?>
    </body>
</html>

