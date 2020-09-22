<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ajax crud</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .loader {
            border: 16px solid #f3f3f3;
            /* Light grey */
            border-top: 16px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div id="loader" style="display:none; z-index: 99;; position:fixed; width:100%; height:100%; background-color:white">
        <div class="loader" style="margin: 10% auto;"></div>
    </div>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <ul class="navbar-nav mr-auto">
                <a class="navbar-brand" href="indicador">Gráfico de Indicadores</a>
            </ul>
            <ul class="navbar-nav">
                <a class="navbar-brand float-right" href="mantenedor">Mantenedor</a>
            </ul>
        </nav>
        <h3>Mantenedor UF</h3>

        <div class="col-12">
            <button class="btn btn-primary my-3" onclick="sincronizar(1)"><i class="glyphicon glyphicon-plus"></i> 30 dias</button>
            <button class="btn btn-primary my-3 ml-3" onclick="sincronizar(2)"><i class="glyphicon glyphicon-plus"></i> 2020</button>
            <button class="btn btn-primary my-3 ml-3" onclick="sincronizar(3)"><i class="glyphicon glyphicon-plus"></i> Historico</button>
        </div>
        <div class="col-12">
            <button class="btn btn-success my-3" onclick="add_uf()"><i class="glyphicon glyphicon-plus"></i> Agregar UF</button>
        </div>

        <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Valor</th>
                    <th>Fecha</th>
                    <th style="width:125px;">Action
                        </p>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ufs as $uf) { ?>
                    <tr>
                        <td><?php echo $uf->id; ?></td>
                        <td><?php echo $uf->valor; ?></td>
                        <td><?php echo $uf->fecha; ?></td>
                        <td>
                            <button class="btn btn-warning" onclick="edit_uf(<?php echo $uf->id; ?>)">Edit</button>
                            <button class="btn btn-danger" onclick="delete_uf(<?php echo $uf->id; ?>)">Delete</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Valor</th>
                    <th>Fecha</th>
                </tr>
            </tfoot>
        </table>

    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_id').DataTable({
                "language": {
                    "lengthMenu": "Mostrar _MENU_ filas por página",
                    "zeroRecords": "No se ha encontrado nada",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "Sin registros",
                    "search": "Encontrar",
                    "infoFiltered": "(filtered from _MAX_ total records)"
                }
            });
        });

        $(document).ready(function() {
            $('#table_id').DataTable();
        });
        var save_method;
        var table;

        function sincronizar(id) {
            var cargando = document.getElementById("loader");
            cargando.style.display = "";
            if (confirm('¿Realmente quieres actualizar la base de datos con la informacion de los ultimos 30 días?')) {
                $.ajax({
                    url: "<?php echo site_url('crudcontroller/sincronizar/') ?>" + id,
                    type: "GET",
                    success: function(data) {
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        alert('Error al obtener datos de ajax');
                    }
                });
            }
        }

        function add_uf() {
            save_method = 'add';
            $('#form')[0].reset();
            $('#modal_form').modal('show');
        }

        function edit_uf(id) {
            save_method = 'update';
            $('#form')[0].reset();
            <?php header('Content-type: application/json'); ?>
            $.ajax({
                url: "<?php echo site_url('crudcontroller/ajax_edit') ?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('[name="id"]').val(data.id);
                    $('[name="valor"]').val(data.valor);
                    $('[name="fecha"]').val(data.fecha);

                    $('#modal_form').modal('show');
                    $('.modal-title').text('Editar UF');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    alert('Error al obtener datos de ajax');
                }
            });
        }

        function save() {
            var url;
            if (save_method == 'add') {
                url = "<?php echo site_url('crudcontroller/uf_add') ?>";
            } else {
                url = "<?php echo site_url('crudcontroller/uf_update') ?>";
            }

            $.ajax({
                url: url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data) {
                    $('#modal_form').modal('hide');
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error al agregar o actualizar información');
                }
            });
        }

        function delete_uf(id) {
            if (confirm('¿Realmente quieres borrar este registro?')) {
                // ajax delete data from database
                $.ajax({
                    url: "<?php echo site_url('crudcontroller/uf_delete') ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error borrando informacón');
                    }
                });

            }
        }
    </script>

    <!-- Bootstrap modal -->
    <div class="modal fade" id="modal_form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h3 class="modal-title">Formulario uf</h3>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form" class="form-horizontal">
                        <input type="hidden" value="" name="id" />
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Valor</label>
                                <div class="col-md-9">
                                    <input type="number" name="valor" placeholder="Valor" class="form-control" step="0.1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Fecha</label>
                                <div class="col-md-9">
                                    <input type="date" name="fecha" class="form-control">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>