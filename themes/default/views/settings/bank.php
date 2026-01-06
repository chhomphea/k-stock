<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#PData').DataTable({
            'ajax' : { url: '<?=site_url('settings/getBanks');?>', type: 'POST', "data": function ( d ) {
                d.<?=$this->security->get_csrf_token_name();?> = "<?=$this->security->get_csrf_hash()?>";
            }},
            "buttons": [
            { extend: 'copyHtml5', 'footer': false, exportOptions: { columns: [ 0, 1, 2, 3] } },
            { extend: 'excelHtml5', 'footer': false, exportOptions: { columns: [ 0, 1, 2, 3] } },
            { extend: 'csvHtml5', 'footer': false, exportOptions: { columns: [ 0, 1, 2, 3] } },
            { extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4', 'footer': false,
            exportOptions: { columns: [ 0, 1, 2, 3] } },
            { extend: 'colvis', text: 'Columns'},
            ],
            "columns": [
            { "data": "name" },
            { "data": "number" },
            { "data": "amount","render":currencyFormat },
            { "data": "statement" },
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
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
            <div class="box-header">
                    <h3 class="box-title"><?= lang('list_results'); ?></h3>
                    <ul class="nav navbar-nav pull-right">
                        <?php if ($Admin || $GP['bank_add']): ?>
                            <a href="<?= site_url('settings/add_bank'); ?>" title="<?=lang('add_unit')?>" class='' data-toggle='ajax'><i class="fa fa-plus-circle fa-2x"></i></a>
                        <?php endif ?>
                    </ul>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="PData" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="col-xs-2"><?= lang("name"); ?></th>
                                    <th class="col-xs-3"><?= lang("number"); ?></th>
                                    <th class="col-xs-2"><?= lang("amount"); ?></th>
                                    <th class="col-xs-3"><?= lang("statement"); ?></th>
                                    <th style="width:65px;"><?= lang("actions"); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="p0"><input type="text" class="form-control b0" name="search_table" id="search_table" placeholder="<?= lang('type_hit_enter'); ?>" style="width:100%;"></td>
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" charset="UTF-8">
  
    $(document).ready(function () {
        $(document).on('click', '.po-delete', function () {
            var id = $(this).attr('id');
            $(this).closest('tr').remove();
        });
    });
</script>