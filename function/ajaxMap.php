<?php 

require '../app/configApp.php';

$error = false;
if ($_REQUEST['estado']) {

    $estado = $_REQUEST['estado'];
    $candidatura_candidato = 'e';
    $abrang_candidato = $estado;

    // Faz o select com os dados de apuração e dos candidatos
    $selectApuracao = $conn->query("SELECT candidato.name_candidato, candidato.color_candidato, candidato.tse_sqcand, apuracao.date_apuracao,apuracao.time_apuracao, apuracao.votos_apu_apuracao, apuracao.por_apu_apuracao, apuracao.por_sec_apu_apuracao, apuracao.fk_candidato, apuracao.eleit_apu_apuracao  FROM `candidato` INNER JOIN apuracao ON (apuracao.fk_candidato = candidato.id_candidato) WHERE 
    candidatura_candidato='f' AND abrang_candidato = 'br' AND apuracao.abrang_apuracao='{$abrang_candidato}' ORDER BY apuracao.date_apuracao DESC, apuracao.time_apuracao DESC LIMIT 0,2");
    if (isset($selectApuracao->num_rows) && $selectApuracao->num_rows > 0) {

        while ($apu = $selectApuracao->fetch_assoc()) {
            $apuracao_f[$apu['fk_candidato']]['id_candidato'] = $apu['fk_candidato'];
            $apuracao_f[$apu['fk_candidato']]['name_candidato'] = $apu['name_candidato'];
            $apuracao_f[$apu['fk_candidato']]['color_candidato'] = $apu['color_candidato'];
            $apuracao_f[$apu['fk_candidato']]['tse_sqcand'] = $apu['tse_sqcand'];
            $apuracao_f[$apu['fk_candidato']]['votos_apu_apuracao'] = $apu['votos_apu_apuracao'];
            $apuracao_f[$apu['fk_candidato']]['por_apu_apuracao'] = $apu['por_apu_apuracao'];

            $eleicao_f['date_apuracao'] = date_brasil($apu['date_apuracao']);
            $eleicao_f['time_apuracao'] = $apu['time_apuracao'];
            $eleicao_f['por_sec_apu_apuracao'] = $apu['por_sec_apu_apuracao'];
            $eleicao_f['eleit_apu_apuracao'] = $apu['eleit_apu_apuracao'];
        }
    } else {
        // Caso não existe dados de apuração, pega os dados dos canditados e monta o array em branco
        if ($candidato = select_fetch('*', 'candidato', " candidatura_candidato='{$candidatura_candidato}' AND abrang_candidato = '{$abrang_candidato}'")) { 
            // Monta um array primario
            foreach ($candidato as $cand) {
                $apuraca_f[$cand['id_candidato']]['id_candidato'] = $cand['id_candidato'];
                $apuraca_f[$cand['id_candidato']]['name_candidato'] = $cand['name_candidato'];
                $apuraca_f[$cand['id_candidato']]['color_candidato'] = $cand['color_candidato'];
                $apuraca_f[$cand['id_candidato']]['tse_sqcand'] = $cand['tse_sqcand'];
                $apuraca_f[$cand['id_candidato']]['votos_apu_apuracao'] = 0.00;
                $apuraca_f[$cand['id_candidato']]['por_apu_apuracao'] = 0.00;

                $eleicao_f['date_apuracao'] = '00/00/0000';
                $eleicao_f['time_apuracao'] = '00:00:00';
                $eleicao_f['por_sec_apu_apuracao'] = '0.00';
                $eleicao_f['eleit_apu_apuracao'] = '0';
            }
        }
    }

    // Dados de Governador
    // Faz o select com os dados de apuração e dos candidatos
    $selectApuracao = $conn->query("SELECT candidato.name_candidato, candidato.color_candidato, candidato.tse_sqcand, apuracao.date_apuracao,apuracao.time_apuracao, apuracao.votos_apu_apuracao, apuracao.por_apu_apuracao, apuracao.por_sec_apu_apuracao, apuracao.fk_candidato, apuracao.eleit_apu_apuracao  FROM `candidato` INNER JOIN apuracao ON (apuracao.fk_candidato = candidato.id_candidato AND apuracao.abrang_apuracao=candidato.abrang_candidato) WHERE 
    candidatura_candidato='e' AND abrang_candidato = '{$estado}' ORDER BY apuracao.date_apuracao DESC, apuracao.time_apuracao DESC LIMIT 0,2");
    if (isset($selectApuracao->num_rows) && $selectApuracao->num_rows > 0) {

        while ($apu = $selectApuracao->fetch_assoc()) {
            $apuracao_e[$apu['fk_candidato']]['id_candidato'] = $apu['fk_candidato'];
            $apuracao_e[$apu['fk_candidato']]['name_candidato'] = $apu['name_candidato'];
            $apuracao_e[$apu['fk_candidato']]['color_candidato'] = $apu['color_candidato'];
            $apuracao_e[$apu['fk_candidato']]['tse_sqcand'] = $apu['tse_sqcand'];
            $apuracao_e[$apu['fk_candidato']]['votos_apu_apuracao'] = $apu['votos_apu_apuracao'];
            $apuracao_e[$apu['fk_candidato']]['por_apu_apuracao'] = $apu['por_apu_apuracao'];

            $eleicao_e['date_apuracao'] = date_brasil($apu['date_apuracao']);
            $eleicao_e['time_apuracao'] = $apu['time_apuracao'];
            $eleicao_e['por_sec_apu_apuracao'] = $apu['por_sec_apu_apuracao'];
            $eleicao_e['eleit_apu_apuracao'] = $apu['eleit_apu_apuracao'];
        }
    } else {
        // Caso não existe dados de apuração, pega os dados dos canditados e monta o array em branco
        if ($candidato = select_fetch('*', 'candidato', " candidatura_candidato='{$candidatura_candidato}' AND abrang_candidato = '{$abrang_candidato}'")) { 
            // Monta um array primario
            foreach ($candidato as $cand) {
                $apuracao_e[$cand['id_candidato']]['id_candidato'] = $cand['id_candidato'];
                $apuracao_e[$cand['id_candidato']]['name_candidato'] = $cand['name_candidato'];
                $apuracao_e[$cand['id_candidato']]['color_candidato'] = $cand['color_candidato'];
                $apuracao_e[$cand['id_candidato']]['tse_sqcand'] = $cand['tse_sqcand'];
                $apuracao_e[$cand['id_candidato']]['votos_apu_apuracao'] = 0.00;
                $apuracao_e[$cand['id_candidato']]['por_apu_apuracao'] = 0.00;

                $eleicao_e['date_apuracao'] = '00/00/0000';
                $eleicao_e['time_apuracao'] = '00:00:00';
                $eleicao_e['por_sec_apu_apuracao'] = '0.00';
                $eleicao_e['eleit_apu_apuracao'] = '0';
            }

        }
    }

    $contentHTML = '';
    if (isset($apuracao_f)) {
        $cand1_f = array_keys($apuracao_f)[0];
        $cand2_f = array_keys($apuracao_f)[1];

        $contentHTML = '
        <div class="col-12">
            <h3 class="mt-2 mb-5 text-success fw-700 bg-success bg-opacity-10 rounded-3 px-2 py-3"><span class="fw-400">Estado</span><br><span>' . $estadosBR[strtoupper($estado)] . '</span></h3>
            <span class="rounded-3 px-2 py-1 fw-400 fs-12px badge-info" style="float: right;"> Atualizado: ' . $eleicao_f['date_apuracao'] . ' ' . $eleicao_f['time_apuracao'] . '</span>
            <h4 class="mt-2 text-success fw-400">Presidente</h4>
            <div class="mt-2">
                <span class="fw-400 " style="color:#' . $apuracao_f[$cand2_f]['color_candidato'] . ';">' . $apuracao_f[$cand2_f]['name_candidato'] . '</span>
                <span class="fw-400 " style="float: right;color:#' . $apuracao_f[$cand1_f]['color_candidato'] . ' ;">   ' . $apuracao_f[$cand1_f]['name_candidato'] . '</span>
                <div class="bar mt-0" style="background: #' . $apuracao_f[$cand1_f]['color_candidato'] . ';">
                    <div class="progress one" style="width: ' . $apuracao_f[$cand2_f]['por_apu_apuracao'] . '%; background:#' . $apuracao_f[$cand2_f]['color_candidato'] . ';"></div>
                    <div class="percent text-white" style="font-size: 12px;">' . $apuracao_f[$cand1_f]['por_apu_apuracao'] . '%</div>
                    <div class="text text-white" style="font-size: 12px;">' . $apuracao_f[$cand2_f]['por_apu_apuracao'] . '%</div>
                </div>
                <div class="bar mt-1" style="height:6px;background: #d8d8d8;">
                    <div class="progress" style="width: ' . $eleicao_f['por_sec_apu_apuracao'] .'%; height:6px; background-image: linear-gradient(to right, #f4d60d, #f6c600, #f8b700, #f7a700, #f69704);"></div>
                </div>
                <p class="mb-0 mt-2">
                    <span class="rounded-3 px-2 py-1 fw-400 fs-10px badge-info me-1" style="float: left;">Seções Apuradas: ' . number_brasil($eleicao_f['por_sec_apu_apuracao']) .'%</span>
                    <span class="rounded-3 px-2 py-1 fw-400 fs-10px badge-info " style="float: left;">Votos Apurados: ' . number_brasil($eleicao_f['eleit_apu_apuracao'], 0) . '</span>
                </p> 
            </div>
            <div style="clear: both;height:45px;"></div>
        </div>';
    }


    if (isset($apuracao_e)) {

        $cand1_e = array_keys($apuracao_e)[0];
        $cand2_e = array_keys($apuracao_e)[1];

        $contentHTML .= '
    <div class="col-12">
        <span class="rounded-3 px-2 py-1 fw-400 fs-12px badge-info" style="float: right;"> Atualizado: ' . $eleicao_e['date_apuracao'] . ' ' . $eleicao_e['time_apuracao'] . ' </span>
        <h4 class="mt-0 mb-0 text-success fw-400" style="display: inline-block;">Governador</h4>
        <div class="mt-2">
            <span class="fw-400 " style="color:#' . $apuracao_e[$cand2_e]['color_candidato'] . ';">' . $apuracao_e[$cand2_e]['name_candidato'] . '</span>
            <span class="fw-400 " style="float: right;color:#' . $apuracao_e[$cand1_e]['color_candidato'] . ';">' . $apuracao_e[$cand1_e]['name_candidato'] . '</span>
            <div class="bar mt-0" style="background: #' . $apuracao_e[$cand1_e]['color_candidato'] . ';">
                <div class="progress one" style="width: ' . $apuracao_e[$cand2_e]['por_apu_apuracao'] . '%; background:#' . $apuracao_e[$cand2_e]['color_candidato'] . ';"></div>
                <div class="percent text-white" style="font-size: 12px;">' . $apuracao_e[$cand1_e]['por_apu_apuracao'] . '%</div>
                <div class="text text-white" style="font-size: 12px;">' . $apuracao_e[$cand2_e]['por_apu_apuracao'] . '%</div>
            </div>
            <div class="bar mt-1" style="height:6px;background: #d8d8d8;">
                <div class="progress" style="width: ' . $eleicao_e['por_sec_apu_apuracao'] . '%; height:6px; background-image: linear-gradient(to right, #f4d60d, #f6c600, #f8b700, #f7a700, #f69704);"></div>
            </div>
            <p class="mb-0 mt-2">
                <span class="rounded-3 px-2 py-1 fw-400 fs-10px badge-info me-1" style="float: left;">Seções Apuradas: ' . number_brasil($eleicao_e['por_sec_apu_apuracao']) .'% </span>
                <span class="rounded-3 px-2 py-1 fw-400 fs-10px badge-info " style="float: left;">Votos Apurados: ' . number_brasil($eleicao_e['eleit_apu_apuracao'], 0) . '</span>
            </p>
        </div>
    </div>';
    }

    $response = array (
        'status' => '200',
        'html' => $contentHTML
    );
} else {
    $error = true;

}

if ($error) {
    $response = array(
        'status' => '500',
    );
}


echo json_encode($response);
