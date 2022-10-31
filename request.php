<?php

require 'app/configApp.php';
date_default_timezone_set('America/Sao_Paulo');

if (TOKEN != $_GET['token']) {
    exit;
}

$refresh['seconds'] = '45';
$refresh['url'] = 'request.php?token=D_aJJu$nLZmhre-mW';

$tipo[547] = 'Estadual';
$tipo[545] = 'Presidente';

$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/br/br-c0001-e000545-r.json"; // FED - BR
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/ac/ac-c0001-e000545-r.json"; // FED - AC (ACRE)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/al/al-c0001-e000545-r.json"; // FED - AL (Alogoas)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/547/dados-simplificados/al/al-c0003-e000547-r.json"; // EST - AL (Alagoas)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/ap/ap-c0001-e000545-r.json"; // FED - AP (Amapa)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/am/am-c0001-e000545-r.json"; // FED - AM (Amazonas)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/547/dados-simplificados/am/am-c0003-e000547-r.json"; // EST - AM (Amazonas)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/ba/ba-c0001-e000545-r.json"; // FED - BA (Bahia)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/547/dados-simplificados/ba/ba-c0003-e000547-r.json"; // EST - BA (Bahia)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/ce/ce-c0001-e000545-r.json"; // FED - CE (Ceara)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/df/df-c0001-e000545-r.json"; // FED - DF (Distro Federal)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/es/es-c0001-e000545-r.json"; // FED - ES (Espirito Santo)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/547/dados-simplificados/es/es-c0003-e000547-r.json"; // EST - ES (Espirito Santo)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/go/go-c0001-e000545-r.json"; // FED - GO (Goias)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/ma/ma-c0001-e000545-r.json"; // FED - MA (Maranhão)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/mt/mt-c0001-e000545-r.json"; // FED - MT (Moto Grosso)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/ms/ms-c0001-e000545-r.json"; // FED - MS (Moto Grosso do Sul)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/547/dados-simplificados/ms/ms-c0003-e000547-r.json"; // EST - MS (Moto Grosso do Sul)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/mg/mg-c0001-e000545-r.json"; // FED - MG (Minas Gerais)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/pr/pr-c0001-e000545-r.json"; // FED - PR (Parana)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/pb/pb-c0001-e000545-r.json"; // FED - PB (Paraiba)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/547/dados-simplificados/pb/pb-c0003-e000547-r.json"; // EST - PB (PARAIBA)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/pa/pa-c0001-e000545-r.json"; // FED - PA (Pará)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/pe/pe-c0001-e000545-r.json"; // FED - PE (Pernambuco)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/547/dados-simplificados/pe/pe-c0003-e000547-r.json"; // EST - PE (Pernambuco)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/pi/pi-c0001-e000545-r.json"; // FED - PI (Piauí)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/rj/rj-c0001-e000545-r.json"; // FED - RJ (Rio de Janeiro)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/rn/rn-c0001-e000545-r.json"; // FED - RN (Rio Grande do Norte)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/rs/rs-c0001-e000545-r.json"; // FED - RS (Rio Grande do Sul)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/547/dados-simplificados/rs/rs-c0003-e000547-r.json"; // EST - RS (Rio Grande do Sul)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/ro/ro-c0001-e000545-r.json"; // FED - RO (Rondônia)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/547/dados-simplificados/ro/ro-c0003-e000547-r.json"; // EST - RO (Rondônia)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/rr/rr-c0001-e000545-r.json"; // FED - RO (Roraima)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/sc/sc-c0001-e000545-r.json"; // FED - SC (Santa Catarina)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/547/dados-simplificados/sc/sc-c0003-e000547-r.json"; // EST - SC (Santa Catarina)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/se/se-c0001-e000545-r.json"; // FED - SE (Sergipe)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/547/dados-simplificados/se/se-c0003-e000547-r.json"; // EST - SE (Sergipe)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/sp/sp-c0001-e000545-r.json"; // FED - SP (São Paulo)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/547/dados-simplificados/sp/sp-c0003-e000547-r.json"; // EST - SP (São Paulo)
$jsonTSE [] = "https://resultados.tse.jus.br/oficial/ele2022/545/dados-simplificados/to/to-c0001-e000545-r.json"; // FED - TO (Tocantis)

/*
// Teste 
$jsonTSE [] = "docs/json/json-br.json";
$jsonTSE [] = "docs/json/json-sp-f.json";
$jsonTSE [] = "docs/json/json-sp-e.json";
$jsonTSE [] = "docs/json/json-rs-f.json";
$jsonTSE [] = "docs/json/json-rs-e.json";
$jsonTSE [] = "docs/json/json-rj-f.json";
*/
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

    echo '<pre>. Resquest ' . $tipo[$apu->ele] . ' - (' . $apu->cdabr . ') .........................................................................</pre>';
    print_r('<pre>. File: ' . $tse . '</pre>');

    // Tipo de Elição (Federal ou Estadual)
    // Federal ==> Oficial = 545 || Teste = 9722
    // Estadual => Oficial = 547 || Teste = 9724
    $apuracao['tipo_apuracao'] = null;
    $apuracao['tipo_apuracao'] = ($apu->ele == 545) ? 'f' : $apuracao['tipo_apuracao'];
    $apuracao['tipo_apuracao'] = ($apu->ele == 547) ? 'e' : $apuracao['tipo_apuracao'];

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
            if ($candidato = select('*', 'candidato', " tse_sqcand='{$cand->sqcand}' AND candidatura_candidato='{$apuracao['tipo_apuracao']}'")) {
                $apuracao['fk_candidato'] = $candidato['id_candidato']; // Quantidade de votos apurados para o candidato
                $apuracao['votos_apu_apuracao'] = $cand->vap; // Porcentagem de votos apurados para o candidato
                $apuracao['por_apu_apuracao'] = number_database($cand->pvap); // Porcentagem de votos apurados para o candidato

                // Pega o dado de apuração mais recente
                if ($select_apuracao = select('*', 'apuracao', " tipo_apuracao='{$apuracao['tipo_apuracao']}' AND  abrang_apuracao='{$apuracao['abrang_apuracao']}' AND fk_candidato={$apuracao['fk_candidato']}", "date_apuracao DESC, time_apuracao DESC", ' 0,1')) {
                    if (!($apuracao['date_apuracao'] == $select_apuracao['date_apuracao'] && $apuracao['time_apuracao'] == $select_apuracao['time_apuracao'])) {
                        // Não é o dado mais recente
                        $insert = true;
                    } else {
                        // echo '<pre>. Recente</pre>';
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

