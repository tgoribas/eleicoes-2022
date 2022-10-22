<?php

require 'app/configApp.php';
require FOLDER . '/template/header.php';
?>
    <main>
        <div class="container-fluid px-0">
            <h3 class="text-center py-3" style="background: #d1e7dd; color:#198754;">
                <span class="fw-200">Apuração</span><br><span class="fw-900">Eleições 2022 - 2º Turno</span>
            </h3>
        </div>
        <div class="container">
            <div class="col-10 m-auto">
                <div class="bar">
                    <div class="progress one"></div>
                    <div class="percent">25%</div>
                    <div class="text">short answer</div>
                </div>
                <div class="bar">
                    <div class="progress two"></div>
                    <div class="percent">55%</div>
                    <div class="text">long answer that takes up multiple lines</div>
                </div>
                <div class="bar">
                    <div class="progress three"></div>
                    <div class="percent">20%</div>
                    <div class="text">another one just for fun</div>
                </div>
            </div>
        </div>
    </main>
    <?php require FOLDER . '/template/footer.php'; ?>
    </body>
</html>