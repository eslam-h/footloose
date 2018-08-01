<div id="cart" class="dropdown clearfix">
	<div  data-toggle="dropdown" data-loading-text="<?php echo $text_loading; ?>" class="dropdown-toggle text-center">
		<i class="icon-cart fa fa-shopping-cart"></i>
		<span id="cart-total">
			<?php echo substr($text_items, 0, strpos($text_items, ' ')+1); ?>
		</span>
          <?php 
            $res = explode("-", $text_items);
          ?>
	</div>
	<ul class="dropdown-menu bg-white">
		<?php if ($products || $vouchers) { ?>
			<li>
				<table class="table table-striped">
					<?php foreach ($products as $product) { ?>
						<tr>
							<td class="text-center">
								<?php if ($product['thumb']) { ?>
									<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
								<?php } ?>
							</td>
							<td class="text-left name">
								<a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
								<?php if ($product['option']) { ?>
									<?php foreach ($product['option'] as $option) { ?>
										<br />
										- <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
									<?php } ?>
								<?php } ?>
								<?php if ($product['recurring']) { ?>
									<br />
									- <small><?php echo $text_recurring; ?> <?php echo $product['recurring']; ?></small>
								<?php } ?>
							</td>
							<td class="text-left num">x&nbsp;<?php echo $product['quantity']; ?></td>
							<td class="text-right price">
								<?php echo $product['total']; ?>
							</td>
							<td class="text-center">
								<button type="button" onclick="cart.remove('<?php echo $product['cart_id']; ?>');" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
							</td>
						</tr>
					<?php } ?>
					<?php foreach ($vouchers as $voucher) { ?>
						<tr>
							<td class="text-center"></td>
							<td class="text-left"><?php echo $voucher['description']; ?></td>
							<td class="text-right">x&nbsp;1</td>
							<td class="text-right"><?php echo $voucher['amount']; ?></td>
							<td class="text-center text-danger"><button type="button" onclick="voucher.remove('<?php echo $voucher['key']; ?>');" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></td>
						</tr>
					<?php } ?>
				</table>
			</li>
			<li>
				<div>
					<table class="table table-bordered">
						<?php foreach ($totals as $total) { ?>
							<tr>
								<td class="text-left"><strong><?php echo $total['title']; ?></strong></td>
								<td class="text-right"><?php echo $total['text']; ?></td>
							</tr>
						<?php } ?>
					</table>
					<div class="text-right">
						<a class="btn btn-v1" href="<?php echo $cart; ?>"><?php echo $text_cart; ?></a>
						<a class="btn btn-v1" href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a>
					</div>
				</div>
			</li>
		<?php } else { ?>
			<li>
				<p class="text-center"><?php echo $text_empty; ?></p>
			</li>
		<?php } ?>
	</ul>
</div>