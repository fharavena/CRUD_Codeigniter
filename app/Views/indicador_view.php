<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indicador</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <ul class="navbar-nav mr-auto">
                <a class="navbar-brand" href="indicador">Gráfico de Indicadores</a>
            </ul>
            <ul class="navbar-nav">
                <a class="navbar-brand float-right" href="mantenedor">Mantenedor</a>
            </ul>
        </nav>

        <div class="row">


            <div class="col-12">
                <form action="graph" method="get">
                    <div class="row">
                        <div class="col-12 py-3">
                            <h4>Filtrar indicadores entre días</h4>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="inicio">Indicador</label>
                                <select class="form-control" id="indicador" name="indicador">
                                    <option id="uf" name="UF" value="uf">UF</option>
                                    <option id="dolar_intercambio" name="Dolar Observado" value="dolar_intercambio">Dolar Observado</option>
                                    <option id="dolar" name="Dolar" value="dolar">Dolar</option>
                                    <option id="euro" name="Euro" value="euro">Euro</option>
                                    <option id="ipc" name="IPC" value="ipc">IPC</option>
                                    <option id="utm" name="UTM" value="utm">UTM</option>
                                    <option id="ivp" name="IVP" value="ivp">IVP</option>
                                    <option id="imacec" name="Imacec" value="imacec">Imacec</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="inicio">Inicio</label>
                                <input type="date" class="form-control" id="start" name="inicio" value="2019-09-10" onchange="cambioeninicio()">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="fin">Termino</label>
                                <input type="date" class="form-control" id="end" name="fin" value="2020-09-21" onchange="cambioenfinal()">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group float-right pl-3 mt-4">
                                <a href="indicador" class="btn btn-success mt-2">Limpiar</a>
                                <button type="button" class="btn btn-primary mt-2  ml-4" onclick="filtrar()">Enviar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12 pt-5">
                <canvas id="myChart" width="400" height="auto" style="opacity: 100%;"></canvas>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    <script>
        $(document).ready(function() {
            filtrar(false);
        });

        function filtrar(indexexec = true) {
            var indicadorInput = document.getElementById("indicador");
            var inicioInput = document.getElementById("start");
            var finInput = document.getElementById("end");

            var indicador = indicadorInput.value;
            var inicio = Date.parse(inicioInput.value);
            var final = Date.parse(finInput.value);

            var anioInicio = inicioInput.value.slice(0, 4);
            var anioFin = finInput.value.slice(0, 4);

            var salida = [];

            if (!isNaN(inicio) && !isNaN(final)) {
                var salida;
                if (anioInicio == anioFin) {
                    var url = 'https://mindicador.cl/api/' + indicador + '/' + anioInicio;

                    salida = $.ajax({
                            url: url,
                            async: false,
                            dataType: 'json'
                        }).responseJSON.serie
                        .filter(elemento =>
                            inicio <= Date.parse(elemento.fecha.slice(0, 10)) &&
                            Date.parse(elemento.fecha.slice(0, 10)) <= final
                        ).reverse();
                } else {
                    for (let index = anioInicio; index <= anioFin; index++) {
                        var url = 'https://mindicador.cl/api/' + indicador + '/' + index;

                        var respuesta = $.ajax({
                                url: url,
                                async: false,
                                dataType: 'json'
                            }).responseJSON.serie
                            .filter(elemento =>
                                inicio <= Date.parse(elemento.fecha.slice(0, 10)) &&
                                Date.parse(elemento.fecha.slice(0, 10)) <= final
                            ).reverse();

                        salida = [...salida, ...respuesta];
                    }
                }
                populateTable(salida);
            } else if (indexexec) {
                alert("debe ingresar fecha de inicio y termino");
            }
        }

        function populateTable(apiresponse) {

            hijo = document.getElementById("myChart");
            padre = hijo.parentElement;
            padre.removeChild(hijo);
            padre.innerHTML += '<canvas id="myChart" width="400" height="auto" style="opacity: 100%;"></canvas>';

            /******destruir canvas */

            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: apiresponse.map(x => x.fecha.slice(0, 10)),
                    datasets: [{
                        label: "Gráfico",
                        borderColor: 'rgb(255, 99, 132)',
                        data: apiresponse.map(x => x.valor)
                    }]
                },
                options: {}
            });
        }

        // se ejecuta al cambiar la fecha inicial
        function cambioeninicio() {
            inicio = document.getElementById("start");
            fin = document.getElementById("end");
            fin.min = inicio.value;
        }

        // se ejecuta al cambiar la fecha final
        function cambioenfinal() {
            inicio = document.getElementById("start");
            fin = document.getElementById("end");
            inicio.max = fin.value;
        }
    </script>

</body>

</html>