<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>プチプチゲーム</title>
</head>
<body>
  <div>
    <p class = "start" id = "startSign">スタート！</p>
  </div>
  <div id = "displayAll">
    <p id = "countTimer" class = "countDown"></p>
  <?php 
  $balls = range(1, 99);
  foreach($balls as $key => $value):?>
    <div class = "bubble" id = <?php echo $value?>><?php echo $value ?></div>
  <?php endforeach;?>
  </div>
</body>
  
  
  <!-- プチプチのモデル -->
  <style>
    .bubble{
      text-indent:100%;
      white-space:nowrap;
      overflow:hidden;
      display:inline-block;
      border-radius:50%;
      background-color: rgb(248, 241, 241);
      text-align:center;
      width:100px;
      height:100px;
      cursor:pointer;
      color:rgb(248, 241, 241);
      border: 0.4em solid rgb(209, 185, 185);
      user-select: none; /* CSS3 */
      -moz-user-select: none; /* Firefox */
      -webkit-user-select: none; /* Safari、Chrome */
      -ms-user-select: none; /* IE10 */
    }
    /* 破裂のモデル */
    .starburst {
      text-indent:100%;
      white-space:nowrap;
      overflow:hidden;
      display: inline-block;
      width:100px;
      height:100px;
      background: #FF9999;
      text-align: center;
      text-decoration: none;
      color: #FFF;
      border-radius:64% 36% 93% 7% / 40% 76% 24% 60%; 
      border: 0.4em solid rgb(209, 185, 185);
      user-select: none; /* CSS3 */
      -moz-user-select: none; /* Firefox */
      -webkit-user-select: none; /* Safari、Chrome */
      -ms-user-select: none; /* IE10 */
      }
      /* 得点バブルのモデル */
      .target{
        text-indent:100%;
        white-space:nowrap;
        overflow:hidden;
        display: inline-block;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        box-shadow:
          inset 0 0 50px #fff,
          inset 20px 0 80px #f0f,
          inset -20px 0 80px #0ff,
          inset 20px 0 300px #f0f,
          inset -20px 0 300px #0ff,
          0 0 50px #fff,
          -10px 0 80px #f0f,
          10px 0 80px #0ff;
      }
      /* 画面背景、カウントダウン表示のモデル */
      .countDown{
        position:fixed;
        font-size:100px;
        top:100px;
        left:575px;
        color:blue;
        opacity:0.5;
        pointer-events:none;
        user-select: none; /* CSS3 */
        -moz-user-select: none; /* Firefox */
        -webkit-user-select: none; /* Safari、Chrome */
        -ms-user-select: none; /* IE10 */
      }

      .start{
        font-size:300px;
        color:blue;
        position:fixed;
        top:100px;
        left:400px;
        margin:0;
        padding-left:724px;
        display:inline-block;
        white-space:nowrap;
        animation-name:marquee;
        animation-timing-function:linear;
        animation-duration:1s;
        animation-iteration-count:1;
      }

      @keyframes marquee{
        from {transform:translate(0%);}
        99%,to{transform:translate(-100%);}
      }
  </style>
  

  <script>
    let totalScore = 0;
    let bubbleCount = 0;
    let count = 65;
    let displayCount = document.getElementById('countTimer');
    const getRandomArbitrary = function(min, max) {
      return Math.floor(Math.random() * (max - min) + min);
    }
    const countUp = () =>{
      displayCount.textContent = count--;
    }
    const intervalId = setInterval(() =>{
      countUp();
      if(count < 0){
        clearInterval(intervalId);
      }}, 1000);

    // プチプチの個別取得
    const obj_list = document.querySelectorAll('.bubble');
    for(var i = 0; i< obj_list.length; i++){
      obj_list[i].addEventListener('click', function(){
        // bubbleクラスを持っている場合(破裂する前)のクリックイベント
        if(this.classList.contains('bubble')){
        // cssの変更による破裂
        this.classList.remove('bubble');
        this.classList.add('starburst');
        // 破裂音
        const punk = new Audio('short_punch1.mp3');
        punk.play();
        // 9回破裂させると得点源バブルが出現
          if(bubbleCount <= 8){
            bubbleCount++;
          }else if(bubbleCount === 9){
            // 得点源バブルは一度のみ出現
            bubbleCount++;
            let targetBubbleId = getRandomArbitrary(1,100);
            let targetBubble = document.getElementById(targetBubbleId);
            targetBubble.classList.remove('bubble');
            targetBubble.classList.add('target');
          }

        }else if(this.classList.contains('target')){
          const star_list = document.querySelectorAll('.starburst');
          for(let j = 0; j < star_list.length; j++){
            star_list[j].classList.remove('starburst');
            star_list[j].classList.add('bubble');
          }
          const addScore = new Audio('damage6.mp3');
          addScore.play();
          this.classList.remove('target');
          this.classList.add('bubble');
          bubbleCount = 0;
          totalScore++;
        }
      }, false);

      const gameOver = setTimeout(function(){
        location.href = 'http://localhost:8888/game/gameOverPage.php?theScore=' + totalScore;
      }, 66*1000);
      
    }
    const startSign = document.getElementById('startSign');
    startSign.addEventListener('animationend',function(){
      startSign.style.display = "none";
    });
    

  </script>


</html>