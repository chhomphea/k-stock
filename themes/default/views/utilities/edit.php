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
                    <?php echo form_open_multipart("utilities/setup/" . $rowData->id); ?>
                    <div class="col-xl-4 col-sm-6 col-xs-12">
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
                            <?php echo lang('code', 'code');?>
                            <?php echo form_input('code', set_value('code', $rowData->code), 'class="form-control tip" id="name"  required="required"');?>
                        </div>
                        <div class="mb-2">
                            <?php echo lang('name', 'name');?>
                            <?php echo form_input('name', set_value('name', $rowData->name), 'class="form-control tip" id="name"  required="required"');?>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="8%"><?php echo lang('n.o')?></th>
                                    <th width="20%"><?php echo lang('branches')?></th>
                                    <th width="20%"><?php echo lang('from')?></th>
                                    <th width="20%"><?php echo lang('to')?></th>
                                    <th width="20%"><?php echo lang('price')?></th>
                                    <th><i class="fa fa-plus-circle fa-2x newRoom"></i></th>
                                </tr>
                            </thead>
                            <tbody id="append-data">
                                <?php $i = 1;foreach ($rows as $key => $row): ?>
                                    <tr>
                                        <td class="rowNumber text-center"><?php echo $i?></td>
                                        <td class="rowBranch"><input type="hidden" name="branchId[]" value="<?php echo $row->branch_id?>"><?php echo $row->branch_kh?></td>
                                        <td class="rowName"><input type="number" step="any" name="from[]" class="form-control input-sm" value="<?php echo $row->from * 1?>"></td>
                                        <td class="rowPrice"><input type="number" step="any" name="to[]" class="form-control input-sm" value="<?php echo $row->to * 1?>"></td>
                                        <td class="rowDisplay"><input type="number" step="any" name="price[]" class="form-control input-sm" value="<?php echo $row->price * 1?>"></td>
                                        <td class="remvoveRoom text-center"><i class="fa fa-times"></i></td>
                                    </tr>
                                <?php $i++;endforeach?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mb-2">
                        <button type="submit" name="save" class="btn btn-primary"><i class="fas fa-save"> </i> <?=lang('save')?></button>
                        <button type="submit" name="reset" class="btn btn-danger" id="reset"><i class="fas fa-undo"></i> <?=lang('reset')?></button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $("body").on("click",".newRoom",function(e) {
        const branchId      = $("#branch option:selected").val();
        const branchName    = $("#branch option:selected").text();
        const elements      = document.getElementsByClassName('rowNumber')??1;
        const length        = parseFloat(elements.length) + 1;
        if (!branchId) {
            return false;
        }
        let row = '<tr>';
            row += '<td class="rowNumber text-center">'+ length +'</td>';
            row += '<td class="rowBranch"><input type="hidden" name="branchId[]" value="'+ branchId +'">'+ branchName +'</td>';
            row += '<td class="rowName"><input type="number" step="any" name="from[]" class="form-control input-sm" value=""></td>';
            row += '<td class="rowPrice"><input type="number" step="any" name="to[]" class="form-control input-sm" value=""></td>';
            row += '<td class="rowDisplay"><input type="number" step="any" name="price[]" class="form-control input-sm" value=""></td>';
            row += '<td class="remvoveRoom text-center"><i class="fa fa-times"></i></td>';
            row += '</tr>';
        $("#append-data").append(row);
    });
</script>