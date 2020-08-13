<div class="container">
   <div class="row">
      <div class="col">
         <h3 class="page-header">Manajemen <?= $title ?></h3>
      </div>
   </div>

   <div class="row">
      <div class="col">
         <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
               <?= $this->session->flashdata('success') ?>.
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>   
            </div>
         <?php elseif($this->session->flashdata('error')) : ?>
            <div class="alert alert-error alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>.
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>   
            </div>
         <?php endif ?>
      </div>
   </div>

   <div class="row mt-3">
      <div class="col">
         <a href="<?= base_url("back/posting/create") ?>" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Tambah</a>
         <button class="btn btn-outline-secondary btn-sm" onclick="reload_table()">
            <i class="fas fa-sync-alt"></i> Reload
         </button>
         <button class="btn btn-outline-danger btn-sm" onclick="bulk_delete()">
            <i class="fas fa-trash"></i> Multiple Delete
         </button>
      </div>
   </div>

  <br>

   <div class="table-responsive">
      <table id="tablePosting" class="table table-bordered"  cellspacing="0" width="100%">
         <thead>
         <tr>
            <th><input type="checkbox" id="check-all"></th>
            <th>Judul Artikel</th>
            <th>F</th>
            <th>C</th>
            <th>P</th>
            <th>Kategori</th>
            <th>Aktif</th>
            <th>Upload</th>
            <th>Action</th>
         </tr>
         </thead>
         <tbody>
         
         </tbody>
      </table>
   </div>

</div>

<!-- Modal -->
<div class="modal fade" id="modalPosting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="modal-title">Form Artikel</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="#" class="form-horizontal" id="form">
            
               <input type="hidden" name="id" id="id">

               <div class="form-group row">
                  <label for="title" class="col-sm-2 col-form-label"><span class="text-danger">*</span> Judul Artikel</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" id="title" name="title" autocomplete="off">
                  </div>
               </div> 

               <div class="form-group row">
                  <label for="article" class="col-sm-2 col-form-label"><span class="text-danger">*</span> Konten</label>
                  <div class="col-sm-10">
                     <textarea name="editor" id="editor" cols="30" rows="4" class="form-control"></textarea>
                  </div>
               </div>

               <div class="form-group row">
                  <div class="col">
                     <label for="featured" class="col-form-label">Featured</label>
                     <select class="form-control" id="featured" name="featured">
                        <option value="N">Tidak</option>
                        <option value="Y">Ya</option> 
                     </select>
                     <small class="form-text text-danger">Recomended Image: 1920 x 1080.</small>
                  </div>

                  <div class="col">
                     <label for="choice" class="col-form-label">Editor's Choice</label>
                     <select class="form-control" id="choice" name="choice">
                        <option value="N">Tidak</option>
                        <option value="Y">Ya</option> 
                     </select>
                  </div>

                  <div class="col">
                     <label for="thread" class="col-form-label">Popular News</label>
                     <select class="form-control" id="thread" name="thread">
                        <option value="N">Tidak</option>
                        <option value="Y">Ya</option> 
                     </select>
                  </div>

                  <div class="col">
                     <label for="category" class="col-form-label"><span class="text-danger">*</span> Kategori</label>
                     <select class="form-control" id="id_category" name="id_category">
                        <option value="">- Pilih -</option>
                        <?php foreach($category as $c) : ?>
                           <option value="<?= $c->id ?>"><?= $c->category_name ?></option> 
                        <?php endforeach ?>
                     </select>
                  </div>
                  
                  <div class="col">
                     <label for="is_active" class="col-form-label">Aktif</label>
                     <select class="form-control" id="is_active" name="is_active">
                        <option value="Y">Ya</option> 
                        <option value="N">Tidak</option>
                     </select>
                  </div>
               </div>

               <div class="form-group row" id="photo-preview">
                  <label class="col-sm-2 col-form-label">Photo</label>
                  <div class="col-sm-10">
                     (No photo)
                  </div>
               </div>

               <div class="form-group row">
                  <label class="col-sm-2 col-form-label" id="label-photo"><span class="text-danger">*</span> Upload Photo </label>
                  <div class="col-sm-10">
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

