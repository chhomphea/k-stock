<main class="app-container">
    <?php echo form_open("sales/" . (isset($sale) ? "edit/".$sale->id : "create"), ['id' => 'saleForm']); ?>
    <div class="card card-full">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-bold"><?= isset($sale) ? 'Edit Sale: #'.$sale->id : 'Create New Sale' ?></span>
            <!-- <div>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearItems()">
                    <span class="material-icons-outlined fs-6">refresh</span> Reset Form
                </button>
            </div> -->
        </div>
        
        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Date *</label>
                    <input type="datetime-local" name="date" class="form-control" 
                           value="<?= isset($sale) ? date('Y-m-d\TH:i', strtotime($sale->date)) : date('Y-m-d\TH:i'); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Customer *</label>
                    <select name="customer_id" class="form-select select2" required>
                        <?php foreach($customers as $c): ?>
                            <option value="<?= $c->id ?>" <?= (isset($sale) && $sale->customer_id == $c->id) ? 'selected' : '' ?>><?= $c->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Branch *</label>
                    <select name="branch_id" class="form-select select2" required>
                        <?php foreach($branches as $b): ?>
                            <option value="<?= $b->id ?>" <?= (isset($sale) && $sale->branch_id == $b->id) ? 'selected' : '' ?>><?= $b->branch_kh ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="material-icons-outlined">search</i></span>
                    <select id="product_search" class="form-control"></select>
                </div>
                <div class="form-text text-muted">Type product name or code to add items.</div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="bg-light text-uppercase small fw-bold">
                        <tr>
                            <th class="ps-3">Product Description</th>
                            <th width="100" class="text-center">Unit</th>
                            <th width="130" class="text-center">Price</th>
                            <th width="110" class="text-center">Qty</th>
                            <th width="180">Discount</th>
                            <th width="150" class="text-end pe-3">Subtotal</th>
                            <th width="50"></th>
                        </tr>
                    </thead>
                    <tbody id="rtable">
                        </tbody>
                    <tfoot class="bg-light">
                        <tr>
                            <td colspan="5" class="text-end fw-bold">Order Discount</td>
                            <td class="pe-3">
                                <div class="input-group input-group-sm">
                                    <input type="number" name="order_discount" id="order_discount" class="form-control text-end" 
                                           value="<?= isset($sale) ? $sale->order_discount : '0' ?>">
                                    <select name="order_discount_id" id="order_discount_type" class="form-select" style="max-width: 70px;">
                                        <option value="amount" <?= (isset($sale) && $sale->order_discount_id == 'amount') ? 'selected' : '' ?>>$</option>
                                        <option value="percentage" <?= (isset($sale) && $sale->order_discount_id == 'percentage') ? 'selected' : '' ?>>%</option>
                                    </select>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-end fw-bold text-primary fs-5">Grand Total</td>
                            <td class="text-end pe-3 fw-bold text-primary fs-5" id="total_display">$0.00</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <input type="hidden" name="total_price" id="total_price_input">
            <input type="hidden" name="grand_total" id="grand_total_input">

            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="<?= base_url('sales') ?>" class="btn btn-light px-4 border">Cancel</a>
                <button type="submit" class="btn btn-primary px-5">
                    <i class="material-icons-outlined fs-6 align-middle">save</i> Save Sale
                </button>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</main>

