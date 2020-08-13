<script type="text/javascript">

   let tableBanner;
   let base_url = '<?= base_url();?>';

   // Show Table
   $(document).ready(function(){
      tableBanner = $('#tableBanner').DataTable({
         processing: true,
         serverSide: true,
         order: [],
         ajax: {
            'url': "<?= base_url('back/banner/ajax_list') ?>",
            'type': "POST"
         },
         columnDefs: [
            { 
               'targets': [ 0, 1, 2, 3 ], 
               'orderable': false, 
            },
         ],
      });
   });

   // Reload Button
   function reload_table(){
      tableBanner.ajax.reload(null, false);
   }

   // Save Button Modal
   function save(){
      $('#btn_save').text('Saving...');
      $('#btn_save').attr('disabled', true);
      
      var formData = new FormData($('#form')[0]);

      $.ajax({
         url: '<?= base_url('back/banner/action') ?>',
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         dataType: 'json',
         success: function(data){
            if(data.status){
               $('#modalBanner').modal('hide');
               Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  showConfirmButton: true
               });
               tableBanner.draw();
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
            $('#modalBanner').modal('hide');
            $('#btn_save').text('Simpan');
            $('#btn_save').attr('disabled', false);
         }
      }); 
   }

   //Edit  
   function edit_banner(id){
      $.ajax({
         url : '<?= base_url('back/banner/get_data/') ?>',
         data: {id: id},
         type: 'post',
         dataType: 'json',
         success: function(data){
            console.log(data);
            $('[name="id"]').val(data.id);
            $('[name="title"]').val(data.title);

            $('.modal-title').text('Edit Banner');
            $('#photo-preview').show();
            $('#modalBanner').modal('show');

            if(data.photo){
               $('#label-photo').text('Change Photo'); 

               $('#photo-preview div').html(`
               <img src="${base_url}/images/banner/${data.photo}" class="img-responsive" style="max-height:250px; max-width:650px;">`);

               $('#photo-preview div').append(`
               <br> 
               <input type="checkbox" name="remove_photo" value="${data.photo}"/> Delete Photo`); 
            }else{
               $('#photo-preview div').text('(No photo)');
            }
         },
      });
   }


</script>