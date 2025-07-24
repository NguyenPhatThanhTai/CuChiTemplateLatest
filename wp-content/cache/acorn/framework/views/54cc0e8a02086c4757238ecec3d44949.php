<?php
  $title = get_theme_mod('intro_2_title');
  $description = get_theme_mod('intro_2_description');
  $subtitle = get_theme_mod('intro_2_subtitle_main');
  $subtitleEmphasis = get_theme_mod('intro_2_subtitle_emphasis');
  $buttonText = get_theme_mod('intro_2_button_text');
  $image = get_theme_mod('intro_2_button_image_upload');
?>

<section class="intro2-section">
  <div class="intro2-section__skew-image">
    <div class="intro2-section__skew-image__skewed">
      <div class="intro2-section__skew-image__skewed__content">
        <h1 class="intro2-section__skew-image__skewed__content__title"><?php echo e($title); ?></h1>
        <div class="intro2-section__skew-image__skewed__content__subtitle">
          <div class="intro2-section__skew-image__skewed__content__subtitle__main"><?php echo e($subtitle); ?> </div>
          <div class="intro2-section__skew-image__skewed__content__subtitle__emphasize"><?php echo e($subtitleEmphasis); ?></div>
        </div>
        <p class="intro2-section__skew-image__skewed__content__description"><?php echo e($description); ?></p>
        <button class="intro2-section__skew-image__skewed__content__button btn btn--primary"><?php echo e($buttonText); ?></button>
      </div>
    </div><img class="intro2-section__skew-image__image" src="<?php echo e(esc_url($image)); ?>" alt="Intro Image">
  </div>
  <p class="intro2-section__description"><?php echo e($description); ?></p>
</section>
<?php /**PATH /home/vol14_3/infinityfree.com/if0_39073049/htdocs/wp-content/themes/cuchi-theme/resources/views/sections/intro-2.blade.php ENDPATH**/ ?>