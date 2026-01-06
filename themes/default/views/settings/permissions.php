<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    .table td:first-child {
        font-weight: bold;
    }
    label {
        margin-right: 20px;
    }
</style>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <?php echo form_open_multipart("settings/permissions/".$p->id, 'class="validation"'); ?>
                <div class="box box-primary">
                    <div class="box-header"> 
                    </div>
                    <div class="box-body">
                       <div class="col-lg-12">
                           <p class="introtext"></p>
                           <div class="table-responsive">
                               <div class="scroll" style="overflow-x: auto;">
                                 <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="11" class="text-center"><?php echo $group->description . ' ( ' . $group->name . ' ) ' . $this->lang->line("group_permissions"); ?></th>
                                            <input type="hidden" name="group" value="<?=$group->id?>">
                                        </tr>
                                        <tr>
                                            <th style="width: 100px !important;white-space: nowrap" rowspan="2" class="text-center"><?= lang("module_name"); ?></th>
                                            <th class="text-center"><?= lang("view"); ?></th>
                                            <th class="text-center"><?= lang("add"); ?></th>
                                            <th class="text-center"><?= lang("edit"); ?></th>
                                            <th class="text-center"><?= lang("delete"); ?></th>
                                            <td colspan="6"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= lang('products') ?></td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="product_view" <?php echo $p->{'product_view'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="product_add" <?php echo $p->{'product_add'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="product_edit" <?php echo $p->{'product_edit'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="product_delete" <?php echo $p->{'product_delete'} ? "checked":'' ?>>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="product_cost" class="checkbox" name="product_cost" <?php echo $p->{'product_cost'} ? "checked":'' ?>>
                                                <label for="product_cost" class="padding05"><?= lang('product_cost') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="product_price" class="checkbox" name="product_price" <?php echo $p->{'product_price'} ? "checked":'' ?>>
                                                <label for="product_price" class="padding05"><?= lang('product_price') ?> </label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="product_adjustment" class="checkbox" name="product_adjustment" <?php echo $p->{'product_adjustment'} ? "checked":'' ?>>
                                                <label for="product_adjustment" class="padding05"><?= lang('stock_adjustment') ?></label>
                                            </td>
                                            <td class="hidden">
                                                <input type="checkbox" value="1" id="product_barcode" class="checkbox" name="product_barcode" <?php echo $p->{'product_barcode'} ? "checked":'' ?>>
                                                <label for="product_barcode" class="padding05"><?= lang('print_barcodes') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="product_import" class="checkbox" name="product_import" <?php echo $p->{'product_import'} ? "checked":'' ?>>
                                                <label for="product_import" class="padding05"><?= lang('import_products') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="product_group_option" class="checkbox" name="product_group_option" <?php echo $p->{'product_group_option'} ? "checked":'' ?>>
                                                <label for="product_group_option" class="padding05"><?= lang('group_option') ?></label>
                                            </td> 
                                            <td>
                                                <input type="checkbox" value="1" id="product_option" class="checkbox" name="product_option" <?php echo $p->{'product_option'} ? "checked":'' ?>>
                                                <label for="product_option" class="padding05"><?= lang('item_option') ?></label>
                                            </td>
                                            <td colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('categories') ?></td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="category_view" <?php echo $p->{'category_view'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="category_add" <?php echo $p->{'category_add'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="category_edit" <?php echo $p->{'category_edit'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="category_delete" <?php echo $p->{'category_delete'} ? "checked":'' ?>>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="category_import" class="checkbox" name="category_import" <?php echo $p->{'category_import'} ? "checked":'' ?>>
                                                <label for="category_import" class="padding05"><?=lang('import_categories')?></label>
                                            </td>   
                                            <td colspan="5"></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang("sales"); ?></td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="sale_view" <?php echo $p->{'sale_view'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="sale_add" <?php echo $p->{'sale_add'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="sale_edit" <?php echo $p->{'sale_edit'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="sale_delete" <?php echo $p->{'sale_delete'} ? "checked":'' ?>>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="pos" class="checkbox" name="pos" <?php echo $p->{'pos'} ? "checked":'' ?>>
                                                <label for="pos" class="padding05"><?= lang('pos') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="sale_payment" class="checkbox" name="sale_payment" <?php echo $p->{'sale_payment'} ? "checked":'' ?>>
                                                <label for="sale_payment" class="padding05"><?= lang('sales_payment') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="view_payment" class="checkbox" name="view_payment" <?php echo $p->{'view_payment'} ? "checked":'' ?>>
                                                <label for="view_payment" class="padding05"><?= lang('view_payments') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="sale_return-add" class="checkbox" name="sale_return-add" <?php echo $p->{'sale_return-add'} ? "checked":'' ?>>
                                                <label for="sale_return-add" class="padding05"><?= lang('add_return') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="sale_return-view" class="checkbox" name="sale_return-view" <?php echo $p->{'sale_return-view'} ? "checked":'' ?>>
                                                <label for="sale_return-view" class="padding05"><?= lang('return_sale') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="sale_listbill" class="checkbox" name="sale_listbill" <?php echo $p->{'sale_listbill'} ? "checked":'' ?>>
                                                <label for="sale_listbill" class="padding05"><?= lang('list_suspend_bills') ?></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang("purchases"); ?></td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="purchase_view" <?php echo $p->{'purchase_view'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="purchase_add" <?php echo $p->{'purchase_add'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="purchase_edit" <?php echo $p->{'purchase_edit'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="purchase_delete" <?php echo $p->{'purchase_delete'} ? "checked":'' ?>>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="add_purchase-return" class="checkbox" name="add_purchase-return" <?php echo $p->{'add_purchase-return'} ? "checked":'' ?>>
                                                <label for="add_purchase-return" class="padding05"><?= lang('add_purchase_return') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="purchase_return" class="checkbox" name="purchase_return" <?php echo $p->{'purchase_return'} ? "checked":'' ?>>
                                                <label for="purchase_return" class="padding05"><?= lang('purchases_return') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="purchase_payment" class="checkbox" name="purchase_payment" <?php echo $p->{'purchase_payment'} ? "checked":'' ?>>
                                                <label for="purchase_payment" class="padding05"><?= lang('purchases_payment') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="list_payments" class="checkbox" name="list_payments" <?php echo $p->{'list_payments'} ? "checked":'' ?>>
                                                <label for="list_payments" class="padding05"><?= lang('list_payments') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="add_expense" class="checkbox" name="add_expense" <?php echo $p->{'add_expense'} ? "checked":'' ?>>
                                                <label for="add_expense" class="padding05"><?= lang('add_expense') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="list_expenses" class="checkbox" name="list_expenses" <?php echo $p->{'list_expenses'} ? "checked":'' ?>>
                                                <label for="list_expenses" class="padding05"><?= lang('list_expenses') ?></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang("customers"); ?></td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="customer_view" <?php echo $p->{'customer_view'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="customer_add" <?php echo $p->{'customer_add'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="customer_edit" <?php echo $p->{'customer_edit'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="customer_delete" <?php echo $p->{'customer_delete'} ? "checked":'' ?>>
                                            </td>
                                            <td colspan="6"></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang("suppliers"); ?></td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="supplier_view" <?php echo $p->{'supplier_view'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="supplier_add" <?php echo $p->{'supplier_add'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="supplier_edit" <?php echo $p->{'supplier_edit'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="supplier_delete" <?php echo $p->{'supplier_delete'} ? "checked":'' ?>>
                                            </td>
                                            <td colspan="6"></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang("units"); ?></td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="unit_view" <?php echo $p->{'unit_view'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="unit_add" <?php echo $p->{'unit_add'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="unit_edit" <?php echo $p->{'unit_edit'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="unit_delete" <?php echo $p->{'unit_delete'} ? "checked":'' ?>>
                                            </td>
                                            <td colspan="6"></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang("banks"); ?></td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="bank_view" <?php echo $p->{'bank_view'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="bank_add" <?php echo $p->{'bank_add'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="bank_edit" <?php echo $p->{'bank_edit'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="bank_delete" <?php echo $p->{'bank_delete'} ? "checked":'' ?>>
                                            </td>
                                            <td colspan="6"></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang("currency"); ?></td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="currency_view" <?php echo $p->{'currency_view'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="currency_add" <?php echo $p->{'currency_add'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="currency_edit" <?php echo $p->{'currency_edit'} ? "checked":'' ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" value="1" class="checkbox" name="currency_delete" <?php echo $p->{'currency_delete'} ? "checked":'' ?>>
                                            </td>
                                            <td colspan="6"></td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2"><?= lang("reports"); ?></td>
                                            <td>
                                                <input type="checkbox" value="1" id="reports_dialy-sales" class="checkbox" name="reports_dialy-sales" <?php echo $p->{'reports_dialy-sales'} ? "checked":'' ?>>
                                                <label for="reports_dialy-sales" class="padding05"><?= lang('daily_sales') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="reports_monthly-sales" class="checkbox" name="reports_monthly-sales" <?php echo $p->{'reports_monthly-sales'} ? "checked":'' ?>>
                                                <label for="reports_monthly-sales" class="padding05"><?= lang('monthly_sales') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="reports_sale-reports" class="checkbox" name="reports_sale-reports" <?php echo $p->{'reports_sale-reports'} ? "checked":'' ?>>
                                                <label for="reports_sale-reports" class="padding05"><?= lang('sales_report') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="reports_saleitem-reports" class="checkbox" name="reports_saleitem-reports" <?php echo $p->{'reports_saleitem-reports'} ? "checked":'' ?>>
                                                <label for="reports_saleitem-reports" class="padding05"><?= lang('sale_items_reports') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="reports_payment-reports" class="checkbox" name="reports_payment-reports" <?php echo $p->{'reports_payment-reports'} ? "checked":'' ?>>
                                                <label for="reports_payment-reports" class="padding05"><?= lang('payments_report') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="reports_register-reports" class="checkbox" name="reports_register-reports" <?php echo $p->{'reports_register-reports'} ? "checked":'' ?>>
                                                <label for="reports_register-reports" class="padding05"><?= lang('registers_report') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="reports_topproduct-reports" class="checkbox" name="reports_topproduct-reports" <?php echo $p->{'reports_topproduct-reports'} ? "checked":'' ?>>
                                                <label for="reports_topproduct-reports" class="padding05"><?= lang('top_products') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="reports_purchase-reports" class="checkbox" name="reports_purchase-reports" <?php echo $p->{'reports_purchase-reports'} ? "checked":'' ?>>
                                                <label for="reports_purchase-reports" class="padding05"><?= lang('purchases_report') ?></label>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="1" id="reports_purchaseitem-reports" class="checkbox" name="reports_purchaseitem-reports" <?php echo $p->{'reports_purchaseitem-reports'} ? "checked":'' ?>>
                                                <label for="reports_purchaseitem-reports" class="padding05"><?= lang('purchase_item') ?></label>
                                            </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                    <input type="checkbox" value="1" id="reports_stock-reports" class="checkbox" name="reports_stock-reports" <?php echo $p->{'reports_stock-reports'} ? "checked":'' ?>>
                                                    <label for="reports_stock-reports" class="padding05"><?= lang('stock_report') ?></label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" value="1" id="reports_bank-reports" class="checkbox" name="reports_bank-reports" <?php echo $p->{'reports_bank-reports'} ? "checked":'' ?>>
                                                    <label for="reports_bank-reports" class="padding05"><?= lang('banks_report') ?></label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" value="1" id="stock_in_stock_out" class="checkbox" name="reports_stock_in_stock_out-report" <?php echo $p->{'reports_stock_in_stock_out-report'} ? "checked":'' ?>>
                                                    <label for="stock_in_stock_out" class="padding05"><?= lang('stock_in_stock_out') ?></label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" value="1" id="account_receivable" class="checkbox" name="reports_account_receivable-report" <?php echo $p->{'reports_account_receivable-report'} ? "checked":'' ?>>
                                                    <label for="account_receivable" class="padding05"><?= lang('account_receivable') ?></label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" value="1" id="account_payable" class="checkbox" name="reports_account_payable-report" <?php echo $p->{'reports_account_payable-report'} ? "checked":'' ?>>
                                                    <label for="account_payable" class="padding05"><?= lang('account_payable') ?></label>
                                                </td> 
                                            </tr>
                                        </tr>
                                      </tbody>
                                    </table>  
                               </div>
                           </div>
                           <div class="form_actions">
                               <button type="submit" class="btn btn-sm btn-primary"><?=lang('update') ?></button>
                           </div>
                       </div>
                    <div class="clearfix"></div>
                    </div>
                </div>
            <?php echo form_close();?>
        </div>
    </div>
</section>
<style type="text/css">
    .scroll td{
        white-space: nowrap !important;
    }
</style>

