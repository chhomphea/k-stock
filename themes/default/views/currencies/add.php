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
            <div class="box-body">
                <div class="form-container">
                    <div class="col-xl-6 col-sm-8 col-xs-12">
                         <?php echo form_open_multipart("currencies/create"); ?>
                            <div class="mb-2">
                                <?php echo lang('code', 'code');?>
                                <?php echo form_input('code', set_value('code'), 'class="form-control tip" id="code"  required="required"');?>
                            </div>
                            <div class="mb-2">
                                <?php echo lang('name', 'name');?>
                                <?php echo form_input('name', set_value('name'), 'class="form-control tip" id="name"  required="required"');?>
                            </div>
                            <div class="mb-2">
                                <?php echo lang('symbol', 'symbol');?>
                                <?php echo form_input('symbol', set_value('symbol'), 'class="form-control tip" id="symbol" required="required"');?>
                            </div>
                            <div class="mb-2">
                                <?php echo lang('rate', 'rate');?>
                                <?php echo form_input('rate', set_value('rate'), 'class="form-control tip" id="rate" required="required"');?>
                            </div>
                            <div class="mb-2">
                                <?php echo lang('operator', 'operator');?>
                                <?php $opertors = ['*' => lang('multiple'), '/' => lang('divition')]; ?>
                                <?php echo form_dropdown('operator', $opertors, set_value('operator'), 'class="form-control tip select2" style="width:100%;" id="operator"  required="required"');?>
                            </div>
                            <div class="mb-2">
                                <button type="submit" name="save" class="btn btn-primary"><i class="fas fa-save"> </i> <?=lang('save')?></button>
                                <button type="submit" name="reset" class="btn btn-danger" id="reset"><i class="fas fa-undo"></i> <?=lang('reset')?></button>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>