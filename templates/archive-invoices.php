<?php require_once 'header-dashboard.php'; ?>

<h3>Invoices</h3>

<div class="row">
    <div class="col-12 col-md-4 col-lg-4">
        <ul id="invoicesCategory" class="list-inline">
            <?php $invCat = apply_filters( 'invmng_invoices_category', '', '' );
            for( $i=0; $i < count( $invCat ); $i++ ): ?>
            <li class="list-inline-item">
                <a href="#">
                    <span class="badge <?php echo ( $invCat[$i]->term_id == 0 ) ? ( 'bg-secondary' ) : ( 'text-dark' ) ?>">
                        <?php echo $invCat[$i]->name ?>
                    </span>                
                </a> 
            </li>
            <?php endfor; ?>
        </ul>
    </div>
    <div class="col-12 col-md-4 col-lg-4">
        From to
    </div>
    <div class="col-12 col-md-4">
        Search
        Mark as paid
    </div>
</div>
<div class="row">
    <table class="table table-light table-borderless">
        <thead class="">
            <tr>
                <th scope="col"><input type="checkbox"></th>
                <th scope="col">ID</th>
                <th scope="col">Restaurant</th>
                <th scope="col">Status</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Total</th>
                <th scope="col">Fees</th>
                <th scope="col">Transfer</th>
                <th scope="col">Orders</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody id="tableContent">
        </tbody>
        <tfoot>
            <tr id="exampleContent" class="d-none">
                <td><input type="checkbox"></td>
                <td>#{ID}</td>
                <td>{RESTAURANT_NAME}</td>
                <td>{STATUS}</td>
                <td>{START_DATE}</td>
                <td>{END_DATE}</td>
                <td>{TOTAL}</td>
                <td>{FEES}</td>
                <td>{TRANSFER}</td>
                <td>{ORDERS}</td>
                <td>img</td>
            </tr>
            <tr>
                <td colspan="5">Page <span id="currentPage">-</span> of <span id="maxPages">-</span>
                <td colspan="6" class="text-right">Pagination</td>
            </tr>
        </tfoot>            
    </table>
</div>

<script>
(function($) {
    $('#invoicesCategory a').on('click', function(e){
        e.preventDefault();

        $('#invoicesCategory .badge').removeClass('bg-secondary').addClass('text-dark');
        $(this).find('.badge').addClass( 'bg-secondary' ).removeClass( 'text-dark' );
    });

    reloadTable( 1 );
    function reloadTable( pageNum ) {
        $.ajax({
            type: 'GET',
            url: '/wp-json/wp/v2/invmng/?per_page=12&page='+pageNum,
            data: { action: 'createHTML' },
            success: function(data, textStatus, request){
                $('#maxPages').html( request.getResponseHeader('X-WP-TotalPages') );
                $('#currentPage').html( pageNum );

                $('#tableContent').empty();
                
                for( var i=0; i < data.length; i++ ) {
                    $('#tableContent').append(
                        '<tr>' +
                        $('#exampleContent').
                            clone().
                            html().
                            replace( '{ID}', data[ i ].id ) +
                        '</tr>'
                    );
                }
                //Figure out the logic whether the next fetch should happen :) 
                // and disable the button if so.
            },
            error: function (request, textStatus, errorThrown) {
                console.log( 'error', errorThrown );
            //FailSafe for WP API Failing
            }
        });
    }

})( jQuery );
</script>