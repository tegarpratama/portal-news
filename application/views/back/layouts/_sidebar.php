<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

   <!-- Sidebar - Brand -->
   <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('admin') ?>">
      <div class="sidebar-brand-icon">
         <i class="fab fa-gofore"></i>
      </div>
      <div class="sidebar-brand-text mx-1">arsans Admin</div>
   </a>

   <!-- Divider -->
   <hr class="sidebar-divider my-0">

   <!-- Nav Item - Dashboard -->
   <?php if($title == 'Dashboard') : ?>
      <li class="nav-item active">
   <?php else: ?>
      <li class="nav-item">
   <?php endif ?>
      <a class="nav-link" href="<?= base_url('admin') ?>">
         <i class="fas fa-fw fa-tachometer-alt"></i>
         <span>Dashboard</span>
      </a>
   </li>

   <!-- Nav Item - Pages Collapse Menu -->
   <?php 
   $menu = $this->menu->getMenu();
   foreach($menu as $m) :
      $submenu = $this->menu->getSubmenu($m->id); 
   ?>
   
      <li class="nav-item"> 
      <?php if($submenu) : ?>
         <a class="nav-link collapsed" href="<?= base_url() ?>" data-toggle="collapse" data-target="#collapse<?= $m->id ?>" aria-expanded="true" aria-controls="collapseTwo">
            <i class="<?= $m->icon ?>"></i>
            <span><?= $m->title ?></span>
         </a>

         <div id="collapse<?= $m->id ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
               <?php foreach($submenu as $sm) : ?>
                  <a class="collapse-item" href="<?= base_url($sm->sub_url) ?>"><?=  $sm->sub_title?></a>
               <?php endforeach ?>
            </div>
         </div>
      <?php else: ?>
         <a class="nav-link" href="<?= base_url($m->url) ?>">
            <i class="<?= $m->icon ?>"></i>
            <span><?= $m->title ?></span>
         </a>
      <?php endif ?>
      </li>
   <?php endforeach ?>
   

   <!-- Sidebar Toggler (Sidebar) -->
   <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
   </div>

</ul>