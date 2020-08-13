<script type="text/javascript">

   let tablePosting;
   let base_url = '<?= base_url();?>';

   // Show Table
   $(document).ready(function(){

      tablePosting = $('#tablePosting').DataTable({
         processing: true,
         serverSide: true,
         order: [ 0, 'desc' ],
         ajax: {
            'url': "<?= base_url('back/posting/ajax_list') ?>",
            'type': "POST"
         },
         columnDefs: [
            { 
               'targets': [  0, -1 ], 
               'orderable': false, 
            },
            { 'width': '5px', 'targets': 0 },
            { 'width': '5px', 'targets': 2 },
            { 'width': '5px', 'targets': 3 },
            { 'width': '5px', 'targets': 4 },
            { 'width': '5px', 'targets': 6 },
         ],
         lengthMenu: [[5, 10, 50, -1], [5, 10, 50, "All"]]
      });

   });


   // Reload Button
   function reload_table(){
      tablePosting.ajax.reload(null, false);
   }

   //check all
   $("#check-all").click(function () {
      $(".data-check").prop('checked', $(this).prop('checked'));
   });

   // Delete Menu
   function delete_posting(id){
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
               url: '<?= base_url('back/posting/delete'); ?>',
               data: {
                  id: id
               },
               success: function(data){
                  if(data.status){
                     tablePosting.row( $(this).parents('tr') ).remove().draw();
                     $('#modalPosting').modal('hide');
                     Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        showConfirmButton: true
                     });
                  }
               },
               error: function(){
                  $('#modalPosting').modal('hide');
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

   function bulk_delete(){
      var list_id = [];
      $(".data-check:checked").each(function() {
         list_id.push(this.value);
      });
      if(list_id.length > 0){
         Swal.fire({
         title: 'Are you sure delete this '+list_id.length+' data?',
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
                  url: '<?= base_url('back/posting/bulk_delete'); ?>',
                  data: {
                     id: list_id
                  },
                  success: function(data){
                     if(data.status){
                        tablePosting.row( $(this).parents('tr') ).remove().draw();
                        $('#modalPosting').modal('hide');
                        Swal.fire({
                           icon: 'success',
                           title: 'Success',
                           showConfirmButton: true
                        });
                        reload_table();
                     }
                  },
                  error: function(){
                     $('#modalPosting').modal('hide');
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
      }else{
         Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Tidak Ada Data Dipilih!',
            showConfirmButton: true
         });
      }
   }

   

</script>

