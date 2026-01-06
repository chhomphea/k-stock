<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#catData').DataTable({
        'serverSide': true,
        'processing': true,
        'ajax': {
            url: '<?php echo site_url('currencies/get_currencies'); ?>',
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
                "data": "symbol"
            },
            {
                "data": "code"
            },
            {
                "data": "name"
            },
            {
                "data": "operator"
            },
            {
                "data": "rate"
            },
            {
                "data": "Actions",
                "searchable": false,
                "orderable": false
            }
        ],
        "order": [
            [5, 'asc']
        ],
        "language": {
            "emptyTable": "<?php echo lang('no_data_available'); ?>",
            "loadingRecords": "<?php echo lang('loading_data_from_server'); ?>"
        }
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
td:nth-child(7),
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
                    <a href="<?php echo site_url('currencies/create') ?>">
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
                    <table id="catData" class="table ">
                        <thead>
                            <tr class="active">
                                <th style="max-width:30px;"><?php echo lang("n.o"); ?></th>
                                <th style="max-width:45px;"><?php echo lang("symbol"); ?></th>
                                <th><?php echo lang('code'); ?></th>
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('operator'); ?></th>
                                <th><?php echo lang('rate'); ?></th>
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