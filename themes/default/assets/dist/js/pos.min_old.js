function add_invoice_item(item) {
  if (count == 1) {
    spositems = {};
  }
  if (item == null) {
    return;
  }
  var item_id = Settings.item_addition == 1 ? item.item_id : item.id;
  if (spositems[item_id]) {
    spositems[item_id].id = item.id;
    spositems[item_id].row.unit_quantity = parseFloat(spositems[item_id].row.unit_quantity) + parseFloat(item.row.unit_quantity || 5);
    spositems[item_id].row.qty = parseFloat(spositems[item_id].row.qty) + parseFloat(item.row.qty || 1);
  } else {
    spositems[item_id] = item;
  }
  store('spositems', JSON.stringify(spositems));
  loadItems();
  return true;
}
function exchange(qty, unitObj) {
    switch(unitObj.operation) {
        case '*':
            return parseFloat(qty)*parseFloat(unitObj.rate);
            break;
        case '/':
            return parseFloat(qty)/parseFloat(unitObj.rate);
            break;
    }
}
function baseUnit(qty, unitObj) {
    switch(unitObj.operation) {
      case '*':
          return parseFloat(qty)*parseFloat(unitObj.operation_value);
          break;
      case '/':
          return parseFloat(qty)/parseFloat(unitObj.operation_value);
          break;
      case '+':
          return parseFloat(qty)+parseFloat(unitObj.operation_value);
          break;
      case '-':
          return parseFloat(qty)-parseFloat(unitObj.operation_value);
          break;
    }
}
function calculateQTY(qty,operation,qty_perunit){
    switch(operation) {
      case '*':
          return parseFloat(qty)*parseFloat(qty_perunit);
          break;
      case '/':
          return parseFloat(qty)/parseFloat(qty_perunit);
          break;
      case '+':
          return parseFloat(qty)+parseFloat(qty_perunit);
          break;
      case '-':
          return parseFloat(qty)-parseFloat(qty_perunit);
          break;
    }
}
function loadItems() {
  if (count == 1) {
      spositems = {};
  }
  if (get('spositems')) {
    total = 0;
    count = 1;
    an = 1;
    item_order = 1;
    product_tax = 0;
    invoice_tax = 0;
    product_discount = 0;
    order_discount = 0;
    total_discount = 0;
    $('#posTable tbody').empty();
    var time = new Date().getTime() / 1000;
    var from_time = $("#from_time").val();
    $('#bill_span').empty();
    $('.order_span').empty();
    if(get('total_people')) {
      $('#total_people').val(get('total_people'));
    }
    $('.order-table').empty();
    var style         = '<style>.bb td, .bb th { border-bottom: 1px solid #DDD; }</style>';
    var pos_head      = "";
    var pos_customer  = "<h4 class='order_cus'>"+lang.table +':'+ $("#select2-spos_customer-container").text() + "</h4>";
    var hr            = '';
    var queue         = "<h3 class='queue_order'></h3>";
    var user          = "<h4>"+lang.user +' : '+ username + "</h4>";
    var time_eating   = "<h4>"+'Start Time : '+ from_time +  ' End Time : '+ date("h:i A", time) +"</h4>";
    var row_order     ='<thead>'+
                          '<tr>'+
                              '<th style="background-color: black !important;color: #fff !important;" width="85%">'+lang.name+'</th>'+
                              '<th style="background-color: black !important;color: #fff !important;" width="15%">'+lang.quantity+'</th>'+
                          '</tr>'+
                      '</thead>';
    $('.order_span').prepend(style + '' + '<h4>' + '' + '</h4></span>' + queue + pos_customer  + user );
    $('#bill_span').prepend(style + '' + '<h4>' + '' + '</h4></span>' + pos_customer  + time_eating + user  +'<span class="t_items" style="font-weight:bold;font-size: 17px"></span>');
    $("#order-table").html(row_order);
    $('#bill-table').empty();
    spositems = JSON.parse(get('spositems'));
    var sortable = [];
    for (var id in spositems) {
      sortable.push([spositems[id].id, spositems[id]]);
    }
    sortable.sort(function (a, b) {
      return a[0] < b[0] ? -1 : a[0] > b[0] ? 1 : 0;
    });
    var option_unit ='';
    $.each(sortable, function () {
      var item = this[1];
      var item_id = Settings.item_addition == 1 ? item.item_id : item.id;
      if (item.row.unit != item.row.default_sale_unit) {
          spositems[item_id].row.qty = calculateQTY(item.row.unit_quantity,item.row.operation,item.row.qty_perunit);
      }else{
          spositems[item_id].row.qty = item.row.unit_quantity;
      }
      // console.log(item);
      spositems[item_id] = item;
      var product_id = item.row.id,
          item_type = item.row.type,
          total_modify = parseFloat(item.row.total_modify)?item.row.total_modify:0,
          item_tax_method = parseFloat(item.row.tax_method),
          combo_items = item.combo_items,
          item_qty = item.row.qty,
          item_aqty = parseFloat(item.row.quantity),
          item_type = item.row.type,
          item_ds = item.row.discount,
          item_code = item.row.code,
          item_name = item.row.name.replace(/"/g, '&#034;').replace(/'/g, '&#039;');
      var unit_price = parseFloat(item.row.real_unit_price);
      var net_price = unit_price;
      var item_comment = item.row.comment;
      var item_was_ordered = 0;
      var ds = item_ds ? item_ds : '0';
      var item_discount = formatDecimal(ds);
      if (ds.indexOf('%') !== -1) {
        var pds = ds.split('%');
        if (!isNaN(pds[0])) {
          item_discount = formatDecimal(parseFloat(((parseFloat(net_price) + parseFloat(total_modify)) * parseFloat(pds[0])) / 100), 4);
        }
      }
      product_discount += formatDecimal(item_discount * item_qty, 4);
      net_price = formatDecimal(net_price - item_discount, 4);
      var pr_tax = parseFloat(item.row.tax),
      pr_tax_val = 0;
      if (pr_tax !== null && pr_tax != 0) {
        if (item_tax_method == 0) {
          pr_tax_val = inclusiveTax(net_price, pr_tax);
          net_price -= pr_tax_val;
          tax = lang.inclusive;
        } else {
          pr_tax_val = exlusiveTax(net_price, pr_tax);
          tax = lang.exclusive;
        }
      }
      product_tax += formatDecimal(pr_tax_val * item_qty, 4);
      var row_no = new Date().getTime();
      var modify = '';
      if (item.row.modify!='') {
        var modify = '('+ item.row.modify_name +')';
      }
      var newTr = $('<tr id="' + row_no + '" class="' + item_id + '" data-item-id="' + item_id + '" data-id="' + item.row.id + '" style="height: 20px"></tr>');
      tr_html ='<td>'+
                  '<input name="product_id[]" type="hidden" class="rid" value="' + product_id +'">'+
                  '<input name="item_comment[]" type="hidden" class="ritem_comment" value="' + item_comment +'">'+
                  '<input name="sale_type[]" type="hidden" class="sale_type" value="' + item.row.sale_type +'">'+
                  '<input name="product_code[]" type="hidden" value="' + item.row.code +'">'+
                  '<input name="modify_name[]" type="hidden" value="' + item.row.modify_name +'">'+
                  '<input name="modify_id[]" type="hidden" value="' + item.row.modify_id +'">'+
                  '<input name="modify_total[]" type="hidden" value="' + item.row.total_modify +'">'+
                  '<input name="product_name[]" type="hidden" value="' + item.row.name +'">'+
                  '<button type="button" class="btn bg-default btn-block btn-xs edit" id="' + row_no +'" data-item="' + item_id +'" >'+
                  '<span  class="sname" id="name_' + row_no + '" >' + item_name + modify +'</span></button>'+
                '</td>';
      tr_html +='<td class="text-right">'+
                  '<input class="realuprice" name="real_unit_price[]" type="hidden" value="' + parseFloat(parseFloat(item.row.real_unit_price) + parseFloat(total_modify)) + '">'+
                  '<input class="rdiscount" name="product_discount[]" type="hidden" id="discount_' + row_no + '" value="' + ds + '">'+
                  '<span class="text-right sprice" id="sprice_' + row_no + '">' + formatMoney(parseFloat(net_price) + parseFloat(pr_tax_val) + parseFloat(total_modify)) + '</span>'+
                '</td>';
      tr_html +='<td>'+
                  '<input name="item_was_ordered[]" type="hidden" class="riwo" value="' + item_was_ordered + '">'+
                  '<input name="quantity_item[]" type="hidden" class="quantity_item" value="' + formatDecimal(item.row.qty) + '">'+
                  '<input name="product_unit[]" type="hidden" class="product_unit" value="' + item.row.unit + '">'+
                  '<input name="sale_unit[]" type="hidden" class="sale_unit" value="' + item.row.default_sale_unit + '">'+
                  '<input class="form-control input-qty kb-pad text-center rquantity" name="quantity[]" type="text" value="' + formatDecimal(item.row.unit_quantity) + '" data-id="' + row_no + '" data-item="' + item_id + '" id="quantity_' + row_no + '" onClick="this.select();">'+
                '</td>';
      tr_html +='<td class="text-center">'+
                  '<span class="text-right">' + item.row.unit_name + '</span>'+
                  '<input name="item_was_ordered[]" type="hidden" class="riwo" value="' + item_was_ordered + '">'+
                '</td>';
      tr_html +='<td class="text-right">'+
                  '<span class="text-right ssubtotal" id="subtotal_' + row_no + '">' + formatMoney((parseFloat(net_price) + parseFloat(pr_tax_val) + parseFloat(total_modify)) * parseFloat(item.row.unit_quantity)) + '</span>'+
                '</td>';
      tr_html +='<td style="width="5%" class="text-center">'+
                  '<i class="fa fa-trash-o tip pointer posdel" id="' + row_no + '" title="Remove"></i>'+
                '</td>';
      newTr.html(tr_html);
      newTr.prependTo('#posTable');
      total += formatDecimal((parseFloat(net_price) + parseFloat(pr_tax_val) + parseFloat(total_modify)) * parseFloat(item.row.unit_quantity), 4);
      count += parseFloat(item.row.unit_quantity);
      item_order += parseFloat(an);
      an++;
      var oitb = $('#list-table-div')[0].scrollHeight;
      $('#list-table-div').slimScroll({ scrollTo: oitb });
      if (item_type == 'standard' && formatDecimal(item_qty) > formatDecimal(item_aqty)) {
        $('#' + row_no).addClass('danger');
        $('#' + row_no)
        .find('.edit');
      } else if (item_type == 'combo') {
        if (combo_items === false) {
          $('#' + row_no).addClass('danger');
        } else {
          $.each(combo_items, function () {
            if (parseFloat(this.quantity) < parseFloat(this.qty) * item_qty) {
              $('#' + row_no).addClass('danger');
              $('#' + row_no)
                .find('.edit');
            }
          });
        }
      }
      var comments = item_comment ? item_comment.split(/\r?\n/g) : [];
      if (1 != Settings.remote_printing) {
          if (item.row.unit_quantity-item.row.quantity_print>0) {
            var row_order='<tr class="bb row_' +row_no+ '" data-item-id="' +row_no+ '">'+
                              '<td>#' + (an - 1) + " " + item.row.name + modify + "</td>"+
                              "<td class='text-center'>[ " + parseFloat(item.row.unit_quantity-item.row.quantity_print) + " ]</td>"+ 
                          "</tr>";
          }
          if (item.row.sale_type=='void') {
            var row_bill = '<tr class="row_' +row_no+ '" data-item-id="' +row_no+ '">'+
                              '<td width="60%" class="text-left"><del>'+(an - 1)+ ' x ' + " " + (0 ==row_no? t.row.name : item.row.name )+ modify +'</del></td>'+
                              '<td width="15%" class="text-right">'+ formatMoney((parseFloat(unit_price) + parseFloat(product_tax)) * parseFloat(item.row.unit_quantity)) +'</td>'+
                          '</tr>';
          } else {
            var row_bill = '<tr class="row_' +row_no+ '" data-item-id="' +row_no+ '">'+
                              '<td style="width:140px" class="text-left">'+ (0 ==row_no? t.row.name : item.row.name )+ modify + item_comment +'</td>'+
                              '<td width="10%" style="white-space: nowrap !important;" class="text-center">' + formatMoney(unit_price) +'</td>'+
                              '<td height="10%" style="white-space: nowrap !important;" class="text-left">' + item.row.discount +'</td>'+
                              '<td width="10%" style="white-space: nowrap !important;" class="text-center"> x '+Number(item.row.unit_quantity).toFixed(0)+'</td>'+
                              '<td width="10%" class="text-right">' + formatMoney((parseFloat(net_price) + parseFloat(product_tax)) * parseFloat(item.row.unit_quantity)) +'</td>'+
                          '</tr>';
          }
          S = row_order;
      } else {
          if (item.row.unit_quantity-item.row.quantity_print>0) {
            var row_order='<tr class="bb row_' +row_no+ '" data-item-id="' +row_no+ '">'+
                              '<td>#' + (an - 1) + " " + item.row.name + modify + "</td>"+
                              "<td>[ " + parseFloat(item.row.unit_quantity-item.row.quantity_print) + " ]</td>"+ 
                          "</tr>";
          }
          if (item.row.sale_type=='void') {
            var row_bill = '<tr class="row_' +row_no+ '" data-item-id="' +row_no+ '">'+
                              '<td width="60%" class="text-left loop_name"><del>'+(an - 1)+ ' x ' + " " + (0 ==row_no? t.row.name : item.row.name )+ modify +'</del></td>'+
                              '<td width="15%" class="text-right">'+ formatMoney((parseFloat(unit_price) + parseFloat(product_tax)) * parseFloat(item.row.unit_quantity)) +'</td>'+
                          '</tr>';
          } else {
            $commit = '';
            if (item_comment !='') {
              $commit = "("+item_comment+")";
            }
            var row_bill = '<tr class="row_' +row_no+ '" data-item-id="' +row_no+ '">'+
                              '<td style="width:140px" class="text-left">'+ (0 ==row_no? t.row.name : item.row.name )+ modify + $commit +'</td>'+
                              '<td width="10%" style="white-space: nowrap !important;" class="text-center">' + formatMoney(unit_price) +'</td>'+
                              '<td height="10%" style="white-space: nowrap !important;" class="text-left">' + item.row.discount +'</td>'+
                              '<td width="10%" style="white-space: nowrap !important;" class="text-center"> x '+Number(item.row.unit_quantity).toFixed(0)+'</td>'+
                              '<td width="10%" class="text-right">' + formatMoney((parseFloat(net_price) + parseFloat(product_tax)) * parseFloat(item.row.unit_quantity)) +'</td>'+
                          '</tr>';
          }
          
      }
      $("#order-table"+item.row.printer+"").append(row_order);
      $("#bill-table").append(row_bill);
    });
    var ds = get('spos_discount') ? get('spos_discount') : $('#discount_val').val() ? $('#discount_val').val() : '0';
    order_discount = parseFloat(ds);
    if (ds.indexOf('%') !== -1) {
      var pds = ds.split('%');
      order_discount = parseFloat((total * parseFloat(pds[0])) / 100);
    }

    var ts = get('spos_tax') ? get('spos_tax') : $('#tax_val').val() ? $('#tax_val').val() : '0';
    order_tax = parseFloat(ts);
    if (ts.indexOf('%') !== -1) {
      var pts = ts.split('%');
      order_tax = ((total - order_discount) * parseFloat(pts[0])) / 100;
    }

    var g_total = total - parseFloat(order_discount) + parseFloat(order_tax);
    grand_total = formatMoney(g_total);
    total_discount = parseFloat(order_discount) + parseFloat(product_discount);
    subtotal = parseFloat(g_total) + parseFloat(total_discount);
    $('#ds_con').text('(' + formatMoney(product_discount) + ') ' + formatMoney(order_discount));
    $('#ts_con').text(formatMoney(order_tax));
    $('#total-payable').text(grand_total);
    $('#total').text(formatMoney(total));
    $('#count').text(an - 1 + ' (' + formatMoney(count - 1) + ')');
    $('.t_items').text( lang.total_items +': '+( an - 1) + ' (' +'Qty : ' + parseFloat(count - 1) + ')');
    
    var total_people = $('#total_people').val();
    var bill_totals= '';
    bill_totals+='<tr><td  colspan="2">SubTotal (USD) : '+'</td><td colspan="2" style="text-align:right;">' + formatMoney(subtotal) + "</td></tr>";
    if (count>1) {
        bill_totals+= '<tr><td colspan="2">' + lang.discount +'('+ds+')'+ '</td><td colspan="2" style="text-align:right">' + formatMoney(total_discount) + "</td></tr>";
      if (0 != order_tax) {
         bill_totals+= '<tr><td>' + lang.order_tax + '</td><td style="text-align:right">' + formatMoney(order_tax) + "</td></tr>";
      }
      bill_totals+='<tr><td  colspan="2">' + lang.total + ' (USD) : '+'</td><td colspan="2" style="text-align:right;">' + formatMoney(grand_total) + "</td></tr>";
      for (var i = 0; i < currencies.length; i++) {
          var rate_exchange = currencies[i];
          var symbol = currencies[i].symbol;
          bill_totals+='<tr class="bill"><td colspan="2">' + lang.total +'('+currencies[i].code+')'+ '</td><td colspan="2" style="text-align:right;">' + formatExchange(exchange(grand_total,rate_exchange),symbol) + "</td></tr>";
      }
      bill_totals+='<tr><td colspan="4"> People : ' + (total_people)+ ' : (1 = '+formatMoney(Number(g_total)/Number( total_people ))+ ")</td></tr>";
    }
    $("#bill-total-table").empty();
    $("#bill-total-table").append(bill_totals)
    if (Settings.display_kb == 1) {
      display_keyboards();
    }
    $('#add_item').focus();
  }
}

function chr(i) {
  return String.fromCharCode(i);
}

$(document).ready(function () {
  $(document).on('click', '.no-results, #filter-suspended-sales', function (e) {
    e.preventDefault();
    e.stopPropagation();
  });

  $('#susModal').on('shown.bs.modal', function (e) {
    $('#reference_note').focus();
  });

  $('#filter-categories').hideseek({
    nodata: lang.no_match_found,
  });

  $(document).on('click', '.suspended_sales .dropdown-menu .header', function (e) {
    e.stopPropagation();
  });

  $('#filter-suspended-sales').hideseek({
    nodata: lang.no_match_found,
  });

  $('#suspended_sales').on('shown.bs.dropdown', function () {
    $('#filter-suspended-sales').focus();
  });

  $(document).on('click', '#update-note', function () {
    var n = $('#snote').val();
    store('spos_note', n);
    $('#note').val(n);
    $('#noteModal').modal('hide');
  });
  /* =============================
    Edit Item Modal
    ============================= */

  $('#posTable').on('click', '.edit', function () {
    $('#posunit').html('');
    var row = $(this).closest('tr');
    var id = row.attr('id');
    var item_id = row.attr('data-item-id');
    var item_rid = row.attr('data-id');
    var item = spositems[item_id];
    var option_unit = '';
    // ========================================Uunit Sell================================
      $.each(item.units, function () {
          if(this.id == item.row.default_sale_unit) {
              option_unit += "<option selected value='"+this.id+"'>"+this.name+"</option>";
          } else {
              option_unit += "<option value='"+this.id+"'>"+this.name+"</option>";
          }
      });
    // ========================================================================
    // ========================================Group Options=============================
    $("#group_options").html('');
    if (item.row.group_options) {
      $.each(item.row.group_options, function () {
          var v = '';
          var group_option = this;
          v +='<div class="col-xs-12"><h5 class="wintech-label">'+ this.name +' ('+ this.label_required +')</h5></div>';
          $.each(item.row.modify, function () {
              var options = this;
              if (options.group_id==group_option.id) {
                var checked = '';
                if (options.check=='1') {
                  checked = 'checked';
                }
                if (item.row.modify_id.includes(options.id)) {
                  checked = 'checked';
                }
                if (group_option.type==1) {
                  v+= '<div class="col-xs-6 no_pd">'+
                        '<div class="custom-control custom-checkbox">'+
                            '<input '+checked+' option_price='+options.price+' option_name='+options.name+' groupoption_name='+group_option.name+' value='+options.id+' class="custom-control-input" type="checkbox" id="item_'+ options.id +'">'+
                            '<label for="item_'+ options.id +'" class="custom-control-label">'+ options.name +'</label>'+
                        '</div>'+
                      '</div>';
                  }
                  if (group_option.type==0) {
                    v+= '<div class="col-xs-6 no_pd">'+
                          '<div class="custom-control custom-radio">'+
                              '<input '+checked+' value='+options.id+' option_price='+options.price+' option_name='+options.name+' groupoption_name='+group_option.name+' name="modify_'+group_option.id+'[]" class="custom-control-input radio-input" type="radio" id="item_'+ options.id +'">'+
                              '<label for="item_'+ options.id +'" class="custom-control-label">'+ options.name +'</label>'+
                          '</div>'+
                        '</div>';
                  }
              }
          });
        $("#group_options").append(v);
      });
    }
    // ==================================================================================
    var unit_price = formatDecimal(row.find('.realuprice').val());
    var net_price = unit_price;
    var ds = item.row.discount ? item.row.discount : '0';
    item_discount = formatDecimal(parseFloat(ds));
    if (ds.indexOf('%') !== -1) {
      var pds = ds.split('%');
      if (!isNaN(pds[0])) {
        item_discount = formatDecimal((net_price * parseFloat(pds[0])) / 100);
      }
    }
    net_price -= item_discount;
    var pr_tax = parseFloat(item.row.tax),
      pr_tax_val = 0,
      tax = '';
    if (pr_tax !== null && pr_tax != 0) {
      if (parseFloat(item.row.tax_method) == 0) {
        pr_tax_val = formatDecimal((net_price * parseFloat(pr_tax)) / (100 + parseFloat(pr_tax)));
        net_price -= pr_tax_val;
        tax = lang.inclusive;
      } else {
        pr_tax_val = formatDecimal((net_price * parseFloat(pr_tax)) / 100);
        tax = lang.exclusive;
      }
    }
    var item_modify = item.row.total_modify;
    if (item_modify) {
      net_price = formatDecimal(parseFloat(net_price) - parseFloat(item_modify));
      unit_price = formatDecimal(parseFloat(unit_price) - parseFloat(item_modify));
    }
    $('#proModalLabel').html('<a href="' + base_url + '/products/view/' + item_rid + '" data-toggle="ajax">' + item.label + '</a>');
    $('#net_price').text(formatMoney(net_price));
    $('#pro_tax').text(formatMoney(pr_tax_val));
    $('#pro_tax_method').text('(' + tax + ')');
    $('#row_id').val(row_id);
    $('#item_id').val(item_id);
    $('#nPrice').val(unit_price);
    $('#nQuantity').val(item.row.unit_quantity);
    $('#nDiscount').val(ds);
    $('#nComment').val(item.row.comment);
    $('#posunit').html(option_unit);
    $('.select').select2();
    $('#proModal').modal({ backdrop: 'static' });
  });
  $(document).on('change', '#nPrice, #nDiscount', function () {
    var item_id = $('#item_id').val();
    var unit_price = parseFloat($('#nPrice').val());
    var net_price = unit_price;
    var item = spositems[item_id];
    // =====================================
      if (protect_delete == 1) {
        var boxd = bootbox.dialog({
          title: lang.enter_pin_code,
          closeButton: true,
          message: '<label>Pin Code</label><input id="pos_pin" name="pos_pin" type="password" placeholder="Pin Code" class="form-control kb-pad"><label>Comment</label><input id="pos_comment" name="pos_comment" type="test" placeholder="Comment" class="form-control kb-pad"> ',
          buttons: {
            danger: {
              label: lang.close,
              className: 'btn-default pull-left',
              callback: function () {},
            },
            success: {
              label: "<i class='fa fa-tick'></i> " + lang.confirm,
              className: 'btn-warning verify_pin',
              callback: function () {
                var pos_pin = md5($('#pos_pin').val());
                if (pos_pin == Settings.pin_code) {
                  
                } else {
                  bootbox.alert(lang.wrong_pin);
                  $('#nDiscount').val(0);
                }
              },
            },
          },
        });
        boxd.on('shown.bs.modal', function () {
          if (Settings.display_kb == 1) {
            display_keyboards();
          }
          $('#pos_pin')
            .focus()
            .keypress(function (e) {
              if (e.keyCode == 13) {
                e.preventDefault();
                $('.verify_pin').trigger('click');
                return false;
              }
            });
        });
      }
      return false;
    // =====================================
    var ds = $('#nDiscount').val() ? $('#nDiscount').val() : '0';
    item_discount = formatDecimal(parseFloat(ds));
    if (ds.indexOf('%') !== -1) {
      var pds = ds.split('%');
      if (!isNaN(pds[0])) {
        item_discount = formatDecimal((unit_price * parseFloat(pds[0])) / 100);
      }
    }
    net_price -= item_discount;
    var pr_tax = parseFloat(item.row.tax),
      pr_tax_val = 0;
    if (pr_tax !== null && pr_tax != 0) {
      if (parseFloat(item.row.tax_method) == 0) {
        pr_tax_val = formatDecimal((net_price * parseFloat(pr_tax)) / (100 + parseFloat(pr_tax)));
        net_price -= pr_tax_val;
        tax = lang.inclusive;
      } else {
        pr_tax_val = formatDecimal((net_price * parseFloat(pr_tax)) / 100);
        tax = lang.exclusive;
      }
    }
    $('#net_price').text(formatMoney(net_price));
    $('#pro_tax').text(formatMoney(pr_tax_val));
  });

  $(document).on('change', '#posunit', function () {
      $("#nbase_unit").empty();
      $("#noperation").empty();
      $("#nqty_perunit").empty();
      var item_id        = $('#item_id').val();
      var posunit        = $(this).val();
      var item           = spositems[item_id];
      var selling_price  = item.row.product_price;
      var stock_quantity = item.row.unit_quantity;
      var operation      ='*';
      var qty_perunit    =1;
      $.each(item.units, function () {
        if(this.id == posunit && posunit != item.row.unit) {
            if (this.operation_value>0) {
              operation    = this.operation;
              qty_perunit  = this.operation_value;
            }
            stock_quantity = baseUnit(1, this)*spositems[item_id].row.qty;
            selling_price  = formatDecimal(this.unit_price);
        }
    });
    $("#nPrice").val(formatDecimal(selling_price));
    $("#nbase_unit").val(formatDecimal(stock_quantity));
    $("#noperation").val(operation);
    $("#nqty_perunit").val(qty_perunit);
  });
  $(document).on('click', '#editItem', function () {
    var item_id = $('#item_id').val();
    var price = parseFloat($('#nPrice').val());
    var saleunit = $("#posunit option:selected").val();
    if (!is_valid_discount($('#nDiscount').val())) {
      bootbox.alert(lang.unexpected_value);
      return false;
    }
    var options     = $(".custom-control-input");
    var modify_arr  =[];
    var modify_name =[];
    var total_modify=0;
    for (var i = 0, length = options.length; i < length; i++) {
      if (options[i].checked) {
        spositems[item_id].row.modify[i].check='1';
        modify_arr.push(options[i].value);
        modify_name  += options[i].getAttribute("groupoption_name") +' : '+ options[i].getAttribute("option_name") +' ';
        total_modify += formatDecimal(options[i].getAttribute("option_price"));
      }
    }
    (spositems[item_id].row.qty = parseFloat($('#nbase_unit').val()));
      (spositems[item_id].row.real_unit_price = price);
      (spositems[item_id].row.total_modify = total_modify);
      (spositems[item_id].row.modify_id = modify_arr);
      (spositems[item_id].row.modify_name = modify_name);
      (spositems[item_id].row.default_sale_unit = saleunit);
      (spositems[item_id].row.comment = $('#nComment').val());
      (spositems[item_id].row.unit_quantity = $('#nQuantity').val());
      (spositems[item_id].row.operation = $('#noperation').val());
      (spositems[item_id].row.qty_perunit = $('#nqty_perunit').val());
      (spositems[item_id].row.unit_name = $("#posunit option:selected").text());
      (spositems[item_id].row.discount = $('#nDiscount').val() ? $('#nDiscount').val() : '0');
      localStorage.setItem('spositems', JSON.stringify(spositems));
    $('#proModal').modal('hide');
    loadItems();
    return;
  });

  /* =============================
    Row quantity change
    ============================= */
  $(document).on('change', '.rquantity', function () {
    var row = $(this).closest('tr');
    if (!is_numeric($(this).val()) || $(this).val() == 0) {
      loadItems();
      bootbox.alert(lang.unexpected_value);
      return false;
    }
    var new_qty = parseFloat($(this).val()),
      item_id = row.attr('data-item-id');
    var qty_perunit = spositems[item_id].row.qty_perunit;
    var operation = spositems[item_id].row.operation;
    spositems[item_id].row.qty = calculateQTY(new_qty,operation,qty_perunit);
    // spositems[item_id].row.qty = new_qty*spositems[item_id].row.qty;
    spositems[item_id].row.unit_quantity = new_qty;
    localStorage.setItem('spositems', JSON.stringify(spositems));
    loadItems();
  });

  $('#reset').click(function (e) {
    if (count <= 1) {
      return false;
    }
   
    if (protect_delete == 1) {
      var boxd = bootbox.dialog({
        title: lang.enter_pin_code,
        closeButton: true,
        message: '<input id="pos_pin" name="pos_pin" type="password" placeholder="Pin Code" class="form-control kb-pad"> ',
        buttons: {
          danger: {
            label: lang.close,
            className: 'btn-default pull-left',
            callback: function () {},
          },
          success: {
            label: "<i class='fa fa-tick'></i> " + lang.confirm,
            className: 'btn-warning verify_pin',
            callback: function () {
              var pos_pin = md5($('#pos_pin').val());
              if (pos_pin == Settings.pin_code) {
                if (get('spositems')) {
                  remove('spositems');
                }
                if (get('spos_tax')) {
                  remove('spos_tax');
                }
                if (get('spos_discount')) {
                  remove('spos_discount');
                }
                if (get('spos_customer')) {
                  remove('spos_customer');
                }
                if (get('total_people')) {
                  remove('total_people');
                }
                window.location.href = base_url + 'pos';
              } else {
                bootbox.alert(lang.wrong_pin);
              }
            },
          },
        },
      });
      boxd.on('shown.bs.modal', function () {
        if (Settings.display_kb == 1) {
          display_keyboards();
        }
        $('#pos_pin')
          .focus()
          .keypress(function (e) {
            if (e.keyCode == 13) {
              e.preventDefault();
              $('.verify_pin').trigger('click');
              return false;
            }
          });
      });
    } else {
      bootbox.confirm(lang.r_u_sure, function (result) {
        if (result) {
          if (get('spositems')) {
            remove('spositems');
          }
          if (get('spos_tax')) {
            remove('spos_tax');
          }
          if (get('spos_discount')) {
            remove('spos_discount');
          }
          if (get('spos_customer')) {
            remove('spos_customer');
          }
          if (get('total_people')) {
                  remove('total_people');
                }
          window.location.href = base_url + 'pos';
        }
      });
    }
  });

  $('#print_order').click(function (e) {
    e.preventDefault();
    $.ajax({
        url: base_url+'pos/getQueue',
        dataType: 'JSON',
        data: {},
        success:function(res){
          $('#ordernumber').append('<input type="hidden" name="ordernumber" value="'+res+'" />');
          $(".queue_order").text('លេខកម្មង់ :'+res);
          if (count <= 1) {
            bootbox.alert(lang.please_add_product);
          } else {
            if (Settings.remote_printing == 0) {
              for (var k = 0; k < printers.length; k++) {
                var data =0;
                var printer_id =0;
                printer_id = parseInt(printers[k].id);
                $("#order-data"+printer_id+"").show();
                if (Settings.print_img == 1) {
                  var html_print = $("#order_tbl"+printer_id+"").html();
                  $("#order-table"+printer_id+"").html();
                  $("#preo"+printer_id+"").html(html_print);
                  $("#order-table"+printer_id+"").html(html_print);
                  var e = $("#order-data"+printer_id+"").get(0);
                  data = $("#order-table"+printer_id+" tbody tr").length;
                  if (data>1) {
                    print_order(e,printer_id);
                  }
                } else {
                  var form = $('#pos-sale-form').serialize();
                  $.post(base_url + 'pos/p/order', form);
                }
              }
            } else {
              printOrder(order_data);
            }
          }
          setTimeout(function () {
            $('#order-data').hide();
            if (Settings.remote_printing == 0) {
              $("#suspend").click();
            }
          }, 500);
          return false;
      }
    })
  });
  function print_order(e,printer_id){
    html2canvas(e, {
        scrollY: 0,
        scale: 1.3
    }).then(function(t) {
        var e = t.toDataURL().split(",")[1];
        $.post(base_url + "pos/receipt_img", {
            img: e,
            printer_id:printer_id,
            type: 'order'+printer_id+'',
            spos_token: csrf_hash
        })
    })
  }
  $(document).on('input', '#total_people', function() {
    store('total_people', $(this).val());
  });
  $('#print_bill').click(function (e) {
    Settings.remote_printing = 1;
    e.preventDefault();
    loadItems();
    if (count <= 1) {
      bootbox.alert(lang.please_add_product);
    } else {
      if (Settings.remote_printing == 0) {
        $('#bill-data').show();
        if (Settings.print_img == 1) {
          var html_bill = $("#bill_tbl").html();
          $("#preb").html(html_bill);
          var e = $("#bill-data").get(0);
          html2canvas(e, {
              scrollY: 0,
              scale: 1.3
          }).then(function(t) {
              var e = t.toDataURL().split(",")[1];
              $.post(base_url + "pos/receipt_img", {
                  img: e,
                  type: 'bill',
                  spos_token: csrf_hash
              })
          })
        } else {
          var form = $('#pos-sale-form').serialize();
          $.post(base_url + 'pos/p/bill', form);
        }
      } else {
        printBill(bill_data);
      }
    }
    setTimeout(function () {
      $('#bill-data').hide();
    }, 500);
    return false;
  });
  $('#updateDiscount').click(function () {
    var ds = $('#get_ds').val() ? $('#get_ds').val() : '0';
    // =====================================
      if (protect_delete == 1) {
        var boxd = bootbox.dialog({
          title: lang.enter_pin_code,
          closeButton: true,
          message: '<label>Pin Code</label><input id="pos_pin" name="pos_pin" type="password" placeholder="Pin Code" class="form-control kb-pad"><label>Comment</label><input id="pos_comment" name="pos_comment" type="test" placeholder="Comment" class="form-control kb-pad"> ',
          buttons: {
            danger: {
              label: lang.close,
              className: 'btn-default pull-left',
              callback: function () {
                ds = 0;
              },
            },
            success: {
              label: "<i class='fa fa-tick'></i> " + lang.confirm,
              className: 'btn-warning verify_pin',
              callback: function () {
                var pos_pin = md5($('#pos_pin').val());
                if (pos_pin == Settings.pin_code) {
                  var apply_to = $('input[name=apply_to]:checked').val();
                  if (ds.length != 0) {
                    if (apply_to == 'order') {
                      $('#discount_val').val(ds);
                      store('spos_discount', ds);
                      if (ds.indexOf('%') !== -1) {
                        var pds = ds.split('%');
                        order_discount = (total * parseFloat(pds[0])) / 100;
                        order_tax = calTax();
                        var g_total = total + order_tax - order_discount;
                        grand_total = parseFloat(g_total);
                        $('#ds_con').text('(' + formatMoney(product_discount) + ') ' + formatMoney(order_discount));
                        $('#total-payable').text(formatMoney(grand_total));
                      } else {
                        order_discount = ds;
                        order_tax = calTax();
                        var g_total = total + order_tax - parseFloat(order_discount);
                        grand_total = parseFloat(g_total);
                        $('#ds_con').text('(' + formatMoney(product_discount) + ') ' + formatMoney(order_discount));
                        $('#total-payable').text(formatMoney(grand_total));
                      }
                    } else if (apply_to == 'products') {
                      var items = {};
                      spositems = JSON.parse(get('spositems'));
                      $.each(spositems, function () {
                        this.row.discount = ds;
                      });
                      store('spositems', JSON.stringify(spositems));
                    }
                    loadItems();
                    $('#dsModal').modal('hide');
                  }
                } else {
                  ds = 0;
                  bootbox.alert(lang.wrong_pin);
                  return false;
                }
              },
            },
          },
        });
        boxd.on('shown.bs.modal', function () {
          if (Settings.display_kb == 1) {
            display_keyboards();
          }
          $('#pos_pin')
            .focus()
            .keypress(function (e) {
              if (e.keyCode == 13) {
                e.preventDefault();
                $('.verify_pin').trigger('click');
                return false;
              }
            });
        });
      }else{
        var apply_to = $('input[name=apply_to]:checked').val();
        if (ds.length != 0) {
          if (apply_to == 'order') {
            $('#discount_val').val(ds);
            store('spos_discount', ds);
            if (ds.indexOf('%') !== -1) {
              var pds = ds.split('%');
              order_discount = (total * parseFloat(pds[0])) / 100;
              order_tax = calTax();
              var g_total = total + order_tax - order_discount;
              grand_total = parseFloat(g_total);
              $('#ds_con').text('(' + formatMoney(product_discount) + ') ' + formatMoney(order_discount));
              $('#total-payable').text(formatMoney(grand_total));
            } else {
              order_discount = ds;
              order_tax = calTax();
              var g_total = total + order_tax - parseFloat(order_discount);
              grand_total = parseFloat(g_total);
              $('#ds_con').text('(' + formatMoney(product_discount) + ') ' + formatMoney(order_discount));
              $('#total-payable').text(formatMoney(grand_total));
            }
          } else if (apply_to == 'products') {
            var items = {};
            spositems = JSON.parse(get('spositems'));
            $.each(spositems, function () {
              this.row.discount = ds;
            });
            store('spositems', JSON.stringify(spositems));
          }
          loadItems();
          $('#dsModal').modal('hide');
        }
      }
    // =====================================
  });

  $('#add_discount').click(function () {
    var dval = $('#discount_val').val();
    $('#get_ds').val(dval);
    $('#dsModal').modal({ backdrop: 'static' });
    return false;
  });
  $('#dsModal').on('shown.bs.modal', function () {
    $('#get_ds').focusToEnd();
  });

  $('#updateTax').click(function () {
    var ts = $('#get_ts').val();
    order_tax = 0;
    if (ts.length != 0) {
      $('#tax_val').val(ts);
      store('spos_tax', ts);
      if (ts.indexOf('%') !== -1) {
        var pts = ts.split('%');
        if (!isNaN(pts[0])) {
          order_tax = ((total - order_discount) * parseFloat(pts[0])) / 100;
          var g_total = total + order_tax - order_discount;
          grand_total = parseFloat(g_total);
          $('#ts_con').text(formatMoney(order_tax));
          $('#total-payable').text(formatMoney(grand_total));
        } else {
          $('#get_ts').val('0');
          $('#tax_val').val('0');
          var g_total = total - order_discount;
          grand_total = parseFloat(g_total);
          $('#ts_con').text('0');
          $('#total-payable').text(formatMoney(grand_total));
        }
      } else {
        if (!isNaN(ts) && ts != 0) {
          order_tax = ts;
          var g_total = total + parseFloat(ts) - order_discount;
          grand_total = parseFloat(g_total);
          $('#ts_con').text(formatMoney(order_tax));
          $('#total-payable').text(formatMoney(grand_total));
        } else {
          $('#get_ts').val('0');
          $('#tax_val').val('0');
          var g_total = total - order_discount;
          grand_total = parseFloat(g_total);
          $('#ts_con').text('0');
          $('#total-payable').text(formatMoney(grand_total));
        }
      }
      $('#tsModal').modal('hide');
    }
  });

  $('#add_tax').click(function () {
    var tval = $('#tax_val').val();
    $('#get_ts').val(tval);
    $('#tsModal').modal({ backdrop: 'static' });
    return false;
  });
  $('#tsModal').on('shown.bs.modal', function () {
    $('#get_ts').focusToEnd();
  });
  $('#noteModal').on('shown.bs.modal', function () {
    $('#snote').focusToEnd();
  });
  $(document).on('click', '.product', function (e) {
    code = $(this).val();
    $.ajax({
      type: 'get',
      url: base_url + 'pos/get_product/' + code,
      data: { 
        customer_id : $("#spos_customer").val(),
      },
      dataType: 'json',
      success: function (data) {
        if (data !== null) {
          add_invoice_item(data);
        } else {
          bootbox.alert(lang.no_match_found);
        }
      },
    });
  });
  $(document).on('click', '.category', function () {
    var cid = $(this).attr('id');
    $("#table-list").hide();
    $("#item-list").show();
    if (cat_id != cid) {
      cat_id = cid;
      $.ajax({
        type: 'get',
        url: base_url + 'pos/ajaxproducts',
        data: { category_id: cat_id, tcp: 1 },
        dataType: 'json',
        success: function (data) {
          p_page = 'n';
          tcp = data.tcp;
          $('.items').html(data.products);
          $('.category').removeClass('active');
          $('#' + cat_id).addClass('active');
          nav_pointer();
        },
      });
    }
    return false;
  });
  $('#category-' + cat_id).addClass('active');

  $('#next').click(function () {
    if (p_page == 'n') {
      p_page = 0;
    }
    p_page += pro_limit;
    if (tcp >= pro_limit && p_page < tcp) {
      $.ajax({
        type: 'get',
        url: base_url + 'pos/ajaxproducts',
        data: { category_id: cat_id, per_page: p_page },
        dataType: 'html',
        success: function (data) {
          $('.items').html(data);
          nav_pointer();
        },
      });
    } else {
      p_page -= pro_limit;
    }
  });

  $('#previous').click(function () {
    if (p_page == 'n') {
      p_page = 0;
    }
    if (p_page != 0) {
      p_page -= pro_limit;
      if (p_page == 0) {
        p_page = 'n';
      }
      $.ajax({
        type: 'get',
        url: base_url + 'pos/ajaxproducts',
        data: { category_id: cat_id, per_page: p_page },
        dataType: 'html',
        success: function (data) {
          $('.items').html(data);
          nav_pointer();
        },
      });
    }
  });

  $('#add_item').autocomplete({
    source: function (request, response) {
        if (!$('#spos_customer').val()) {
            $('#add_item').val('').removeClass('ui-autocomplete-loading');
            bootbox.alert('Please selct customer');
            return false;
        }
        $.ajax({
            type: "get",
            url: base_url+'sales/suggestions',
            dataType: "json",
            data: {
                term: request.term,
                customer_id: $("#spos_customer").val(),
            },
            success: function (data) {
                response(data);
            }
        });
    },
    minLength: 1,
    autoFocus: false,
    delay: 200,
    response: function (event, ui) {
      if ($(this).val().length >= 16 && ui.content[0] && ui.content[0].id == 0) {
        bootbox.alert(lang.no_match_found, function () {
          $('#add_item').focus();
        });
        $(this).val('');
      } else if (ui.content.length == 1 && ui.content[0] && ui.content[0].id != 0) {
        ui.item = ui.content[0];
        $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
        $(this).autocomplete('close');
      } else if (ui.content.length == 1 && ui.content[0] && ui.content[0].id == 0) {
        bootbox.alert(lang.no_match_found, function () {
          $('#add_item').focus();
        });
        $(this).val('');
      }
    },
    select: function (event, ui) {
      event.preventDefault();
      if (ui.item.id !== 0) {
        var row = add_invoice_item(ui.item);
        if (row) $(this).val('');
      } else {
        bootbox.alert(lang.no_match_found);
      }
    },
  });

  $('#add_item').bind('keypress', function (e) {
    if (e.keyCode == 13) {
      e.preventDefault();
      $(this).autocomplete('search');
    }
  });

  $('#add_item').focus();
  $('#gccard_no').inputmask('9999 9999 9999 9999');
  $('#gift_card_no').inputmask('9999 9999 9999 9999');
  $('#gcexpiry').inputmask('yyyy-mm-dd', { placeholder: 'yyyy-mm-dd' });
  $('#genNo').click(function () {
    var no = generateCardNo();
    $(this).parent().parent('.input-group').children('input').val(no);
    return false;
  });

  $(document).on('click', '#sellGiftCard', function (e) {
    if (count == 1) {
      spositems = {};
    }
    $('#gcModal').modal({ backdrop: 'static' });
  });

  $(document).on('click', '#addGiftCard', function (e) {
    var mid = 0,
      gccode = $('#gccard_no').val(),
      gcname = $('#gcname').val(),
      gcvalue = $('#gcvalue').val(),
      gcprice = parseFloat($('#gcprice').val());
    gcexpiry = $('#gcexpiry').val();
    if (gccode == '' || gcvalue == '' || gcprice == '' || gcvalue == 0 || gcprice == 0) {
      $('#gcerror').text(lang.file_required_fields);
      $('.gcerror-con').show();
      return false;
    }
    var gc_data = new Array();
    gc_data[0] = gccode;
    gc_data[1] = gcvalue;
    gc_data[2] = gcexpiry;

    $.ajax({
      type: 'get',
      url: base_url + 'gift_cards/sell_gift_card',
      dataType: 'json',
      data: { gcdata: gc_data },
      success: function (data) {
        if (data.result === 'success') {
          spositems[mid] = {
            id: mid,
            item_id: mid,
            label: gcname + ' (' + gccode + ')',
            row: {
              id: mid,
              code: gccode,
              name: gcname,
              quantity: 1,
              price: gcprice,
              real_unit_price: gcprice,
              tax: 0,
              qty: 1,
              type: 'manual',
              discount: '0',
              comment: '',
            },
          };
          store('spositems', JSON.stringify(spositems));
          loadItems();
          $('#gcModal').modal('hide');
          $('#gccard_no').val('');
          $('#gcvalue').val('');
          $('#gcprice').val('');
        } else {
          $('#gcerror').text(data.message);
          $('.gcerror-con').show();
        }
      },
    });
  });
  var pwacc = false;
  $(document).on('click', '.posdel', function () {
    var row = $(this).closest('tr');
    var item_id = row.attr('data-item-id');
    if (protect_delete == 1) {
      var boxd = bootbox.dialog({
        title: lang.enter_pin_code,
        closeButton: true,
        message: '<label>Pin Code</label><input id="pos_pin" name="pos_pin" type="password" placeholder="Pin Code" class="form-control kb-pad"><label>Comment</label><input id="pos_comment" name="pos_comment" type="test" placeholder="Comment" class="form-control kb-pad">',
        buttons: {
          danger: {
            label: lang.close,
            className: 'btn-default pull-left',
            callback: function () {},
          },
          success: {
            label: "<i class='fa fa-tick'></i> " + lang.confirm,
            className: 'btn-warning verify_pin',
            callback: function () {
              var pos_pin = md5($('#pos_pin').val());
              if (pos_pin == Settings.pin_code) {
                // =================================================================================
                  $.ajax({
                    url: base_url+'pos/void_items',
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                      item_id: item_id,
                      comments: $("#pos_comment").val(),
                    },
                    success:function(res){
                      delete spositems[item_id];
                      row.remove();
                      if (spositems.hasOwnProperty(item_id)) {
                      } else {
                        localStorage.setItem('spositems', JSON.stringify(spositems));
                        loadItems();
                      }
                    }
                  })

                // ====================================================================================
              } else {
                bootbox.alert(lang.wrong_pin);
              }
            },
          },
        },
      });
      boxd.on('shown.bs.modal', function () {
        if (Settings.display_kb == 1) {
          display_keyboards();
        }
        $('#pos_pin')
          .focus()
          .keypress(function (e) {
            if (e.keyCode == 13) {
              e.preventDefault();
              $('.verify_pin').trigger('click');
              return false;
            }
          });
      });
    } else {
      delete spositems[item_id];
      row.remove();
      if (spositems.hasOwnProperty(item_id)) {
      } else {
        localStorage.setItem('spositems', JSON.stringify(spositems));
        loadItems();
      }
    }
    return false;
  });
  // $('#suspend').click(function () {
  //   if (count <= 1) {
  //     bootbox.alert(lang.please_add_product);
  //     return false;
  //   } else {
  //     $('#susModal').modal({ backdrop: 'static' });
  //   }
  // });
  $('#suspend').click(function () {
    if (item_order >= 1) {
      $('#hidesuspend').append('<input type="hidden" name="suspend" value="yes" />');
      $.ajax({
        url: base_url+'pos/getQueue',
        dataType: 'JSON',
        data: {},
        success:function(res){
          $('#ordernumber').append('<input type="hidden" name="ordernumber" value="'+res+'" />');
          $('#submit').click();
        }
      })
    }else{
      bootbox.alert(lang.please_add_product);
      return false;
    }
  });
  $('#void').click(function () {
    if (item_order >= 1) {
      $('#hidevoid').append('<input type="hidden" name="void" value="yes" />');
      $('#submit').click();
    }else{
      bootbox.alert(lang.please_add_product);
      return false;
    }
  });
  $('#hidereturn').click(function () {
    if (item_order >= 1) {
      $('#hidehidereturn').append('<input type="hidden" name="return" value="yes" />');
      $('#submit').click();
    }else{
      bootbox.alert(lang.please_add_product);
      return false;
    }
  });

 $('#payment').click(function () {
    if (item_order <= 1) {
      bootbox.alert(lang.please_add_product);
      return false;
    } else {
      if (sid) {
        suspend = $('<span></span>');
        suspend.html('<input type="hidden" name="delete_id" value="' + sid + '" />');
        suspend.appendTo('#hidesuspend');
      }
      gtotal = formatDecimal(total - order_discount + order_tax);
      if (Settings.rounding != 0) {
        round_total = roundNumber(gtotal, parseInt(Settings.rounding));
        var rounding = formatDecimal(round_total - gtotal);
        $('#twt').text(formatMoney(round_total) + ' (' + formatMoney(rounding) + ')');
        $.each(currencies, function () {
          var currency = this;
          $('#twt'+currency.id+'').text(exchange(round_total,currency) + ' (' + exchange(rounding,currency) + ')');
        });
        $.each(currencies, function () {
          console.log(this)
        });
        $('#quick-payable').text(round_total);
      } else {
        $.each(currencies, function () {
          var currency = this;
          $('#twt'+currency.id+'').text(exchange(gtotal,currency));
        });
        $('#twt').text(formatMoney(gtotal));
        $('#quick-payable').text(gtotal);
      }
      $('#item_count').text(an - 1 + ' (' + (count - 1) + ')');
      $('#order_quantity').val(count - 1);
      $('#order_items').val(an - 1);
      $('#balance').text('0.00');
      $.each(currencies, function () {
        var currency = this;
        $('#balance'+currency.id+'').text('0.00');
      });
      $('#payModal').modal({ backdrop: 'static' });
    }
  });
  $('#payModal').on('shown.bs.modal', function (e) {
    $('#amount').focus().val(0);
    $('#quick-payable').click();
  });
  $('#payModal').on('hidden.bs.modal', function (e) {
    $('#amount').val('').change();
  });
  $('#amount').change(function (e) {
    var total_paying = $('.amount').val();
    $('#total_paying').text(formatMoney(total_paying));
    if (Settings.rounding != 0) {
      $('#balance').text(formatMoney(total_paying - round_total));
      $.each(currencies, function () {
        var currency = this;
        $('#balance'+currency.id+'').text(exchange(total_paying - round_total,currency));
      });
      $('#balance_val').val(formatDecimal(total_paying - round_total));
      total_paid = total_paying;
      grand_total = round_total;
    } else {
      $('#balance').text(formatMoney(total_paying - gtotal));
      $.each(currencies, function () {
        var currency = this;
        $('#balance'+currency.id+'').text(exchange(total_paying - gtotal,currency));
      });
      $('#balance_val').val(formatDecimal(total_paying - gtotal));
      total_paid = total_paying;
      grand_total = gtotal;
    }
  });
// =====================================================================================================
  $.each(currencies, function () {
    var currency = this;
    var rate     = currency.rate;
    $('#amount_'+currency.id+'').change(function (e) {
      var total_paying      = $(".amount").val()  ? $(".amount").val() :0;
      var total_paying_rate = $('.amount_'+currency.id+'').val()/rate;
      total_paying = formatDecimal(total_paying) + formatDecimal(total_paying_rate);
      $("#amount_val").val(total_paying);
      $('#total_paying').text(formatMoney(total_paying));
      if (Settings.rounding != 0) {
        $('#balance').text(formatMoney(total_paying - round_total));
        $.each(currencies, function () {
          var currency = this;
          $('#balance'+currency.id+'').text(Number(exchange(total_paying - round_total,currency)).toFixed(0));
        });
        $('#balance_val').val(formatDecimal(total_paying - round_total));
        total_paid = total_paying;
        grand_total = round_total;
      } else {
        $('#balance').text(formatMoney(total_paying - gtotal));
        $.each(currencies, function () {
          var currency = this;
          $('#balance'+currency.id+'').text(Number(exchange(total_paying - gtotal,currency)).toFixed(0));
        });
        $('#balance_val').val(formatDecimal(total_paying - gtotal));
        total_paid = total_paying;
        grand_total = gtotal;
      }
    });
    // $('#balance'+currency.id+'').text(exchange(total_paying - round_total,currency));
  });
  // =====================================================================================================
  $('#add-customer').click(function () {
    $('#customerModal').modal({ backdrop: 'static' });
  });

  $('#payModal').on('keypress', function (e) {
    if (e.which == 13 && e.target.type != 'textarea') {
      $('#submit-sale').focus();
      setTimeout(function () {
        $('#submit-sale').click();
      }, 250);
    }
  });

  $('#payModal').on('change', '#paid_by', function () {
    $('#clear-cash-notes').click();
    $('#amount').val(grand_total);
    var p_val = $(this).val();
    $('#paid_by_val').val(p_val);
    var gtotal = formatDecimal(total - order_discount + order_tax);
    if (Settings.rounding != 0) {
      var rounded_total = formatDecimal(roundNumber(gtotal, parseInt(Settings.rounding)));
    } else {
      var rounded_total = formatDecimal(gtotal);
    }
    $('#rpaidby').val(p_val);
    if (p_val == 'gift_card') {
      $('.gc').slideDown();
      $('.ngc').slideUp('fast');
      setTimeout(function () {
        $('#gift_card_no').focus();
      }, 10);
      $('#amount').attr('readonly', true);
    } else {
      $('.ngc').slideDown();
      $('.gc').slideUp('fast');
      $('#gc_details').html('');
      $('#amount').attr('readonly', false);
    }
    if (p_val == 'cash' || p_val == 'other') {
      $('.pcash').slideDown();
      $('.pcheque').slideUp('fast');
      $('.pcc').slideUp('fast');
      setTimeout(function () {
        $('#amount').focus();
      }, 10);
    } else if (p_val == 'CC' || p_val == 'stripe') {
      $('.pcc').slideDown();
      $('.pcheque').slideUp('fast');
      $('.pcash').slideUp('fast');
      $('#amount').val(rounded_total);
      setTimeout(function () {
        $('#swipe').val('').focus();
      }, 10);
    } else if (p_val == 'cheque') {
      $('.pcheque').slideDown();
      $('.pcc').slideUp('fast');
      $('.pcash').slideUp('fast');
      $('#amount').val(rounded_total);
      setTimeout(function () {
        $('#cheque_no').focus();
      }, 10);
    } else {
      $('.pcheque').hide();
      $('.pcc').hide();
      $('.pcash').hide();
    }
  });

  $(document).on('change', '.gift_card_no', function () {
    var cn = $(this).val() ? $(this).val() : '';
    if (cn != '') {
      $.ajax({
        type: 'get',
        async: false,
        url: base_url + 'pos/validate_gift_card/' + cn,
        dataType: 'json',
        success: function (data) {
          if (data === false || data.balance < 0) {
            $('#gift_card_no').parent('.form-group').addClass('has-error');
            bootbox.alert(lang.incorrect_gift_card);
          } else {
            $('#gc_details').html(
              lang.card_no + ': ' + data.card_no + '<br>' + lang.value + ': ' + data.value + ' - ' + lang.balance + ': ' + data.balance
            );
            $('#gift_card_no').parent('.form-group').removeClass('has-error');
            var paying = gtotal > data.balance ? data.balance : gtotal;
            $('#amount_val').val(paying);
            $('#amount').val(paying);
          }
        },
      });
    }
    return false;
  });
  $(document).on('click', '#quick-payable', function () {
    $('#clear-cash-notes').click();
    $(this).append('<span class="badge">1</span>');
    $('#amount').val(grand_total);
  });
  $(document).on('click', '.quick-cash', function () {
    var amount_old = $('#amount').val();
    if ($('#quick-payable').find('span.badge').length) {
      $('#clear-cash-notes').click();
    }
    var $quick_cash = $(this);
    var amt = $quick_cash
      .contents()
      .filter(function () {
        return this.nodeType == 3;
      })
      .text();
    var $pi = $('#amount');
    var click_amt = $(this).find('.amt-quick').text();
    amt = formatDecimal(amt) + formatDecimal($pi.val());
    $pi.val(formatDecimal(amt)).change().focus();
    var note_count = $quick_cash.find('.badge');
    if (note_count.length == 0) {
      $pi.val(formatDecimal(click_amt)+formatDecimal(amount_old)).change().focus();
      $quick_cash.append('<span class="badge">1</span>');
    } else {
      var old_amt = $('#amount').val();
      $pi.val(formatDecimal(click_amt)+formatDecimal(old_amt)).change().focus();
      note_count.text(parseInt(note_count.text()) + 1);
    }
  });
  $(document).on('click', '#clear-cash-notes', function () {
    $('.quick-cash').find('.badge').remove();
    $('#amount').val('').change().focus();
  });

  $('#payModal').on('change', '#amount, #paid_by', function (e) {
    $('#amount_val').val($('#amount').val());
  });
  $('#payModal').on('change', '#bank_id', function (e) {
    $('#paid_by').val($('#bank_id').val());
  });
  $('#payModal').on('blur', '#amount', function (e) {
    $('#amount_val').val($('#amount').val());
  });
  $('#payModal').on('select2-close', '#paid_by', function (e) {
    $('#paid_by_val').val($(this).val());
  });
  $('#payModal').on('change', '#pcc_no', function (e) {
    $('#cc_no_val').val($(this).val());
  });
  $('#payModal').on('change', '#pcc_holder', function (e) {
    $('#cc_holder_val').val($(this).val());
  });
  $('#payModal').on('change', '#gift_card_no', function (e) {
    $('#paying_gift_card_no_val').val($(this).val());
  });
  $('#payModal').on('change', '#pcc_month', function (e) {
    $('#cc_month_val').val($(this).val());
  });
  $('#payModal').on('change', '#pcc_year', function (e) {
    $('#cc_year_val').val($(this).val());
  });
  $('#payModal').on('change', '#pcc_type', function (e) {
    $('#cc_type_val').val($(this).val());
  });
  $('#payModal').on('change', '#pcc_cvv2', function (e) {
    $('#cc_cvv2_val').val($(this).val());
  });
  $('#payModal').on('change', '#cheque_no', function (e) {
    $('#cheque_no_val').val($(this).val());
  });
  $('#payModal').on('change', '#payment_note', function (e) {
    $('#payment_note_val').val($(this).val());
  });
  $('#payModal').on('change', '#note', function (e) {
    var n = $(this).val();
    store('spos_note', n);
    $('#spos_note').val(n);
  });
  if ((spos_note = get('spos_note'))) {
    $('#note').val(spos_note);
    $('#snote').val(spos_note);
  }
  $(document).on('click', '.table', function (e) {
    table_id   = $(this).val();
    suspend    = $(this).attr('suspend');
    if (table_id && suspend=='') {
      store('spos_customer', $(this).val());
      $('#spos_customer').select2().select2('val',table_id);
      $("#table-list").hide();
      $("#item-list").show();
    }
    if (suspend>0) {
      location.replace(base_url+'pos/?hold='+suspend);
    }
  });
  $('#spos_customer').change(function (e) {
    store('spos_customer', $(this).val());
    var default_customer = Settings.default_customer;
    var spos_customer    = get('spos_customer');
    var count = $("#count").text()
    if (default_customer==spos_customer) {
        $("#table-list").show();
        $("#item-list").hide();
    }else{
        $("#table-list").hide();
        $("#item-list").show();
    }
  });
  if ((spos_customer = get('spos_customer'))) {
    $('#spos_customer').select2('val', spos_customer);
  }
  $('.treeview').hover(function (e) {
    var wh = $(document).height();
    var top = $(this).offset().top;
    var menu = $(this).find('.treeview-menu');
    var menuh = menu.height() + 44;
    if (wh - top < menuh) {
      $(this).find('a').children('span').addClass('popup');
      menu.addClass('popup');
    } else {
      $(this).find('a').children('span').removeClass('popup');
      menu.removeClass('popup');
    }
  });

  $('body').click(function (e) {
    if (!$(e.target).hasClass('sidebar-icon') && !$(e.target).hasClass('sb') && $('#categories-list').hasClass('control-sidebar-open')) {
      $('#categories-list').removeClass('control-sidebar-open');
    }
  });
  $('#submit-sale').click(function () {
    $('#total_items').val(an - 1);
    var bank_id = $("#bank_id").val();
    $('#total_quantity').val(quantityFormat(count - 1));
    $('#paid_by').val(bank_id);
    $("#submit-sale").prop('disabled', true);
    $('#submit').click();
  });
  var hold_ref = $('#hold_ref').val();
  $('#hold_ref').change(function () {
    hold_ref = $(this).val();
    $('#reference_note').val(hold_ref);
  });
  $('#reference_note').change(function () {
    hold_ref = $(this).val();
    $('#hold_ref').val(hold_ref);
  });

  $('#suspend_sale').click(function () {
    if ($('#reference_note').val()) {
      $('#hold_ref').val($('#reference_note').val());
      $('#total_items').val(an - 1);
      $('#total_quantity').val(quantityFormat(count - 1));
      $('#submit').click();
    }
    return false;
  });

  $('#customer-form').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
      type: 'post',
      url: base_url + 'customers/add',
      data: $(this).serialize(),
      dataType: 'json',
      success: function (res) {
        if (res.status == 'success') {
          $('#spos_customer').append($('<option></option>').attr('value', res.id).text(res.val));
          $('#spos_customer').select2('val', res.id);
          $('#customerModal').modal('hide');
        } else {
          $('#c-alert').html(res.msg);
          $('#c-alert').show();
        }
      },
      error: function () {
        bootbox.alert(lang.customer_request_failed);
        return false;
      },
    });
    return false;
  });

  $('#customerModal').on('hidden.bs.modal', function (e) {
    $('#c-alert').hide();
    $('#cname').val('');
    $('#cemail').val('');
    $('#cphone').val('');
    $('#cf1').val('');
    $('#cf2').val('');
  });
});

