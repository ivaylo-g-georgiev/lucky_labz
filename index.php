<?php
include_once 'db_postgres.php';
$con = new Postgres_con('students_table');

  $path = './xml';
  $table = 'students_table';
  $res=$con->import($table,$path);

if(isset($_POST['btn-search'])):
  $table = 'students_table';
  $student = $_POST['search_student'];
  $search_res=$con->search($table,$student);
endif;
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Lucky Labz</title>

    <!-- Bootstrap -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <header>
        <div class="page-header">
            <h1>Lucky Labz</h1></div>
    </header>
    <section id="main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" class="form-group">
                        <label for="search">Search By Name</label>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <input type="text" name="search_student" class="form-control" id="search">
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <button type="submit" name="btn-search" class="btn btn-default">search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php
            $res = '<table class="table table-bordered">';
            $res .= '<thead><tr><th>Faculty Number</th><th>Name</th><th>Gender</th><th>Faculty</th><th>Major</th><th>Score</th><th>Date</th><th>Time</th></thead>';
              foreach($search_res as $key => $result){
                $res .= '<tr>';
                foreach ($result as $key => $value) {

                  $res .= '<td>' . $value . '</td>';
                }
                $res .= '</tr>';
              }
              $res .= '</table>';
            echo $res;
           ?>
        </div>
    </section>
    <footer></footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
</body>

</html>
