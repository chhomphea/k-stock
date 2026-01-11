<main class="app-container d-flex flex-column" style="height: calc(100vh - 60px); background: #fff;">
    <?php echo form_open(isset($sale->id) ? "sales/edit/" . $sale->id : "sales/create", ['id' => 'saleForm', 'class' => 'h-100 d-flex flex-column']); ?>

    <div class="card-header bg-white py-3 px-3 border-bottom d-flex justify-content-between align-items-center flex-shrink-0" style="border-color: #f3f4f6;">
        <div>
            <span class="material-icons-outlined fs-5 align-middle me-1 text-dark">point_of_sale</span>
            <span class="fw-bold text-dark">SALES ENTRY</span> <span class="label-kh ms-1 text-muted">(ការលក់)</span>
        </div>
        <div class="text-muted small"><?= date('d-M-Y') ?></div>
    </div>

    <div class="px-3 py-3 flex-shrink-0">
        <div class="row g-2">
            <div class="col-md-4">
                <label class="form-label fw-bold text-dark" style="font-size: 11px;">DATE <span class="text-danger">*</span></label>
                <input type="datetime-local" name="date" class="form-control" style="font-size: 12px; height: 34px;"
                    value="<?= isset($sale) ? date('Y-m-d\TH:i', strtotime($sale->date)) : date('Y-m-d\TH:i'); ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold text-dark" style="font-size: 11px;">CUSTOMER <span class="text-danger">*</span></label>
                <select name="customer_id" class="form-select select2" required style="width: 100%;">
                    <?php foreach ($customers as $c): ?>
                        <option value="<?= $c->id ?>" <?= (isset($sale) && $sale->customer_id == $c->id) ? 'selected' : '' ?>><?= $c->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold text-dark" style="font-size: 11px;">REFERENCE</label>
                <input type="text" name="reference_no" class="form-control" style="font-size: 12px; height: 34px;"
                    value="<?= isset($sale) ? $sale->reference_no : (isset($ref_no) ? $ref_no : '') ?>" readonly>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold text-dark" style="font-size: 11px;">STORE <span class="text-danger">*</span></label>
                <select name="branch_id" class="form-select select2" required style="width: 100%;">
                    <?php foreach ($branches as $b): ?>
                        <option value="<?= $b->id ?>" <?= (isset($sale) && $sale->branch_id == $b->id) ? 'selected' : '' ?>><?= $b->branch_kh ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="px-3 pb-3 flex-shrink-0">
        <div class="input-group" style="height: 38px;">
            <span class="input-group-text bg-white border border-end-0 text-muted ps-3">
                <i class="material-icons-outlined" style="font-size: 18px;">qr_code_2</i>
            </span>
            <input type="text" id="product_search" class="form-control border-start-0 border-end-0 shadow-none"
                placeholder="Scan barcode or type product name..."
                style="height: 38px; font-size: 13px; border-color: #ced4da;">
            <button class="btn btn-primary px-3 rounded-end" type="button" style="height: 38px;">
                <i class="material-icons-outlined" style="font-size: 20px;">add</i>
            </button>
        </div>
    </div>

    <div class="flex-grow-1 overflow-auto p-0" style="min-height: 0;">
        <table class="table table-bordered align-middle mb-0" style="border-color: #e5e7eb; border-left: 0; border-right: 0;">
            <thead class="bg-light sticky-top" style="z-index: 10;">
                <tr>
                    <th class="ps-3 py-2 bg-light text-dark fw-bold border-bottom" style="width: 40%; font-size: 11px;">PRODUCT</th>
                    <th class="py-2 bg-light text-dark fw-bold border-bottom text-center" style="width: 10%; font-size: 11px;">UNIT</th>
                    <th class="py-2 bg-light text-dark fw-bold border-bottom text-center" style="width: 12%; font-size: 11px;">PRICE</th>
                    <th class="py-2 bg-light text-dark fw-bold border-bottom text-center" style="width: 10%; font-size: 11px;">QTY</th>
                    <th class="py-2 bg-light text-dark fw-bold border-bottom text-center" style="width: 15%; font-size: 11px;">DISC</th>
                    <th class="py-2 bg-light text-dark fw-bold border-bottom text-end pe-3" style="width: 13%; font-size: 11px;">SUBTOTAL</th>
                    <th class="py-2 bg-light border-bottom text-center" style="width: 40px;"></th>
                </tr>
            </thead>
            <tbody id="rtable">
                </tbody>
        </table>

        <div id="empty-msg" class="text-center py-5 mt-4" style="display:none;">
            <div class="mb-2 text-muted opacity-25">
                <span class="material-icons-outlined" style="font-size: 48px;">shopping_cart</span>
            </div>
            <p class="text-muted small">Cart is empty</p>
        </div>
    </div>

    <div class="bg-white border-top px-2 py-3 mt-auto flex-shrink-0" style="z-index: 20;">
        <div class="row align-items-center">
            <div class="col-md-6 d-flex gap-2">
                <button type="submit" class="btn btn-primary px-3 fw-bold shadow-sm" style="font-size: 12px; height: 34px;">
                    <i class="material-icons-outlined fs-6 me-1" style="vertical-align: middle;">save</i> Save Sale
                </button>
                <button type="button" class="btn btn-dark px-3 fw-bold shadow-sm" onclick="$('#save_action').val('new'); $('#saleForm').submit();" style="background: #334155; font-size: 12px; height: 34px;">
                    Save & New
                </button>
                <button type="button" class="btn btn-white border px-3 fw-bold text-danger" onclick="clearLS()" style="font-size: 12px; height: 34px;">
                    Reset
                </button>
            </div>

            <div class="col-md-6">
                <div class="d-flex justify-content-end align-items-center gap-3">
                    <div class="d-flex align-items-center">
                        <span class="small fw-bold text-muted me-2" style="font-size: 11px;">DISC:</span>
                        <div class="input-group input-group-sm" style="width: 120px;">
                            <input type="number" name="order_discount" id="order_discount" class="form-control text-end" value="0" onchange="renderTable()" style="height: 30px; font-size: 12px;">
                            <select name="order_discount_id" id="order_discount_type" class="form-select text-center" style="max-width: 45px; height: 30px; font-size: 12px;" onchange="renderTable()">
                                <option value="amount">$</option>
                                <option value="percentage">%</option>
                            </select>
                        </div>
                    </div>
                    <div class="ps-3 ms-3 text-end">
                        <span class="fs-3 fw-bold text-dark" id="total_display" style="letter-spacing: -0.5px;">$0.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="total_price" id="total_price_input">
    <input type="hidden" name="grand_total" id="grand_total_input">
    <input type="hidden" name="save_action" id="save_action">

    <?php echo form_close(); ?>
