<?php

require 'app/configApp.php';

$refresh['seconds'] = '120';
$refresh['url'] = URL;

$candidatura_candidato = 'f';
$abrang_candidato = 'br';

// Faz o select com os dados de apuração e dos candidatos
$selectApuracao = $conn->query("SELECT candidato.name_candidato, candidato.color_candidato, candidato.tse_sqcand, apuracao.date_apuracao,apuracao.time_apuracao, apuracao.votos_apu_apuracao, apuracao.por_apu_apuracao, apuracao.por_sec_apu_apuracao, apuracao.fk_candidato, apuracao.eleit_apu_apuracao  FROM `candidato` INNER JOIN apuracao ON (apuracao.fk_candidato = candidato.id_candidato AND apuracao.abrang_apuracao=candidato.abrang_candidato) WHERE 
candidatura_candidato='{$candidatura_candidato}' AND abrang_candidato = '{$abrang_candidato}' ORDER BY apuracao.date_apuracao DESC, apuracao.time_apuracao DESC LIMIT 0,2");
if (isset($selectApuracao->num_rows) && $selectApuracao->num_rows > 0) {
    while ($apu = $selectApuracao->fetch_assoc()) {

        $apuracao[$apu['fk_candidato']]['id_candidato'] = $apu['fk_candidato'];
        $apuracao[$apu['fk_candidato']]['name_candidato'] = $apu['name_candidato'];
        $apuracao[$apu['fk_candidato']]['color_candidato'] = $apu['color_candidato'];
        $apuracao[$apu['fk_candidato']]['tse_sqcand'] = $apu['tse_sqcand'];
        $apuracao[$apu['fk_candidato']]['votos_apu_apuracao'] = $apu['votos_apu_apuracao'];
        $apuracao[$apu['fk_candidato']]['por_apu_apuracao'] = $apu['por_apu_apuracao'];

        $eleicao['date_apuracao'] = date_brasil($apu['date_apuracao']);
        $eleicao['time_apuracao'] = $apu['time_apuracao'];
        $eleicao['por_sec_apu_apuracao'] = $apu['por_sec_apu_apuracao'];
        $eleicao['eleit_apu_apuracao'] = $apu['eleit_apu_apuracao'];

        $timeline[$apu['fk_candidato']]['porc_apuracao'] = '';
        $timeline[$apu['fk_candidato']]['datetime_apuracao'] = '';
    }
} else {
    // Caso não existe dados de apuração, pega os dados dos canditados e monta o array em branco
    if ($candidato = select_fetch('*', 'candidato', " candidatura_candidato='{$candidatura_candidato}' AND abrang_candidato = '{$abrang_candidato}'")) { 
        // Monta um array primario
        foreach ($candidato as $cand) {
            $apuracao[$cand['id_candidato']]['id_candidato'] = $cand['id_candidato'];
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

// Pegar os dados para os graficos

foreach ($apuracao as $apura) {
    $selectTimeline = $conn->query("SELECT fk_candidato, por_apu_apuracao, time_apuracao FROM `apuracao` 
    WHERE tipo_apuracao='{$candidatura_candidato}' AND abrang_apuracao = '{$abrang_candidato}' AND fk_candidato={$apura['id_candidato']}
    ORDER BY apuracao.date_apuracao ASC, apuracao.time_apuracao ASC");

    if (isset($selectTimeline->num_rows) && $selectTimeline->num_rows > 0) {
        while ($dadosTimeline = $selectTimeline->fetch_assoc()) {
            $timeline[$apura['id_candidato']]['id_candidato'] =  $dadosTimeline['fk_candidato'];
            $timeline[$apura['id_candidato']]['porc_apuracao'] .=  $dadosTimeline['por_apu_apuracao'] . ', ';
            $timeline[$apura['id_candidato']]['datetime_apuracao'] .= "'{$dadosTimeline['time_apuracao']}', ";
        }
    } else {
        $timeline[$apura['id_candidato']]['id_candidato'] =  $apura['id_candidato'];
        $timeline[$apura['id_candidato']]['porc_apuracao'] =   '0, ';
        $timeline[$apura['id_candidato']]['datetime_apuracao'] = '"0", ';
    }
}

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
                            <div class="circular--portrait shadow-sm d-none d-sm-block"> <img src="<?php echo $urlImage . $apuracao[$cand1]['tse_sqcand']?>.jpeg" class="w-100" alt=""> </div>
                        </div>
                        <div class="col-10">
                            <span class="fw-400 " style="color:#<?php echo $apuracao[$cand1]['color_candidato'] ?>;"><?php echo $apuracao[$cand1]['name_candidato'] ?> <span class="fs-12px">(<?php echo number_brasil($apuracao[$cand1]['votos_apu_apuracao'], 0) ?> Votos)</span></span>
                            <span class="fw-400 " style="float: right;color:#<?php echo $apuracao[$cand2]['color_candidato'] ?>;"><span class="fs-12px">(<?php echo number_brasil($apuracao[$cand2]['votos_apu_apuracao'], 0) ?> Votos)</span> <?php echo $apuracao[$cand2]['name_candidato'] ?></span>
                            <div class="bar mt-0" style="background: #<?php echo $apuracao[$cand2]['color_candidato'] ?>;">
                                <div class="progress one" style="width: <?php echo $apuracao[$cand1]['por_apu_apuracao']?>%; background:#<?php echo $apuracao[$cand1]['color_candidato'] ?>;"></div>
                                <div class="percent text-white"><?php echo number_brasil($apuracao[$cand2]['por_apu_apuracao'])?>%</div>
                                <div class="text text-white"><?php echo number_brasil($apuracao[$cand1]['por_apu_apuracao'])?>%</div>
                            </div>
                            <div class="bar mt-1" style="height:10px;background: #d8d8d8;">
                                <div class="progress" style="width: <?php echo $eleicao['por_sec_apu_apuracao'] . '%'?>; height:10px; background-image: linear-gradient(to right, #f4d60d, #f6c600, #f8b700, #f7a700, #f69704);"></div>
                            </div>
                            <p class="mb-0 mt-2">
                                <span class="rounded-3 px-2 py-1 fw-400 fs-12px badge-info me-1"  style="float: left;">
                                Seções Apuradas: <?php echo number_brasil($eleicao['por_sec_apu_apuracao']) . '%'?>
                                </span>
                                <span class="rounded-3 px-2 py-1 fw-400 fs-12px badge-info " style="float: left;">
                                    Votos Apurados: <?php echo number_brasil($eleicao['eleit_apu_apuracao'], 0) ?>
                                </span>
                                <span class="rounded-3 px-2 py-1 fw-400 fs-12px badge-info" style="float: right;">
                                    Atualizado: <?php echo $eleicao['date_apuracao'] . ' ' . $eleicao['time_apuracao']?>
                                </span>
                            </p>
                        </div>
                        <div class="col-1">
                            <div class="circular--portrait shadow-sm d-none d-sm-block"> <img src="<?php echo $urlImage . $apuracao[$cand2]['tse_sqcand']?>.jpeg" class="w-100" alt=""> </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="col-md-12 pt-3 mb-3 ">
                        <div class="card shadow-sm" style="border:0px solid;">
                            <p class="text-center text-success mb-2 bg-success bg-opacity-10 rounded-3 py-2 mx-3 my-3"><b>Timeline da Apuração Presidencial</b></p>
                            <!-- <div class="card-header p-3 bg-success bg-opacity-10" style="border: 0px solid;">
                                <p class="mb-0 text-center text-success"><b></b></p>
                            </div> -->
                            <div class="card-body p-3">
                                <canvas id="grap_hospital" style="max-height: 300px;"></canvas>
                                <div id="chart_legend_0" class="noselect"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="card shadow-sm" style="border:0px solid;">
                        <div class="row px-3">
                            <div class="col-12">
                                <p class="mb-0 mt-3 text-center text-success mb-2 bg-success bg-opacity-10 rounded-3 py-2"><b>Mapa da Disputa Presidencial</b></p>
                            </div>
                            <div class="col-md-7 pt-2 mb-3 ">                                
                                <div id="map_brasil" style="width: 100%;height: 500px;border-radius:12px;"></div>    
                            </div>
                            <div class="col-md-5" id="contentApuracao"> </div>
                        </div>
                    </div>
                </div>
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
            labels: [<?php echo substr($timeline[$cand1]['datetime_apuracao'], 0, -2)?>],
            datasets: [
                {   
                    label: '<?php echo $apuracao[$cand1]['name_candidato']?>', 
                    type: 'line', 
                    backgroundColor: 'rgba(204, 17, 18,0.2)', 
                    borderColor: '#<?php echo $apuracao[$cand1]['color_candidato']?>',
                    pointBackgroundColor:'#<?php echo $apuracao[$cand1]['color_candidato']?>', 
                    borderWidth:'3',
                    pointBorderWidth:'0',
                    pointRadius:'0',
                    pointHoverBorderWidth:'0',
                    fill: false,
                    lineTension: 0,
                    data: [<?php echo substr($timeline[$cand1]['porc_apuracao'], 0, -2)?>]
                },
                {
                    label: '<?php echo $apuracao[$cand2]['name_candidato']?>',
                    type: 'line',
                    backgroundColor: 'rgba(50, 111, 233,0.2)',
                    borderColor: '#<?php echo $apuracao[$cand2]['color_candidato']?>',
                    pointBackgroundColor:'#<?php echo $apuracao[$cand2]['color_candidato']?>',
                    borderWidth:'3',
                    pointBorderWidth:'0',
                    pointRadius:'0',
                    pointHoverBorderWidth:'0',
                    fill: false,
                    lineTension: 0,      
                    data: [<?php echo substr($timeline[$cand2]['porc_apuracao'], 0, -2)?>]
                }
            ]
        },
        options: { 
            legend: false, 
            legendCallback: function(chart) { 
                var text = []; 
                text.push('<ul class="-legend">'); 
                text.push('<li class="fw-700" style="color:#<?php echo $apuracao[$cand1]['color_candidato']?>"><span style="background-color:#<?php echo $apuracao[$cand1]['color_candidato']?>"></span> <?php echo $apuracao[$cand1]['name_candidato']?></li>'); 
                text.push('<li class="fw-700" style="color:#<?php echo $apuracao[$cand2]['color_candidato']?>"><span style="background-color:#<?php echo $apuracao[$cand2]['color_candidato']?>"></span> <?php echo $apuracao[$cand2]['name_candidato']?></li>'); 
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




//****************************************************
<?php require FOLDER . '/function/geoJson.php'; ?>

var mymap_ = L.map('map_brasil',{minZoom: 4, zoomControl: false}).setView([-15.199386048560008, -53.52539062500001], 3);

L.tileLayer('https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
}).addTo(mymap_);

// control that shows state info on hover
var info_m = L.control();

info_m.onAdd = function (map) {
    this._div = L.DomUtil.create('div', '');
    this.updat();
    return this._div;
};

info_m.updat = function (props) {  };
info_m.addTo(mymap_);

// get color depending on population density value
function getColorm(d) {
    return  d > 60 ? '#cb181d' :
            d > 55 ? '#ef3b2c' :
            d > 53 ? '#fb6a4a' :
            d > 51 ? '#fc9272' :
            d > 50 ? '#fcbba1' :
            d > 49 ? '#c6dbef' :
            d > 47 ? '#9ecae1' :
            d > 45 ? '#6baed6' :
            d > 40 ? '#4292c6' :
            d > 0 ?  '#2171b5' :
                     '#FFF';
}

function style_(feature) {
    return {
        weight: 1,
        opacity: 0.5,
        color: '#808080',
        dashArray: '',
        fillOpacity: 0.8,
        fillColor: getColorm(feature.properties.apuracao)
    };
}

var geojson_;


function onEachFeature_(feature, layer) {
    console.log(feature);
    console.log(layer);
    // layer.bindPopup('<p class="mt-1 mb-0" style="font-size: 13px;" ><b> ' + feature.properties.name + '</b></p><p class="mt-1 mb-1 text-gray" style="font-size: 13px;font-weight: 500 !important;" > <span style="color:#808080 !important;"> Infectados:</span> ' + feature.properties.cases.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + '<BR><span style="color:#808080 !important;">Muertos:</span> '+ feature.properties.deaths.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") +'</p>');
    layer.bindPopup(function () {
        

        var url = 'http://localhost/eleicoes-2022/function/ajaxMap.php'; 
        var params = 'estado=' + feature.properties.code
        // alert(params);
        var xmlreq =  new XMLHttpRequest();
        // Iniciar uma requisição
        xmlreq.open("POST", url, true);
        xmlreq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        // Atribui uma função para ser executada sempre que houver uma mudança de ado
        xmlreq.onreadystatechange = function() {
        
            // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
            if (xmlreq.readyState == 4) {
                console.log(xmlreq);
                // Verifica se o arquivo foi encontrado com sucesso
                if (xmlreq.status == 200) {
                    
                    try {
                        JSON.parse(xmlreq.responseText);
                    } catch (e) {
                        // Modal Error
                        alert('errorrrr');
                        return false;
                    }

                    var response = JSON.parse(xmlreq.responseText);
                    // alert(response.code);
                    if (response.status == '200'){
                        document.getElementById("contentApuracao").innerHTML = response.html;
                    } else {
                        // Modal Error
                        alert('error22');
                    }
                } else {
                    alert( "-Erro: " + xmlreq.statusText);
                }
            }
        };
        xmlreq.send(params);

    });
    layer.on({  });
}

geojson_ = L.geoJson(dataApuracao, {
    style: style_,
    onEachFeature: onEachFeature_
}).addTo(mymap_);

mymap_.attributionControl.addAttribution('');

var legend_ = L.control({position: 'bottomright'});

legend_.onAdd = function (map) {

    var div = L.DomUtil.create('div', 'info-m legend'),
        grades = [0, 500, 5000, 10000, 25000, 50000],
        labels = [],
        from, to;

    for (var i = 0; i < grades.length; i++) {
        from = grades[i];
        to = grades[i + 1];
        labels.push(
            '<i style="background:' + getColorm(from + 1) + '"></i> ' +
            from.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + (to ? ' - ' + to.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") : '+'));
    }

    div.innerHTML = labels.join('<br>');
    return div;
};

// legend_.addTo(mymap_);

    </script>
    </body>
</html>