<script>
window.onload = function() {
    if (typeof jQuery === 'undefined') {
        console.error("jQuery is missing! Ensure it is loaded in your footer.");
        return;
    }

    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({ width: '100%' });

        // Load existing data if Editing
        <?php if (isset($items) && !empty($items)): ?>
            let existingItems = [];
            <?php foreach ($items as $item): ?>
                existingItems.push({
                    product_id: "<?= $item->product_id ?>",
                    name: "<?= $item->code.' - '.$item->name ?>",
                    unit: "<?= $item->unit_name ?>",
                    price: "<?= $item->unit_price ?>",
                    quantity: "<?= $item->quantity ?>",
                    disc: "<?= $item->item_discount ?>",
                    disc_type: "<?= $item->discount_type ?>"
                });
            <?php endforeach; ?>
            localStorage.setItem('slitems', JSON.stringify(existingItems));
        <?php endif; ?>

        // AJAX Product Search
        $('#product_search').select2({
            width: '100%',
            ajax: {
                url: '<?= site_url("sales/suggestions") ?>',
                dataType: 'json',
                delay: 250,
                data: function(params) { return { term: params.term }; },
                processResults: function(data) { return { results: data }; }
            },
            placeholder: "Search product by code or name...",
            minimumInputLength: 1
        }).on('select2:select', function(e) {
            let item = e.params.data;
            let items = JSON.parse(localStorage.getItem('slitems')) || [];
            let exists = items.find(x => x.product_id == item.id);
            if (exists) {
                exists.quantity = parseFloat(exists.quantity) + 1;
            } else {
                items.push({ 
                    product_id: item.id, 
                    name: item.text, 
                    unit: item.unit, 
                    price: item.price, 
                    quantity: 1, 
                    disc: 0, 
                    disc_type: 'amount' 
                });
            }
            localStorage.setItem('slitems', JSON.stringify(items));
            render();
            $(this).val(null).trigger('change');
        });

        window.render = function() {
            let items = JSON.parse(localStorage.getItem('slitems')) || [];
            let html = ''; let total_sub = 0;
            
            if(items.length === 0) {
                $('#rtable').html('<tr><td colspan="7" class="text-center p-5 text-muted">No items added. Use the search bar above.</td></tr>');
                $('#total_display').text('$0.00');
                return;
            }

            items.forEach((it, i) => {
                let qty = parseFloat(it.quantity) || 0;
                let price = parseFloat(it.price) || 0;
                let line_total = qty * price;
                let disc_amt = it.disc_type == 'percentage' ? (line_total * (parseFloat(it.disc) / 100)) : parseFloat(it.disc);
                let sub = line_total - disc_amt;
                total_sub += sub;

                html += `<tr>
                    <td class="ps-3"><div class="fw-bold">${it.name}</div><input type="hidden" name="product_id[]" value="${it.product_id}"></td>
                    <td class="text-center"><span class="badge bg-light text-dark border">${it.unit}</span><input type="hidden" name="unit_name[]" value="${it.unit}"></td>
                    <td><input type="number" step="any" name="unit_price[]" class="form-control form-control-sm text-center" value="${price}" onchange="upd(${i},'price',this.value)"></td>
                    <td><input type="number" name="quantity[]" class="form-control form-control-sm text-center" value="${qty}" onchange="upd(${i},'quantity',this.value)"></td>
                    <td>
                        <div class="input-group input-group-sm">
                            <input type="number" name="item_discount[]" class="form-control" value="${it.disc}" onchange="upd(${i},'disc',this.value)">
                            <select name="item_discount_type[]" class="form-select" onchange="upd(${i},'disc_type',this.value)">
                                <option value="amount" ${it.disc_type=='amount'?'selected':''}>$</option>
                                <option value="percentage" ${it.disc_type=='percentage'?'selected':''}>%</option>
                            </select>
                        </div>
                    </td>
                    <td class="text-end pe-3 fw-bold">$${sub.toFixed(2)}<input type="hidden" name="subtotal[]" value="${sub.toFixed(2)}"></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm text-danger" onclick="rem(${i})"><i class="material-icons-outlined fs-6">delete</i></button>
                    </td>
                </tr>`;
            });
            $('#rtable').html(html);
            
            let od = parseFloat($('#order_discount').val()) || 0;
            let oda = $('#order_discount_type').val() == 'percentage' ? (total_sub * (od / 100)) : od;
            let gt = total_sub - oda;

            $('#total_display').text('$'+gt.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $('#total_price_input').val(total_sub.toFixed(2));
            $('#grand_total_input').val(gt.toFixed(2));
        }

        window.upd = (i, f, v) => { 
            let items = JSON.parse(localStorage.getItem('slitems')); 
            items[i][f] = v; 
            localStorage.setItem('slitems', JSON.stringify(items)); 
            render(); 
        }
        
        window.rem = (i) => { 
            let items = JSON.parse(localStorage.getItem('slitems')); 
            items.splice(i, 1); 
            localStorage.setItem('slitems', JSON.stringify(items)); 
            render(); 
        }
        
        window.clearItems = () => { 
            if(confirm('Are you sure you want to reset the form?')) { 
                localStorage.removeItem('slitems'); 
                location.reload(); 
            } 
        }

        $('#order_discount, #order_discount_type').on('change', render);
        render(); // Initial load

        $('#saleForm').on('submit', function() {
            if((JSON.parse(localStorage.getItem('slitems')) || []).length === 0) {
                alert("Please add at least one product.");
                return false;
            }
            localStorage.removeItem('slitems');
        });
    });
};
</script>