<?php $this->load->view('auth/templates/header') ?>

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
                     <h3 class="page-header">My Profile</h3>
                  </div>
               </div> 
               
               <div class="row">
                  <div class="col-md-6">
                     <?php if($message) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                           <div id="infoMessage"><?= $message;?></div>
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                     <?php endif ?>
                  </div>
               </div>

               <?= form_open(uri_string());?>
               <div class="form-row mt-3">
                  <div class="form-group col-md-4">
                     <label for="inputEmail4">Nama Depan</label>
                     <?= form_input($first_name, '',['class' => 'form-control', 'autocomplete' => 'off']);?>
                  </div>
                  <div class="form-group col-md-4">
                     <label for="inputPassword4">Nama Belakang</label>
                     <?= form_input($last_name, '',['class' => 'form-control', 'autocomplete' => 'off']);?>
                  </div>
               </div>

               <div class="form-row ">
                  <div class="form-group col-md-4">
                     <label for="inputEmail4">Email</label>
                     <?= form_input($email, '',['class' => 'form-control', 'autocomplete' => 'off']);?>
                  </div>
                  <div class="form-group col-md-4">
                     <label for="inputPassword4">No. Telepon</label>
                     <?= form_input($phone, '',['class' => 'form-control', 'autocomplete' => 'off']);?>
                  </div>
               </div>

               <div class="form-row ">
                  <div class="form-group col-md-4">
                     <label for="inputEmail4">Password (jika ingin diubah)</label>
                     <?= form_input($password, '',['class' => 'form-control']);?>
                  </div>
                  <div class="form-group col-md-4">
                     <label for="inputPassword4">Konfirmasi Password</label>
                     <?= form_input($password_confirm, '',['class' => 'form-control']);?>
                  </div>
               </div>

               <?php if ($this->ion_auth->is_admin()): ?>

                  <h3><?= lang('edit_user_groups_heading');?></h3>
                  <?php foreach ($groups as $group):?>
                     <label class="checkbox">
                     <?php
                           $gID=$group['id'];
                           $checked = null;
                           $item = null;
                           foreach($currentGroups as $grp) {
                              if ($gID == $grp->id) {
                                 $checked= ' checked="checked"';
                              break;
                              }
                           }
                     ?>
                     <input type="checkbox" name="groups[]" value="<?= $group['id'];?>"<?= $checked;?>>
                     <?= htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
                     </label>
                  <?php endforeach?>

               <?php endif ?>

               <?= form_hidden('id', $user->id);?>
               <?= form_hidden($csrf); ?>
               
               <br><br>

               <div class="row">
                  <div class="col-8">
                     <a href="<?= base_url('admin'); ?>" class="btn btn-secondary btn-sm">Kembali</a>
                     <?= form_submit('submit', 'Simpan', ['class' => 'btn btn-primary btn-sm float-right']);?>

                  </div>
               </div>

               <?= form_close();?>
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

<?php $this->load->view('auth/templates/footer') ?>
