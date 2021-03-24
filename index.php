<html>
<head>
    <title>B2B Welcome</title>
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <style>
        table
        {
           font-size: 11px; 
        }
        .table .thead-light th {
            color: #FFF;
        }
        .td-product{
            color: #FFF;
            background-color: #c6c8ca;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">B2B</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                <i class="fa fa-home"></i>
                Tarea 1
                <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="report.php">
                <i class="fa fa-envelope-o">
                </i>
                Tarea 2
                </a>
            </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <hr>
        <div class="row">
            <div class=="col-md-2">
                <p>Agrupar por:</p>
            </div>
            <div clasS="col-md-4">
                <select id="select-group_by" class="form-control" onchange="load_table();">
                    <option value="1">Productos</option>
                    <option value="2">Locales</option>
                </select>
            </div>

            <div class=="col-md-2">
                <p>Mostrar:</p>
            </div>
            <div clasS="col-md-4">
                <select id="select-display_by"  class="form-control" onchange="load_table();">
                    <option value="1">Ventas</option>
                    <option value="2">Unidades Vendidas</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div clasS="col-md-12">
                <br>
                <section id="section-task-1">
                    <fieldset>
                    <legand><h5>Tarea 1</h5></legend>

                        <table class="table table-bordered" id="table-task-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" id="th-group_by">Productos/Ventas</th>
                                    <th scope="col">2019-01-07</th>
                                    <th scope="col">2019-01-08</th>
                                    <th scope="col">2019-01-09</th>
                                    <th scope="col">2019-01-10</th>
                                    <th scope="col">2019-01-11</th>
                                    <th scope="col">2019-01-12</th>
                                    <th scope="col">2019-01-13</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-task-1">
                                <tr>
                                    <td colspan="8" align="center"> Cargando... </td>
                                </tr>
                            </tbody>
                            <tfoot id="tfoot-task-1">
                               
                            </tfoot>
                        </table>

                    </fieldset>
                </section>

            </div>
        </div>
    
    </div>

    <script type="text/javascript">

    $(document).ready(function() {
        load_table();
    });

    function load_table()
    {
        let group_by = $('#select-group_by').val();
        let display_by = $('#select-display_by').val();

        let group_display = $( "#select-group_by option:selected" ).text()+'/'+$( "#select-display_by option:selected" ).text();

        $('#th-group_by').html(group_display);

        $.ajax({
            url: 'middleware/B2b.php',
            type: 'post',
            data: {action: 'load_data', group_by: group_by, display_by: display_by},
            dataType: 'json',
            beforeSend: function(){
                $('#tbody-task-1').html('<tr><td colspan="8" align="center"> Cargando... </td></tr>');
            },
            success: function(response)
            {   
                $('#tbody-task-1').html(response['tbody']);
                $('#tfoot-task-1').html(response['tfoot']);
            }
        });

    }


    </script>

</body>
</html>
