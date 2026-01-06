<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <p class="card-title mb-0 flex-grow-1"><?=lang('units')?></p>
                <div class="flex-shrink-0">
                </div>
            </div>
            <div class="card-body">
                <div class="live-preview">
                    <?php echo form_open_multipart("units/edit/" . $unit->id,['class' => 'row g-3 needs-validation','novalidate' => 'novalidate']);?>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <?php echo lang('code', 'code');?>
                                <?php echo form_input('code', set_value('code', $unit->code), 'class="form-control tip" id="code"  required="required"');?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <?php echo lang('name', 'name');?>
                                <?php echo form_input('name', set_value('name', $unit->name), 'class="form-control tip" id="name"  required="required"');?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <?php echo lang('order_display', 'order_display');?>
                                <?php echo form_input('order_display', set_value('order_display', $unit->sort), 'class="form-control tip" id="order_display"  required="required"');?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input type="checkbox" class="form-check-input" <?php echo $unit->active == 1 ? 'checked' : ''?> value="1" name="display" id="display">
                                    <label class="form-check-label" for="display"><?php echo lang('display') ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <?php echo form_submit('update', lang('update'), 'class="btn btn-primary"');?>
                                <?php echo form_submit('reset', lang('reset'), 'class="btn btn-danger" id="reset"');?>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                 </div>
            </div>
        </div>
    </div>
</div>