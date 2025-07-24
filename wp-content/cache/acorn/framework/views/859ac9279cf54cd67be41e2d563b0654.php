<section class="bookingfeature-section">
  <div class="bookingfeature-section__block <?php echo e($item['is_reversed'] ? 'reverse' : ''); ?>">
    <div class="bookingfeature-section__left">
      <div class="bookingfeature-section__left__title"><?php echo e($item['title']); ?></div>

      <?php $__currentLoopData = $item['highlight_features'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bookingfeature-section__left__highlight"><?php echo e($hf['text']); ?></div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

      <?php $__currentLoopData = $item['features'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bookingfeature-section__left__description"><?php echo e($f['text']); ?></div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      
      <?php if(!empty($item['select'][0])): ?>
        <?php
            $icon = wp_get_attachment_image_url($item['select'][0]['icon'], 'full');
        ?>
        <div class="bookingfeature-section__left__booking">
          <div class="bookingfeature-section__left__booking__content"><img class="bookingfeature-section__left__booking__content__icon" src="<?php echo e($icon); ?>" alt=""/>
            <div class="bookingfeature-section__left__booking__content__main">
              <div class="bookingfeature-section__left__booking__content__main__title"><?php echo e($item['select'][0]['title']); ?></div>
              <div class="bookingfeature-section__left__booking__content__main__description">
                <div class="bookingfeature-section__left__booking__content__main__description__block"><span class="bookingfeature-section__left__booking__content__main__description__label"><?php echo e($item['select'][0]['from_label']); ?> </span><span class="bookingfeature-section__left__booking__content__main__description__date">MON, NOV 4, 2025</span></div>
                <div class="bookingfeature-section__left__booking__content__main__description__block"><span class="bookingfeature-section__left__booking__content__main__description__label"><?php echo e($item['select'][0]['to_label']); ?> </span><span class="bookingfeature-section__left__booking__content__main__description__date">SUN, NOV 8, 2025</span></div>
              </div>
            </div>
          </div>
          <div class="bookingfeature-section__left__booking__action">
          <button class="bookingfeature-section__left__booking__button btn btn--primary" type="button" class="btn btn-book-now" data-room-name="<?php echo e($item['title']); ?>" data-room-id="<?php echo e($item['select'][0]['room_id']); ?>" data-price="<?php echo e($room['price']); ?>" onclick="openBookingPopup(this)"> <?php echo e($item['select'][0]['button_text']); ?> </button>
            <div class="bookingfeature-section__left__booking__stock"><?php echo e($item['stock_availability_text']); ?></div>
          </div>
        </div>
      <?php endif; ?>
    </div>
    <div class="bookingfeature-section__right">
      <?php $__currentLoopData = $item['images'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $image_url = wp_get_attachment_image_url($image['src'], 'full');
        ?>
        <div class="bookingfeature-section__right__item">
          <img class="bookingfeature-section__right__item__image" src="<?php echo e($image_url); ?>" alt=""/>
          <div class="bookingfeature-section__right__item__content">
            <?php if(!empty($image['features'])): ?>
              <?php $__currentLoopData = $image['features']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bookingfeature-section__right__item__content__text">
                  <?php echo e($text['feature'] ?? ''); ?>

                </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php /**PATH /home/vol14_3/infinityfree.com/if0_39073049/htdocs/wp-content/themes/cuchi-theme/resources/views/partials/booking/detail-row.blade.php ENDPATH**/ ?>