<?php
  $title = get_theme_mod('in_one_tour_title');
  $description = get_theme_mod('in_one_tour_description');
  $button_text = get_theme_mod('in_one_tour_button_text');
  $image = get_theme_mod('in_one_tour_button_image_upload');
?>

<section class="inonetour-section" style="background-image: url('<?php echo e(asset('images/GradientPurple.png')); ?>');">
  <div class="inonetour-section__block">
    <div class="inonetour-section__block__content"> 
      <h1 class="inonetour-section__block__content__title"><?php echo e($title); ?></h1>
      <div class="inonetour-section__block__content__description"><?php echo e($description); ?></div>
      <button class="inonetour-section__block__content__button btn btn--primary"><?php echo e($button_text); ?></button>
    </div>
    <div class="inonetour-section__block__image"><img src="<?php echo e(esc_url($image)); ?>" alt=""></div>
  </div>
</section>
<?php /**PATH /home/vol14_3/infinityfree.com/if0_39073049/htdocs/wp-content/themes/cuchi-theme/resources/views/sections/inonetour.blade.php ENDPATH**/ ?>