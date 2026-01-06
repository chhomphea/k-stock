<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h5 class="box-title"><?= lang('update_info'); ?></h5>
        </div>
        <div class="modal-body">
                <div class="box-body">
                    <?php echo form_open_multipart("settings/edit_table/".$tables->id);?>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="name"><?= $this->lang->line("name"); ?></label>
                            <?= form_input('name', set_value('name', $tables->name), 'class="form-control input-sm" id="name"'); ?>
                        </div>

                      <div class="form-group">
                            <label class="control-label" for="order_by"><?= $this->lang->line("order_by"); ?></label>
                            <?= form_input('order_by', set_value('order_by', $tables->order_by), 'class="form-control input-sm" id="order_by"'); ?>
                        </div>

                        <div class="form-group ">
                            <?= lang('group_tables', 'group_tables'); ?>
                            <?php
                            $gt[''] = lang("select")." ".lang("group_tables");
                            foreach($group_tables as $group_table) {
                                $gt[$group_table->id] = $group_table->name;
                            }
                             ?>
                            <?= form_dropdown('group_table', $gt, $tables->group_table, 'class="form-control select2 tip"  id="group_table"  required="required"'); ?>
                        </div> 

                        <div class="form-group ">
                            <?= lang('price_group', 'price_group'); ?>
                            <?php
                            $pg[''] = lang("select")." ".lang("price_group");
                            foreach($price_groups as $price_group) {
                                $pg[$price_group->id] = $price_group->name;
                            }
                            ?>
                            <?= form_dropdown('price_group', $pg, $tables->price_group_id, 'class="form-control select2 tip"  id="price_group"  required="required"'); ?>
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

