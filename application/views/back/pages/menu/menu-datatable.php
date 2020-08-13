<script type="text/javascript">

   let tableMenu;

   // Show Table
   $(document).ready(function(){
      tableMenu = $('#tableMenu').DataTable({
         processing: true,
         serverSide: true,
         order: [],
         ajax: {
         'url': "<?= base_url('back/menu/ajax_list') ?>",
         'type': "POST"
         },
         columnDefs: [
            { 
               'targets': [ 0, -1 ], 
               'orderable': false, 
            }
         ],
      });
   });

   // Reload Table
   function reload_table(){
      tableMenu.ajax.reload(null, false);
   }

   // Save Button Modal
   function save(){
      $('#btn_save').text('Saving...');
      $('#btn_save').attr('disabled', true);

      $.ajax({
         type: 'post',
         dataType: 'json',
         url: '<?= base_url('back/menu/action') ?>',
         data: $('#form').serialize(),
         success: function(data){
            if(data.status){
               $('#modalMenu').modal('hide');
               location.reload();
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
            $('#modalMenu').modal('hide');
            $('#btn_save').text('Simpan');
            $('#btn_save').attr('disabled', false);
         }
      }); 
   }

   // Add Menu
   function add_menu(){
      $('#form')[0].reset();
      $('.modal-title').text('Tambah Menu');
      $('#modalMenu').modal('show');
   } 

   //Edit  
   function edit_menu(id){
      $.ajax({
         url : '<?= base_url('back/menu/get_data/') ?>',
         data: {id :id},
         type: 'post',
         dataType: 'json',
         success: function(data){
            $('[name="id"]').val(data.id);
            $('[name="title"]').val(data.title);
            $('[name="url"]').val(data.url);
            $('[name="icon"]').val(data.icon);
            $('[name="is_active"]').val(data.is_active);

            $('.modal-title').text('Edit Menu');
            $('#modalMenu').modal('show');
         },
      });
   }

   // Delete Menu
   function delete_menu(id){
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
               url: '<?= base_url('back/menu/delete'); ?>',
               data: {
                  id: id
               },
               success: function(data){
                  if(data.status){
                     tableMenu.row( $(this).parents('tr') ).remove().draw();
                     $('#modalMenu').modal('hide');
                     location.reload();
                  }
               },
               error: function(){
                  $('#modalMenu').modal('hide');
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