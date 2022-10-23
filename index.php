<?php

require 'app/configApp.php';
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
                            <div class="circular--portrait shadow-sm"> <img src="https://resultados.tse.jus.br/oficial/ele2022/545/fotos/br/280001618036.jpeg" class="w-100" alt=""> </div>
                        </div>
                        <div class="col-10">
                            <div class="bar mt-0" style="background: #b92323;">
                                <div class="progress one" style="width: 48%; background:#245bdd;"></div>
                                <div class="percent text-white">48%</div>
                                <div class="text text-white">52%</div>
                            </div>
                            <div class="bar mt-1" style="height:10px;background: #d8d8d8;">
                                <div class="progress" style="width: 100%; height:10px; background-image: linear-gradient(to right, #f4d60d, #f6c600, #f8b700, #f7a700, #f69704);"></div>
                            </div>
                            <p class="mb-0 mt-2">
                                <span class="rounded-3 px-2 py-1 fw-400 fs-12px badge-info me-1" style="float: left;">
                                    Votos Apurados: 4.232.321
                                </span>
                                <span class="rounded-3 px-2 py-1 fw-400 fs-12px badge-info"  style="float: left;">
                                    45,4 %
                                </span>
                                <span class="rounded-3 px-2 py-1 fw-400 fs-12px badge-info" style="float: right;">
                                    Atualizado: 12/34/2022 19:53:12
                                </span>

                            </p>
                        </div>
                        <div class="col-1">
                            <div class="circular--portrait shadow-sm"> <img src="https://resultados.tse.jus.br/oficial/ele2022/545/fotos/br/280001607829.jpeg" class="w-100" alt=""> </div>
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
    </body>
</html>