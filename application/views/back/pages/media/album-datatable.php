<script type="text/javascript">

   let tableAlbum;
   let base_url = '<?= base_url();?>';

   // Show Table
   $(document).ready(function(){

      tableAlbum = $('#tableAlbum').DataTable({
         processing: true,
         serverSide: true,
         order: [],
         ajax: {
            'url': "<?= base_url('back/album/ajax_list') ?>",
            'type': "POST"
         },
         columnDefs: [
            { 
               'targets': [ 0, -1 ], 
               'orderable': false, 
            },
            { 'width': '5px', 'targets': 4 }
         ],
      });
   });

   // Reload Table
   function reload_table(){
      tableAlbum.ajax.reload(null, false);
   }

   // Save Button Modal
   function save(){
      $('#btn_save').text('Saving...');
      $('#btn_save').attr('disabled', true);
      
      var formData = new FormData($('#form')[0]);

      $.ajax({
         url: '<?= base_url('back/album/action') ?>',
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         dataType: 'json',
         success: function(data){
            if(data.status){
               $('#modalAlbum').modal('hide');
               Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  showConfirmButton: true
               });
               tableAlbum.draw();
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
            $('#modalAlbum').modal('hide');
            $('#btn_save').text('Simpan');
            $('#btn_save').attr('disabled', false);
         }
      }); 
   }

   // Add Menu
   function add_album(){
      $('#form')[0].reset();
      $('.modal-title').text('Tambah Album');
      $('#photo-preview').hide(); 
      $('#modalAlbum').modal('show');
   } 

   //Edit  
   function edit_album(id){
      $.ajax({
         url : '<?= base_url('back/album/get_data/') ?>/',
         data: {id: id},
         type: 'post',
         dataType: 'json',
         success: function(data){
            $('[name="id"]').val(data.id);
            $('[name="album_name"]').val(data.album_name);
            $('[name="is_active"]').val(data.is_active);

            $('.modal-title').text('Edit Album');
            $('#photo-preview').show();
            $('#modalAlbum').modal('show');

            if(data.photo){
               $('#label-photo').text('Change Photo'); 

               $('#photo-preview div').html(`
               <img src="${base_url}/images/album/${data.photo}" class="img-responsive" style="max-height:150px; "max-width:250px;"">`);

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
   function delete_album(id){
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
               url: '<?= base_url('back/album/delete'); ?>',
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
                     tableAlbum.row( $(this).parents('tr') ).remove().draw();
                     $('#modalAlbum').modal('hide');
                     tableAlbum.draw();
                  }
               },
               error: function(){
                  $('#modalAlbum').modal('hide');
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