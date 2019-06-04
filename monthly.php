<?php
  session_start();
  include 'default.php';

  $id = $_SESSION['okID'];

    $sqlColor = "select rg, good, nb, sad, angry, bad from signin where id = '$id'";
    $resultColor = $connect->query($sqlColor);
    while($getColors = mysqli_fetch_assoc($resultColor)){
      $rgColor = $getColors['rg'];
      $goodColor = $getColors['good'];
      $nbColor = $getColors['nb'];
      $sadColor = $getColors['sad'];
      $angryColor = $getColors['angry'];
      $badColor = $getColors['bad'];
    }
  // $monthlyMax = array();

  $rgCnt = 0; $goodCnt = 0; $nbCnt = 0; $sadCnt = 0; $angryCnt = 0; $badCnt = 0;

  for ($i = 0; $i < 12; $i++) {
      $key = $i+1;

      $sql = "select todayfeel, todayblock from eachrecord where id = '$id' and todaymonth = '$key';";
      $result = $connect->query($sql);
      $row = mysqli_affected_rows($connect);
      // echo $key."월 ".$row."<br />";
      clearFeels();
      getFeels($result, $key);
      //clearFeels();
    //print_r($monthlyMax);
  }
?>

<?php
  function getFeels($result, $key)
  {
      $rbCnt = 0; $goodCnt = 0; $nbCnt = 0; $sadCnt = 0; $angryCnt = 0; $badCnt = 0;
      while ($monthResult = mysqli_fetch_assoc($result)) {
        switch ($monthResult['todayfeel']) {
        case "rg":
          $rgCnt++;
        break;
        case "good":
          //array_push($goodArr, $monthResult['todayblock']);
          $goodCnt++;
        break;
        case "nb":
          //array_push($nbArr, $monthResult['todayblock']);
          $nbCnt++;
        break;
        case "sad":
          //array_push($sadArr, $monthResult['todayblock']);
          $sadCnt++;
        break;
        case "angry":
          //array_push($angryArr, $monthResult['todayblock']);
          $angryCnt++;
        break;
        case "bad":
          //array_push($badArr, $monthResult['todayblock']);
          $badCnt++;
        break;
      }
      }

      countFeel($rgCnt, $goodCnt, $nbCnt, $sadCnt, $angryCnt, $badCnt, $key);
  }


  function countFeel($rg, $good, $nb, $sad, $angry, $bad, $month)
  {
      $maxCnt = 0;
      if (max($rg, $good, $nb, $sad, $angry, $bad) != null) {
          $maxCnt = max($rg, $good, $nb, $sad, $angry, $bad);
      }

      global $monthlyMax;
      //$monthly = array();
      $monthlyMax[$month] = $maxCnt;

      global $monthlyFeel;
      global $test;
      $test = array($rg, $good, $nb, $sad, $angry, $bad);

      if ($maxCnt != 0) {
        $j = 0;
        for($j = 0; $j < 6; $j++){
            //echo $test[$j]."<br />";
            if($test[$j] == $maxCnt){
                $monthlyFeel[$month][$j] = $test[$j];
            }
        }
      }// if $maxCnt
  } // countFeel


  function clearFeels()
  {
      $rgCnt = 0;
      $goodCnt = 0;
      $nbCnt = 0;
      $sadCnt = 0;
      $angryCnt = 0;
      $badCnt = 0;
  } // clearFeels();

  function monthFeelDiary() {

  }

  function getDiary($i){
    return $i;
  }
  ?>

  <!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <title>MONTHLY</title>
      <link rel="stylesheet" href="./css/monthly.css?ver=1">
      <link rel="stylesheet" type="text/css" href="./css/mydiary.css?ver1">

      <style media="screen">
        .outerDiv{
          text-align: center;
          background: #A99F92;
          opacity: 0.5;
        }
        .monthly{
            width: 25vw;
            height: 17vw;
            margin: 2vh;
            padding: 2vh;
            display: inline-block;
            color: rgba(255, 255, 255, 0.61);
            font-size: 5rem;
            text-align: center;
            line-height: 15vw;
            background-color: rgb(227, 227, 227);
          }
      </style>
    </head>
    <body>    
    <header id="header">
      <nav class="links" style="--items: 5;">
        <div class="dropdown">
          <a href="#" class="menutag">기분별 색</a>
            <!-- <button type="button" class="dropbtn">기분별 색</button> -->
            <div class="dropdown-content">
              <a href="#" id="dropRG">REALLY GOOD</a>
              <a href="#" id="dropGOOD">GOOD</a>
              <a href="#" id="dropNB">NOT BAD</a>
              <a href="#" id="dropANGRY">ANGRY</a>
              <a href="#" id="dropSAD">SAD</a>
              <a href="#" id="dropBAD">BAD</a>
            </div>
        </div>
        <a href="monthly.php" class="menutag">월별통계</a>
        <a href="MyDiary.php">
          <center><img src="image/logo2-1.png" width="200vw" height="60vh" align="center"></center>
        </a>
        <a href="Setting.php" class="menutag">정보수정</a>
        <a href="Logout.php" class="menutag">로그아웃</a>
        <span class="line"></span>
      </nav>
    </header>
        
    <?php
      $sqlForColors = "select * from signin where id = '$id';";
      $resultForColors = $connect->query($sqlForColors);
      while ($getColor = mysqli_fetch_assoc($resultForColors)) {
        $reallygood = $getColor['rg'];
        $good = $getColor['good'];
        $nb = $getColor['nb'];
        $sad = $getColor['sad'];
        $bad = $getColor['bad'];
        $angry = $getColor['angry'];
        echo "<script>
               document.getElementById('dropRG').style.background = '$reallygood';
               document.getElementById('dropGOOD').style.background = '$good';
               document.getElementById('dropNB').style.background = '$nb';
               document.getElementById('dropSAD').style.background = '$sad';
               document.getElementById('dropBAD').style.background = '$bad';
               document.getElementById('dropANGRY').style.background = '$angry';
        </script>";
      }
    ?>
        
      <?php

        for ($i = 1; $i < count($monthlyMax)+1; $i++) {
          $sqlForMonthly = "select todaydiary from eachrecord where todaymonth=$i";
          $resultforMonthly = $connect->query($sqlForMonthly);
          $rowDiary = mysqli_affected_rows($connect);
          $getDiary = array();
          $j = 0;
            while ($monthResultGetFeels = mysqli_fetch_assoc($resultforMonthly)) {
              $getDiary[$j++] = $monthResultGetFeels['todaydiary'];
            }
            if ($i == 1) {
                echo "<div class='outerDiv'>";
            }
            if ($i == 5 || $i == 9) {
                echo "</div>";
                echo "<div class='outerDiv'>";
            }
            /*echo "<h1 class='monthlyH1' id='monthlyH1".$i."'>".getDiary($i)."</h1>";*/
            echo "<div class='monthly' id='month".$i."'>".$i."</div>
                    <div class='DialogOutMonthly' id='DialogOutMonthly".$i."'>
                      <div class='monthlyDialogIn' id='monthlyDialogIn".$i."'>
                        <span class='closeMonthly' id='closeMonthly".$i."'>&times;</span>
                        <div class='monthlyDialogContent' id='monthlyDialogContent".$i."'>
                          <div id='monthlyDiary".$i."'>
                          </div>
                        </div>
                      </div>
                    </div>";
            if ($i == 12) {
                echo "</div>";
            }?>
            <script type="text/javascript">
            //var feels = new Array();
            var feels = new Array();
            var feelsString = new Array();
            var cnt = 0;
            var monthlyID = '<?php echo 'month'.$i ?>';
            </script>
            <?php
            for($j = 0; $j < 6; $j++){
              if($monthlyFeel[$i][$j]){
            ?>
          <script type="text/javascript">
            console.log("i : " + <?php echo $i ?> + " j : " + <?php echo $j ?>);
            var monthlyFeel = '<?php echo count($monthlyFeel[$i][$j]) ?>';
            var month = '<?php echo $i ?>';
            var type = '<?php echo $j ?>';
            if(type == 0){
              feels[cnt] = "<?php echo $rgColor ?>";
              feelsString[cnt] = "REALLY GOOD";
            }else if(type == 1){
              feels[cnt] = "<?php echo $goodColor ?>";
              feelsString[cnt] = "GOOD";
            }else if(type == 2){
              feels[cnt] = "<?php echo $nbColor ?>";
              feelsString[cnt] = "NOT BAD";
            }else if(type == 3){
              feels[cnt] = "<?php echo $sadColor ?>";
              feelsString[cnt] = "SAD";
            }else if(type == 4){
              feels[cnt] = "<?php echo $angryColor ?>";
              feelsString[cnt] = "ANGRY";
            }else if(type == 5){
              feels[cnt] = "<?php echo $badColor ?>";
              feelsString[cnt] = "BAD";
            }
            cnt++;
            //console.log(feels);
          </script>
      <?php
    }// if $monthlyFeel
  } // for j
    if(count($monthlyFeel[$i])<2){?>
      <script type="text/javascript">
      document.getElementById(monthlyID).style.backgroundColor = feels.toString();
      //titleH1.innerHTML = feelsString.toString();
      </script>
  <?php
}else{?>
  <script type="text/javascript">
    //console.log(feels.toString());
            document.getElementById(monthlyID).style.backgroundImage = "linear-gradient(to right, "+feels.toString()+")";
            //titleH1.innerHTML = feelsString.toString();

  </script>
<?php }
        } // for i
      ?>



      <!--<script type="text/javascript" src="javascript/monthlyFunction.js"></script>-->

    </body>
  </html>
