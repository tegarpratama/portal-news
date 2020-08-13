<div class="container">
   <div class="row">
      <div class="col">
         <h3 class="page-header">Manajemen <?= $title ?></h3>
      </div>
   </div>

   <div class="row mt-3">
      <div class="col">
         <button type="buton" class="btn btn-success btn-sm" onclick="add_menu()">
               <i class="fas fa-plus"></i> Tambah
         </button>

         <button class="btn btn-outline-secondary btn-sm" onclick="reload_table()">
               <i class="fas fa-sync-alt"></i> Reload
         </button>
      </div>
   </div>


    <br>

   <div class="table-responsive">
      <table id="tableMenu" class="table table-striped table-bordered"  cellspacing="0" width="100%">
         <thead>
         <tr>
            <th>#</th>
            <th>Nama Menu</th>
            <th>URL</th>
            <th>Icon</th>
            <th>Aktif</th>
            <th>Action</th>
         </tr>
         </thead>
         <tbody>
         
         </tbody>
      </table>
   </div>

</div>

<!-- Modal -->
<div class="modal fade" id="modalMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
         <div class="modal-header">
         <h5 class="modal-title" id="modal-title">Edit Menu Utama</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
         </div>
         <div class="modal-body">
            <form action="#" class="form-horizontal" id="form">
            
               <input type="hidden" name="id" id="id">

               <div class="form-group row">
                  <label for="title" class="col-sm-3 col-form-label">Nama Menu</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" id="title" name="title">
                  </div>
               </div> 

               <div class="form-group row">
                  <label for="url" class="col-sm-3 col-form-label">URL</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" id="url" name="url">
                  </div>
               </div>

               <div class="form-group row">
                  <label for="icon" class="col-sm-3 col-form-label">Icon</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" id="icon" name="icon">
                  </div>
               </div>

               <div class="form-group row">
                  <label for="Active" class="col-sm-3 col-form-label">Active</label>
                  <div class="col-sm-9">
                     <select class="form-control" id="is_active" name="is_active">
                           <option value="Y">Ya</option> 
                           <option value="N">Tidak</option>
                     </select>
                  </div>
               </div>

            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-sm btn-primary" onclick="save()" id="btn_save">Simpan</button>
         </div>
      </div>
   </div>
</div>