<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#unitData').DataTable({
        'serverSide': true,
        'processing': true,
        'ajax': {
            url: '<?php echo site_url('utilities/get_utilities'); ?>',
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
                "data": "code"
            },
            {
                "data": "name"
            },
            {
                "data": "Actions",
                "searchable": false,
                "orderable": false
            }
        ],
        "language": {
            "emptyTable": "<?php echo lang('no_data_available'); ?>",
            "loadingRecords": "<?php echo lang('loading_data_from_server'); ?>"
        }
    });
});
</script>
<style type="text/css">
td:nth-child(1),
td:nth-child(5) {
    text-align: center !important;
}
</style>
<div class="main-content">
    <section class="content-header">
        <div class="row">
            <div class="col-sm-12">
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
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="table-container">
                    <table id="unitData" class="table">
                        <thead>
                            <tr class="active">
                                <th style="max-width:30px;"><?php echo lang("n.o"); ?></th>
                                <th><?php echo lang('branches'); ?></th>
                                <th><?php echo lang('code'); ?></th>
                                <th><?php echo lang('name'); ?></th>
                                <th style="width:75px;"><?php echo lang('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3" class="dataTables_empty"><?php echo lang('loading_data_from_server'); ?></td>
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