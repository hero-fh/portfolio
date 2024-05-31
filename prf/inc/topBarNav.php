<nav class="navbar navbar-dark navbar-expand-lg bg-success" id="topNavBar">
  <div class="container-fluid px-4 px-lg-5 ">
    <button class="navbar-toggler btn btn-sm" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" id="button1" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
    <a class="navbar-brand" href="">
      <img src="<?php echo base_url . ($_settings->info('logo')) ?>" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
      <?php echo $_settings->info('short_name') ?>
    </a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
        <!-- <li class="nav-item"><a class="nav-link <?= isset($page) && $page == 'home' ? "active" : '' ?>" aria-current="page" href="./">Home</a></li> -->
        <!-- <li class="nav-item"><a class="nav-link <?= isset($page) && $page == 'registration' ? "active" : '' ?>" href="./?p=registration">Registration</a></li>
        <li class="nav-item"><a class="nav-link <?= isset($page) && $page == 'exams' ? "active" : '' ?>" href="./?p=exams">Exams</a></li> -->
        <!-- <li class="nav-item"><a class="nav-link <?= isset($page) && $page == 'about' ? "active" : '' ?>" href="./?p=about">About Us</a></li> -->
      </ul>
    </div>
    <div class="d-flex align-items-center ">
      <?php if (!isset($_SESSION['userdata']['id'])) : ?>
        <a href="<?php echo base_url ?>prf/login.php" class="btn btn-outline-light ml-2 log" id="login-btn" type="button">Login</a>
      <?php else : ?>
        <ul class="navbar-nav">
          <li class="nav-item">
            <div class="btn-group nav-link">
              <button type="button" class="btn btn-rounded text-light dropdown-toggle dropdown-icon" data-toggle="dropdown">
                <span class="ml-3"><b> Hi, <?php echo $_settings->userdata('username') ?>!</b></span>
                <span class="sr-only">Toggle Dropdown</span>
              </button>
              <div class="dropdown-menu" role="menu">
                <a class="dropdown-item" href="<?php echo base_url . 'prf/?p=manage_user' ?>"><span class="fa fa-user"></span>My Account</a>
                <div class="dropdown-divider"></div>
                <a href="javascript:void(0)" class="text-dark dropdown-item logout nav-link"><span class="fa fa-sign-out-alt"> </span>Logout</a>
              </div>
            </div>
          </li>
          <!-- <a href="" class="text-light  nav-link"><b> Hi, <?php echo $_settings->userdata('username') ?>!</b></a>
          <a href="javascript:void(0)" class="text-dark logout nav-link ml-3"><i class="fa fa-sign-out-alt"> </i></a> -->
        <?php endif; ?>
    </div>
  </div>
</nav>
<script>
  $(document).ready(function() {
    $('.logout').click(function() {
      _conf("Are you sure to Log out of session?", "delete_user")
    })

  })

  function delete_user() {
    $.ajax({
      url: _base_url_ + "logout.php",
      success: function() {
        alert_toast("Logout Successful", 'success');
        setTimeout(() => {
          location.replace('./')
        }, 1000);
      }
    })
  }
  $(function() {
    $('.log').click(function() {
      uni_modal("", "login_modal.php")
    })
    $('#navbarResponsive').on('show.bs.collapse', function() {
      $('#mainNav').addClass('navbar-shrink')
    })
    $('#navbarResponsive').on('hidden.bs.collapse', function() {
      if ($('body').offset.top == 0)
        $('#mainNav').removeClass('navbar-shrink')
    })
  })

  $('#search-form').submit(function(e) {
    e.preventDefault()
    var sTxt = $('[name="search"]').val()
    if (sTxt != '')
      location.href = './?p=products&search=' + sTxt;
  })
</script>