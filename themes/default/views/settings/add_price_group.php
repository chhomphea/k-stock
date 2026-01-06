<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h5 class="box-title"><?= lang('enter_info'); ?></h5>
        </div>
        <div class="modal-body">
            
                <div class="box-body">
                    <?php echo form_open_multipart("settings/addprice_group");?>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="name"><?= $this->lang->line("name"); ?></label>
                            <?= form_input('name', set_value('name'), 'class="form-control input-sm" id="name"'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_submit('add_price_group', $this->lang->line("add_price_group"), 'class="btn btn-primary"');?>
                        </div>
                    </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</section>


