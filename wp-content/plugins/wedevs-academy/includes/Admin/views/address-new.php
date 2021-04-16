<div class="wrap">
    <h1><?php _e( 'Add New Address', 'wedevs-academy' ); ?></h1>

    <form action="" method="post">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <lebel for="name"><?php _e( 'Name', 'wedevs-academy' ) ?></label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" class="regular-text" value="" placeholder="Your Name">
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <lebel for="address"><?php _e( 'Address', 'wedevs-academy' ) ?></label>
                    </th>
                    <td>
                        <textarea type="text" name="address" id="address" class="regular-text" value="" placeholder="House, Road, Dubai-3310"></textarea>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <lebel for="phone"><?php _e( 'Phone', 'wedevs-academy' ) ?></label>
                    </th>
                    <td>
                        <input type="text" name="phone" id="phone" class="regular-text" value="" placeholder="01710 0000 00">
                    </td>
                </tr>
            </tbody>
        </table>

        <?php wp_nonce_field( 'new-address' ); ?>
        <?php submit_button( __( 'Add Address', 'wedevs-academy' ), 'primary', 'submit_-address'); ?>
    </form>
</div>