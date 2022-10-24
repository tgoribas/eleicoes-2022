<?php

require 'app/configApp.php';


$candidatura_candidato = 'f';
$abrang_candidato = 'br';

// Faz o select com os dados de apuração e dos candidatos
$selectApuracao = $conn->query("SELECT candidato.name_candidato, candidato.color_candidato, candidato.tse_sqcand, apuracao.date_apuracao,apuracao.time_apuracao, apuracao.votos_apu_apuracao, apuracao.por_apu_apuracao, apuracao.por_sec_apu_apuracao, apuracao.fk_candidato, apuracao.eleit_apu_apuracao  FROM `candidato` INNER JOIN apuracao ON (apuracao.fk_candidato = candidato.id_candidato AND apuracao.abrang_apuracao=candidato.abrang_candidato) WHERE 
candidatura_candidato='{$candidatura_candidato}' AND abrang_candidato = '{$abrang_candidato}' ORDER BY apuracao.date_apuracao DESC, apuracao.time_apuracao DESC LIMIT 0,2");
if (isset($selectApuracao->num_rows) && $selectApuracao->num_rows > 0) {
    while ($apu = $selectApuracao->fetch_assoc()) {
        $apuracao[$apu['fk_candidato']]['name_candidato'] = $apu['name_candidato'];
        $apuracao[$apu['fk_candidato']]['color_candidato'] = $apu['color_candidato'];
        $apuracao[$apu['fk_candidato']]['tse_sqcand'] = $apu['tse_sqcand'];
        $apuracao[$apu['fk_candidato']]['votos_apu_apuracao'] = $apu['votos_apu_apuracao'];
        $apuracao[$apu['fk_candidato']]['por_apu_apuracao'] = $apu['por_apu_apuracao'];

        $eleicao['date_apuracao'] = date_brasil($apu['date_apuracao']);
        $eleicao['time_apuracao'] = $apu['time_apuracao'];
        $eleicao['por_sec_apu_apuracao'] = $apu['por_sec_apu_apuracao'];
        $eleicao['eleit_apu_apuracao'] = $apu['eleit_apu_apuracao'];
    }
} else {
    // Caso não existe dados de apuração, pega os dados dos canditados e monta o array em branco
    if ($candidato = select('*', 'candidato', " candidatura_candidato='{$candidatura_candidato}' AND abrang_candidato = '{$abrang_candidato}'")) { 
        // Monta um array primario
        foreach ($candidato as $cand) {
            $apuracao[$cand['id_candidato']]['name_candidato'] = $cand['name_candidato'];
            $apuracao[$cand['id_candidato']]['color_candidato'] = $cand['color_candidato'];
            $apuracao[$cand['id_candidato']]['tse_sqcand'] = $cand['tse_sqcand'];
            $apuracao[$cand['id_candidato']]['votos_apu_apuracao'] = 0.00;
            $apuracao[$cand['id_candidato']]['por_apu_apuracao'] = 0.00;

            $eleicao['date_apuracao'] = '00/00/0000';
            $eleicao['time_apuracao'] = '00:00:00';
            $eleicao['por_sec_apu_apuracao'] = '0.00';
            $eleicao['eleit_apu_apuracao'] = '0';
        }
    } else {
        echo 'Error'; exit();
    }
}
$cand1 = array_keys($apuracao)[0];
$cand2 = array_keys($apuracao)[1];

require FOLDER . '/template/header.php';
?>
    <main>
        <div class="container-fluid px-0">
            <h3 class="text-center py-3 mb-4" style="background: #FFF; color:#198754;line-height: 27px;">
                <span class="fw-200">Apuração</span><br><span class="fw-700">Eleições 2022 - 2º Turno</span>
            </h3>
        </div>

        <div class="container">
            <div class="col-10 m-auto mt-5">
                <div class="col-12 bg-white rounded-3 py-3 px-2 shadow-sm">
                    <div class="row">
                        <div class="col-1">
                            <div class="circular--portrait shadow-sm"> <img src="<?php echo $urlImage . $apuracao[$cand1]['tse_sqcand']?>.jpeg" class="w-100" alt=""> </div>
                        </div>
                        <div class="col-10">
                            <div class="bar mt-0" style="background: #<?php echo $apuracao[$cand2]['color_candidato'] ?>;">
                                <div class="progress one" style="width: 48%; background:#<?php echo $apuracao[$cand1]['color_candidato'] ?>;"></div>
                                <div class="percent text-white"><?php echo $apuracao[$cand1]['por_apu_apuracao']?>%</div>
                                <div class="text text-white"><?php echo $apuracao[$cand2]['por_apu_apuracao']?>%</div>
                            </div>
                            <div class="bar mt-1" style="height:10px;background: #d8d8d8;">
                                <div class="progress" style="width: <?php echo $eleicao['por_sec_apu_apuracao'] . '%'?>; height:10px; background-image: linear-gradient(to right, #f4d60d, #f6c600, #f8b700, #f7a700, #f69704);"></div>
                            </div>
                            <p class="mb-0 mt-2">
                                <span class="rounded-3 px-2 py-1 fw-400 fs-12px badge-info me-1" style="float: left;">
                                    Votos Apurados: <?php echo number_dot($eleicao['eleit_apu_apuracao']) ?>
                                </span>
                                <span class="rounded-3 px-2 py-1 fw-400 fs-12px badge-info"  style="float: left;">
                                <?php echo number_brasil($eleicao['por_sec_apu_apuracao']) . '%'?>
                                </span>
                                <span class="rounded-3 px-2 py-1 fw-400 fs-12px badge-info" style="float: right;">
                                    Atualizado: <?php echo $eleicao['date_apuracao'] . ' ' . $eleicao['time_apuracao']?>
                                </span>
                            </p>
                        </div>
                        <div class="col-1">
                            <div class="circular--portrait shadow-sm"> <img src="<?php echo $urlImage . $apuracao[$cand2]['tse_sqcand']?>.jpeg" class="w-100" alt=""> </div>
                        </div>
                    </div>




                </div>

                <div class="col-12">
                    <div class="col-md-12 pt-3 mb-3 ">
                        <div class="card card-covid shadow-sm">
                            <div class="card-header p-3 bg-none">
                                <p class="mb-0 text-center text-success"><b>Timeline da Apuração Presidencial</b></p>
                            </div>
                            <div class="card-body p-3">
                                <canvas id="grap_hospital" style="max-height: 300px;"></canvas>
                                <div id="chart_legend_0" class="noselect"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="bar">
                    <div class="progress two"></div>
                    <div class="percent">55%</div>
                    <div class="text">long answer that takes up multiple lines</div>
                </div>
                <div class="bar">
                    <div class="progress three"></div>
                    <div class="percent">20%</div>
                    <div class="text">another one just for fun</div>
                </div> -->
            </div>
        </div>
    </main>
    <?php require FOLDER . '/template/footer.php'; ?>
    <script>
var Tooltips_0 = function(tooltip) { var tooltipEl = document.getElementById('tooltip_0'); if (!tooltipEl) { tooltipEl = document.createElement('div'); tooltipEl.id = 'tooltip_0'; tooltipEl.innerHTML = '<table></table>'; this._chart.canvas.parentNode.appendChild(tooltipEl); } if (tooltip.opacity === 0) { tooltipEl.style.opacity = 0; return; } tooltipEl.classList.remove('above', 'below', 'no-transform'); if (tooltip.yAlign) { tooltipEl.classList.add(tooltip.yAlign); } else { tooltipEl.classList.add('no-transform'); } function getBody(bodyItem) { return bodyItem.lines; } if (tooltip.body) { var titleLines = tooltip.title || []; var bodyLines = tooltip.body.map(getBody); var innerHtml = '<thead>'; titleLines.forEach(function(title) { innerHtml += '<tr><th>' + title + '</th></tr>'; }); innerHtml += '</thead><tbody>'; bodyLines.forEach(function(body, i) { var myJSON = JSON.stringify(body); var myJSON = myJSON.replace('["', ""); var myJSON = myJSON.replace('"]', ""); leg = myJSON.split(":"); res = leg[1].toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."); var colors = tooltip.labelColors[i]; var style = 'background:' + colors.backgroundColor; style += '; border-color:' + colors.borderColor; style += '; border-width: 2px'; var span = '<span class="chartjs-tooltip-key" style="' + style + '"></span>'; innerHtml += '<tr><td class="text-gray-dark" >' + span + '<span style="font-weight:bold;">' +leg[0] +':</span> '+ res +'</td></tr>'; }); innerHtml += '</tbody>'; var tableRoot = tooltipEl.querySelector('table'); tableRoot.innerHTML = innerHtml; } var positionY = this._chart.canvas.offsetTop; var positionX = this._chart.canvas.offsetLeft; tooltipEl.style.opacity = 1; tooltipEl.style.left = positionX + tooltip.caretX + 'px'; tooltipEl.style.top = positionY + tooltip.caretY + 'px'; tooltipEl.style.fontFamily = tooltip._bodyFontFamily; tooltipEl.style.fontSize = '13px'; tooltipEl.style.fontStyle = tooltip._bodyFontStyle; tooltipEl.style.padding = tooltip.yPadding + 'px ' + tooltip.xPadding + 'px'; };

    Chart.plugins.register({
    afterDatasetsDraw: function(chart) {
        if (chart.tooltip._active && chart.tooltip._active.length) {
            var activePoint = chart.tooltip._active[0],
                ctx = chart.ctx,
                y_axis = chart.scales['y-axis-0'],
                x = activePoint.tooltipPosition().x,
                topY = y_axis.top,
                bottomY = y_axis.bottom;
            // draw line
            ctx.save();
            ctx.beginPath();
            ctx.moveTo(x, topY);
            ctx.lineTo(x, bottomY);
            ctx.lineWidth = 1;
            ctx.strokeStyle = '#b5b5b5';
            ctx.stroke();
            ctx.restore();
        }
    }
    });



    var ctx = document.getElementById('grap_hospital').getContext('2d');
    var chart = new Chart(ctx, { type: 'line',
        data: {
            labels: ['01/12/2021','02/12/2021','03/12/2021','04/12/2021','05/12/2021'],
            datasets: [
                {   
                    label: 'J. Bolsonaro', 
                    type: 'line', 
                    backgroundColor: 'rgba(204, 17, 18,0.2)', 
                    borderColor: '#cc1112',
                    pointBackgroundColor:'#cc1112', 
                    borderWidth:'3',
                    pointBorderWidth:'0',
                    pointRadius:'0',
                    pointHoverBorderWidth:'0',
                    fill: false,
                    lineTension: 0,      
                    data: [45.3, 46.2, 42.1, 49.2, 47.8]
                },
                {
                    label: 'Lula',
                    type: 'line',
                    backgroundColor: 'rgba(50, 111, 233,0.2)',
                    borderColor: '#326ee9',
                    pointBackgroundColor:'#326ee9',
                    borderWidth:'3',
                    pointBorderWidth:'0',
                    pointRadius:'0',
                    pointHoverBorderWidth:'0',
                    fill: false,
                    lineTension: 0,      
                    data: [50.3, 51.2, 53.1, 52.2, 52.8]
                }
            ]
        },
        options: { 
            legend: false, 
            legendCallback: function(chart) { 
                var text = []; 
                text.push('<ul class="-legend">'); 
                text.push('<li class="fw-700" style="color:#cc1112"><span style="background-color:#cc1112"></span> J. Bolsonaro</li>'); 
                text.push('<li class="fw-700" style="color:#326ee9"><span style="background-color:#326ee9"></span> Lula</li>'); 
                text.push('</ul>'); 
                return text.join(""); }, 
            responsive: true,
            maintainAspectRatio: false,
            tooltips: {
                mode: 'index',
                intersect: false,
                enabled: false,
                custom: Tooltips_0 },
            hover: {
                mode: 'nearest',
                intersect: true},
            scales: { 
                xAxes: [
                    {
                        display: true, 
                        gridLines: { display: true, color:'#FFF'},
                        scaleLabel: {display: false}, 
                        ticks:{ fontColor:'#678098', maxTicksLimit: 20} 
                    }
                ], 
                yAxes: [
                    {
                        display: true, 
                        gridLines: {display: false,color:'#e5e5e5'},
                        scaleLabel: {display: false},
                        ticks:{fontColor:'#678098',maxTicksLimit:'5'}
                    }
                ]
            }
        }
    });
    document.getElementById("chart_legend_0").innerHTML = chart.generateLegend();
    </script>
    </body>
</html>