<?php
  $title = get_theme_mod('highlighted_memories_title');
  $video_urls = get_theme_mod('video_urls');
  $videos = array_filter(array_map('trim', explode(',', $video_urls)));
?>

<section class="highlighted-moments-section">
  <h1 class="highlighted-moments-section__title"><?php echo e($title); ?></h1>
  <div class="highlighted-moments-section__slider">
    <div class="highlighted-moments-section__slick cucci-slick">
      <?php $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="highlighted-moments-section__item video-container">
          <video src="<?php echo e($video); ?>" alt=""> </video><img class="btn-play" src="<?php echo e(asset('images/play.svg')); ?>" alt="play">
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="highlighted-moments-section__navigation"> <img class="highlighted-moments-section__navigation__prev cucci-slick-prev" src="<?php echo e(asset('images/arrow-prev.svg')); ?>" alt=""><img class="highlighted-moments-section__navigation__next cucci-slick-next" src="<?php echo e(asset('images/arrow-next.svg')); ?>" alt=""></div>
  </div>
</section>
<?php /**PATH /home/vol14_3/infinityfree.com/if0_39073049/htdocs/wp-content/themes/cuchi-theme/resources/views/sections/highlighted-memories.blade.php ENDPATH**/ ?>