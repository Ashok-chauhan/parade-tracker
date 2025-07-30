<!DOCTYPE html>
<html lang="en">

<head>
  <title>Parade Tracker</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo base_url() ?>css/style.css?v=1.0" />
  <link rel="stylesheet" href="<?php echo base_url() ?>css/routemanagement.css?v=1.0" />
  <script src="<?php echo base_url() ?>js/confirmation.js?v=1.0"></script>


</head>

<header>
  <div style="float:left; width: 20%;"> <a href="http://www.wdsu.com">
      <image src="<?php echo base_url() ?>assets/WDSULogo.png">
    </a> </div>
  <div style=" float: left; width: 60%">
    <h2>Parade tracker</h2>
    <p><small>For support please email <a href="mailto:support@whizti.com" target="_top"> support@whizti.com
        </a></small></p>
  </div>
  <div style="float:left; width: 20%;"><a href="https://www.whizti.com/">
      <image src="<?php echo base_url() ?>assets/whiz-whitelogo-inner.gif">
    </a></div>

</header>

<section>

  <?php if ($this->session->userdata('type') == 'admin') { ?>
    <nav>
      <ul>
        <li><?php print anchor('parade', 'Home'); ?></li>
        <li><a href="<?php echo base_url() ?>parade/createParade"> Create </a></li>
        <li><a href="<?php echo base_url() ?>parade/config"> App Settings </a></li>
        <!--      <li><a href="<?php //echo base_url() ?>route"> Today's Parades </a></li>-->
        <li><a href="<?php echo base_url() ?>registration/"> Registration </a></li>
        <li><a href="<?php echo base_url() ?>registration/registeredusers"> Users </a></li>
        <li><?php print anchor('users/logout', 'Log out'); ?></li>
      </ul>
    </nav>
  <?php } else if ($this->session->userdata('type') == 'user') { ?>
      <nav>
        <ul>
          <li><?php print anchor('home', 'Home'); ?></li>
          <li><a href="<?php echo base_url() ?>parade/"> Parades</a></li>
          <li><a href="<?php echo base_url() ?>parade/createParade"> Create parade</a></li>
          <li><?php print anchor('routemanagement/', 'Copy route'); ?></li>
          <li><?php print anchor('routemanagement/manage', 'Manage route'); ?></li>

          <li><?php print anchor('pointofinterest/', 'Interest point'); ?></li>

        <?php if ($this->session->userdata('type') != '') { ?>
            <li><?php print anchor('users/logout', 'Log out'); ?></li>
        <?php } ?>
        </ul>
      </nav>
  <?php } else { ?>
      <nav>
        <ul>
          <li><?php print anchor('home', 'Home'); ?></li>

        </ul>
      </nav>
  <?php } ?>

  <article>