<!-- <header class="banner">
  <a class="brand" href="<?php echo e(home_url('/')); ?>">
    <?php echo $siteName; ?>

  </a>

  <?php if(has_nav_menu('primary_navigation')): ?>
    <nav class="nav-primary" aria-label="<?php echo e(wp_get_nav_menu_name('primary_navigation')); ?>">
      <?php echo wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'echo' => false]); ?>

    </nav>
  <?php endif; ?>
</header> -->
<?php
  $logo = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
  $header_image = get_theme_mod('header_image_upload');

  $locations = get_nav_menu_locations(); // returns array: location => menu ID
  $menu_id = $locations['primary_navigation'] ?? null;
  if ($menu_id) {
    $menu = wp_get_nav_menu_items($menu_id);
  } else {
      $menu = [];
  }


  $menu_name_mobile = 'Mobile Menu'; // or your registered location
  $menu_items_mobile = wp_get_nav_menu_items($menu_name_mobile);
?>

<header class="header">
  <div class="header__header">
    <div class="container">
      <div class="row">
        <div class="header__header__left col-xs-12 col-sm-12 col-md-3">
          <div class="header__header__left__logo">

            <a href="/"><img class="logo" src="<?php echo e($logo[0]); ?>" alt="Cucci Logo"></a>
            <img class="more-icon" id="header-more-button" src="<?php echo e(asset('images/bars.svg')); ?>" alt="bars">
          </div>
        </div>
        <div class="header__header__right col-xs-12 col-sm-12 col-md-9">
          <div class="header__header__right__nav">
            <ul>
              <?php if($menu): ?>
                <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li><a href="<?php echo e($item->url); ?>"><?php echo e($item->title); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </ul>
          </div>
          <div class="header__header__right__languages"> 
            <ul> 
              <li><img class="flag" src="<?php echo e(asset('images/icons8-american-flag-48.svg')); ?>" alt="English"></li>
              <li><img class="flag" src="<?php echo e(asset('images/icons8-vietnam-48.svg')); ?>" alt="Vietnam"></li>
            </ul>
          </div>
          <div class="header__header__right__booknow">
            <button class="btn btn--primary" onclick="window.open('/booking.html', '_self')">Book Now</button>
          </div>
        </div>
      </div>
      <div class="header__drawer" id="header-drawer">
        <div class="header__menu">
            <img class="header__menu__close" id="header-close-button" src="<?php echo e(asset('images/close.svg')); ?>" alt="">
            
            <?php if($menu_items_mobile): ?>
              <?php $__currentLoopData = $menu_items_mobile; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $icon_id = carbon_get_nav_menu_item_meta($item->ID, 'menu_icon');
                    $icon_url = $icon_id ? wp_get_attachment_image_url($icon_id, 'thumbnail') : null;
                ?>

                 <a class="header__menu__item" href="<?php echo e($item->url); ?>">
                    <div class="header__menu__item__icon">
                      <?php if($icon_url): ?>
                            <img src="<?php echo e($icon_url); ?>" alt="">
                        <?php endif; ?>
                    </div>
                    <div class="header__menu__item__title"> <?php echo e($item->title); ?></div>
                </a>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <?php if(is_page('Contact Us')): ?>
    <div class="header__hero"> 
      <div class="container-fluid">
        <div class="row"> 
          <div class="header__hero"><img class="header__hero__image" src="<?php echo e(esc_url($header_image)); ?>" alt="Cucci Hero">
            <div class="header__hero__callnow">
              <div class="header__hero__callnow__logo">C</div>
              <div class="header__hero__callnow__description">We’d love to hear from you! Whether you’re planning your next getaway or have questions about our services, feel free to reach out to us:</div><a class="header__hero__callnow__action" href="#">
                <div class="header__hero__callnow__action__link">Call Now </div><img class="header__hero__callnow__action__icon" src="<?php echo e(asset('images/arrow-right-1.svg')); ?>" alt=""></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>
  <div class="header__hero"> 
    <div class="container-fluid">
      <div class="row"> 
        <div class="header__hero">
          <img class="header__hero__image" src="<?php echo e(esc_url($header_image)); ?>" alt="Cucci Hero">

          
          <form method="POST" action="<?php echo e(admin_url('admin-post.php')); ?>" class="header__hero__search">
            <?php wp_nonce_field('booking_form', 'booking_nonce'); ?>
            <input type="hidden" name="action" value="handle_booking">
            <input type="hidden" name="action_type" value="check_availability">

            <div class="header__hero__search__filters">
              <div class="header__hero__search__filters__item">
                <div class="header__hero__search__filters__item__title">Check in Date</div>
                <div class="header__hero__search__filters__item__input"> 
                  <div class="div-datepicker">
                    <input class="datepicker" type="text" name="check_in" required>
                    <img class="icon-updown" src="<?php echo e(asset('images/Dropdown.svg')); ?>" alt="Arrow Icon">
                  </div>
                </div>
              </div>

              <div class="header__hero__search__filters__item">
                <div class="header__hero__search__filters__item__title">Check out Date</div>
                <div class="header__hero__search__filters__item__input"> 
                  <div class="div-datepicker">
                    <input class="datepicker" type="text" name="check_out" required>
                    <img class="icon-updown" src="<?php echo e(asset('images/Dropdown.svg')); ?>" alt="Arrow Icon">
                  </div>
                </div>
              </div>

              <div class="header__hero__search__filters__item">
                <div class="header__hero__search__filters__item__title">People</div>
                <div class="header__hero__search__filters__item__input"> 
                  <select class="select" name="guests" required>
                    <option value="1" selected>1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="header__hero__search__submit">
            <button type="submit" 
              style="background-color: transparent; color: white; padding: 30px 30px; border: none; border-radius: 25px; font-weight: 600; font-size: 16px; cursor: pointer;">
              Search
            </button>
            </div>
          </form>
          
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
</header>

<style>
  #loadingScreenOverlay {
  position: fixed;
  top: 0; left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.5);
  z-index: 9999;
  display: flex;
  flex-direction: column; /* so text goes below spinner */
  align-items: center;
  justify-content: center;
}

.loader {
  border: 8px solid #f3f3f3;
  border-top: 8px solid #996515;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  animation: spin 0.9s linear infinite;
}

.loading-text {
  margin-top: 16px;
  font-size: 16px;
  color: #fff;
  font-weight: 500;
  text-align: center;
}

@keyframes spin {
  0%   { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<div id="loadingScreenOverlay" style="display: none;">
    <div class="loader"></div>
    <p class="loading-text">Looking for the best room for you...</p>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
      const form = document.querySelector(".header__hero form");
      if (form) {
        form.addEventListener("submit", function () {
          document.getElementById("loadingScreenOverlay").style.display = "flex";
        });
      }
    });
</script><?php /**PATH /home/vol14_3/infinityfree.com/if0_39073049/htdocs/wp-content/themes/cuchi-theme/resources/views/sections/header.blade.php ENDPATH**/ ?>