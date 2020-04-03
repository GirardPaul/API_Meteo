<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/4/cerulean/bootstrap.min.css">
    <title>Document</title>
    <style>
        body{
            width: 100%;
        }
        * {
            white-space: nowrap !important;
        }
        tr, th, td {
            text-align: center;
        }
        .table th, .table td {
    padding: 0.75rem;
    vertical-align: inherit !important;
    border-top: 1px solid #dee2e6;
}
    </style>
</head>

<body>



    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">ACS Météo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <form action="" method="post" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" name="ville" placeholder="Saisir votre ville">
                <button class="btn btn-secondary my-2 my-sm-0" type="submit">Rechercher</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="row flex-column align-items-center flex-nowrap">
            <?php


            if (isset($_POST['ville'])) {

                $all_countries = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=' . $_POST['ville'] . '&lang=fr&units=metric&appid=6cb0c5274fc3d4ca476af2162ab5d713');

                $all_countries = json_decode($all_countries, true);


                echo '<div class="card mb-3 col-12 center">';
                echo '<h3 class="card-header">Météo du jour</h3>';
                echo '<div class="card-body d-flex flex-column align-items-center">';
                echo '<h2 class="card-title">' . $all_countries['name'] . '</h2>';
                $icon = $all_countries['weather'][0]['icon'];
                echo "<img src='http://openweathermap.org/img/wn/$icon@2x.png'>";
                echo '<h6 class="card-subtitle text-muted">' . ucfirst($all_countries['weather'][0]['description']) . '</h6>';
                echo '<h1 class="display-3">' . ceil($all_countries['main']['temp']) . '°' . '</h1>';
                echo '</div>';
                echo '<div class="card-body d-flex justify-content-between">';
                $data = date('Y-m-d');
                setlocale(LC_TIME, "fr_FR", "French");
                $date = strftime("%A", strtotime($data));
                echo "<p>" . $date . " Aujourd'hui</p>";
                echo '<p>' . ceil($all_countries['main']['temp_min']) . '°' . '  ' . ceil($all_countries['main']['temp_max']) . '°' . '</p>';
                echo "</div>";
                echo "<hr>";


                $latitude = $all_countries['coord']['lat'];
                $longitude = $all_countries['coord']['lon'];

                $lever = date_sunrise(time(), SUNFUNCS_RET_STRING, $latitude, $longitude, 90, 2);
                $coucher = date_sunset(time(), SUNFUNCS_RET_STRING, $latitude, $longitude, 90, 2);


                echo '<div class="card-body col-12 d-flex justify-content-between">';

                echo '<div class="d-flex flex-column">';
                echo '<label>Lever</label>';
                echo "<h4>$lever</h4>";
                echo '</div>';



                echo '<div class="d-flex flex-column">';
                echo '<label>Coucher</label>';
                echo "<h4>$coucher</h4>";
                echo '</div>';
                echo '</div>';

                echo '<div class="card-body col-12 d-flex justify-content-between">';

                echo '<div class="d-flex flex-column">';
                echo '<label>Risque de pluie</label>';
                echo "<h4>" . $all_countries['clouds']['all'] . '%' . "</h4>";
                echo '</div>';



                echo '<div class="d-flex flex-column">';
                echo '<label>Humidité</label>';
                echo "<h4>" . $all_countries['main']['humidity'] . '%' . "</h4>";
                echo '</div>';
                echo '</div>';



                $deg_vent = $all_countries['wind']['deg'];

                $vent = "";

                if ($deg_vent === 0) {
                    $vent = "N";
                } elseif ($deg_vent > 0 && $deg_vent < 45) {
                    $vent = "NNE";
                } elseif ($deg_vent === 45) {
                    $vent = "NE";
                } elseif ($deg_vent > 45 && $deg_vent < 90) {
                    $vent = "ENE";
                } elseif ($deg_vent === 90) {
                    $vent = "E";
                } elseif ($deg_vent > 90 && $deg_vent < 135) {
                    $vent = "ESE";
                } elseif ($deg_vent === 135) {
                    $vent = "SE";
                } elseif ($deg_vent > 135 && $deg_vent < 180) {
                    $vent = "SSE";
                } elseif ($deg_vent === 180) {
                    $vent = "S";
                } elseif ($deg_vent > 180 && $deg_vent < 225) {
                    $vent = "SSO";
                } elseif ($deg_vent === 225) {
                    $vent = "SO";
                } elseif ($deg_vent > 225 && $deg_vent < 270) {
                    $vent = "OSO";
                } elseif ($deg_vent === 270) {
                    $vent = "O";
                } elseif ($deg_vent > 270 && $deg_vent < 315) {
                    $vent = "ONO";
                } elseif ($deg_vent === 315) {
                    $vent = "NO";
                } elseif ($deg_vent > 315 && $deg_vent <= 360) {
                    $vent = "NNO";
                }




                echo '<div class="card-body col-12 d-flex justify-content-between">';

                echo '<div class="d-flex flex-column">';
                echo '<label>Vent</label>';
                echo "<h4>" . $vent . '  ' . ceil($all_countries['wind']['speed']) . 'km/h' . "</h4>";
                echo '</div>';



                echo '<div class="d-flex flex-column">';
                echo '<label>Ressenti</label>';
                echo "<h4>" . ceil($all_countries['main']['feels_like']) . '°' . "</h4>";
                echo '</div>';
                echo '</div>';



                $visibility = $all_countries['visibility'] / 1000;

                echo '<div class="card-body col-12 d-flex justify-content-between">';

                echo '<div class="d-flex flex-column">';
                echo '<label>Pression</label>';
                echo "<h4>" . $all_countries['main']['pressure'] . 'hPa' . "</h4>";
                echo '</div>';



                echo '<div class="d-flex flex-column">';
                echo '<label>Visibilité</label>';
                echo "<h4>" . $visibility . 'km' . "</h4>";
                echo '</div>';
                echo '</div>';
                echo '</div>';



                echo "<h1>Prévisions à 5 jours</h1>";



                $day = file_get_contents('http://api.openweathermap.org/data/2.5/forecast?q=' . $_POST['ville'] . '&lang=fr&units=metric&appid=6cb0c5274fc3d4ca476af2162ab5d713');

                $day = json_decode($day, true);







                for ($i = 0; $i < $day['list'][$i]; $i++) {

                    $test = explode(' ', $day['list'][0]['dt_txt']);

                    $test2 = explode(' ', $day['list'][$i]['dt_txt']);

                    // var_dump($test[0]);

                    // var_dump($test2[0]);

                    if ($test[0] == $test2[0]) {

                        echo '<table class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Météo</th>
                            <th scope="col">Température</th>
                            <th scope="col">Ressenti</th>
                            <th scope="col text-nowrap">Risque de pluie</th>
                            <th scope="col">Vent</th>
                          </tr>
                        </thead>
                        <tbody>';






                        $dataa = date($day['list'][$i]['dt_txt']);
                        setlocale(LC_TIME, "fr_FR", "French");
                        $datee = strftime("%X", strtotime($dataa));


                        $icon = $day['list'][$i]['weather'][0]['icon'];


                        $day_vent = $day['list'][$i]['wind']['deg'];

                        $vent_day_all = "";

                        if ($day_vent === 0) {
                            $vent_day_all = "N";
                        } elseif ($day_vent > 0 && $day_vent < 45) {
                            $vent_day_all = "NNE";
                        } elseif ($day_vent === 45) {
                            $vent_day_all = "NE";
                        } elseif ($day_vent > 45 && $day_vent < 90) {
                            $vent_day_all = "ENE";
                        } elseif ($day_vent === 90) {
                            $vent_day_all = "E";
                        } elseif ($day_vent > 90 && $day_vent < 135) {
                            $vent_day_all = "ESE";
                        } elseif ($day_vent === 135) {
                            $vent_day_all = "SE";
                        } elseif ($day_vent > 135 && $day_vent < 180) {
                            $vent_day_all = "SSE";
                        } elseif ($day_vent === 180) {
                            $vent_day_all = "S";
                        } elseif ($day_vent > 180 && $day_vent < 225) {
                            $vent_day_all = "SSO";
                        } elseif ($day_vent === 225) {
                            $vent_day_all = "SO";
                        } elseif ($day_vent > 225 && $day_vent < 270) {
                            $vent_day_all = "OSO";
                        } elseif ($day_vent === 270) {
                            $vent_day_all = "O";
                        } elseif ($day_vent > 270 && $day_vent < 315) {
                            $vent_day_all = "ONO";
                        } elseif ($day_vent === 315) {
                            $vent_day_all = "NO";
                        } elseif ($day_vent > 315 && $day_vent <= 360) {
                            $vent_day_all = "NNO";
                        }



                        echo "<tr>
                            <th scope='row'>" . $datee . "</th>
                            <td><img src='http://openweathermap.org/img/wn/$icon@2x.png'>" . ucfirst($day['list'][$i]['weather'][0]['description']) . "</td>
                            <td>" . ceil($day['list'][$i]['main']['temp']) . "°" . "</td>
                        
                            <td>" . ceil($day['list'][$i]['main']['feels_like']) . "°" . "</td>
                      
                            <td>" . $day['list'][$i]['clouds']['all'] . "%" . "</td>
                            <td>" . $vent_day_all . '  ' . ceil($day['list'][$i]['wind']['speed']) . 'km/h' . "</td>
                          </tr>";
                    }
                }




                $all = file_get_contents('http://api.openweathermap.org/data/2.5/forecast?q=' . $_POST['ville'] . '&lang=fr&units=metric&appid=6cb0c5274fc3d4ca476af2162ab5d713');

                $all = json_decode($all, true);



                echo '<table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Météo</th>
                    <th scope="col">Température</th>
                    <th scope="col">Ressenti</th>
                    <th scope="col text-nowrap">Risque de pluie</th>
                    <th scope="col">Vent</th>
                  </tr>
                </thead>
                <tbody>';




                for ($i = 0; $i < $all['list'][$i]; $i++) {

                    $test = explode(' ', $all['list'][0]['dt_txt']);

                    $test2 = explode(' ', $all['list'][$i]['dt_txt']);

                    // var_dump($test[0]);

                    // var_dump($test2[0]);



                    if ($test[0] !== $test2[0]) {


                    $dataa = date($all['list'][$i]['dt_txt']);
                    setlocale(LC_TIME, "fr_FR", "French");
                    $datee = strftime("%a, %e, %X", strtotime($dataa));


                    $icon = $all['list'][$i]['weather'][0]['icon'];


                    $deg_vent_all = $all['list'][$i]['wind']['deg'];

                    $vent_all = "";

                    if ($deg_vent_all === 0) {
                        $vent_all = "N";
                    } elseif ($deg_vent_all > 0 && $deg_vent_all < 45) {
                        $vent_all = "NNE";
                    } elseif ($deg_vent_all === 45) {
                        $vent_all = "NE";
                    } elseif ($deg_vent_all > 45 && $deg_vent_all < 90) {
                        $vent_all = "ENE";
                    } elseif ($deg_vent_all === 90) {
                        $vent_all = "E";
                    } elseif ($deg_vent_all > 90 && $deg_vent_all < 135) {
                        $vent_all = "ESE";
                    } elseif ($deg_vent_all === 135) {
                        $vent_all = "SE";
                    } elseif ($deg_vent_all > 135 && $deg_vent_all < 180) {
                        $vent_all = "SSE";
                    } elseif ($deg_vent_all === 180) {
                        $vent_all = "S";
                    } elseif ($deg_vent_all > 180 && $deg_vent_all < 225) {
                        $vent_all = "SSO";
                    } elseif ($deg_vent_all === 225) {
                        $vent_all = "SO";
                    } elseif ($deg_vent_all > 225 && $deg_vent_all < 270) {
                        $vent_all = "OSO";
                    } elseif ($deg_vent_all === 270) {
                        $vent_all = "O";
                    } elseif ($deg_vent_all > 270 && $deg_vent_all < 315) {
                        $vent_all = "ONO";
                    } elseif ($deg_vent_all === 315) {
                        $vent_all = "NO";
                    } elseif ($deg_vent_all > 315 && $deg_vent_all <= 360) {
                        $vent_all = "NNO";
                    }



                    echo "<tr>
                    <th scope='row'>" . $datee . "</th>
                    <td><img src='http://openweathermap.org/img/wn/$icon@2x.png'>" . ucfirst($all['list'][$i]['weather'][0]['description']) . "</td>
                    <td>" . ceil($all['list'][$i]['main']['temp']) . "°" . "</td>

                    <td>" . ceil($all['list'][$i]['main']['feels_like']) . "°" . "</td>

    
                    <td>" . $all['list'][$i]['clouds']['all'] . "%" . "</td>
                    <td>" . $vent_all . '  ' . ceil($all['list'][$i]['wind']['speed']) . 'km/h' . "</td>
                  </tr>";
                }
            }
        }
            ?>
            </tbody>
            </table>
            <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>