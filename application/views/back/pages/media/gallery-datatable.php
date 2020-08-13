<script type="text/javascript">

   let tableGallery;
   let base_url = '<?= base_url();?>';

   // Show Table
   $(document).ready(function(){
      tableGallery = $('#tableGallery').DataTable({
         processing: true,
         serverSide: true,
         order: [],
         ajax: {
            'url': "<?= base_url('back/gallery/ajax_list') ?>",
            'type': "POST"
         },
         columnDefs: [
            { 
               'targets': [ 0, 2, 4, 6 ], 
               'orderable': false, 
            },
            { 'width': '5px', 'targets': 5 },
         ],
      });
   });

   // Reload Button
   function reload_table(){
      tableGallery.ajax.reload(null, false);
   }

   // Save Button Modal
   function save(){
      $('#btn_save').text('Saving...');
      $('#btn_save').attr('disabled', true);
      
      var formData = new FormData($('#form')[0]);

      $.ajax({
         url: '<?= base_url('back/gallery/action') ?>',
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         dataType: 'json',
         success: function(data){
            if(data.status){
               $('#modalGallery').modal('hide');
               Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  showConfirmButton: true
               });
               tableGallery.draw();
            }else{
               Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Terjadi Suatu Kesalahan!',
                  showConfirmButton: true
               });
               $('#modalGallery').modal('hide');
               $('#btn_save').text('Simpan');
               $('#btn_save').attr('disabled', false);
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
            $('#modalGallery').modal('hide');
            $('#btn_save').text('Simpan');
            $('#btn_save').attr('disabled', false);
         }
      }); 
   }

   // Add Menu
   function add_gallery(){
      $('#form')[0].reset();
      $('.modal-title').text('Tambah Galeri');
      $('#photo-preview').hide(); 
      $('#modalGallery').modal('show');
   } 

   //Edit  
   function edit_gallery(id){
      $.ajax({
         url : '<?= base_url('back/gallery/get_data/') ?>/',
         data: {id: id},
         type: 'post',
         dataType: 'json',
         success: function(data){
            console.log(data);
            $('[name="id"]').val(data.id);
            $('[name="gallery_name"]').val(data.gallery_name);
            $('[name="id_album"]').val(data.id_album);
            $('[name="information"]').val(data.information);
            $('[name="is_active"]').val(data.is_active);

            $('.modal-title').text('Edit Galeri');
            $('#photo-preview').show();
            $('#modalGallery').modal('show');

            if(data.photo){
               $('#label-photo').text('Change Photo'); 

               $('#photo-preview div').html(`
               <img src="${base_url}/images/gallery/${data.photo}" class="img-responsive" style="max-height:250px;">`);

               $('#photo-preview div').append(`
               <br> 
               <input type="checkbox" name="remove_photo" value="${data.photo}"/> Delete Photo`); 
            }else{
               $('#photo-preview div').text('(No photo)');
            }
         },
      });
   }

   // Delete Menu
   function delete_gallery(id){
      Swal.fire({
         title: 'Apakah anda yakin?',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Hapus!'
         }).then((result) => {
         if (result.value) {
            $.ajax({
               type: 'post',
               dataType: 'json',
               url: '<?= base_url('back/gallery/delete'); ?>',
               data: {
                  id: id
               },
               success: function(data){
                  if(data.status){
                     Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        showConfirmButton: true
                     });
                     tableGallery.row( $(this).parents('tr') ).remove().draw();
                     $('#modalGallery').modal('hide');
                     tableGallery.draw();
                  }
               },
               error: function(){
                  $('#modalGallery').modal('hide');
                  Swal.fire({
                     icon: 'error',
                     title: 'Oops...',
                     text: 'Terjadi Suatu Kesalahan!',
                     showConfirmButton: true
                  });
               }
            });
         }
      });
   }

</script>