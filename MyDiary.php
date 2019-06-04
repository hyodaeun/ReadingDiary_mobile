<?php
session_start();
header('P3P: CP="NOI CURa ADMa DEVa TAIa OUR DELa BUS IND PHY ONL UNI COM NAV INT DEM PRE"');

  include 'default.php';
  $id = $_SESSION['okID'];
  $sql = "select * from eachrecord where id = '$id';";
  $result = $connect->query($sql);
  $row = mysqli_affected_rows($connect);

  $tableID = $_GET["tableID"];
  $sql3 = $_GET["sqlSent"];
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" type="text/css" href="./css/mydiary.css?ver4">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="./javascript/mydiaryFunction.js"></script>


<!--여기까지-->

</head>

<body>



    <!--0516효은수정-->

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

    <!--여기까지-->

    <!--로그아웃, 정보수정 링크 위치 변경
 <form action="Logout.php" method="post">
  <div class="navigation">
    <input type="submit" name="logout" id="idLogout" value="로그아웃">
    <div class="logout">LOGOUT</div>
  </div><br/>
  <a href="Setting.php">정보 수정</a>
  </form>-->

  <!--여기까지-->

  <!--이미지 로고 추가-->
    <!--0516효은수정
     <div class="header"><img src="image/logo2.png" class="logo"></div>-->
     <!--오늘 날짜로 돌아가는 버튼 기능 추가-->
    <div class="f_table">
     <table class="tables" id="tables">
        <tr class="firstLine" id="slash">
          <td></td>
          <td>Jan</td>
          <td>Feb</td>
          <td>Mar</td>
          <td>Apr</td>
          <td>May</td>
          <td>Jun</td>
          <td>Jul</td>
          <td>Aug</td>
          <td>Sep</td>
          <td>Oct</td>
          <td>Nov</td>
          <td>Dec</td>
        </tr>
        <script type="text/javascript">
          var x = 31;
          var n = 0;
          var day = 0;
          for (i = 1; i < 32; i++) { // 테이블 그리는 JS문
            document.write("<tr>");
            document.write("<td>"+i+"</td>")
            if (i < 10){
              i = "0"+String(i);
            }else{
              i = String(i);
            }
            for(j = 1; j < 13; j++){
              var idSet = String(j) + i;
              document.write("<td id='date" + idSet + "'></td>");
            }
            document.write("</tr>");
          };
        </script>
      </table>
  </div>
    <?php

      //오른쪽 목록 그리기
      if ($row > 0) {
          // "select * from eachrecord where id = $id
          while ($results = mysqli_fetch_assoc($result)) { // 쿼리된 열이 없을 때까지 반복
              // id 불러오는 부분 수정 필요
              $feelings = $results['todayfeel']; // 쿼리 결과에서 todayfeel 값을 불러옴
              $dateGet = $results['todaydate']; // 쿼리 결과에서 todaydate 값을 불러옴

              ////////////////color setting///////////////
              $sql2 = "select * from signin where id = '$id'";
              $result2 = $connect->query($sql2);
              $feelingsGet = mysqli_fetch_array($result2);

              $tableIDforColor = $results['todayblock'];

              //////////////// 저장되어있던 감정에 따라 칸칸마다 색 설정 ///////////////
            switch ($feelings) {
              case 'rg':
                $cellColor = $feelingsGet['rg'];
              break;
              case 'good':
                $cellColor = $feelingsGet['good'];
              break;
              case 'nb':
                $cellColor = $feelingsGet['nb'];
              break;
              case 'angry':
                $cellColor = $feelingsGet['angry'];
              break;
              case 'sad':
                $cellColor = $feelingsGet['sad'];
              break;
              case 'bad':
                $cellColor = $feelingsGet['bad'];
              break;
            } //colorSwitch
            ////////////////////////////////////////////
            ?>
            <!-- 칸마다 색칠하는 JS 코드 -->
            <script type="text/javascript">
              var cellID = '<?php echo $tableIDforColor; ?>';
              var cellColor = '<?php echo $cellColor; ?>';
              document.getElementById(cellID).style.backgroundColor = cellColor;
            </script>
            <!-- ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ -->
    <?php
          } //while ($results = mysqli_fetch_assoc($result))
      } //if ($row > 0)
    ?>

    <!-- 칸 클릭시 아이디 불러오는 JS 코드 (가공 필요) -->
    <script type = "text/javascript">
      $("document").ready(function() {
        if('<?php echo $tableID ?>'){
            if('<?php echo $tableID ?>' != "undefined"){
              jQuery('#DialogOutLogin').css("display", "block");
              jQuery('#box').css("display", "block");
            }
        }
        $("#tables td").click(function() {

            var tableID = $(this).attr("id");
            window.location.href="MyDiary.php?tableID="+tableID+"&sqlSent="
                                  +  "select * from eachrecord where id ='<?php echo $id; ?>' and todayblock ='" + tableID+"'"; // POST 방식으로 php로 js 변수 넘김

        });
        
          //기분 선택하는 게 안됨
        $("body").click(function() {
          console.log($(event.target).is("#DialogOutLogin"));
          if($(event.target).is("#DialogOutLogin")){
            jQuery('#DialogOutLogin').css("display", "none");
          }
          console.log("clicked");
        });
          
          
          
      });
    </script>
    <div class="mainForm">
        <?php
          $result3 = $connect->query($sql3);
          $savedRecord = mysqli_fetch_array($result3); // 저장된 레코드 (오늘의 일기가) 있으면
          $row3 = mysqli_affected_rows($connect);
         // echo "<br />기록 ".$savedRecord;
         echo "<script>console.log('$row3')</script>";
          if ($savedRecord > 0) {
              $savedFeeling = $savedRecord['todayfeel'];
              $savedDiary = $savedRecord['todaydiary'];

              switch ($savedFeeling) { // 불러온 감정을 문자열로 바꾸고
              case 'rg':
                $savedFeelingtoWord = '아주 좋아요';
              break;
              case 'good':
                $savedFeelingtoWord = '좋아요';
              break;
              case 'nb':
                $savedFeelingtoWord = '나쁘지 않아요';
              break;
              case 'bad':
                $savedFeelingtoWord = '나빠요';
              break;
              case 'sad':
                $savedFeelingtoWord = '슬퍼요';
              break;
              case 'angry':
                $savedFeelingtoWord = '화가 나요';
              break;
            } // switch($savedFeeling)
        ?>

        <!-- 출력 -->
        <!-- 0430 효은수정-->


        <!--여기까지-->
    
<div id="DialogOutLogin">
    <div id="loginDialogIn">
<!--      <span id="closeLogin">&times;</span>-->
      <div id="loginDialogContent">
        <div class="box" id="box">
          <div class="diaryResult">
            <div class="feelCheck">
              <label class="fCheck1">오늘 하루 기분은 <?php echo $savedFeelingtoWord ?></label>
            </div>
            <!-- 저장된 일기 내용 출력 -->
            <div class="ContentsSaved">
              <?php echo $savedDiary ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
        <?php
          // "select * from eachrecord where id = $id 쿼리된 문장이 없으면
          } else {
        ?>
    <div id="DialogOutLogin">
    <div id="loginDialogIn">
      <span id="closeLogin">&times;</span>
      <div id="loginDialogContent">
                <!-- 폼 띄워서 입력받을 수 있도록 하기 -->
        <div class="box" id="box">
        <form class="diaryForm" action="MyDiaryProgress.php" method="post">
            <div class="sel sel--superman">
              <select name="select-superpower" id="select-superpower">
                <option value="" disabled>기분을 선택하세요</option>
                <option value="rg">REALLY GOOD</option>
                <option value="good">GOOD</option>
                <option value="nb">NOT BAD</option>
                <option value="angry">ANGRY</option>
                <option value="sad">SAD</option>
                <option value="bad">BAD</option>
              </select>
            </div>
            <div class="Contents">
            <textarea name="diary" maxlength="1000" class= "diary" id="diary" placeholder="오늘의 하루는 어땠나요?"></textarea><br>
            <span id="counter">###</span>

            <!-- 글자 수 세는 JS 코드 -->
            <script type="text/javascript">
              $(function() {
                $('#diary').keyup(function(e) {
                  var content = $(this).val();
                  $('#counter').html(content.length + '/1000');
                });
                $('#diary').keyup();
              });
            </script>

                <!-- 코드 출처 : https://zinee-world.tistory.com/237 -->

            </div><br>
            <input class="writeButton" type="submit" name="records" value="일기 쓰기">
            <?php echo "<input type='hidden' name='blockId' value=".$tableID.">"; ?>
        </form>
        </div>
      </div>
    </div>
  </div>

    <?php
          }//else
    ?>
    </div>
</body>

</html>
