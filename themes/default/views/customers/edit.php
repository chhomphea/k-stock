<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<div class="main-content">
     <section class="content-header">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url()?>"></a><?php echo lang('home')?></li> ->
                    <?php
                        foreach ($bc as $b) {
                            if ($b['link'] === '#') {
                                echo '<li class="active"> / ' . $b['page'] . '</li>';
                            } else {
                                echo '<li><a href="' . $b['link'] . '">' . $b['page'] . '</a></li>';
                            }
                    }?>
                </ol>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <div class="form-container">
                    <div class="col-xl-6 col-sm-8 col-xs-12">
                         <?php echo form_open_multipart("customers/edit/" . $rowData->id); ?>
                            <div class="mb-2">
                                <?php echo lang('branches', 'branches');?>
                                <?php
                                    $brach[] = lang('please_select');
                                    foreach ($branches as $key => $row) {
                                        $brach[$row->id] = $row->branch_kh;
                                    }
                                ?>
                                <?php echo form_dropdown('branch', $brach, set_value('branch', $rowData->branch_id), 'class="form-control tip select2" style="width:100%;" id="branch"  required="required"');?>
                            </div>
                            <div class="mb-2">
                                <?php echo lang('name', 'name');?>
                                <?php echo form_input('name', set_value('name', $rowData->name), 'class="form-control tip" id="name"  required="required"');?>
                            </div>
                            <div class="mb-2">
                                <?php echo lang('phone', 'phone');?>
                                <?php echo form_input('phone', set_value('phone', $rowData->phone), 'class="form-control tip" id="phone"  required="required"');?>
                            </div>
                            <div class="mb-2">
                                <?php echo lang('address', 'address');?>
                                <?php echo form_input('address', set_value('address', $rowData->address), 'class="form-control tip" id="address"  required="required"');?>
                            </div>
                            <div class="mb-3">
                                <label for="file" class="form-label"><?php echo lang('image')?></label>
                                <input type="file" class="form-control tip" id="file" name="userfile">
                                <div class="invalid-feedback"><?php echo lang('please_upload_file')?></div>
                            </div>
                            <div class="mb-2">
                                <button type="submit" name="save" class="btn btn-primary"><i class="fas fa-save"> </i> 
                                    <?=lang('save')?>
                                </button>
                                <button type="submit" name="reset" class="btn btn-danger" id="reset"><i class="fas fa-undo"></i> 
                                    <?=lang('reset')?>
                                </button>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>