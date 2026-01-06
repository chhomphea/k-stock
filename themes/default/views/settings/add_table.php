<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h5 class="box-title"><?= lang('enter_info'); ?></h5>
        </div>
        <div class="modal-body">
            
                <div class="box-body">
                    <?php echo form_open_multipart("settings/add_table",'class="validation"');?>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="name"><?= $this->lang->line("name"); ?></label>
                            <?= form_input('name', set_value('name'), 'class="form-control input-sm" id="name" required="required"'); ?>
                        </div>

                        <div class="form-group">
                            <?= lang('order_by', 'order_by'); ?>
                            <?= form_input('order_by', set_value('order_by'), 'class="form-control input-sm" id="order_by" required="required"'); ?>
                        </div>
                         <div class="form-group ">
                            <?= lang('group_tables', 'group_tables'); ?>
                            <?php
                            $gt[''] = lang("select")." ".lang("group_tables");
                            foreach($group_table as $table) {
                                $gt[$table->id] = $table->name;
                            }
                             ?>
                            <?= form_dropdown('group_table', $gt, '', 'class="form-control select2 tip"  id="group_table"  required="required"'); ?>
                        </div>
                         <div class="form-group ">
                            <?= lang('price_group', 'price_group'); ?>
                            <?php
                            $pg[''] = lang("select")." ".lang("price_group");
                            foreach($price_groups as $price_group) {
                                $pg[$price_group->id] = $price_group->name;
                            }
                            ?>
                            <?= form_dropdown('price_group', $pg, '', 'class="form-control select2 tip"  id="price_group"  required="required"'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_submit('add_table', $this->lang->line("add_table"), 'class="btn btn-primary"');?>
                        </div>
                       
                    </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</section>

