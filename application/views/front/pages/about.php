<!--================Home Banner Area =================-->
<section class="banner_area">
   <div class="banner_inner d-flex align-items-center" style="background-image: url(<?= base_url('images/banner/' . $banner->photo) ?>)">
      <div class="overlay bg-parallax" data-stellar-ratio="0.9" data-stellar-vertical-offset="0" data-background=""></div>
      <div class="container">
         <div class="banner_content text-center">
            <h2>ABOUT</h2>
         </div>
      </div>
   </div>
</section>
<!--================End Home Banner Area =================-->

<div class="row">
   <div class="col-lg-6  mx-auto">
      <div class="container contact">
         <p>
            <?= $content->description ?>
         </p>
      </div>
   </div>
</div>