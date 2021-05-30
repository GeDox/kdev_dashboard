<?php if( ! defined( 'ABSPATH' ) ) exit;

class INV_Restaurants extends INV_Abstract_Taxonomy {
    public function taxonomyShowAdminCustomFields( $tag ) {
        $term_meta = get_post_meta( $tag->term_id );
        ?>
        <tr class="form-field">  
            <th scope="row" valign="top">  
                <label for="class"><?php _e('Thumbnail'); ?></label>  
            </th>  
            <td>  
                <input type="text" name="term_meta[thumbnail]" id="term_meta[thumbnail]" size="40" style="width:95%;" value="<?php echo $term_meta['thumbnail'][0] ?>"><br />  
                <span class="description"><?php _e('Image URL from media'); ?></span>  
            </td>  
        </tr>  
        <?php
    }
}