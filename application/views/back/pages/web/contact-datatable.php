<script type="text/javascript">

   let tableContact;

   $(document).ready(function(){
      tableContact = $('#tableContact').DataTable({
         processing: true,
         serverSide: true,
         order: [],
         ajax: {
         'url': "<?= base_url('back/contact/ajax_list') ?>",
         'type': "POST"
         },
         columnDefs: [
            { 
               'targets': [0, 1, 2, 3], 
               'orderable': false, 
            }
         ],
      });
   });

   // Reload Table
   function reload_table(){
      tableContact.ajax.reload(null, false);
   }

   //Edit  
   function edit_contact(id){
      $('#form')[0].reset();

      $.ajax({
         url : '<?= base_url('back/contact/get_data/') ?>',
         data: {id: id},
         type: 'post',
         dataType: 'json',
         success: function(data){
            $('[name="id"]').val(data.id);
            $('[name="contact_name"]').val(data.contact_name);
            $('[name="description"]').val(data.description);

            $('.modal-title').text('Edit Kontak Website');
            $('#modalContact').modal('show');
         },
      });
   }

   // Save Button Modal
   function save(){
      $('#btn_save').text('Saving...');
      $('#btn_save').attr('disabled', true);

      $.ajax({
         type: 'post',
         dataType: 'json',
         url: '<?= base_url('back/contact/update') ?>',
         data: $('#form').serialize(),
         success: function(data){
         if(data.status){
            $('#modalContact').modal('hide');
            Swal.fire({
               icon: 'success',
               title: 'Success',
               showConfirmButton: true
            });
            tableContact.draw();
         }
         $('#btn_save').text('Simpan');
         $('#btn_save').attr('disabled', false);
         },
         error: function(){
         Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Terjadi Suatu Kesalahan!',
            showConfirmButton: true
         });
         $('#modalContact').modal('hide');
         $('#btn_save').text('Simpan');
         $('#btn_save').attr('disabled', false);
         }
      }); 
   }

</script>