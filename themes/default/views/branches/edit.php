<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card-body">
            <div class="live-preview">
                <?php echo form_open_multipart("branches/edit/" . $rowData->id,['class' => 'row g-3 needs-validation','novalidate' => 'novalidate']); ?>
                    <div class="col-md-4">
                        <?php echo lang('code', 'code');?>
                        <?php echo form_input('code', set_value('code', $rowData->code), 'class="form-control tip" id="code"  required="required"');?>
                    </div>
                    <div class="col-md-4">
                        <?php echo lang('branch_kh', 'branch_kh');?>
                        <?php echo form_input('branch_kh', set_value('branch_kh', $rowData->branch_kh), 'class="form-control tip" id="branch_kh"  required="required"');?>
                    </div>
                    <div class="col-md-4">
                        <?php echo lang('branch_en', 'branch_en');?>
                        <?php echo form_input('branch_en', set_value('branch_en', $rowData->branch_en), 'class="form-control tip" id="branch_en"  required="required"');?>
                    </div>
                    <div class="col-md-4">
                        <?php echo lang('address_kh', 'address_kh');?>
                        <?php echo form_input('address_kh', set_value('address_kh', $rowData->address_kh), 'class="form-control tip" id="address_kh"  required="required"');?>
                    </div>
                    <div class="col-md-4">
                        <?php echo lang('address_en', 'address_en');?>
                        <?php echo form_input('address_en', set_value('address_en', $rowData->address_en), 'class="form-control tip" id="address_en"  required="required"');?>
                    </div>
                    <div class="col-md-4">
                        <?php echo lang('phone', 'phone');?>
                        <?php echo form_input('phone', set_value('phone', $rowData->phone), 'class="form-control tip" id="phone"  required="required"');?>
                    </div>
                    <div class="col-md-4">
                        <?php echo lang('order_display', 'order_display');?>
                        <?php echo form_input('order_display', set_value('order_display', $rowData->order_display), 'class="form-control tip" id="order_display"  required="required"');?>
                    </div>
                    <div class="col-md-4">
                        <label for="file" class="form-label"><?php echo lang('image')?></label>
                        <input type="file" class="form-control tip" id="file" name="userfile">
                        <div class="invalid-feedback"><?php echo lang('please_upload_file')?></div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input type="checkbox" class="form-check-input" <?php echo $rowData->active == 1 ? 'checked' : ''?>  value="1" name="display" id="display">
                            <label class="form-check-label" for="display"><?php echo lang('display') ?></label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php echo form_submit('save', lang('save'), 'class="btn btn-primary"');?>
                        <?php echo form_submit('reset', lang('reset'), 'class="btn btn-danger" id="reset"');?>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>