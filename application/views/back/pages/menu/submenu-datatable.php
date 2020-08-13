<script type="text/javascript">

   let tableSubmenu;

   // Show Table
   $(document).ready(function(){
      tableSubmenu = $('#tableSubmenu').DataTable({
         processing: true,
         serverSide: true,
         order: [],
         ajax: {
            'url': "<?= base_url('back/submenu/ajax_list') ?>",
            'type': "POST"
         },
         columnDefs: [
            { 
               'targets': [ 0, -1 ], 
               'orderable': false, 
            }
         ],
         lengthMenu: [[5, 10, 50, -1], [5, 10, 50, "All"]]
      });
   });

  // Reload Button
  function reload_table(){
    tableSubmenu.ajax.reload(null, false);
  }

   // Save Button Modal
   function save(){
      $('#btn_save').text('Saving...');
      $('#btn_save').attr('disabled', true);

      $.ajax({
         type: 'post',
         dataType: 'json',
         url: '<?= base_url('back/submenu/action') ?>',
         data: $('#form').serialize(),
         success: function(data){
            if(data.status){
               $('#modalSubmenu').modal('hide');
               location.reload();
            }
            $('#btnSave').text('Simpan');
            $('#btnSave').attr('disabled', false);
         },
         error: function(){
            Swal.fire({
               icon: 'error',
               title: 'Oops...',
               text: 'Terjadi Suatu Kesalahan!',
               showConfirmButton: true
            });
            $('#modalSubmenu').modal('hide');
            $('#btn_save').text('Simpan');
            $('#btn_save').attr('disabled', false);
         }
      }); 
   }

   // Add Menu
   function add_submenu(){
      $('#form')[0].reset();
      $('.modal-title').text('Tambah Submenu');
      $('#modalSubmenu').modal('show');
   } 

   //Edit  
   function edit_submenu(id){
      $.ajax({
         url : '<?= base_url('back/submenu/get_data/') ?>',
         data: {id :id},
         type: 'post',
         dataType: 'json',
         success: function(data){
            $('[name="id"]').val(data.id);
            $('[name="sub_title"]').val(data.sub_title);
            $('[name="sub_url"]').val(data.sub_url);
            $('[name="id_menu"]').val(data.id_menu);
            $('[name="is_active"]').val(data.is_active);

            $('.modal-title').text('Edit Menu');
            $('#modalSubmenu').modal('show');
         },
      });
   }

   // Delete Menu
   function delete_submenu(id){
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
               url: '<?= base_url('back/submenu/delete'); ?>',
               data: {
                  id: id
               },
               success: function(data){
                  if(data.status){
                     tableSubmenu.row( $(this).parents('tr') ).remove().draw();
                     $('#modalSubmenu').modal('hide');
                     location.reload();
                  }
               },
               error: function(){
                  $('#modalSubmenu').modal('hide');
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