function display_keyboards() {
  if (!jQuery.browser.mobile) {
    $('.kb-text').keyboard({
      autoAccept: true,
      alwaysOpen: false,
      openOn: 'focus',
      usePreview: false,
      // layout: 'qwerty',
      layout: 'custom',
      display: {
        bksp: '\u2190',
        accept: 'return',
        default: 'ABC',
        meta1: '123',
        meta2: '#+=',
      },
      customLayout: {
        default: [
          'q w e r t y u i o p {bksp}',
          'a s d f g h j k l {enter}',
          '{s} z x c v b n m , . {s}',
          '{meta1} {space} {cancel} {accept}',
        ],
        shift: ['Q W E R T Y U I O P {bksp}', 'A S D F G H J K L {enter}', '{s} Z X C V B N M / ? {s}', '{meta1} {space} {meta1} {accept}'],
        meta1: [
          '1 2 3 4 5 6 7 8 9 0 {bksp}',
          '- / : ; ( ) \u20ac & @ {enter}',
          '{meta2} . , ? ! \' " {meta2}',
          '{default} {space} {default} {accept}',
        ],
        meta2: [
          '[ ] { } # % ^ * + = {bksp}',
          '_ \\ | &lt; &gt; $ \u00a3 \u00a5 {enter}',
          '{meta1} ~ . , ? ! \' " {meta1}',
          '{default} {space} {default} {accept}',
        ],
      },
    });

    $('.kb-pad').keyboard({
      restrictInput: true,
      preventPaste: true,
      autoAccept: true,
      alwaysOpen: false,
      openOn: 'click',
      usePreview: false,
      layout: 'costom',
      display: {
        b: '\u2190:Backspace',
      },
      customLayout: {
        default: ['1 2 3 {b}', '4 5 6 . {clear}', '7 8 9 0 %', '{accept} {cancel}'],
      },
    });
  }
}

