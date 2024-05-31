<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>

<head>
  <link rel="stylesheet" type="text/css" href="./../prf_login/css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a81368914c.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    #snow {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      pointer-events: none;
      z-index: 1000;
    }



    canvas {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }
  </style>
</head>

<body>
  <?php
  $avatar = './../prf_login/img/avatar.svg';
  $month = date('m');
  if ($month > 10) {
    $avatar = './../prf_login/img/christmas_avatar.svg';
  ?>
    <div id="snow"></div>
  <?php } elseif ($month == 1) { ?>
    <canvas id="Canvas"></canvas>
  <?php } ?>
  <script>
    start_loader()
  </script>
  <img class="wave" src="./../prf_login/img/wave.png">
  <div class="container">
    <div class="img">
      <img src="./../prf_login/img/admin.svg">
    </div>
    <div class="login-content">
      <form id="login-frm" action="" method="post">
        <img src="<?php echo $avatar ?>"><br>
        <h3 class="title"><?php //echo $_settings->info('short_name'); 
                          ?> E - RECRUITMENT</h3>
        <a href="http://192.168.1.28/hr-portal/"><i class="fa fa-home" aria-hidden="true"></i> Go to HR Portal</a>
        </br>
        <div class="input-div one">
          <div class="i">
            <i class="fas fa-user"></i>
          </div>
          <div class="div">
            <!-- <h5>Username</h5> -->
            <input type="text" class="form-control" autofocus name="username" placeholder="Username">
          </div>
        </div>
        <div class="input-div pass">
          <div class="i">
            <i class="fas fa-lock"></i>
          </div>
          <div class="div">
            <!-- <h5>Password</h5> -->
            <input type="password" class="form-control" name="password" placeholder="Password">
          </div>
        </div>
        <!-- <a href="#">Forgot Password?</a> -->
        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
      </form>
    </div>
  </div>
  <script>
    var c = document.getElementById("Canvas");
    var ctx = c.getContext("2d");

    var cwidth, cheight;
    var shells = [];
    var pass = [];

    var colors = ['#FF5252', '#FF4081', '#E040FB', '#7C4DFF', '#536DFE', '#448AFF', '#40C4FF', '#18FFFF', '#64FFDA', '#69F0AE', '#B2FF59', '#EEFF41', '#FFFF00', '#FFD740', '#FFAB40', '#FF6E40'];

    window.onresize = function() {
      reset();
    }
    reset();

    function reset() {

      cwidth = window.innerWidth;
      cheight = window.innerHeight;
      c.width = cwidth;
      c.height = cheight;
    }

    function newShell() {

      var left = (Math.random() > 0.5);
      var shell = {};
      shell.x = (1 * left);
      shell.y = 1;
      shell.xoff = (0.01 + Math.random() * 0.007) * (left ? 1 : -1);
      shell.yoff = 0.01 + Math.random() * 0.007;
      shell.size = Math.random() * 6 + 3;
      shell.color = colors[Math.floor(Math.random() * colors.length)];

      shells.push(shell);
    }

    function newPass(shell) {

      var pasCount = Math.ceil(Math.pow(shell.size, 2) * Math.PI);

      for (i = 0; i < pasCount; i++) {

        var pas = {};
        pas.x = shell.x * cwidth;
        pas.y = shell.y * cheight;

        var a = Math.random() * 4;
        var s = Math.random() * 10;

        pas.xoff = s * Math.sin((5 - a) * (Math.PI / 2));
        pas.yoff = s * Math.sin(a * (Math.PI / 2));

        pas.color = shell.color;
        pas.size = Math.sqrt(shell.size);

        if (pass.length < 1000) {
          pass.push(pas);
        }
      }
    }

    var lastRun = 0;
    Run();

    function Run() {

      var dt = 1;
      if (lastRun != 0) {
        dt = Math.min(50, (performance.now() - lastRun));
      }
      lastRun = performance.now();

      //ctx.clearRect(0, 0, cwidth, cheight);
      ctx.fillStyle = "white";
      ctx.fillRect(0, 0, cwidth, cheight);

      if ((shells.length < 10) && (Math.random() > 0.96)) {
        newShell();
      }

      for (let ix in shells) {

        var shell = shells[ix];

        ctx.beginPath();
        ctx.arc(shell.x * cwidth, shell.y * cheight, shell.size, 0, 2 * Math.PI);
        ctx.fillStyle = shell.color;
        ctx.fill();

        shell.x -= shell.xoff;
        shell.y -= shell.yoff;
        shell.xoff -= (shell.xoff * dt * 0.001);
        shell.yoff -= ((shell.yoff + 0.2) * dt * 0.00005);

        if (shell.yoff < -0.005) {
          newPass(shell);
          shells.splice(ix, 1);
        }
      }

      for (let ix in pass) {

        var pas = pass[ix];

        ctx.beginPath();
        ctx.arc(pas.x, pas.y, pas.size, 0, 2 * Math.PI);
        ctx.fillStyle = pas.color;
        ctx.fill();

        pas.x -= pas.xoff;
        pas.y -= pas.yoff;
        pas.xoff -= (pas.xoff * dt * 0.001);
        pas.yoff -= ((pas.yoff + 5) * dt * 0.0005);
        pas.size -= (dt * 0.002 * Math.random())

        if ((pas.y > cheight) || (pas.y < -50) || (pas.size <= 0)) {
          pass.splice(ix, 1);
        }
      }
      requestAnimationFrame(Run);
    }
  </script>
  <script>
    $(document).ready(function() {
      var d = new Date();

      var sound = new Audio("jingle_bells.mp3");
      sound.loop = true;

      function playAudio() {
        sound.play();
      }
      if ((d.getMonth() + 1) > 10) {
        setInterval(playAudio, 500);
      }
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var script = document.createElement('script');
      script.src = 'https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js';
      script.onload = function() {
        particlesJS("snow", {
          "particles": {
            "number": {
              "value": 200,
              "density": {
                "enable": true,
                "value_area": 800
              }
            },
            "color": {
              "value": "#ffffff"
            },
            "opacity": {
              "value": 0.7,
              "random": false,
              "anim": {
                "enable": false
              }
            },
            "size": {
              "value": 5,
              "random": true,
              "anim": {
                "enable": false
              }
            },
            "line_linked": {
              "enable": false
            },
            "move": {
              "enable": true,
              "speed": 5,
              "direction": "bottom",
              "random": true,
              "straight": false,
              "out_mode": "out",
              "bounce": false,
              "attract": {
                "enable": true,
                "rotateX": 300,
                "rotateY": 1200
              }
            }
          },
          "interactivity": {
            "events": {
              "onhover": {
                "enable": false
              },
              "onclick": {
                "enable": false
              },
              "resize": false
            }
          },
          "retina_detect": true
        });
      }
      document.head.append(script);
    });
  </script>
  <script type="text/javascript" src="./../prf_login/js/main.js"></script>
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <script>
    $(document).ready(function() {
      end_loader();
    })
  </script>
</body>

</html>