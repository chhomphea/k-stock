<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background-color: #2649a5">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h5 class="box-title" style="color: #fff;font-size: 18px"><?= lang('add_currency'); ?></h5>
        </div>
        <div class="modal-body">
            
            <div class="box-body">
                <?php echo form_open_multipart("settings/add_currency", 'class="validation"');?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="code"><?= $this->lang->line("Currency Code"); ?></label>
                            <?= form_input('code', set_value('code'), 'class="form-control input-sm" required="required" id="code"'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name"><?= $this->lang->line("Currency Name"); ?></label>
                            <?= form_input('name', set_value('name'), 'class="form-control input-sm" required="required" id="name"'); ?>
                        </div>

                        <div class="form-group">
                            <?= lang('operation', 'operation'); ?>
                            <?php $bs = array(''=>lang("please_select"),'/' => lang("division"), '*' => lang('multiple'));
                            echo form_dropdown('operation', $bs, $currency->operation??set_value('operation', ''), 'class="form-control select2" required="required" id="operation" style="width:100%;"'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="rate"><?= $this->lang->line("Exchange Rate"); ?></label>
                            <?= form_input('rate', set_value('rate'), 'class="form-control input-sm" required="required" id="rate"'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="symbol"><?= $this->lang->line("symbol"); ?></label>
                            <?= form_input('symbol', set_value('symbol'), 'class="form-control input-sm" required="required" id="symbol"'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_submit('add_currency', $this->lang->line("submit"), 'class="btn btn-primary"');?>
                        </div>
                    </div>
                    <?php echo form_close();?>
                </div>
        </div>
    </div>
</div>
<script type="text/javascript" charset="UTF-8">
    $(document).ready(function () {
        $(document).on('click', '.po-delete', function () {
            var id = $(this).attr('id');
            $(this).closest('tr').remove();
        });
    });
</script>