function calTax() {
  var ts = get('spos_tax') ? get('spos_tax') : $('#tax_val').val();
  if (ts.indexOf('%') !== -1) {
    var pts = ts.split('%');
    order_tax = ((total - order_discount) * parseFloat(pts[0])) / 100;
    $('#ts_con').text(formatMoney(order_tax));
  } else {
    order_tax = parseFloat(ts);
    $('#ts_con').text(formatMoney(order_tax));
  }
  return order_tax;
}

function nav_pointer() {
  var pp = p_page == 'n' ? 0 : p_page;
  pp == 0 ? $('#previous').attr('disabled', true) : $('#previous').attr('disabled', false);
  pp + pro_limit > tcp ? $('#next').attr('disabled', true) : $('#next').attr('disabled', false);
}

$(document).ready(function () {
  $(document).on('click', '#print-modal-close', function (e) {
    $('#printModal').hide();
  });
});
function Popup(data, type) {
  $('#print-title').text(lang.print + ' ' + lang[type]);
  $('#print-body').html(data);
  $('#printModal').show();
}
function createWin(data) {
  return new Promise(function (resolve) {
    var d =
      '<!DOCTYPE html><html><head><title>Print</title><link rel="stylesheet" href="' +
      assets +
      'bootstrap/css/bootstrap.min.css" type="text/css" /></head><body>' +
      data +
      '<script type="text/javascript">window.print();</script></body></html>';
    var mywindow = window.open(d, 'spos_print', 'height=500,width=300');
    mywindow.document.write(d);
    setTimeout(function () {
      resolve(mywindow);
    }, 20);
  });
}

