<?php require_once 'header-dashboard.php'; ?>

<h3>Invoices</h3>

<div class="row m-0 mt-3 justify-content-end">
    <div class="col-12 col-md-4 p-0">
        <ul id="invoicesCategory" class="list-inline m-0">
            <?php $invCat = apply_filters( 'invmng_invoices_category', '', '' );
            for( $i=0; $i < count( $invCat ); $i++ ): ?>
            <li class="list-inline-item">
                <a href="#" data-value="<?php echo $invCat[$i]->term_id ?>">
                    <span class="badge text-uppercase <?php echo ( $invCat[$i]->term_id == 0 ) ? ( 'bg-secondary' ) : ( 'text-dark' ) ?>">
                        <?php echo $invCat[$i]->name ?>
                    </span>                
                </a> 
            </li>
            <?php endfor; ?>
        </ul>
    </div>
    <div class="col-12 col-md-8 p-0 text-end">
        <div class="d-inline-flex flex-row-reverse">
            <?php $lastCategory = array_key_last( $invCat ); ?>
            <button class="btn btn-warning btn-sm text-white" id="markAsPaidButton" style="margin: 0 0 0 15px" data-value="<?php echo $invCat[ $lastCategory ]->term_id ?>">Mark as paid</button>
            <input class="form-control form-control-sm w-auto mr-sm-2" style="margin: 0 0 0 15px" type="search" placeholder="Search" aria-label="Search">
            From to
        </div>
    </div>
</div>
<div class="row m-0 mt-3">
    <table class="table table-light table-borderless" border="0" rules="none">
        <thead class="text-uppercase">
            <tr>
                <th scope="col"><input type="checkbox" id="reCheckBox"></th>
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
                <td><input type="checkbox" class="singleInvoice" data-id="{ID}"></td>
                <td>#{ID}</td>
                <td><img src="{RESTAURANT_THUMB}" style="width: 20px"/> <span class="fw-bold">{RESTAURANT_NAME}</span></td>
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
.table th, .table tfoot { font-size: 12px; font-weight: 600 }
.table td, .table th { border: transparent }
.table thead, .table tfoot { color: rgb(155,155,155) }
.table #tableContent tr:hover { transform: scale(1.05); border: 1pt solid #E6E6E8; cursor: pointer }
.table .bg-light { background-color: rgb(224,228,231) !important }

input[type="search"] {
    background-image:url("https://cdn2.iconfinder.com/data/icons/ios-7-icons/50/search-256.png") !important;
    background-position: 10px center;
    background-repeat: no-repeat;
    background-size: 15px 15px;
    text-indent: 25px;
}
</style>