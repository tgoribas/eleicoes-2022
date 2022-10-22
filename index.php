<?php 
require 'app/configApp.php';
?><!doctype html>
<html lang="pt">

<head>
  <title>Apuração Eleições 2022 - 2º Turno</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <style>
        .bar {
  width: 100%;
  border: 1px solid;
  border-radius: 5px;
  position: relative;
}

.progress {
  height: 100%;
  position: absolute;
  top: 0px;
  left: 0px;
  z-index: -1;
}

.percent {
  position: absolute;
  top: 50%;
  right: 5px;
  transform: translate(0, -50%);
}

.text {
  padding: 3px;
  width: 80%;
}

.one {
  background-color: rgba(255, 0, 0, 0.5);
  width: 40%;
}

.two {
  background-color: rgba(0, 255, 0, 0.5);
  width: 47%;
}

.three {
  background-color: rgba(0, 0, 255, 0.5);
  width: 50%;
}
    </style>
</head>

<body>
    <main>
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
  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>