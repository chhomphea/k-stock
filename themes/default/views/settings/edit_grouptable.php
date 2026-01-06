<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background-color: #2649a5">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h5 class="box-title" style="color: #fff"><?= lang('update_table'); ?></h5>
        </div>
        <div class="modal-body">
                <div class="box-body">
                    <?php echo form_open_multipart("settings/edit_grouptable/".$table->id);?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="no"><?= $this->lang->line("description"); ?></label>
                            <?= form_input('no', set_value('no', $table->no), 'class="form-control input-sm" id="no"'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name"><?= $this->lang->line("name"); ?></label>
                            <?= form_input('name', set_value('name', $table->name), 'class="form-control input-sm" id="name"'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_submit('update_table', $this->lang->line("update_table"), 'class="btn btn-primary"');?>
                        </div>
                    </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</section>

