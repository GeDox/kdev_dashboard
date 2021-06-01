<?php require_once 'header-dashboard.php'; ?>

<h3>Invoices</h3>

<div class="row">
    <div class="col-12 col-md-4 col-lg-4">
        <ul id="invoicesCategory" class="list-inline">
            <?php $invCat = apply_filters( 'invmng_invoices_category', '', '' );
            for( $i=0; $i < count( $invCat ); $i++ ): ?>
            <li class="list-inline-item">
                <a href="#" data-value="<?php echo $invCat[$i]->term_id ?>">
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
    <table class="table table-light table-borderless" border="0" rules="none">
        <thead class="text-uppercase">
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
                <td><img src="{RESTAURANT_THUMB}" style="width: 20px"/> {RESTAURANT_NAME}</td>
                <td><span class="badge {STATUS_CLASS} text-uppercase">{STATUS_NAME}</span></td>
                <td>{START_DATE}</td>
                <td>{END_DATE}</td>
                <td>HK${TOTAL}</td>
                <td>HK${FEES}</td>
                <td>HK${TRANSFER}</td>
                <td>{ORDERS}</td>
                <td>img</td>
            </tr>
            <tr>
                <td colspan="5" class="text-uppercase">Page <span id="currentPage">-</span> of <span id="maxPages">-</span>
                <td colspan="6" class="text-right">Pagination</td>
            </tr>
        </tfoot>            
    </table>
</div>

<style>
.table { border-collapse: collapse; transition: 1s }
.table, .table tr  { border: 1pt solid #E6E6E8 }
.table td, .table th { border: transparent }
.table thead, .table tfoot { color: rgb(155,155,155) }
.table #tableContent tr:hover { transform: scale(1.05); border: 1pt solid #E6E6E8; cursor: pointer }
.table .bg-light { background-color: rgb(224,228,231) !important }
</style>

<script>
(function($) {
    $('#invoicesCategory a').on('click', function(e){
        e.preventDefault();

        $('#invoicesCategory .badge').removeClass('bg-secondary').addClass('text-dark');
        $(this).find('.badge').addClass( 'bg-secondary' ).removeClass( 'text-dark' );

        var statusValue = parseInt( $(this).attr('data-value' ) );
        reloadTable( 1, statusValue ? { 'invmng-status': statusValue } : {} );
    });

    reloadTable( 1 );
    function reloadTable( pageNum, customQuery={} ) {
        var params = {
            'per_page': 12,
            'page': pageNum
        };

        $.extend( params, customQuery );
        $.ajax({
            type: 'GET',
            url: '/wp-json/wp/v2/invmng/?' + $.param( params ),
            data: { action: 'createHTML' },
            success: function(data, textStatus, request){
                $('#maxPages').html( request.getResponseHeader('X-WP-TotalPages') );
                $('#currentPage').html( pageNum );

                $('#tableContent').empty();
                
                for( var i=0; i < data.length; i++ ) {
                    var singlePost = data[ i ];
                    var restaurantsInfo = singlePost.restaurants;
                    var statusInfo = singlePost.status;
                    var metaFields = singlePost['meta-fields'];
                    
                    $('#tableContent').append(
                        '<tr>' +
                        $('#exampleContent').
                            clone().
                            html().
                            replace( '{ID}', singlePost.id ).
                            replace( '{RESTAURANT_THUMB}', restaurantsInfo.thumbnail ?? '#' ).
                            replace( '{RESTAURANT_NAME}', restaurantsInfo.name ?? '-' ).
                            replace( '{STATUS_CLASS}', statusInfo.class ?? '' ).  
                            replace( '{STATUS_NAME}', statusInfo.name ?? '-').
                            replace( '{TOTAL}', metaFields.total ?? 0 ).
                            replace( '{FEES}', metaFields.fees ?? 0 ).
                            replace( '{TRANSFER}', metaFields.transfer ?? 0).
                            replace( '{ORDERS}', singlePost.orders ?? 0 ) +
                        '</tr>'
                    );
                }
            },
            error: function (request, textStatus, errorThrown) {
                console.log( 'error', errorThrown );
            }
        });
    }

    function parseTaxonomyInfo( data ) {
        console.log( 'parseTaxonomyInfo', data._links );
    }
})( jQuery );
</script>