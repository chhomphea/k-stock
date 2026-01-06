<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background-color: #2649a5">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h5 class="box-title" style="color: #fff;"><?= lang('enter_info'); ?></h5>
        </div>
        <div class="modal-body">
             <?php echo form_open_multipart("settings/add_bank", 'class="validation"'); ?>
                <div class="box-body">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <?= lang('name', 'name'); ?>
                            <?= form_input('name', '', 'class="form-control" id="name" required="required"'); ?>
                        </div>

                        <div class="form-group all">
                            <?= lang('number', 'number'); ?>
                            <?= form_input('number', set_value('number'), 'class="form-control tip" required="required" id="number" '); ?>
                        </div>
                         <div class="form-group all">
                            <?= lang('amount', 'amount'); ?>
                            <?= form_input('amount', set_value('amount'), 'class="form-control tip" required="required" id="amount" '); ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <?php echo form_submit('add_bank', lang('add_bank'), 'class="btn btn-primary"'); ?>
                    </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" ></script>