<?php if( ! defined( 'ABSPATH' ) ) exit;

class INV_Orders_Status extends INV_Abstract_Taxonomy {
    public function taxonomyShowAdminCustomFields( $tag ) {
        $term_meta = get_post_meta( $tag->term_id );
        ?>
        <tr class="form-field">  
            <th scope="row" valign="top">  
                <label for="class"><?php _e('Visible class'); ?></label>  
            </th>  
            <td>  
                <input type="text" name="term_meta[class]" id="term_meta[class]" size="25" style="width:60%;" value="<?php echo $term_meta['class'] ? $term_meta['class'][0] : 'bg-light text-dark'; ?>"><br />  
                <span class="description"><?php _e('Type: bg-light, bg-warning, bg-success, text-dark'); ?></span>  
            </td>  
        </tr>  
        <?php
    }
}