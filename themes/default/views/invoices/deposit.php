<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#deposit').DataTable({
        'serverSide': true,
        'processing': true,
        'ajax': {
            url: '<?php echo site_url('invoices/getdeposit'); ?>',
            type: 'POST',
            data: function(d) {
                d.<?php echo $this->security->get_csrf_token_name(); ?> =
                    "<?php echo $this->security->get_csrf_hash(); ?>";
            },
            error: function(xhr, error, thrown) {
                console.error('AJAX error:', error, thrown, xhr.status, xhr.responseText);
                alert('Failed to load data. Please check the console for details.');
            }
        },
        "columns": [{
                "data": null,
                "render": function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                "orderable": false,
                "searchable": false
            },
            {
                "data": "date"
            },
            {
                "data": "invoice_no"
            },
            {
                "data": "name"
            },
            {
                "data": "amount"
            },
            {
                "data": "paid"
            },
            {
                "data": "payment_status","render":status
            },
            {
                "data": "created_at"
            },
             {
                "data": "created_by"
            },
            {
                "data": "Actions",
                "searchable": false,
                "orderable": false
            }
        ],
        "order": [
            [2, 'desc']
        ],
        "language": {
            "emptyTable": "<?php echo lang('no_data_available'); ?>",
            "loadingRecords": "<?php echo lang('loading_data_from_server'); ?>"
        },
        "pageLength" : 25
    });
    $('body').on('click', '.open-image', function() {
        $('.modal').modal('hide');
        var a_href = $(this).attr('href');
        var code = $(this).closest('tr').find('td:eq(2)').text();
        $('.modal-title').text(code);
        $('#image-url').attr('src', a_href);
        $('#imageModal').modal({
            backdrop: true,
            keyboard: true
        });
        $('#imageModal').modal('show');
        return false;
    });
});
</script>
<style type="text/css">
    td:nth-child(1),td:nth-child(10){
        text-align: center;
    }
    td:nth-child(5),td:nth-child(6){
        text-align: right;
    }
</style>
<div class="main-content">
    <section class="content-header">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=site_url()?>"><?=lang('home')?></a></li>
                        <?php foreach ($bc as $b) {
                            if ($b['link'] === '#') {
                                echo '<li class="breadcrumb-item">->' . $b['page'] . '</li>';
                            } else {
                                echo '<li class="breadcrumb-item active" aria-current="page"><a href="' . $b['link'] . '">' . $b['page'] . '</a></li>';
                            }
                        }?>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="table-container">
                    <table id="deposit" class="table">
                        <thead>
                            <tr class="active">
                                <th><?php echo lang("n.o"); ?></th>
                                <th><?php echo lang("date"); ?></th>
                                <th><?php echo lang('invoice_no'); ?></th>
                                <th><?php echo lang('customers'); ?></th>
                                <th><?php echo lang('amount'); ?></th>
                                <th><?php echo lang('paid'); ?></th>
                                <th><?php echo lang('payment_status'); ?></th>
                                <th><?php echo lang('created_at'); ?></th>
                                <th><?php echo lang('created_by'); ?></th>
                                <th style="width:75px;"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="10" class="dataTables_empty"><?php echo lang('loading_data_from_server'); ?>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="imageModal" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h4 class="modal-title"></h4>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <img src="" id="image-url">
            </div>
        </div>
    </div>
</div>