$(document).ready(function ($) {
  window.setTimeout(function () {
    $('.alerts').slideUp();
  }, 15000);
  $('.alerts').on('click', function (e) {
    $(this).slideUp();
  });
  $('#list-table-div').slimScroll({ start: 'bottom' });
  $('#category-sidebar-menu').slimScroll({ width: '100%' });
  $('.items').slimScroll({});
});

function posScreen() {
  var wh = $(window).height(),
    total_dh = $('#totaldiv').height(),
    buttons_dh = $('.botbuttons').height(),
    left_top_dh = $('#lefttop').outerHeight();
  var items_dh = wh - 120,
    list_table_dh = wh - 185 - left_top_dh - total_dh - buttons_dh;
  $('#right-col').height(wh - 100);
  $('.items').height(items_dh > 400 ? items_dh : 400);
  $('#list-table-div').height(list_table_dh);
}

function printLine(str) {
  var size = parseInt(Settings.char_per_line) - 4;
  var len = str.length;
  var res = str.split(':');
  var newd = res[0];
  for (i = 1; i < size - len; i++) {
    newd += ' ';
  }
  newd += res[1];
  return newd;
}

$(window).bind('resize', posScreen);

function read_card() {}

$.extend($.keyboard.keyaction, {
  enter: function (base) {
    if (base.$el.is('textarea')) {
      base.insertText('\r\n');
    } else {
      base.accept();
    }
  },
});

