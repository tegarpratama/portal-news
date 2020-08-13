<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin - <?= $title ?></title>

  <!-- Font Awesome -->
  <link href="<?= base_url("assets/back/vendors/fontawesome-free/css/all.min.css") ?>" rel="stylesheet" type="text/css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Datatables -->
  <link href="<?= base_url("assets/back/vendors/datatables/dataTables.bootstrap4.min.css") ?>" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="<?= base_url("assets/back/css/sb-admin-2.min.css") ?>" rel="stylesheet">

  <link rel="stylesheet" href="<?= base_url("assets/back/vendors/summernote/dist/summernote-bs4.min.css") ?>">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php $this->load->view('back/layouts/_sidebar') ?>

    <!-- Content Wrapper -->

    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php $this->load->view('back/layouts/_navbar') ?>

        <!-- Begin Page Content -->
        <?php $this->load->view('back/pages/'. $page) ?>

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php $this->load->view('back/layouts/_footer') ?>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


  <!-- Core JavaScript-->
  <script src="<?= base_url("assets/back/vendors/jquery/jquery.min.js") ?>"></script>
  <script src="<?= base_url("assets/back/vendors/popper/popper.min.js") ?>"></script>
  <script src="<?= base_url("assets/back/vendors/bootstrap/js/bootstrap.min.js") ?>"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url("assets/back/vendors/jquery-easing/jquery.easing.min.js") ?>"></script>

  <!-- Datatables -->
  <script src="<?= base_url("assets/back/vendors/datatables/jquery.dataTables.min.js") ?>"></script>
  <script src="<?= base_url("assets/back/vendors/datatables/dataTables.bootstrap4.min.js") ?>"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url("assets/back/js/sb-admin-2.min.js") ?>"></script>

  <!-- Page level plugins -->
  <script src="<?= base_url("assets/back/vendors/chart.js/Chart.min.js") ?>"></script>

  <!-- Sweet Alert 2 -->
  <script src="<?= base_url("assets/back/vendors/sweetalert2/sweetalert2.js") ?>"></script>
  

  <!-- For Datatable -->
  <?php 
    if(isset($datatable)){
      $this->load->view('back/pages/'. $datatable);
    }
  ?>

  <!-- For Chart in Dashboard -->
  <?php 
    if(isset($pageChart)){
      $this->load->view('back/layouts/'. $pageChart);
    }
  ?>


</body>

</html>
