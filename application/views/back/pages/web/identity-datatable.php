<script type="text/javascript">

   let tableIdentity;
   let base_url = '<?= base_url();?>';

   // Show Table
   $(document).ready(function(){

      tableIdentity = $('#tableIdentity').DataTable({
         processing: true,
         serverSide: true,
         order: [],
         ajax: {
            'url': "<?= base_url('back/identity/ajax_list') ?>",
            'type': "POST"
         },
         columnDefs: [
            { 
               'targets': [ 0, 1, 2 ], 
               'orderable': false, 
            }
         ],
      });

   });

   // Reload Table
   function reload_table(){
      tableIdentity.ajax.reload(null, false);
   }

   //Edit  
   function edit_identity(id){
      $('#form')[0].reset();
      $.ajax({
         url : '<?= base_url('back/identity/get_data/') ?>',
         data: {id: id},
         type: 'post',
         dataType: 'json',
         success: function(data){
            $('[name="id"]').val(data.id);
            $('[name="web_name"]').val(data.web_name);
            $('[name="web_address"]').val(data.web_address);
            $('[name="meta_description"]').val(data.meta_description);
            $('[name="meta_keyword"]').val(data.meta_keyword);

            $('.modal-title').text('Edit Identitas Website');
            $('#photo-preview').show();
            $('#modalIdentity').modal('show');

            if(data.photo){
               $('#label-photo').text('Change Photo'); 
               $('#photo-preview div').html(`<img src="${base_url}images/favicon/${data.photo}" class="img-responsive" style="max-width:200px;">`);
               $('#photo-preview div').append(`<br><br><input type="checkbox" name="remove_photo" value="${data.photo}"/> Delete Photo`); 

            }else{
               $('#label-photo').text('Upload Photo'); 
               $('#photo-preview div').text('(No photo)');
            }
         },
      });
   }

   // Save Button Modal
   function save(){
      $('#btn_save').text('Saving...');
      $('#btn_save').attr('disabled', true);

      var formData = new FormData($('#form')[0]);
      
      $.ajax({
         url: '<?= base_url('back/identity/update')?>',
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         dataType: 'json',
         success: function(data){
            if(data.status){
               $('#modalIdentity').modal('hide');
               Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  showConfirmButton: true
               });
               tableIdentity.draw();
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
            $('#modalIdentity').modal('hide');
            $('#btn_save').text('Simpan');
            $('#btn_save').attr('disabled', false);
         }
      }); 
   }

</script>