$(document).ready(function () {
  posScreen();
  if (Settings.display_kb == 1) {
    display_keyboards();
  }
  nav_pointer();
  loadItems();
  read_card();

  $('.swipe')
    .keypress(function (e) {
      var TrackData = $(this).val() ? $(this).val() : '';
      if (TrackData != '') {
        if (e.keyCode == 13) {
          e.preventDefault();
          var p = new SwipeParserObj(TrackData);

          if (p.hasTrack1) {
            var CardType = null;
            var ccn1 = p.account.charAt(0);
            if (ccn1 == 4) CardType = 'Visa';
            else if (ccn1 == 5) CardType = 'MasterCard';
            else if (ccn1 == 3) CardType = 'Amex';
            else if (ccn1 == 6) CardType = 'Discover';
            else CardType = 'Visa';

            $('#pcc_no').val(p.account).change();
            $('#pcc_holder').val(p.account_name).change();
            $('#pcc_month').val(p.exp_month).change();
            $('#pcc_year').val(p.exp_year).change();
            $('#pcc_cvv2').val('');
            $('#pcc_type').select2('val', CardType);
          } else {
            $('#pcc_no').val('').change();
            $('#pcc_holder').val('').change();
            $('#pcc_month').val('').change();
            $('#pcc_year').val('').change();
            $('#pcc_cvv2').val('').change();
            $('#pcc_type').val('').change();
          }

          $('#pcc_cvv2').focus();
        }
      }
    })
    .blur(function (e) {
      $(this).val('');
    })
    .focus(function (e) {
      $(this).val('');
    });

  $(document).on('blur', '#pcc_no', function () {
    var cn = $(this).val();
    var ccn1 = cn.charAt(0);
    if (ccn1 == 4) CardType = 'Visa';
    else if (ccn1 == 5) CardType = 'MasterCard';
    else if (ccn1 == 3) CardType = 'Amex';
    else if (ccn1 == 6) CardType = 'Discover';
    else CardType = 'Visa';

    $('#pcc_type').select2('val', CardType);
  });

  $('.modal').on('hidden.bs.modal', function () {
    $(this).removeData('bs.modal');
  });
  $('#clearLS').click(function (event) {
    bootbox.confirm(lang.r_u_sure, function (result) {
      if (result == true) {
        localStorage.clear();
        location.reload();
      }
    });
    return false;
  });

  if (Settings.focus_add_item != '') {
    shortcut.add(
      Settings.focus_add_item,
      function () {
        $('#add_item').focus();
      },
      { type: 'keydown', propagate: false, target: document }
    );
  }
  if (Settings.add_customer != '') {
    shortcut.add(
      Settings.add_customer,
      function () {
        $('#add-customer').trigger('click');
      },
      { type: 'keydown', propagate: false, target: document }
    );
  }
  if (Settings.toggle_category_slider != '') {
    shortcut.add(
      Settings.toggle_category_slider,
      function () {
        $('[data-toggle="control-sidebar"]').trigger('click');
      },
      { type: 'keydown', propagate: false, target: document }
    );
  }
  if (Settings.cancel_sale != '') {
    shortcut.add(
      Settings.cancel_sale,
      function () {
        $('#reset').click();
      },
      { type: 'keydown', propagate: false, target: document }
    );
  }
  if (Settings.suspend_sale != '') {
    shortcut.add(
      Settings.suspend_sale,
      function () {
        $('#suspend').trigger('click');
      },
      { type: 'keydown', propagate: false, target: document }
    );
  }
  if (Settings.print_order != '') {
    shortcut.add(
      Settings.print_order,
      function () {
        $('#print_order').click();
      },
      { type: 'keydown', propagate: false, target: document }
    );
  }
  if (Settings.print_bill != '') {
    shortcut.add(
      Settings.print_bill,
      function () {
        $('#print_bill').click();
      },
      { type: 'keydown', propagate: false, target: document }
    );
  }
  if (Settings.finalize_sale != '') {
    shortcut.add(
      Settings.finalize_sale,
      function () {
        $('#payment').trigger('click');
      },
      { type: 'keydown', propagate: false, target: document }
    );
  }
  if (Settings.today_sale != '') {
    shortcut.add(
      Settings.today_sale,
      function () {
        $('#today_sale').click();
      },
      { type: 'keydown', propagate: false, target: document }
    );
  }
  if (Settings.open_hold_bills != '') {
    shortcut.add(
      Settings.open_hold_bills,
      function () {
        $('#opened_bills').trigger('click');
      },
      { type: 'keydown', propagate: false, target: document }
    );
  }
  if (Settings.close_register != '') {
    shortcut.add(
      Settings.close_register,
      function () {
        $('#close_register').click();
      },
      { type: 'keydown', propagate: false, target: document }
    );
  }
});
$.fn.focusToEnd = function () {
  return this.each(function () {
    var v = $(this).val();
    $(this).focus().val('').val(v);
  });
};
$.ajaxSetup({ cache: false, headers: { 'cache-control': 'no-cache' } });
