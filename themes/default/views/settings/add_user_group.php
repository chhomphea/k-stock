<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background-color: #2649a5">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h5 class="box-title" style="color: #fff;"><?= lang('enter_info'); ?></h5>
        </div>
        <div class="modal-body">
                <div class="box-body">
                    <div class="col-lg-12">
                        <?php echo form_open_multipart("settings/add_user_group", 'class="validation"'); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" value="<?=$group->id?>">
                                <div class="form-group">
                                    <?= lang('name', 'name'); ?>
                                    <?= form_input('name', $group->name??set_value('name'), 'class="form-control tip" id="name"  required="required"'); ?>
                                </div>
                                <div class="form-group">
                                    <?= lang('description', 'description'); ?>
                                    <?= form_input('description', $group->description??set_value('description'), 'class="form-control tip" id="description"  required="required"'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= form_submit('add_user_group', lang('add_user_group'), 'class="btn btn-primary"'); ?>
                        </div>
                        <?php echo form_close();?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
