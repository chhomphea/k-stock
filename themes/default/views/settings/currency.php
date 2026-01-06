<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#PData').DataTable({

            'ajax' : { url: '<?=site_url('settings/get_currency');?>', type: 'POST', "data": function ( d ) {
                d.<?=$this->security->get_csrf_token_name();?> = "<?=$this->security->get_csrf_hash()?>";
            }},
            "buttons": [
            { extend: 'copyHtml5', 'footer': false, exportOptions: { columns: [ 0, 1, 2] } },
            { extend: 'excelHtml5', 'footer': false, exportOptions: { columns: [ 0, 1, 2] } },
            { extend: 'csvHtml5', 'footer': false, exportOptions: { columns: [ 0, 1, 2] } },
            // { extend: 'modal', 'footer': false, exportOptions: { columns: [ 0, 1, 2] } },
            { extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4', 'footer': false,
            exportOptions: { columns: [ 0, 1, 2] } },
            { extend: 'colvis', text: 'Columns'},
            ],
            "columns": [
                { "data": "code" },
                { "data": "name" },
                { "data": "operation" },
                { "data": "rate", "render": currencyFormat  },
                { "data": "symbol"},
            { "data": "Actions", "searchable": false, "orderable": false }
            ]
        });
        $('#search_table').on( 'keyup change', function (e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (((code == 13 && table.search() !== this.value) || (table.search() !== '' && this.value === ''))) {
                table.search( this.value ).draw();
            }
        });
    });
</script>
<section class="content">
    <div class="col-xs-12">
            <div class="row">
                <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?= lang('list_results'); ?></h3>
                    <ul class="nav navbar-nav pull-right">
                        <?php if ($Admin || $GP['currency_add']): ?>
                            <a href="<?= site_url('settings/add_currency'); ?>" title="<?=lang('add_currency')?>" class='' data-toggle='ajax'>
                                <i class="fa fa-plus-circle fa-2x"></i>
                            </a>
                        <?php endif ?>
                    </ul>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="PData" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="col-xs-2"><?= lang("currency code"); ?></th>
                                    <th class="col-xs-3"><?= lang("currency name"); ?></th>
                                    <th class="col-xs-2"><?= lang("operation"); ?></th>
                                    <th class="col-xs-3"><?= lang("exchange rate"); ?></th>
                                    <th class="col-xs-1"><?= lang("symbol"); ?></th>
                                    <th style="width:65px;"><?= lang("actions"); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="p0">
                                        <input type="text" class="form-control b0" name="search_table" id="search_table" placeholder="<?= lang('type_hit_enter'); ?>" style="width:100%;">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- <div class="modal fade" id="stModal" tabindex="-1" role="dialog" aria-labelledby="stModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <h4 class="modal-title" id="stModalLabel"><?= lang('update_status'); ?> <span id="status-id"></span></h4>
            </div>
            <?= form_open('sales/status'); ?>
            <div class="modal-body">
                <input type="hidden" value="" id="sale_id" name="sale_id" />
                <div class="form-group">
                    <?= lang('status', 'status'); ?>
                    <?php $opts = array('paid' => lang('paid'), 'partial' => lang('partial'), 'due' => lang('due'))  ?>
                    <?= form_dropdown('status', $opts, set_value('status'), 'class="form-control select2 tip" id="status" required="required" style="width:100%;"'); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close'); ?></button>
                <button type="submit" class="btn btn-primary"><?= lang('update'); ?></button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.sale_status', function() {
            $('#stModal').modal()
        });
    }); 
</script> -->