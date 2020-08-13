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
      <table id="tableIdentity" class="table table-striped table-bordered"  cellspacing="0" width="100%">
         <thead>
         <tr>
            <th>#</th>
            <th>Nama Website</th>
            <th>Action</th>
         </tr>
         </thead>
         <tbody>
         
         </tbody>
      </table>
   </div>

</div>

<!-- Modal -->
<div class="modal fade" id="modalIdentity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
         <h5 class="modal-title" id="modal-title">Menu Identitas</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
         </div>
         <div class="modal-body">
            <form action="#" class="form-horizontal" id="form">
               <input type="hidden" name="id">

               <div class="form-group row">
                  <label for="web_name" class="col-sm-3 col-form-label">Nama Website</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" name="web_name">
                  </div>
               </div> 

               <div class="form-group row">
                  <label for="web_address" class="col-sm-3 col-form-label">Alamat Website</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" name="web_address">
                  </div>
               </div> 

               <div class="form-group row">
                  <label for="meta_description" class="col-sm-3 col-form-label"> Deskripsi</label>
                  <div class="col-sm-9">
                  <textarea name="meta_description" cols="30" rows="3" class="form-control"></textarea>
                  </div>
               </div> 

               <div class="form-group row">
                  <label for="meta_keyword" class="col-sm-3 col-form-label">Meta Keyword</label>
                  <div class="col-sm-9">
                  <textarea name="meta_keyword" cols="30" rows="3" class="form-control"></textarea>
                  </div>
               </div>

               <div class="form-group row" id="photo-preview">
                  <label class="col-sm-3 col-form-label">Photo</label>
                  <div class="col-sm-9">
                     (No photo)
                  </div>
               </div>
               
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label" id="label-photo">Upload Photo </label>
                  <div class="col-sm-9">
                     <input name="photo" type="file">
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