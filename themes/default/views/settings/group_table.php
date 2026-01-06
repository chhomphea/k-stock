<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#PData').DataTable({
            'ajax' : { url: '<?=site_url('settings/get_grouptables');?>', type: 'POST', "data": function ( d ) {
                d.<?=$this->security->get_csrf_token_name();?> = "<?=$this->security->get_csrf_hash()?>";
            }},
            "buttons": [
            { extend: 'excelHtml5', 'footer': false, exportOptions: { columns: [ 0, 1] } },
            ],
            "columns": [
            { "data": "no" },
            { "data": "name" },
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
                        <a href="<?= site_url('settings/add_grouptable'); ?>" title="<?=lang('add_table')?>" class='' data-toggle='ajax'>
                        <i class="fa fa-plus-circle fa-2x"></i></a>
                    </ul>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="PData" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="col-md-3"><?= lang("description"); ?></th>
                                    <th class="col-md-5"><?= lang("name"); ?></th>
                                    <th class="col-md-1"><?= lang("actions"); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="p0"><input type="text" class="form-control b0" name="search_table" id="search_table" placeholder="<?= lang('type_hit_enter'); ?>" style="width:100%;"></td>
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
