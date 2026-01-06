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
                    <?php echo form_open_multipart("rooms/create"); ?>
                        <div class="col-xl-6 col-sm-8 col-xs-12">
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
                            <table class="table table-bordered">
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
                                <tbody id="append-data">

                                </tbody>
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
    $("body").on("click",".newRoom",function(e) {
        const branchId      = $("#branch option:selected").val();
        const branchName    = $("#branch option:selected").text();
        const floorId       = $("#floor option:selected").val();
        const floorName     = $("#floor option:selected").text();
        const elements      = document.getElementsByClassName('rowNumber')??1;
        const length        = parseFloat(elements.length) + 1;
        if (branchId && floorId < 1) {
            return false;
        }
        let row = '<tr>';
            row += '<td class="rowNumber text-center">'+ length +'</td>';
            row += '<td class="rowBranch"><input type="hidden" name="branchId[]" value="'+ branchId +'">'+ branchName +'</td>';
            row += '<td class="rowFloor"><input type="hidden" name="floorId[]" value="'+ floorId +'">'+ floorName +'</td>';
            row += '<td class="rowName"><input type="text" name="roomName[]" class="form-control input-sm" value=""></td>';
            row += '<td class="rowPrice"><input type="text" name="roomPrice[]" class="form-control input-sm" value=""></td>';
            row += '<td class="rowDisplay"><input type="text" name="orderDisplay[]" class="form-control input-sm" value="'+ length +'"></td>';
            row += '<td class="remvoveRoom text-center"><i class="fa fa-times"></i></td>';
            row += '</tr>';
        $("#append-data").append(row);
    });
</script>