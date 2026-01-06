<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#branchData').DataTable({
        processing: true,
        serverSide: true,
        responsive: true, // Enable responsive behavior
        scrollX: true,
        autoWidth: false,
        'ajax': {
            url: '<?php echo site_url('branches/get_branches'); ?>',
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
                "data"          : "image",
                "searchable"    : false,
                "orderable"     : false,
                "render"        : dislayImage
            },
            {
                "data": "code"
            },
            {
                "data": "branch_kh"
            },
            {
                "data": "branch_en"
            },
            {
                "data": "address_kh"
            },
            {
                "data": "address_en"
            },
            {
                "data": "phone"
            },
            {
                "data": "order_display"
            },
            {
                "data": "active",
                "render": Active
            },
            {
                "data": "Actions",
                "searchable": false,
                "orderable": false
            }
        ],
        "order": [
            [7, 'asc']
        ],
        "language": {
            "emptyTable": "<?php echo lang('no_data_available'); ?>",
            "loadingRecords": "<?php echo lang('loading_data_from_server'); ?>"
        }
    });
    $(window).on('resize', function() {
        table.columns.adjust();
    });
});
</script>
<style type="text/css">
    td:nth-child(10),td:nth-child(1) {
        text-align: center !important;
    }
</style>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="live-preview">
                    <table id="branchData" class="table align-middle table-nowrap mb-0">
                        <thead>
                            <tr class="active">
                                <th style="max-width:45px;"><?php echo lang("image"); ?></th>
                                <th><?php echo lang('code'); ?></th>
                                <th><?php echo lang('branch_kh'); ?></th>
                                <th><?php echo lang('branch_en'); ?></th>
                                <th><?php echo lang('address_kh'); ?></th>
                                <th><?php echo lang('address_en'); ?></th>
                                <th><?php echo lang('phone'); ?></th>
                                <th><?php echo lang('order_display'); ?></th>
                                <th><?php echo lang('display'); ?></th>
                                <th style="width:75px;"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="10" class="dataTables_empty"><?php echo lang('loading_data_from_server'); ?></td>
                            </tr>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>