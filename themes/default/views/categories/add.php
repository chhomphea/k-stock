<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <p class="card-title mb-0 flex-grow-1"><?=lang('create_category')?></p>
                <div class="flex-shrink-0">
                </div>
            </div>
            <div class="card-body">
                <div class="live-preview">
                    <?php echo form_open_multipart("categories/create",['class' => 'row g-3 needs-validation','novalidate' => 'novalidate']);?>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <?= lang('code', 'code'); ?>
                                <?= form_input('code', set_value('code'), 'class="form-control tip" id="code"  required="required"'); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <?= lang('name', 'name'); ?>
                                <?= form_input('name', set_value('name'), 'class="form-control tip" id="name"  required="required"'); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <?= lang('order_display', 'order_display'); ?>
                                <?= form_input('order_display', set_value('order_display'), 'class="form-control tip" id="order_display"  required="required"'); ?>
                            </div>
                        </div>
                         <div class="col-md-12">
                            <div class="col-md-6">
                                <label for="file" class="form-label"><?=lang('image')?></label>
                                <input type="file" class="form-control tip" id="file" name="userfile">
                                <div class="invalid-feedback"><?=lang('please_upload_file')?></div>
                            </div>
                        </div>
                         <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input type="checkbox" class="form-check-input" checked value="1" name="display" id="display">
                                    <label class="form-check-label" for="display"><?php echo lang('display') ?></label>
                                </div>
                            </div>
                        </div>
                         <div class="col-md-12">
                            <div class="col-md-6">
                                <?= form_submit('save', lang('save'), 'class="btn btn-primary"'); ?>
                                <?= form_submit('reset', lang('reset'), 'class="btn btn-danger" id="reset"'); ?>
                            </div>
                        </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>