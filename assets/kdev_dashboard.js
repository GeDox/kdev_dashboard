$(document).ready(function(){
    var RELOAD_TABLE = true;
    var searchTimeout = null;
    var filterObject = {};
    $('input[type="search"]').on('keypress keyup keydown', function(){
        if( searchTimeout ) clearTimeout( searchTimeout );

        var searchName = $(this).val();

        if( searchName.length == 0 ) {
            addFilter( 'invmng-restaurants', false, RELOAD_TABLE );
            return;
        }
        searchTimeout = setTimeout(function(){
            $.ajax({
                type: 'GET',
                url: ajaxVars.root + 'wp/v2/invmng-restaurants?search=' + searchName,
                data: { },
                success: function(data, textStatus, request){
                    var restaurantsID = data.map(function(restaurant){
                        return restaurant.id;
                    }).join(',');

                    addFilter( 'invmng-restaurants', restaurantsID, RELOAD_TABLE );
                },
                error: function (request, textStatus, errorThrown) {
                    console.log( 'error', errorThrown );
                }
            });
        }, 700);
    });

    $('#markAsPaidButton').on('click', function(){
        var invoices = $('.singleInvoice:checked').map(function(){ 
            return $(this).attr('data-id') 
        });
        var status = [ $(this).attr('data-value') ];

        console.log( invoices[0], status, ajaxVars );
        $.ajax({
            type: 'POST',
            url: ajaxVars.root + 'wp/v2/invmng/' + invoices[0],
            data: { 'invmng-status': status },
            beforeSend: function ( xhr ) {
                xhr.setRequestHeader( 'X-WP-Nonce', ajaxVars.nonce );
            },
            success: function(data, textStatus, request){
                console.log( 'success', data );
                reloadTable();
            },
            error: function (request, textStatus, errorThrown) {
                console.log( 'error', errorThrown );
            }
        });
    });

    $('#reCheckBox').on('click', function(){
        var checked = $(this).prop('checked');
        $('.singleInvoice').prop('checked', checked);
    });

    $('#invoicesCategory a').on('click', function(e){
        e.preventDefault();

        $('#invoicesCategory .badge').removeClass('bg-secondary').addClass('text-dark');
        $(this).find('.badge').addClass( 'bg-secondary' ).removeClass( 'text-dark' );

        var statusValue = parseInt( $(this).attr('data-value' ) );

        addFilter( 'invmng-status', statusValue, RELOAD_TABLE );
    });

    cleanFilters( RELOAD_TABLE );

    function reloadTable() {
        var params = filterObject;

        $.ajax({
            type: 'GET',
            url: ajaxVars.root + 'wp/v2/invmng/?' + $.param( params ),
            data: { action: 'createHTML' },
            success: function(data, textStatus, request){
                $('#maxPages').html( request.getResponseHeader('X-WP-TotalPages') );
                $('#currentPage').html( params.page );

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
                            replace( /{ID}/g, singlePost.id ?? 0 ).
                            replace( /{RESTAURANT_THUMB}/g, restaurantsInfo.thumbnail ?? '#' ).
                            replace( /{RESTAURANT_NAME}/g, restaurantsInfo.name ?? '-' ).
                            replace( /{STATUS_CLASS}/g, statusInfo.class ?? 'bg-danger' ).  
                            replace( /{STATUS_NAME}/g, statusInfo.name ?? '-').
                            replace( /{START_DATE}/g, metaFields.startDate ?? '-').
                            replace( /{END_DATE}/g, metaFields.endDate ?? '-').
                            replace( /{TOTAL}/g, metaFields.total ?? 0 ).
                            replace( /{FEES}/g, metaFields.fees ?? 0 ).
                            replace( /{TRANSFER}/g, metaFields.transfer ?? 0).
                            replace( /{ORDERS}/g, singlePost.orders ?? 0 ) +
                        '</tr>'
                    );
                }
            },
            error: function (request, textStatus, errorThrown) {
                console.log( 'error', errorThrown );
            }
        });
    }

    function cleanFilters( reload=false ) {
        filterObject = {
            'per_page': 12,
            'page': 1
        };

        helperReload( reload );
    }

    function addFilter(name, value, reload=false) {
        if( !value ) {
            if( typeof filterObject[ name ] ){
                delete filterObject[ name ];
            }

            helperReload( reload );
            return;
        }

        filterObject[ name ] = value;
        helperReload( reload );
    }

    function helperReload(reload) {
        console.log( 'filters', filterObject );
        if( reload ) {
            reloadTable();
        }
    }
});