</main>

<style>
    /* Styling */
    .form-control, .form-select, .select2-container .select2-selection--single {
        border-color: #ced4da; font-size: 13px; color: #1e293b; border-radius: 4px;
    }
    .form-control:focus, .form-select:focus { border-color: #2563eb !important; box-shadow: none !important; }
    
    /* Table Inputs */
    .table-bordered th, .table-bordered td { border: 1px solid #e5e7eb; }
    .table-input { border: 1px solid transparent; background: transparent; width: 100%; text-align: center; font-weight: 500; font-size: 12px; color: #334155; padding: 4px; }
    .table-input:focus { border: 1px solid #2563eb; background: #fff; outline: none; border-radius: 2px; }
    .table-input:hover { background: #f8fafc; }
    
    /* Select2 */
    .select2-container { width: 100% !important; }
    .select2-container .select2-selection--single { height: 34px !important; display: flex; align-items: center; border-color: #ced4da !important; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 34px !important; padding-left: 10px; font-size: 12px; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 34px !important; }
    
    /* Autocomplete */
    .ui-autocomplete { background: white; border: 1px solid #ced4da; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); max-height: 300px; overflow-y: auto; z-index: 9999; width: 100% !important; }
    .ui-menu-item { padding: 8px 15px; border-bottom: 1px solid #f8fafc; font-size: 12px; cursor: pointer; }
    .ui-menu-item:hover { background: #eff6ff; color: #2563eb; }
</style>

<script>
    $(document).ready(function() {
        $("#product_search").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?= site_url('sales/suggestions') ?>",
                    dataType: "json",
                    data: { term: request.term },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return { label: item.text, value: item.text, id: item.id, price: item.price, unit: item.unit };
                        }));
                    }
                });
            },
            minLength: 1, autoFocus: true,
            select: function(event, ui) { event.preventDefault(); addItem(ui.item); $(this).val(''); }
        });
        renderTable();
        $('#saleForm').on('submit', function() {
            let items = JSON.parse(localStorage.getItem('slitems')) || [];
            if (items.length === 0) { alert("Please add at least one product."); return false; }
        });
    });

    function addItem(item) {
        let items = JSON.parse(localStorage.getItem('slitems')) || [];
        let existing = items.find(x => x.id == item.id);
        if (existing) { existing.qty = parseFloat(existing.qty) + 1; } 
        else { items.push({ id: item.id, name: item.label, price: parseFloat(item.price), unit: item.unit, qty: 1, disc: 0, disc_type: 'amount' }); }
        localStorage.setItem('slitems', JSON.stringify(items));
        renderTable();
    }

    function renderTable() {
        let items = JSON.parse(localStorage.getItem('slitems')) || [];
        let html = ''; let total_sub = 0;
        if (items.length === 0) {
            $('#rtable').html(''); $('#empty-msg').show(); $('#total_display').text('$0.00');
            $('#total_price_input').val(0); $('#grand_total_input').val(0); return;
        }
        $('#empty-msg').hide();
        items.forEach((it, i) => {
            let qty = parseFloat(it.qty) || 0; let price = parseFloat(it.price) || 0;
            let line_total = qty * price;
            let disc_amt = (it.disc_type === 'percentage') ? line_total * (parseFloat(it.disc) / 100) : parseFloat(it.disc);
            let sub = line_total - disc_amt;
            total_sub += sub;
            html += `<tr>
                <td class="text-start ps-3"><span class="fw-bold text-dark" style="font-size: 12px;">${it.name}</span><input type="hidden" name="product_id[]" value="${it.id}"></td>
                <td class="text-center"><input type="text" class="table-input text-muted" value="${it.unit}" readonly tabindex="-1"></td>
                <td class="text-center"><input type="number" step="any" name="unit_price[]" class="table-input" value="${price}" onchange="updateItem(${i}, 'price', this.value)"></td>
                <td class="text-center"><input type="number" name="quantity[]" class="table-input fw-bold text-primary" value="${qty}" onchange="updateItem(${i}, 'qty', this.value)"></td>
                <td class="text-center"><div class="d-flex justify-content-center"><input type="number" name="item_discount[]" class="table-input" value="${it.disc}" onchange="updateItem(${i}, 'disc', this.value)" style="width:50px"><select name="item_discount_type[]" class="table-input text-muted p-0" onchange="updateItem(${i}, 'disc_type', this.value)" style="width:25px; border:none; -webkit-appearance:none; background:transparent;"><option value="amount" ${it.disc_type=='amount'?'selected':''}>$</option><option value="percentage" ${it.disc_type=='percentage'?'selected':''}>%</option></select></div></td>
                <td class="text-end pe-3 fw-bold text-dark" style="font-size: 12px;">$${sub.toFixed(2)}</td>
                <td class="text-center"><button type="button" class="btn btn-link text-danger p-0" onclick="removeItem(${i})"><i class="material-icons-outlined" style="font-size:16px">close</i></button></td>
            </tr>`;
        });
        $('#rtable').html(html);
        let od_val = parseFloat($('#order_discount').val()) || 0;
        let od_type = $('#order_discount_type').val();
        let order_disc_amt = (od_type === 'percentage') ? (total_sub * (od_val / 100)) : od_val;
        let grand_total = total_sub - order_disc_amt;
        $('#total_display').text('$' + grand_total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        $('#total_price_input').val(total_sub.toFixed(2));
        $('#grand_total_input').val(grand_total.toFixed(2));
    }

    function updateItem(i, f, v) { let items = JSON.parse(localStorage.getItem('slitems')); items[i][f] = v; localStorage.setItem('slitems', JSON.stringify(items)); renderTable(); }
    function removeItem(i) { let items = JSON.parse(localStorage.getItem('slitems')); items.splice(i, 1); localStorage.setItem('slitems', JSON.stringify(items)); renderTable(); }
    function clearLS() { if (confirm("Are you sure you want to clear the cart?")) { localStorage.removeItem('slitems'); renderTable(); } }
</script>