<div class="container">
   <div class="row">
      <div class="col">
         <h3 class="page-header">Manajemen <?= $title ?></h3>
      </div>
   </div>

   <button class="btn btn-outline-secondary btn-sm mt-3"onclick="reload_table()">
      <i class="fas fa-sync-alt"></i> Reload
   </button>

   <br><br>

   <div class="table-responsive">
      <table id="tableContact" class="table table-striped table-bordered"  cellspacing="0" width="100%">
         <thead>
         <tr>
            <th>#</th>
            <th>Nama Kontak</th>
            <th>Deskripsi</th>
            <th>Action</th>
         </tr>
         </thead>
         <tbody>
         
         </tbody>
      </table>
   </div>

</div>

<!-- Modal -->
<div class="modal fade" id="modalContact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
         <h5 class="modal-title" id="modal-title">Menu Kontak</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
         </div>
         <div class="modal-body">
         <form action="#" class="form-horizontal" id="form">
         
            <input type="hidden" name="id" id="id">

            <div class="form-group row">
               <label for="contact" class="col-sm-3 col-form-label">Nama Kontak</label>
               <div class="col-sm-9">
               <input type="text" class="form-control" id="contact_name" name="contact_name">
               </div>
            </div> 

            <div class="form-group row">
               <label for="description" class="col-sm-3 col-form-label">Deskripsi</label>
               <div class="col-sm-9">
                  <textarea name="description" id="description" cols="30" rows="4" class="form-control"></textarea>
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