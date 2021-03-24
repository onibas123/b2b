<html>
<head>
    <title>B2B Welcome</title>
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <!-- script charts-->
    <script
      type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"
    ></script>
    <!-- Include fusion theme -->
    <script
      type="text/javascript"
      src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"
    ></script>

    <style>
        table
        {
           text-size: 11px; 
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
            <div clasS="col-md-12">
                <br>
                <section id="section-task-2">
                    <fieldset>
                    <legand><h5>Tarea 2</h5></legend>
                    <div id="chart-container"></div>
                       

                    </fieldset>
                </section>
            </div>
        </div>
    
    </div>

    <script type="text/javascript">

    $(document).ready(function() {
      
      let dataset_ = [];
      let cadenas = [];
      let sales = [];

      $.ajax({
        url: 'middleware/B2b.php',
        type: 'post',
        data: {action: 'report'},
        dataType: 'json',
        success: function(response)
        {  
          for(var i=0; i< response['cadenas'].length; i++)
          {
            if(cadenas.includes(response['cadenas'][i]) == false){
              if(i > 0 )
              {
                dataset_.push(
                {
                  seriesname: cadenas[0],
                  data: sales
                }
              );

                cadenas = [];
                sales = '';
              }
              cadenas.push(response['cadenas'][i]);
              sales.push({ value: response['sales'][i] });
            }
            else{
              
              sales.push({ value: response['sales'][i] });
              if(i == response['cadenas'].length - 1 )
              {
                dataset_.push(
                {
                  seriesname: cadenas[0],
                  data: sales
                }
              );
              }
            }
          }

          //->
          const dataSource = {
          chart: {
            caption: "Venta diaria por Cadenas.",
            subcaption: " Intervalo [07/01/2019 - 13/01/2019]",
            numbersuffix: "",
            showsum: "1",
            plottooltext:
              "El día $label La Cadena $seriesName Vende $ <b>$dataValue</b> ",
            theme: "fusion",
            drawcrossline: "1",
          },
          categories: [
            {
              category: [
                {
                  label: "07-01-2019",
                },
                {
                  label: "08-01-2019",
                },
                {
                  label: "09-01-2019",
                },
                {
                  label: "10-01-2019",
                },
                {
                  label: "11-01-2019",
                },
                {
                  label: "12-01-2019",
                },
                {
                  label: "13-01-2019",
                },
              ],
            },
          ],
          dataset: dataset_ , 
        };

        FusionCharts.ready(function () {
          var myChart = new FusionCharts({
            type: "stackedcolumn2d",
            renderAt: "chart-container",
            width: "100%",
            height: "600",
            dataFormat: "json",
            dataSource,
          }).render();
        });
          //<-
        }

      });

    });

   
    </script>

</body>
</html>
