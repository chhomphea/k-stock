<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#unitData').DataTable({
        'serverSide': true,
        'processing': true,
        'ajax': {
            url: '<?php echo site_url('floors/get_floors'); ?>',
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
                "data": "branch"
            },
            {
                "data": "name"
            },
            {
                "data": "order_display"
            },
            {
                "data": "active",
                "render": Active
            },
            {
                "data": "created_at"
            },
            {
                "data": "action",
                "searchable": false,
                "orderable": false
            }
        ],
        "order": [
            [3, 'asc']
        ],
        "language": {
            "emptyTable": "<?php echo lang('no_data_available'); ?>",
            "loadingRecords": "<?php echo lang('loading_data_from_server'); ?>"
        }
    });
});
</script>
<style type="text/css">
td:nth-child(7) {
    text-align: center !important;
}

td:nth-child(1) {
    text-align: center !important;
}
</style>
<div class="main-content">
    <section class="content-header">
        <div class="row">
            <div class="col-sm-11">
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url() ?>"><?php echo lang('home') ?></li>/
                    <?php
                        foreach ($bc as $b) {
                            if ($b['link'] === '#') {
                                echo '<li class="active"> / ' . $b['page'] . '</li>';
                            } else {
                                echo '<li><a href="' . $b['link'] . '">' . $b['page'] . '</a></li>';
                            }
                    }?>
                </ol>
            </div>
            <div class="col-sm-1 pull-right">
                <button class="btn-create btn btn-sm">
                    <a href="<?php echo site_url('floors/create') ?>">
                        <i class="fa fa-plus-circle fa-2x"></i>
                    </a>
                </button>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="table-container">
                    <table id="unitData" class="table ">
                        <thead>
                            <tr class="active">
                                <th style="max-width:30px;"><?php echo lang("n.o"); ?></th>
                                <th><?php echo lang('branches'); ?></th>
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('order_display'); ?></th>
                                <th><?php echo lang('display'); ?></th>
                                <th><?php echo lang('created_at'); ?></th>
                                <th style="width:75px;"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="dataTables_empty"><?php echo lang('loading_data_from_server'); ?>
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
<div class="modal fade" id="picModal" tabindex="-1" role="dialog" aria-labelledby="picModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body text-center">
                <img id="product_image" src="" alt="" />
            </div>
        </div>
    </div>
</div>