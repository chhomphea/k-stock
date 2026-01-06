<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<style type="text/css">
    .room-bg {
        background: #eaf0ed !important;
    }
</style>
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
                    <?php echo form_open_multipart("bookings/create"); ?>
                        <div class="col-xl-12 col-sm-12">
                            <div class="row">
                                <div class="col-xl-4 col-sm-6">
                                    <div class="mb-2">
                                        <?php echo lang('date', 'date');?>
                                        <?php echo form_input('date', set_value('date', $rowData->date), 'class="form-control datepicker" id="datepicker"  required="required"');?>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-6">
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
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                    <div class="mb-2">
                                        <?php echo lang('room', 'room');?>
                                        <?php
                                            $rooms[] = lang('please_select');
                                        ?>
                                        <?php echo form_dropdown('room', $rooms, set_value('room', $rowData->branch_id), 'class="form-control tip select2" style="width:100%;" id="room"');?>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                    <div class="mb-2">
                                        <?php echo lang('customers', 'customers');?>
                                        <?php echo form_input('customer', set_value('customer', $rowData->customer), 'class="form-control customer" id="customer"  required="required"');?>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                    <div class="mb-2">
                                        <?php echo lang('phone', 'phone');?>
                                        <?php echo form_input('phone', set_value('phone', $rowData->phone), 'class="form-control phone" id="phone"  required="required"');?>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                    <div class="mb-3">
                                        <label for="file" class="form-label"><?php echo lang('image')?></label>
                                        <input type="file" class="form-control tip" id="file" name="userfile">
                                        <div class="invalid-feedback"><?php echo lang('please_upload_file')?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%"><?php echo lang('n.o')?></th>
                                        <th width="15%"><?php echo lang('checkin_date')?></th>
                                        <th width="15%"><?php echo lang('floor')?></th>
                                        <th width="15%"><?php echo lang('name')?></th>
                                        <th width="15%"><?php echo lang('duration_months')?></th>
                                        <th width="15%"><?php echo lang('check_out_date')?></th>
                                        <th width="15%"><?php echo lang('price')?></th>
                                        <th><i class="fa fa-times"></i></th>
                                    </tr>
                                </thead>
                                <tbody id="append-data">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-right"><?=lang('total')?></th>
                                        <th colspan="6" class="text-right total">0.00</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="row">
                                <div class="col-xl-4 col-sm-6">
                                    <div class="mb-2">
                                        <?php echo lang('deposit', 'deposit');?>
                                        <?php echo form_input('deposit', set_value('deposit', $rowData->deposit), 'class="form-control deposit" id="deposit"  required="required"');?>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                    <div class="mb-2">
                                        <?php echo lang('paid_by', 'paid_by');?>
                                        <?php
                                            $bank[] = lang('please_select');
                                            foreach ($banks as $key => $row) {
                                                $bank[$row->id] = $row->name;
                                            }
                                        ?>
                                        <?php echo form_dropdown('paid_by', $bank, set_value('paid_by', $rowData->paid_by), 'class="form-control tip select2" style="width:100%;" id="paid_by"  required="required"');?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <button type="submit" name="save" class="btn btn-primary"><i class="fas fa-save"> </i> <?=lang('save')?></button>
                                <button type="submit" name="reset" class="btn btn-danger" id="reset"><i class="fas fa-undo"></i> <?=lang('reset')?></button>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    // $(document).ready(function() {
    //     $('#add_item').autocomplete({
    //         source: function(request, response) {
    //             $.ajax({
    //                 url: base_url + "bookings/getServices",
    //                 data: { term: request.term },
    //                 dataType: "json",
    //                 success: function(data) {
    //                     response(data);
    //                 }
    //             });
    //         },
    //         minLength: 1,
    //         autoFocus: false,
    //         delay: 200,
    //         response: function(event, ui) {
    //             if (ui.content.length === 0) {
    //                 $(this).val('');
    //             } else if ($(this).val().length >= 16 && ui.content[0].item_id == 0) {
    //                 $(this).val('');
    //             } else if (ui.content.length == 1 && ui.content[0].item_id != 0) {
    //                 ui.item = ui.content[0];
    //                 $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
    //                 $(this).autocomplete('close');
    //             } else if (ui.content.length == 1 && ui.content[0].item_id == 0) {
    //                 $(this).val('');
    //             }
    //         },
    //         select: function(event, ui) {
    //             event.preventDefault();
    //             if (ui.item.item_id !== 0) {
    //                 // var row = add_order_item(ui.item);
    //                 // if (row) {
    //                 //     $(this).val('');
    //                 // }
    //             }
    //         }
    //     });
    // });
    $("body").on("click", ".newRoom", function(e) {
        let $row = $(e.target).closest('tr');
        let roomId = $row.find('[name="roomId[]"]').val();
        let optionspro = '<?=$options?>';
        let row = '<tr>';
            row += '<td colspan="2" class="text-right"><select name="otherFee[]" class="form-control select2" style="width:100%">' + optionspro + '</select></td>';
            row += '<td class="rowCategory"><input type="hidden" name="service_room[]" value="' + roomId + '">N/A</td>';
            row += '<td class="rowUnit"><input type="hidden" name="product_unit[]" value="">N/A</td>';
            row += '<td class="rowQuantity"><input type="text" name="product_quantity[]" class="form-control" value="1"></td>';
            row += '<td class="rowPrice"><input type="text" name="product_price[]" class="form-control input-sm" value=""></td>';
            row += '<td class="rowSubtotal"><input type="text" name="product_subtotal[]" class="form-control input-sm subtotal" value=""></td>';
            row += '<td class="removeRoom text-center"><i class="fa fa-times"></i></td>';
            row += '</tr>';
        $("#append-data").append(row);
        $("#append-data .select2").select2();
    });
    $("body").on("change","#branch",function(e) {
        const branch       = $("#branch option:selected").val();
        $.ajax({
            url     : base_url + 'bookings/getRoomsBybranchs',
            type    : 'GET',
            dataType: 'JSON',
            data : {
                branch : branch
            },
            success :function(data){
                $("#room").html(data);
            }
        })
    });
    $("body").on("click",".removeRoom",function(e) {
        $(this).closest('tr').remove();
    });
    $("body").on("change","#room",function(e) {
        const room          = $("#room option:selected").val();
        const elements      = document.getElementsByClassName('rowName')??1;
        const length        = parseFloat(elements.length) + 1;
        $.ajax({
            url     : base_url + 'bookings/getRoombookings',
            type    : 'GET',
            dataType: 'JSON',
            data : {
                room : room,
                row  : length
            },
            success :function(data){
                $("#append-data").append(data);
                calculateTotal();
                $(".datepicker").flatpickr({
                    enableTime: false,
                        dateFormat: "Y-m-d",
                        onChange: function(selectedDates) {
                            $("#end-datetime").flatpickr("minDate", selectedDates[0]);
                        }
                });
            }
        })
    });
    $("body").on("change","[name='otherFee[]']",function(e) {
        $.ajax({
            url         : base_url + 'bookings/getServicesId',
            type        : 'GET',
            dataType    : 'JSON',
            data: {
                serviceId : $(this).val(),
            },
            success :function (data){
                let $row = $(e.target).closest('tr');
                $row.find('[name="product_category[]"]').val(data.category_id);
                $row.find('[name="product_unit[]"]').val(data.unit_id);
                $row.find('[name="product_price[]"]').val(data.price);
                $row.find('[name="product_subtotal[]"]').val(data.price);
                $row.find('.rowUnit').text(data.unit);
                $row.find('.rowCategory').text(data.category);
                calculateTotal();
            }
        })
    });
    $("body").on("change","[name='product_quantity[]'],[name='product_price[]']",function(e) {
        let $row        = $(e.target).closest('tr');
        let quantity    = $row.find('[name="product_quantity[]"]').val();
        let price       = $row.find('[name="product_price[]"]').val();
        $row.find('[name="product_subtotal[]"]').val(quantity * price);
        calculateTotal();
    });
    function calculateTotal() {
        let total = 0;
        $('.subtotal').each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        $('.total').text(total.toFixed(2));
    }
</script>