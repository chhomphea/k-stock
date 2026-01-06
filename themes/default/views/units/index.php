<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#unitData').DataTable({
        processing  : true,
        serverSide  : true,
        responsive  : false,
        scrollX     : true,
        autoWidth   : false,
        'ajax': {
            url     : '<?php echo site_url('units/getUnit'); ?>',
            type    : 'POST',
            data    : function(d) {
                d.<?php echo $this->security->get_csrf_token_name(); ?> =
                    "<?php echo $this->security->get_csrf_hash(); ?>";
            },
            error: function(xhr, error, thrown) {
                console.error('AJAX error:', error, thrown, xhr.status, xhr.responseText);
                alert('Failed to load data. Please check the console for details.');
            }
        },
        "columns": [{
                "data": "code"
            },
            {
                "data": "name"
            },
            {
                "data": "sort"
            },
            {
                "data": "active",
                "render": Active
            },
            {
                "data": "created_at",
                "render": formatDate
            },
            {
                "data": "action",
                "searchable": false,
                "orderable": false
            }
        ],
        "order": [
            [2, 'asc']
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
td:nth-child(6) {
    text-align: center !important;
}
</style>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <p class="card-title mb-0 flex-grow-1"><?=lang('branches')?></p>
                <div class="flex-shrink-0">
                    <a href="<?=site_url('units/create')?>">
                        <button type="button" class="btn btn-soft-secondary btn-sm waves-effect waves-light"><i class="mdi mdi-plus-box"></i></button>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="live-preview">
                    <table id="unitData" class="table align-middle table-nowrap mb-0">
                        <thead>
                            <tr class="active">
                                <th><?php echo lang('code'); ?></th>
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('display'); ?></th>
                                <th><?php echo lang('active'); ?></th>
                                <th><?php echo lang('created_at'); ?></th>
                                <th style="width:75px;"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="dataTables_empty"><?php echo lang('loading_data_from_server'); ?></td>
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