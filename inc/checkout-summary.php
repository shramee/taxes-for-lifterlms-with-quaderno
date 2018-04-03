<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Order Summary area of the checkout form
 *
 * @author    LifterLMS
 * @package  LifterLMS/Templates
 */
/** @var LLMS_Access_Plan $plan */
?>
<ul
	class="llms-order-summary<?php echo $plan->is_on_sale() ? ' on-sale' : ''; ?><?php echo $coupon ? ' has-coupon' : ''; ?>">
	<li><span class="llms-label"><?php echo $product->get_post_type_label( 'singular_name' ); ?>
			:</span> <?php echo $product->get( 'title' ); ?></li>
	<li><span class="llms-label"><?php _e( 'Access Plan', 'lifterlms' ); ?>:</span> <?php echo $plan->get( 'title' ); ?>
	</li>
	<?php if ( $plan->has_trial() ) : ?>
		<li>
			<span class="llms-label"><?php _e( 'Trial', 'lifterlms' ); ?>:</span>
			<span class="price-regular"><?php echo $plan->get_price( 'trial_price' ); ?></span>
			<?php if ( $coupon ) : ?>
				<span class="price-coupon"><?php echo $plan->get_price_with_coupon( 'trial_price', $coupon ); ?></span>
			<?php endif; ?>
			<?php echo $plan->get_trial_details(); ?>
		</li>
	<?php endif; ?>

	<li>
		<span class="llms-label"><?php _e( 'Terms', 'lifterlms' ); ?>:</span>
		<span class="price-regular"><?php echo $plan->get_price( 'price' ); ?></span>
		<?php if ( $coupon ) : ?>
			<span
				class="price-coupon"><?php echo $plan->get_price_with_coupon( $plan->is_on_sale() ? 'sale_price' : 'price', $coupon ); ?></span>
		<?php else : ?>
			<?php if ( $plan->is_on_sale() ) : ?>
				<span class="price-sale"><?php echo $plan->get_price( 'sale_price' ); ?></span>
			<?php endif; ?>
		<?php endif; ?>
		<?php $schedule = $plan->get_schedule_details();
		if ( $schedule ) : ?>
			<?php echo $schedule; ?>
		<?php endif; ?>
	</li>

	<?php
	$taxes = Taxes_LLMS_Quaderno::get_tax();
	if ( ! $taxes['error'] && $taxes['data']['name'] ) {
		$price = $plan->get_price( 'sale_price', [], 'float' );
		$rate  = $taxes['data']['rate'];
		$tax = $price * $rate / ( 100 + $rate );
		$net_price = $price - $tax;
		?>
		<li><span class="llms-label"><?php echo "{$taxes['data']['name']} $rate%"; ?>
				:</span> <?php echo llms_price( $tax ); ?></li>
		<li><span class="llms-label"><?php _e( 'Net Price', 'lifterlms' ); ?>
				:</span> <?php echo llms_price( $net_price ) ?></li>
		<li><span class="llms-label"><?php _e( 'Payment', 'lifterlms' ); ?>:</span> <?php echo llms_price( $price ) ?></li>
		<?php
	}
	$expires = $plan->get_expiration_details();
	if ( $expires ) : ?>
		<li><span class="llms-label"><?php _e( 'Access', 'lifterlms' ); ?>:</span> <?php echo $expires; ?></li>
	<?php endif; ?>
</ul>
