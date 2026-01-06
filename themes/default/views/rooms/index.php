<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#catData').DataTable({
        'serverSide': true,
        'processing': true,
        'ajax': {
            url: '<?php echo site_url('rooms/get_rooms'); ?>',
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
                "data": "floor"
            },
            {
                "data": "room"
            },
            {
                "data": "price"
            },
            {
                "data": "active",
                "render": Active
            },
            {
                "data": "order_display"
            },
            {
                "data": "Actions",
                "searchable": false,
                "orderable": false
            }
        ],
        "order": [
            [6, 'asc']
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
    td:nth-child(7),
    td:nth-child(8),
    td:nth-child(6),
    td:nth-child(1) {
        text-align: center !important;
    }
    td:nth-child(5) {
        text-align: right !important;
    }
</style>
<div class="main-content">
    <section class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url() ?>"><?php echo lang('home') ?></li> /
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
            <div class="col-sm-6 pull-right">
                <button class="btn-create btn btn-sm ">
                    <a href="<?php echo site_url('rooms/create') ?>">
                        <i class="fa fa-plus-circle "></i>
                        បង្កើត
                    </a>
                </button>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="table-container">
                    <table id="catData" class="table  ">
                        <thead>
                            <tr class="active">
                                <th><?php echo lang("n.o"); ?></th>
                                <th><?php echo lang("branches"); ?></th>
                                <th><?php echo lang('floor'); ?></th>
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('price'); ?></th>
                                <th><?php echo lang('display'); ?></th>
                                <th><?php echo lang('order_display'); ?></th>
                                <th style="width:75px;"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="9" class="dataTables_empty"><?php echo lang('loading_data_from_server'); ?>
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