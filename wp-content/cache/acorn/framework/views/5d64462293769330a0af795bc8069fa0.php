<div class="bookingplace-section">
  <div class="bookingplace-section__block">
    <div class="bookingplace-section__item">
      <h1 class="bookingplace-section__title"><?php echo e($item['title']); ?></h1>
      <?php $__currentLoopData = $item['highlight_features'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bookingplace-section__subtitle"><?php echo e($hf['text']); ?></div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <img class="bookingplace-section__image" src="<?php echo e(wp_get_attachment_image_url($item['images'][0]['src'], 'full')); ?>" alt="">
    </div>
    <div class="bookingplace-section__item">
      <img class="bookingplace-section__image" src="<?php echo e(wp_get_attachment_image_url($item['images'][1]['src'], 'full')); ?>" alt="">
      <?php if(!empty($item['select'][0])): ?>
        <?php
            $icon = wp_get_attachment_image_url($item['select'][0]['icon'], 'full');
        ?>
        <div class="bookingfeature-section__left__booking">
          <div class="bookingfeature-section__left__booking__content">
            <img class="bookingfeature-section__left__booking__content__icon" src="<?php echo e($icon); ?>" alt="">
              <div class="bookingfeature-section__left__booking__content__main">
              <div class="bookingfeature-section__left__booking__content__main__title"><?php echo e($item['select'][0]['title']); ?></div>
              <div class="bookingfeature-section__left__booking__content__main__description">
                <span class="bookingfeature-section__left__booking__content__main__description__label"><?php echo e($item['select'][0]['from_label']); ?> </span>
                <span class="bookingfeature-section__left__booking__content__main__description__date"></span>
                <span class="bookingfeature-section__left__booking__content__main__description__label"><?php echo e($item['select'][0]['to_label']); ?> </span>
                <span class="bookingfeature-section__left__booking__content__main__description__date"></span>
              </div>
            </div>
          </div>
          <button class="bookingfeature-section__left__booking__button btn btn--primary" type="button" class="btn btn-book-now" data-room-name="<?php echo e($item['title']); ?>" data-room-id="<?php echo e($item['select'][0]['room_id']); ?>" data-price="<?php echo e($room['price']); ?>" onclick="openBookingPopup(this)"> <?php echo e($item['select'][0]['button_text']); ?> </button>
        </div>
      <?php endif; ?>
    </div>
    <div class="bookingplace-section__item">
      <div class="bookingplace-section__content">
        <?php $__currentLoopData = $item['features'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <p><?php echo e($f['text']); ?></p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <img class="bookingplace-section__image" src="<?php echo e(wp_get_attachment_image_url($item['images'][2]['src'], 'full')); ?>" alt="">
    </div>
  </div>
</div><?php /**PATH /home/vol14_3/infinityfree.com/if0_39073049/htdocs/wp-content/themes/cuchi-theme/resources/views/partials/booking/detail-mix.blade.php ENDPATH**/ ?>