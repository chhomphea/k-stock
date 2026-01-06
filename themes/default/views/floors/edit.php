<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<div class="main-content">
     <section class="content-header">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url()?>"><?php echo lang('home')?></li> ->
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
            <div class="box-header">
                <span class="box-title">សូមបំពេញព័ត៌មានខាងក្រោម</span>
            </div>
            <div class="box-body">
                <div class="form-container">
                    <div class="col-xl-6 col-sm-8 col-xs-12">
                         <?php echo form_open_multipart("floors/edit/" . $rowData->id); ?>
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
                                <?php echo lang('order_display', 'order_display');?>
                                <?php echo form_input('order_display', set_value('order_display', $rowData->order_display), 'class="form-control tip" id="order_display"  required="required"');?>
                            </div>
                            <div class="mb-2 form-check">
                                <input type="checkbox" class="form-check-input" <?php echo $rowData->active == 1 ? 'checked' : ''?> value="1" name="display" id="display">
                                <label class="form-check-label" for="terms"><?php echo lang('display')?></label>
                            </div>
                            <div class="mb-2">
                                <?php echo form_submit('save', lang('save'), 'class="btn btn-primary"');?>
                                <?php echo form_submit('reset', lang('reset'), 'class="btn btn-danger" id="reset"');?>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>