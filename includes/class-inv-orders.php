<?php if( ! defined( 'ABSPATH' ) ) exit;

class INV_Orders extends INV_Abstract_Taxonomy {
    private static $taxID;

    public function initialize( $taxID ) {
        self::$taxID = $taxID;
    }

    public function taxonomyShowAdminCustomFields( $tag ) {
        $term_meta = get_post_meta( $tag->term_id );
        ?>
        <tr class="form-field">  
            <th scope="row" valign="top">  
                <label for="class"><?php _e('Total'); ?></label>  
            </th>  
            <td>  
                <input type="text" name="term_meta[total]" id="term_meta[total]" size="40" style="width:95%;" value="<?php echo $term_meta['total'][0] ?>"><br />  
                <span class="description"><?php _e('Total value of order, without fees'); ?></span>  
            </td>  
        </tr>
        <tr class="form-field">  
            <th scope="row" valign="top">  
                <label for="class"><?php _e('Fees'); ?></label>  
            </th>  
            <td>  
                <input type="text" name="term_meta[fees]" id="term_meta[fees]" size="40" style="width:95%;" value="<?php echo $term_meta['fees'][0] ?>"><br />  
                <span class="description"><?php _e('Fees from order'); ?></span>  
            </td>  
        </tr>  
        <?php
    }
}