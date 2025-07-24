<?php
    $footer_image = get_theme_mod('footer_logo_upload');
    $footer_title = get_theme_mod('footer_title');
    $footer_name = get_theme_mod('footer_name');
    $footer_phone = get_theme_mod('footer_phone');
    $footer_address = get_theme_mod('footer_address');
    $footer_copyright = get_theme_mod('footer_copyright');
    $footer_form_title = get_theme_mod('footer_form_title');
    $footer_form_field_name = get_theme_mod('footer_form_field_name');
    $footer_form_field_email = get_theme_mod('footer_form_field_email');
    $footer_form_submit = get_theme_mod('footer_form_submit');
?>

<footer class="footer">
  <div class="footer__footer">
    <div class="container">
      <div class="row">
        <div class="footer__footer__left col-xs-12 col-sm-12 col-md-8">
          <div class="footer__footer__left__logo"><a href="/"><img class="logo" src="<?php echo e(esc_url($footer_image)); ?>" alt="Cucci Logo"></a></div>
          <div class="footer__footer__left__titleandnav">
            <h5 class="footer__footer__left__title"><?php echo e($footer_title); ?></h5>
          </div>
          <div class="footer__footer__left__info"> 
            <div class="footer__footer__left__info__item">
              <p><?php echo e($footer_name); ?></p>
              <p><?php echo e($footer_phone); ?></p>
            </div>
            <div class="footer__footer__left__info__item">
              <p><?php echo e($footer_address); ?></p>
            </div>
          </div>
        </div>
        <div class="footer__footer__right col-xs-12 col-sm-12 col-md-4">
          <h6 class="footer__footer__right__title"><?php echo e($footer_form_title); ?></h6>
          <div class="footer__footer__right__form">
                            <input class="textfield" type="text" name="firstname" placeholder="<?php echo e($footer_form_field_name); ?>" value="">
                            <input class="textfield" type="email" name="email" placeholder="<?php echo e($footer_form_field_email); ?>" value="">
            <button class="btn btn--primary" type="submit"><?php echo e($footer_form_submit); ?></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="divider divider--primary"></div>
  <div class="footer__footer">
    <div class="container">
      <div class="row">
        <div class="footer__footer__left col-xs-12 col-sm-12 col-md-8">
          <div class="body-2 footer__footer__left__copyright"><?php echo e($footer_copyright); ?>© All rights reserved.</div>
        </div>
        <div class="footer__footer__right col-xs-12 col-sm-12 col-md-4">
          <div class="footer__footer__right__nav">
            <ul>
              <li><a href="/"><img class="footer__footer__right__nav__icon" src="<?php echo e(asset('images/facebook.svg')); ?>" alt="Facebook"></a></li>
              <li><a href="/activities.html"><img src="<?php echo e(asset('images/instagram.svg')); ?>" alt="Instagram" lass="footer__footer__right__nav__icon"></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer><?php /**PATH /home/vol14_3/infinityfree.com/if0_39073049/htdocs/wp-content/themes/cuchi-theme/resources/views/sections/footer.blade.php ENDPATH**/ ?>