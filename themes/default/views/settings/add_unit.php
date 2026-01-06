<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background-color: #2649a5">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h5 class="box-title" style="color: #fff;"><?= lang('enter_info'); ?></h5>
        </div>
        <div class="modal-body">
                <div class="box-body">
                    <div class="col-lg-12">
                        <?php echo form_open_multipart("settings/add_unit", 'class="validation"'); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" value="<?=$inv->id?>">
                                <div class="form-group">
                                    <?= lang('code', 'code'); ?>
                                    <?= form_input('code', $inv->code??set_value('code'), 'class="form-control tip" id="code"  required="required"'); ?>
                                </div>
                                <div class="form-group">
                                    <?= lang('name', 'name'); ?>
                                    <?= form_input('name', $inv->name??set_value('name'), 'class="form-control tip" id="name"  required="required"'); ?>
                                </div>
                                <div class="form-group">
                                    <?= lang('base_unit', 'base_unit'); ?>
                                    <?php 
                                        $sel[''] =lang("please_select");
                                        foreach ($base_unit as $key => $unit) {
                                            $sel[$unit->id] = $unit->name;
                                        }
                                     ?>
                                    <?php echo form_dropdown('base_unit', $sel, set_value('base_unit', $inv->base_unit??''), 'class="form-control select2" id="base_unit" style="width:100%;"'); ?>
                                </div>
                                <div class="form-group base_unit">
                                    <?= lang('operation', 'operation'); ?>
                                    <?php $bs = array(''=>lang("please_select"),'+' => lang("addition"), '/' => lang("division"), '*' => lang('multiple'),'-' => lang("substraction"));
                                    echo form_dropdown('operation', $bs, $inv->operation??set_value('operation', ''), 'class="form-control select2" id="operation" style="width:100%;"'); ?>
                                </div>
                                <div class="form-group base_unit">
                                    <?= lang('operation_value', 'operation_value'); ?>
                                    <?= form_input('operation_value', $inv->operation_value??set_value('operation_value'), 'class="form-control tip" id="operation_value"'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= form_submit('add_unit', lang('add_unit'), 'class="btn btn-primary"'); ?>
                        </div>
                        <?php echo form_close();?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(".base_unit").addClass('hide')
        if ($("#base_unit option:selected").val()>0) {
             $(".base_unit").removeClass('hide');
        }else{
            $(".base_unit").addClass('hide');
        }
    });
    $("#base_unit").change(function (e) {
        var base_unit = $("#base_unit option:selected").val();
        if (base_unit>0) {
            $(".base_unit").removeClass('hide');
        }else{
            $(".base_unit").addClass('hide');
        }
    });
</script>
