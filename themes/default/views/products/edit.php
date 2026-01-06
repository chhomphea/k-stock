<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="live-preview">
                    <?php echo form_open_multipart("products/edit/".$product->id,['class' => 'row g-3 needs-validation','novalidate' => 'novalidate']); ?>
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <?php echo lang('code', 'code');?>
                                <?php echo form_input('code', set_value('code',$product->code), 'class="form-control tip" id="code"  required="required"');?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <?php echo lang('name', 'name');?>
                                <?php echo form_input('name', set_value('name',$product->name), 'class="form-control tip" id="name"  required="required"');?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <?php echo lang('category', 'category');?>
                                <?php
                                    $categoryOptions[] = lang('please_select');
                                    foreach ($categories as $key => $row) {
                                        $categoryOptions[$row->id] = $row->name;
                                    }
                                ?>
                                <?php echo form_dropdown('category', $categoryOptions, set_value('category',$product->category_id), 'class="form-control tip select2" style="width:100%;" id="category"  required="required"');?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <?php echo lang('unit', 'unit');?>
                                <?php
                                    $unitOptions[] = lang('please_select');
                                    foreach ($units as $key => $row) {
                                        $unitOptions[$row->id] = $row->name;
                                }?>
                                <?php echo form_dropdown('unit', $unitOptions, set_value('unit',$product->unit_id), 'class="form-control tip select2" style="width:100%;" id="unit"  required="required"');?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <?php echo lang('price', 'price');?>
                                <?php echo form_input('price', set_value('price',$product->price), 'class="form-control tip" id="price"  required="required"');?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12 mt-2">
                                <?php echo lang('cost', 'cost');?>
                                <?php echo form_input('cost', set_value('cost',$product->cost), 'class="form-control tip" id="cost"  required="required"');?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <?php echo lang('order_display', 'order_display');?>
                                <?php echo form_input('order_display', set_value('order_display', $product->order_display), 'class="form-control tip" id="order_display"  required="required"');?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <div class="image-dis">
                                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                        <img src="<?=base_url('assets/uploads/'.$product->image.'')?>" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                            <input id="profile-img-file-input" type="file" name="userfile" class="profile-img-file-input">
                                            <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                <span class="avatar-title rounded-circle bg-light text-body">
                                                    <i class="ri-camera-fill"></i>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
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