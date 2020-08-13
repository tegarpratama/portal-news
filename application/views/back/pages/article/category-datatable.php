<script type="text/javascript">

   let tableCategory;

  // Show Table
   $(document).ready(function(){
      tableCategory = $('#tableCategory').DataTable({
         processing: true,
         serverSide: true,
         order: [],
         ajax: {
            'url': "<?= base_url('back/category/ajax_list') ?>",
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

   // Reload Button
  function reload_table(){
    tableCategory.ajax.reload(null, false);
  }

   // Save Button Modal
   function save(){
      $('#btn_save').text('Saving...');
      $('#btn_save').attr('disabled', true);

      $.ajax({
         type: 'post',
         dataType: 'json',
         url: '<?= base_url('back/category/action') ?>',
         data: $('#form').serialize(),
         success: function(data){
            if(data.status){
               $('#modalCategory').modal('hide');
               Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  showConfirmButton: true
               });
               tableCategory.draw();
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
            $('#modalCategory').modal('hide');
            $('#btn_save').text('Simpan');
            $('#btn_save').attr('disabled', false);
         }
      }); 
   }

   // Add Menu
   function add_category(){
      $('#form')[0].reset();
      $('.modal-title').text('Tambah Kategori');
      $('#modalCategory').modal('show');
   }

   //Edit  
   function edit_category(id){
      method = 'update';
      $.ajax({
         url : '<?= base_url('back/category/get_data/') ?>',
         data: {id :id},
         type: 'post',
         dataType: 'json',
         success: function(data){
            $('[name="id"]').val(data.id);
            $('[name="category_name"]').val(data.category_name);
            $('[name="is_active"]').val(data.is_active);

            $('.modal-title').text('Edit Menu');
            $('#modalCategory').modal('show');
         },
      });
   }

   // Delete Menu
   function delete_category(id){
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
               url: '<?= base_url('back/category/delete'); ?>',
               data: {
                  id: id
               },
               success: function(data){
                  if(data.status){
                     tableCategory.row( $(this).parents('tr') ).remove().draw();
                     $('#modalCategory').modal('hide');
                     Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        showConfirmButton: true
                     });
                  }
               },
               error: function(){
                  $('#modalCategory').modal('hide');
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