<?php
  $title = get_theme_mod('our_insights_title', 'Explore insights');
  $stickyText = get_theme_mod('our_insights_sticky_text', 'Disconnect to Reconnect');
  $image_urls = get_theme_mod('our_insights_image_urls');
  $images = array_filter(array_map('trim', explode(',', $image_urls)));
?>

<section class="our-insights">
  <h3 class="our-insights__title"><?php echo e($title); ?></h3>
  <div class="our-insights__list cucci-slick-3">
    <?php if(!empty($images)): ?>
      <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          $attachment_id = is_numeric($image) ? (int) $image : attachment_url_to_postid($image);
          $caption = $attachment_id ? wp_get_attachment_caption($attachment_id) : '';
          $attachment = $attachment_id ? get_post($attachment_id) : null;
        ?>
        <a class="our-insights__item" href="#"> 
            <div class="our-insights__item__image">
              <img src="<?php echo e(esc_url($image)); ?>" alt="">
            </div>
            <div class="our-insights__item__description">
              <?php if($caption): ?>
                <p><?php echo e($caption); ?></p>
              <?php endif; ?>
            </div>
          </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    <!-- <a class="our-insights__item" href="#"> 
      <div class="our-insights__item__image"><img src="../img/our-insight-2.jpg" alt=""></div>
      <div class="our-insights__item__description">Pedal Through Paradise: Scenic Bicycle Tours in Cuchi</div></a><a class="our-insights__item" href="#"> 
      <div class="our-insights__item__image"><img src="../img/our-insight-3.jpg" alt=""></div>
      <div class="our-insights__item__description">Pedal Through Paradise: Scenic Bicycle Tours in Cuchi</div></a> -->
  </div>
  <div class="our-insights__navigation">
    <img class="our-insights__navigation__prev cucci-slick-3-prev" src="<?php echo e(asset('images/arrow-prev.svg')); ?>" alt="">
    <img class="our-insights__navigation__next cucci-slick-3-next" src="<?php echo e(asset('images/arrow-next.svg')); ?>" alt="">
  </div>
  <div class="our-insights__sticky-footer"><?php echo e($stickyText); ?></div><img class="our-insights__go-to-top" src="<?php echo e(asset('images/arrow-top.svg')); ?>" alt="" onclick="window.scrollTo(0,0)">
</section>
<?php /**PATH /home/vol14_3/infinityfree.com/if0_39073049/htdocs/wp-content/themes/cuchi-theme/resources/views/sections/our-insights.blade.php ENDPATH**/ ?>