<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<script type="text/javascript">
   
    $(document).ready(function() {
         function checkbox(x) {
            return '<div class="text-center"><input class="checkbox checkbox-product" type="checkbox"  name="val[]" value="' + x + '" /></div>';
        }
        var table = $('#PData').DataTable({

            'ajax' : { url: '<?=site_url('settings/getproductprice/'.$price_group->id);?>', type: 'POST', "data": function ( d ) {
                d.<?=$this->security->get_csrf_token_name();?> = "<?=$this->security->get_csrf_hash()?>";
            }},
            "buttons": [
            { extend: 'copyHtml5', 'footer': false, exportOptions: { columns: [1,2,3,4,6,7] } },
            { extend: 'excelHtml5', 'footer': false, exportOptions: { columns: [1,2,3,4,6,7] } },
            { extend: 'csvHtml5', 'footer': false, exportOptions: { columns: [1,2,3,4,6,7] } },
            { extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4', 'footer': false,
            exportOptions: { columns: [1,2,3,4,6,7] } },
            { extend: 'colvis', text: 'Columns'},
            ],
            "columns": [
            { "data": "id", "visible": false },
            { "data": "cname" },
            { "data": "codes" },
            { "data": "unit" },
            { "data": "name" },
            { "data": "details" },
            { "data": "price","searchable": true,"render": price_input, },
            { "data": "hide_price","visible": false},
            { "data": "uid", "render": checkbox}
            ],
             "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                nRow.id = aData.id;
                nRow.uid = aData.uid;
                return nRow;
            },
        });
        $('#search_table').on( 'keyup change', function (e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (((code == 13 && table.search() !== this.value) || (table.search() !== '' && this.value === ''))) {
                table.search( this.value ).draw();
            }
        });

        var ti = 0;
        function price_input(x) {
            return "<div class=\"text-center\"><input type=\"text\" name=\"price"+x+"\" value=\""+formatDecimal(x)+"\" class=\"form-control text-center price\" tabindex=\""+x+"\" style=\"padding:2px;height:auto;\"></div>";
        }  
    });
</script>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?= lang('list_results'); ?></h3>
                    <ul class="nav navbar-nav pull-right">
                        <i class="fa fa-save fa-2x"></i></a>
                    </ul>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <input type="hidden" value="<?=$price_group->id?>" class="group_id">
                        <table id="PData" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <td colspan="6" class="p0"><input type="text" class="form-control b0" name="search_table" id="search_table" placeholder="<?= lang('type_hit_enter'); ?>" style="width:100%;"></td>
                                </tr>
                                <tr>
                                    <th><?= lang("id"); ?></th>
                                    <th  style="width: 70px;" class="col-xs-3"><?= lang("categories"); ?></th>
                                    <th  style="width: 70px;" class="col-xs-3"><?= lang("product_code"); ?></th>
                                    <th  style="width: 70px;" class="col-xs-3"><?= lang("unit"); ?></th>
                                    <th  style="width: 70px;" class="col-xs-3"><?= lang("product_name"); ?></th>
                                    <th  style="width: 70px;" class="col-xs-3"><?= lang("product_name"); ?></th>
                                    <th  style="width: 70px;" class="col-xs-3"><?= lang("price"); ?></th>
                                    <th  style="width: 70px;" class="col-xs-3"><?= lang("price"); ?></th>
                                    <th  style="width: 70px;" class="col-xs-3"><?= lang("update"); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="7" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).change('.checkbox-product',function(event){
        $(event.target).closest('tr').find('.save').removeClass('btn-default');
        $(event.target).closest('tr').find('.save').addClass('btn-danger');
        var product_id = $(event.target).closest('tr').attr('id');
        var price      = $(event.target).closest('tr').find('.price').val();
        var unit_id    = $(event.target).closest('tr').find('.checkbox-product').val();
        var group_id   = $(".group_id").val();
        $.ajax({
            url: '<?=base_url('settings/product_price')?>',
            type: 'GET',
            dataType: 'JSON',
            data: {
                product_id: product_id,
                price     : price,
                group_id  : group_id,
                unit_id  : unit_id
            },
           success:function(data){

           }
       });
    });
</script>