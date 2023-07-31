<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Scan ticket system admin panel</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" href="js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/select2/select2.min.css">
  <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <!-- End plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" href="js/select.dataTables.min.css">
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
   <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="favicon.ico" />
  <script src="/admin/js/jquery.min.js"></script>
</head>
<style>
  .loader-wrapper {
        position: fixed; /* or absolute */
        top: 50%;
        left: 50%;
        width: 200px;
        height:100px;
        margin: -50px 0 0 -100px;
        z-index: 100000;
        transition: transform 0.7s ease;
    }
    @media (max-width: 991px){
      .loader-wrapper {
          margin: -50px 0 0 -150px;
      }
    }
</style>
<?php
  session_start();
  //session_regenerate_id();
  if(!isset($_SESSION['user_id']))      // if there is no valid session
  {
    header ('Location: http://'.$_SERVER['SERVER_ADDR'].'/admin/login.php');
  }

  if($_SESSION['user_role'] == 'ctrl'){
    header ('Location: http://'.$_SERVER['SERVER_ADDR']);
    exit;
  }

?>
  <style>

  @media (max-width: 991px){
    .navbar .navbar-brand-wrapper .navbar-brand.brand-logo-mini {
      display: inline-block;
      padding-left: 5px !important;
    }
  }
</style>

<?php
    include '../classes.php';
    $set = new Settings();
    switch($set->lang){
      case 'ukr':
        include '../lang/ukr_lang.php';
        break;

      case 'eng':
        include '../lang/eng_lang.php';
        break;

    }


    $event = new Event();
?>
