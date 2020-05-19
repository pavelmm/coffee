<!doctype html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Кофе машина</title>
    <style>
      body {
        overflow:hidden;
      }
      .container{
        border:1px solid black;
      }
      .coffee-btn{
        background:Brown;
        width:50px;
        height:50px;
        border-radius:50%;
        border:1px solid black;
      }
     .coffee-btn{
        background:Brown;
        width:50px;
        height:50px;
        border-radius:50%;
        border:1px solid black;
      }
      .coffee-btn:hover {
        background:red;
        cursor:pointer;
      }
      .coffee-btn:active{
        background:Maroon;
      }
      .coffee-title {
        background:Tan;
        font-size:2rem;
        border-radius: 50px 0 0 50px;
        margin:1rem;
       
      }
      .coffee-title img {
        border:1px outset black;
        cursor:pointer;
      }
      .left {
        border: 1px;
        background-size: cover;
      }
      .coffee-group {
        padding:1rem;
  
      }
      #display {
        width:100%;
        height:150px;
        background:navy;
        color:white;
        border:4px groove black;
        
        
      }
      .coffee-title {
        color:black;
        font-size:1.6rem;
      }
      
      .progress {
        display:none;
      }
      #change_tray {
        position:relative;
        width:100%;
        height:200px;
        background:#9ACD32;
      }
      img[src$='rub.png'] {
        width:64px;
        cursor:pointer;
        position:absolute;
      }
      img[src$='rub.png']:hover{
        filter: contrast(130%);
      }
      #coffee_cup {
        width:100%;
      }
      img[src$='rub.jpg'] {
        cursor:pointer;
      }
      img[src$='rub.jpg']:hover {
        filter: contrast(130%);
      }
    </style>
  </head>
  <body>
    <div class="container my-3 border">
      <div class="row">
        <div class="col-6 left">
          <div class="coffee-group my-3">
            <div class="coffee-title">
              <img onclick="getCoffee('Капучино',30);" class="coffee-btn" >
              <span class="align-middle">Американо - 30 руб</span> 
            </div>
            <div class="coffee-title">
              <img onclick="getCoffee('Американо',38);" class="coffee-btn" >
              <span class="align-middle">Еспрессо - 38 руб.</span>
            </div>
            <div class="coffee-title">
              <img onclick="getCoffee('Латте',42);" class="coffee-btn" >
              <span class="align-middle">Латте - 42 руб.</span>
            </div>
            <div class="coffee-title">
              <img onclick="getCoffee('Гляссе',50);" class="coffee-btn" >
              <span class="align-middle">Капучино - 50 руб.</span>
            </div>
            <div class="coffee-title">
              <img onclick="getCoffee('Гляссе',93);" class="coffee-btn" >
              <span class="align-middle">Гляссе - 93 руб.</span>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="row">
            <div class="col-6">
              <div id="display">
                <p id="info1"></p>
                <p id="info2">Внесите деньги</p>
                <div class="progress">
                  <div id="progress" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
              <button class="btn btn-primary" onclick="getChange(money.value)">Получить сдачу</button>
              <img id="coffee_cup" src="">
            </div>
            <div class="col-6">
              <input id="money" type="hidden">
              <img id="bill_acc" src="img/bill_acc.png">
              <div id="change_tray"></div>
            </div>
          </div>
        </div>
      </div>
      <img src="img/50rub.jpg" alt="50">
      <img src="img/100rub.jpg" alt="100">
      <img src="img/500rub.jpg" alt="500">
    </div>
    <script>
      let i=0;
      let bills = document.querySelectorAll("img[src$='rub.jpg']");
      function getCoffee(name,price) {
        if (price<=money.value) {
          progress.parentElement.style.display="flex";
          info1.innerText="Кофе готовится...";
          money.value-=price;
          info2.innerText = money.value+"руб.";
          let timerId = setInterval(() => {
            progress.style.width = i+'%';
            i++;
            if (i>100) {
              clearInterval(timerId);
              info1.innerText = "Кофе готов!";
              i=0;
              progress.parentElement.style.display="none";
              progress.style.width='0%';
              coffee_cup.style.opacity=1;
            }
          }, 50);
        }
        else {
         info1.innerHTML=`Не хватает ${price-money.value} руб.`;
        }
        
      }
      
      for (let i=0; i<bills.length; i++) {
        bills[i].addEventListener('mousedown',dragAndDrop)
      }
      
      function dragAndDrop(event) {
        let bill = event.currentTarget;
        bill.ondragstart = function() {
          return false;
        };
        bill.style = "transform: rotate(90deg)";
        bill.style.position = 'absolute';
        bill.style.zIndex = 1000;
        moveAt(event.pageX, event.pageY);
        document.addEventListener('mousemove', onMouseMove);
        
        function moveAt(pageX, pageY) {
          bill.style.left = pageX - bill.offsetWidth / 2 + 'px';
          bill.style.top = pageY - bill.offsetHeight / 2 + 'px';
        }
        function onMouseMove(event) {
          moveAt(event.pageX, event.pageY);
        }
        
        bill.onmouseup = function() {
          document.removeEventListener('mousemove', onMouseMove);
          let bill_top = bill.offsetTop-bill.offsetWidth/2;
          let bill_left = bill.getBoundingClientRect().x;
          let bill_right= bill_left+bill.offsetHeight;
          let bill_acc_top=bill_acc.offsetTop;
          let bill_acc_bottom=bill_acc.offsetTop+bill_acc.offsetHeight;
          let bill_acc_left = bill_acc.getBoundingClientRect().x;
          let bill_acc_right= bill_acc_left+bill_acc.offsetWidth;
          if (bill_top>bill_acc_top 
          && bill_top<bill_acc_bottom-(bill_acc.offsetHeight/3)*2
          && bill_acc_left<bill_left 
          && bill_acc_right>bill_right) {
            bill.style.display = "none";
            money.value= +bill.alt+(+money.value);
            info2.innerText = money.value+"руб.";
          }
          bill.style.zIndex = 1;
          bill.onmouseup = null;
        };
        
      }
      
      function getChange(sum) {
        let left = getRandom(0,change_tray.offsetWidth-70);
        let top = getRandom(0,change_tray.offsetHeight-70);
        if (sum>=10) {
          sum-=10;
          change_tray.innerHTML+=`<img onclick='this.style.display="none";' style='left:${left}px;top:${top}px;' src='img/10rub.png'>`;
        }
        else if (sum>=5){
          sum-=5;
          change_tray.innerHTML+=`<img onclick='this.style.display="none";' style='left:${left}px;top:${top}px;' src='img/5rub.png'>`;
        }
        else if (sum>=2){
          sum-=2;
          change_tray.innerHTML+=`<img onclick='this.style.display="none";' style='left:${left}px;top:${top}px;' src='img/2rub.png'>`;
        }
        else if (sum>=1) {
          sum-=1;
          change_tray.innerHTML+=`<img onclick='this.style.display="none";' style='left:${left}px;top:${top}px;' src='img/1rub.png'>`;
        }
        else {
          money.value="";
          info2.innerText="Забрите сдачу";
          return;}
        getChange(sum);
      }
      
      function getRandom(min,max) {
        return Math.random()*(max-min)+min;
      }
    </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>