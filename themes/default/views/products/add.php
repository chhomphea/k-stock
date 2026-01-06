<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <p class="card-title mb-0 flex-grow-1"><?=lang('create_product')?></p>
                <div class="flex-shrink-0">
                </div>
            </div>
            <div class="card-body">
                <div class="live-preview">
                    <?php echo form_open_multipart("products/create",['class' => 'row g-3 needs-validation','novalidate' => 'novalidate']); ?>
                        <div class="col-xxl-3 col-md-4">
                            <?php echo lang('code', 'code');?>
                            <?php echo form_input('code', set_value('code'), 'class="form-control tip" id="code"  required="required"');?>
                        </div>
                        <div class="col-xxl-3 col-md-4">
                            <?php echo lang('name', 'name');?>
                            <?php echo form_input('name', set_value('name'), 'class="form-control tip" id="name"  required="required"');?>
                        </div>
                        <div class="col-xxl-3 col-md-4">
                            <?php echo lang('category', 'category');?>
                            <?php
                                $categoryOptions[] = lang('please_select');
                                foreach ($categories as $key => $row) {
                                    $categoryOptions[$row->id] = $row->name;
                                }
                            ?>
                            <?php echo form_dropdown('category', $categoryOptions, set_value('category'), 'class="form-control tip select2" style="width:100%;" id="category"  required="required"');?>
                        </div>
                        <div class="col-xxl-3 col-md-4">
                            <?php echo lang('unit', 'unit');?>
                            <?php
                                $unitOptions[] = lang('please_select');
                                foreach ($units as $key => $row) {
                                    $unitOptions[$row->id] = $row->name;
                                }
                            ?>
                            <?php echo form_dropdown('unit', $unitOptions, set_value('unit'), 'class="form-control tip select2" style="width:100%;" id="unit"  required="required"');?>
                        </div>
                        <div class="col-xxl-3 col-md-4">
                            <?php echo lang('price', 'price');?>
                            <?php echo form_input('price', set_value('price'), 'class="form-control tip" id="price"  required="required"');?>
                        </div>
                        <div class="col-xxl-3 col-md-4">
                            <?php echo lang('cost', 'cost');?>
                            <?php echo form_input('cost', set_value('cost'), 'class="form-control tip" id="cost"  required="required"');?>
                        </div>
                        <div class="col-xxl-3 col-md-4">
                            <?php echo lang('order_display', 'order_display');?>
                            <?php echo form_input('order_display', set_value('order_display', $rowData->order_display), 'class="form-control tip" id="order_display"  required="required"');?>
                        </div>
                        <div class="col-xxl-3 col-md-4">
                            <label for="file" class="form-label"><?php echo lang('image')?></label>
                            <input type="file" class="form-control tip" id="file" name="userfile">
                            <div class="invalid-feedback"><?php echo lang('please_upload_file')?></div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-switch form-switch-md" dir="ltr">
                                <input type="checkbox" class="form-check-input" checked value="1" name="display" id="display">
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
</div>