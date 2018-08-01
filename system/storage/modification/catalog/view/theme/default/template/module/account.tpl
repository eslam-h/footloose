<div class="list-group">
  <?php if (!$logged) { ?>
  <a href="<?php echo $login; ?>" class="list-group-item"><?php echo $text_login; ?></a> <a href="<?php echo $register; ?>" class="list-group-item"><?php echo $text_register; ?></a> <a href="<?php echo $forgotten; ?>" class="list-group-item"><?php echo $text_forgotten; ?></a>
  <?php } ?>
  <a href="<?php echo $account; ?>" class="list-group-item"><?php echo $text_account; ?></a>
  <?php if ($logged) { ?>
  <a href="<?php echo $edit; ?>" class="list-group-item"><?php echo $text_edit; ?></a> <a href="<?php echo $password; ?>" class="list-group-item"><?php echo $text_password; ?></a>
  <?php } ?>
  <?php if ($logged) { ?>
  <a href="<?php echo $address; ?>" class="list-group-item"><?php echo $text_address; ?></a> <a href="<?php echo $wishlist; ?>" class="list-group-item"><?php echo $text_wishlist; ?></a> <a href="<?php echo $order; ?>" class="list-group-item"><?php echo $text_order; ?></a> <a style="display:none;" href="<?php echo $download; ?>" class="list-group-item"><?php echo $text_download; ?></a><a style="display:none;" href="<?php echo $recurring; ?>" class="list-group-item"><?php echo $text_recurring; ?></a> <a style="display:none;" href="<?php echo $reward; ?>" class="list-group-item"><?php echo $text_reward; ?></a> <a style="display:none;" href="<?php echo $return; ?>" class="list-group-item"><?php echo $text_return; ?></a> <a style="display:none;" href="<?php echo $transaction; ?>" class="list-group-item"><?php echo $text_transaction; ?></a> <a style="display:none;" href="<?php echo $newsletter; ?>" class="list-group-item"><?php echo $text_newsletter; ?></a>
  <?php } ?>
  <?php if (!$logged){ ?>
  <a href="<?php echo $address; ?>" class="list-group-item"><?php echo $text_address; ?></a> <a href="<?php echo $wishlist; ?>" class="list-group-item"><?php echo $text_wishlist; ?></a> <a href="<?php echo $order; ?>" class="list-group-item"><?php echo $text_order; ?></a> <a  href="<?php echo $download; ?>" class="list-group-item"><?php echo $text_download; ?></a><a  href="<?php echo $recurring; ?>" class="list-group-item"><?php echo $text_recurring; ?></a> <a  href="<?php echo $reward; ?>" class="list-group-item"><?php echo $text_reward; ?></a> <a  href="<?php echo $return; ?>" class="list-group-item"><?php echo $text_return; ?></a> <a  href="<?php echo $transaction; ?>" class="list-group-item"><?php echo $text_transaction; ?></a> <a  href="<?php echo $newsletter; ?>" class="list-group-item"><?php echo $text_newsletter; ?></a>
  <?php } ?>
  <?php if ($logged) { ?>

        <?php } ?>
        <?php if(!empty($salescombopge_info)) { ?>
         <?php foreach ($salescombopge_info as $key => $value) { ?>
        <a href="<?php echo $value['href']; ?>" class="list-group-item"><?php echo $value['name']; ?></a>
         <?php } ?>
      <?php } ?>
      <?php if ($logged) { ?>
        
  <a href="<?php echo $logout; ?>" class="list-group-item"><?php echo $text_logout; ?></a>
  <?php } ?>
</div>