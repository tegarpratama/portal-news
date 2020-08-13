<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin - Garsansnews.com</title>

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
        <div class="container">

            <div class="row">
               <div class="col">
                  <h3 class="page-header">Tambah Posting</h3>
               </div>
            </div>

            <br>

            <?= form_open_multipart($form_action) ?>

               <!-- <?php var_dump($input) ?> -->

               <?= isset($input->id) ? form_hidden('id', $input->id) : '' ?>
            
               <div class="form-group row">
                  <label for="title" class="col-sm-2 col-form-label"><span class="text-danger">*</span> Judul Artikel</label>
                  <div class="col-sm-10">
                     <?= form_input('title', $input->title, ['class' => 'form-control', 'id' => 'title', 'required' => true, 'autofocus' => true, 'autocomplete' => 'off']) ?>
                     <?= form_error('title', '<small class="form-text text-danger">', '</small>') ?>
                  </div>
               </div> 

               <div class="form-group row">
                  <label for="article" class="col-sm-2 col-form-label"><span class="text-danger">*</span> Konten</label>
                  <div class="col-sm-10">
                     <?= form_textarea('content', $input->content, ['row' => 4, 'class' => 'form-control', 'id' => 'summernote']); ?>
                     <?= form_error('content', '<small class="form-text text-danger">', '</small>') ?>
                  </div>
               </div>

               <div class="form-group row">
                  <div class="col">
                     <label for="featured" class="col-form-label">Featured</label>
                     <select class="form-control" id="featured" name="featured">
                        <option value="N" <?php if($input->featured == "N"){ print ' selected'; }?>>Tidak</option>
                        <option value="Y" <?php if($input->featured == "Y"){ print ' selected'; }?>>Ya</option> 
                     </select>
                  </div>

                  <div class="col">
                     <label for="choice" class="col-form-label">Editor's Choice</label>
                     <select class="form-control" id="choice" name="choice">
                        <option value="N" <?php if($input->choice == "N"){ print ' selected'; }?>>Tidak</option>
                        <option value="Y" <?php if($input->choice == "Y"){ print ' selected'; }?>>Ya</option> 
                     </select>
                  </div>

                  <div class="col">
                     <label for="thread" class="col-form-label">Popular News</label>
                     <select class="form-control" id="thread" name="thread">
                        <option value="N" <?php if($input->thread == "N"){ print ' selected'; }?>>Tidak</option>
                        <option value="Y" <?php if($input->thread == "Y"){ print ' selected'; }?>>Ya</option> 
                     </select>
                  </div>

                  <div class="col">
                     <label for="category" class="col-form-label"><span class="text-danger">*</span> Kategori</label>
                     <select class="form-control" id="id_category" name="id_category">
                        <option value="">- Pilih -</option>
                        <?php foreach($category as $c) : ?>
                           <option value="<?= $c->id ?>" <?php if($c->id == $input->id_category){ print ' selected'; }?>><?= $c->category_name ?></option> 
                        <?php endforeach ?>
                     </select>
                     <?= form_error('id_category', '<small class="form-text text-danger">', '</small>') ?>
                  </div>
                  
                  <div class="col">
                     <label for="is_active" class="col-form-label">Aktif</label>
                     <select class="form-control" id="is_active" name="is_active">
                        <option value="Y" <?php if($input->is_active == "Y"){ print ' selected'; }?>>Ya</option> 
                        <option value="N" <?php if($input->is_active == "N"){ print ' selected'; }?>>Tidak</option>
                     </select>
                  </div>
               </div>
               
               <div class="form-group row">
                  <label for="" class="col-sm-2 col-form-label">Gambar</label>
                  <br>
                  <div class="col-sm-10">
                     <?= form_upload('photo') ?>
                     <?php if($this->session->flashdata('image_error')) :  ?>
                        <small class="form-text text-danger">
                           <?= $this->session->flashdata('image_error') ?>
                        </small>
                     <?php endif ?>
                     <?php if(!empty($input->photo)) : ?>
                        <img src="<?= base_url("images/posting/$input->photo") ?>" alt="" height="150">
                     <?php endif; ?>
                  </div>
               </div>

               <a href="<?= base_url('admin/posting') ?>" class="btn btn-sm btn-secondary">Kembali</a>
               <button type="submit" class="btn btn-sm btn-primary float-right">Simpan</button>

            <?= form_close() ?>
         
         </div>

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
   <!-- Summernote -->
   <script src="<?= base_url("assets/back/vendors/summernote/dist/summernote-bs4.min.js") ?>"></script>

   <script>
   $('#summernote').summernote({
      height: 300,
   });
   </script>


</body>

</html>




