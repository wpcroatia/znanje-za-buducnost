<?php global $global_devide_item ?>
<div class="nophone <?php echo @$global_devide_item['orientation']?' landscape':''; ?>">
  <div class="nophone-body">
    <div class="nophone-screen">
      <?php echo iAppShowcase::ias_devide_content($global_devide_item); ?>
    </div>
  </div>
</div>