<script type="text/javascript">

    Checkout.configure({
        merchant: '<?php echo $merchant_id; ?>',
        order: {
            amount: '<?php echo $order_money; ?>',
            currency: '<?php echo $merchant_currency; ?>',
            description: 'Ordered goods',
            id: '<?php echo $order_id; ?>'
        },
        session: {
            id: '<?php echo $session_id; ?>'
        },
        interaction: {
            merchant: {
                name: 'Footloose'
            }
        }
    });

    Checkout.showLightbox();
</script>
