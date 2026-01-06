<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<div class="main-content">
     <section class="content-header">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=site_url()?>"><?=lang('home')?></a></li>
                    <?php foreach ($bc as $b) {
                        if ($b['link'] === '#') {
                            echo '<li class="breadcrumb-item">'. $b['page'] .'</li>';
                        } else {
                            echo '<li class="breadcrumb-item active" aria-current="page"><a href="' . $b['link'] . '">' . $b['page'] . '</a></li>';
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
                    <?php echo form_open_multipart("invoices/saveUtilities"); ?>
                        <div class="col-sm-6 col-xs-12">
                            <div class="mb-2">
                                <?php echo lang('date', 'date');?>
                                <?php echo form_input('date', set_value('date', $rowData->date), 'class="form-control datepicker" id="datepicker"  required="required"');?>
                            </div>
                            <div class="mb-2">
                            <?php
                                echo lang('branches', 'branches');
                                $branchOptions[] = lang('please_select');
                                foreach ($branches as $key => $row) {
                                    $branchOptions[$row->id] = $row->branch_kh;
                                }
                            ?>
                            <?php echo form_dropdown('branch', $branchOptions, set_value('branch'), 'class="form-control tip select2" style="width:100%;" id="branch"  required="required"');?>
                            </div>
                            <div class="mb-3">
                                <?php echo lang('floor', 'floor');?>
                                <?php echo form_dropdown('floor', $floorOptions, set_value('floor'), 'class="form-control tip select2" style="width:100%;" id="floor"  required="required"');?>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <table class="table table-bordered table-utilities">
                                <thead>
                                    <tr>
                                        <th width="8%"><?php echo lang('n.o')?></th>
                                        <th width="20%"><?php echo lang('branches')?></th>
                                        <th width="20%"><?php echo lang('floor')?></th>
                                        <th width="20%"><?php echo lang('name')?></th>
                                        <th width="20%"><?php echo lang('price')?></th>
                                        <th width="15%"><?php echo lang('order_display')?></th>
                                        <th><i class="fa fa-plus-circle fa-2x newRoom"></i></th>
                                    </tr>
                                </thead>
                            </table>
                            <div class="mb-2">
                                <?php echo form_submit('save', lang('save'), 'class="btn btn-primary"');?>
                                <?php echo form_submit('reset', lang('reset'), 'class="btn btn-danger" id="reset"');?>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    var utilities = [];
    $("#branch").change(function(event) {
        const branchId = $(this).val();
        $.ajax({
            url: base_url + 'rooms/getFloorBranch',
            type: 'get',
            dataType: 'JSON',
            data: {
                branchId: branchId
            },
            success:function(data){
                $("#floor").html(data);
            }
        })
    });
    $("#floor").change(function(event) {
        const floorId = $(this).val();
        const branch = $("#branch").val();
        $.ajax({
            url     : base_url + 'invoices/getAllroomsStaying',
            type    : 'get',
            dataType: 'JSON',
            data    : {
                floorId: floorId,
                branch : branch,
            },
            success:function(data){
                $(".table-utilities").html(data.dataHtml);
                utilities = data.utility;
            }
        })
    });
    $(document).on('input', 'input[name^="old"], input[name^="new"]', function() {
        var $row = $(this).closest('tr');
        utilities.forEach(function(u) {
            var oldVal = parseFloat($row.find('input[name="old' + u.id + '[]"]').val()) || 0;
            var newVal = parseFloat($row.find('input[name="new' + u.id + '[]"]').val()) || 0;
            $row.find('input[name="used' + u.id + '[]"]').val(newVal - oldVal);
        });
    });
    $(document).on('focus', 'input.form-control', function() {
        $(this).select();
    });

</script>