<!--
Cortese Gabriele - 858372 - CorsoA - Tweb - 6CFU

Consegna: Prendere la pagina html della consegna 02 e rendere dinamica la creazione dei contenuti
in base al titolo del film passato in GET alla pagina php.

Contenuto: Una volta preso come GET il nome del film è stata gestita la lettura dei vari file di descrizione.
Per la gestione dei commenti bilanciati, ovvero n/2+1 a sx e i reststanti a dx, tramite l'uso di una variabile
limit in grado di trovare la meta. Successivmante la creazione è stata fatta con due for in sequenza posti
nei div opportuni.
-->

<?php
//Prelievo nome film in GET(URL) e salvo in titolo, anno, rating il valori scritti nel file $movie/info.txt
 $movie = $_GET["film"];
 list($titolo, $anno, $rating) = file($movie."/info.txt",FILE_IGNORE_NEW_LINES);
 ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="movie.css" type="text/css" rel="stylesheet">
		<link rel="icon" href="http://courses.cs.washington.edu/courses/cse190m/11sp/homework/2/rotten.gif">
    <title>Rancid Tomatoes</title>
	</head>

	<body>
    <div id="baseAlta">
        <img id="imgAlta" src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/banner.png" alt="Rancid Tomatoes">
    </div>
    <h1 id="nomeFilm"><?= $titolo." (".$anno.")";?></h1>
    <div id="container">
      <div id="leftSide">
        <div id="sezioneAlta">
          <?php
            //Controllo raiting per decidere img in SezioneAlta
            if($rating >= 60)
              $path_img = "http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/freshbig.png";
            else
              $path_img = "http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/rottenbig.png";
           ?>
          <img id="imgSezAlta" src=<?=$path_img?> alt="Rancid Tomatoes">
          <span id="perc"><?= $rating."%"; ?></span>
        </div>
        <div id="commentSx">

          <?php
            //Lettura e creazione dinamica dei commenti
            $arr_overview = glob("$movie/review*.txt");
            //Creazione limite 10 commenti
            if(count($arr_overview) > 10)
                $arr_overview_size = 10;
            else
                $arr_overview_size = count($arr_overview);
            //Creazione limite per divisione per commenti dx e sx
            $limit = $arr_overview_size/2;

            //Primo for per commenti della colonna di sinistra
            for($i = 0; $i < $limit; $i++) {
                list($msg, $img, $usr, $src) = file($arr_overview[$i]);
                $img = strtolower($img);
                 ?>
                  <div class="comment">
                      <p class="desc">
                          <img class="imgCom" src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/<?= trim($img);?>.gif" alt="<?=$img;?>">
                          <q><?= $msg; ?></q>
                      </p>
                  </div>
                  <div class="subCom">
                      <p class="usr">
                          <img class="imgSub" src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/critic.gif" alt="Critic">
                          <?= "$usr<br>$src"; ?>
                      </p>
                  </div>
                  <?php
            } //Chiusura primo for
          ?>
        </div>
        <div id="commentDx">
          <?php
          //Creazione dinamica dei commenti della colonna di destra
          for(;$i < $arr_overview_size; $i++) {
              list($msg, $img, $usr, $src) = file($arr_overview[$i]);
              $img = strtolower($img);
              ?>
              <div class="comment">
                  <p class="desc">
                      <img class="imgCom" src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/<?= trim($img);?>.gif" alt="<?=$img;?>">
                      <q><?= $msg; ?></q>
                  </p>
              </div>
              <div class="subCom">
                  <p class="usr">
                      <img class="imgSub" src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/critic.gif" alt="Critic">
                      <?= "$usr<br>$src"; ?>
                  </p>
              </div>
              <?php
          }//Chiusura secondo for
            ?>
        </div>
      </div>
      <div id="righSide">
        <div>
          <img src="<?=$movie?>/overview.png" alt="general overview">
        </div>
        <div id="rightList">
          <dl>
              <?php
              //Lettura da file + split
              $lines = file($movie."/overview.txt");
              //Creazione dinamica di dt,dd per le varie voci di descrizione del film
              foreach ($lines as $line) {
                    //Split per trovare voce del dt
                    $primo = explode(":", $line);
                    ?>
                    <dt>
                        <?= $primo[0];?>
                    </dt>
                    <dd>
                        <?= $primo[1];?>
                    </dd>
                    <?php
              } ?>
           </dl>
        </div>
      </div>
      <div id="footer">
          <?= "(1-".count($arr_overview).") of ".count($arr_overview)?>
      </div>
      </div>
      <div id="css">
          <a href="ttp://validator.w3.org/check/referer"><img src="http://www.cs.washington.edu/education/courses/cse190m/11sp/homework/2/w3c-xhtml.png" alt="Validate HTML"></a> <br>
          <a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!"></a>
      </div>
    </body>
</html>
