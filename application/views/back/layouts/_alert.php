<!-- <?php 
  $success = $this->session->flashdata('success');
  $error = $this->session->flashdata('error');
  $warning = $this->session->flashdata('warning');

  if($success){
    $alert_status = 'alert-success';
   //  $status = 'Berhasil,';
    $message = $success;
  }else if($error){
    $alert_status = 'alert-danger';
   //  $status = 'Oops,';
    $message = $error;
  }else if($warning){
    $alert_status = 'alert-warning';
   //  $status = 'Oops,';
    $message = $warning;
  }

?>

<?php if($success || $error || $warning) : ?>
<div class="alert <?= $alert_status ?> alert-dismissible fade show text-center" role="alert">
  <?= $message ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php endif; ?> -->