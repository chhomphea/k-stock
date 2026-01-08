<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark m-0"><?=lang('products')?></h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 text-muted small">
                <li class="breadcrumb-item">
                    <a href="#" class="text-decoration-none text-muted">
                        <span class="material-icons-outlined align-middle fs-6">dashboard</span>
                        <?=lang('dashboard')?>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><?=lang('products')?></li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-2 border-bottom">
            <h6 class="m-0 fw-bold text-primary" style="font-size: 0.85rem;">
                <span class="material-icons-outlined align-middle me-1 fs-6">add_circle_outline</span> 
                <?= isset($product->id) ? 'Edit Product' : lang('create_product') ?>
            </h6>
        </div>
        
        <div class="collapse show border-bottom" id="createFormBody">
            <div class="card-body p-4">
                <?php echo form_open_multipart(isset($product->id) ? "products/edit/".$product->id : "products/create"); ?>
                
                <div class="row g-4">
                    
                    <div class="col-lg-9 pe-lg-4 border-end-lg">
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label"><?= lang('code', 'code'); ?> <span class="text-danger">*</span></label>
                                <?= form_input('code',$product->code, 'class="form-control font-mono" id="code" placeholder="P-001"'); ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><?= lang('name', 'name'); ?> <span class="text-danger">*</span></label>
                                <?= form_input('name', $product->name, 'class="form-control" id="name" placeholder="Enter product name"'); ?>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label"><?= lang('category', 'categorySelect'); ?></label>
                                <?php $catArr[''] = lang('please_select'); foreach ($categories as $key => $cate) { $catArr[$cate->id] = $cate->name; } ?>
                                <?= form_dropdown('category', $catArr, $product->category_id, 'class="form-select select2-basic w-100" id="categorySelect"'); ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><?= lang('unit', 'unit'); ?></label>
                                <?php $unitArr[''] = lang('please_select'); foreach ($units as $key => $u) { $unitArr[$u->id] = $u->name; } ?>
                                <?= form_dropdown('unit', $unitArr, $product->unit_id, 'class="form-select select2-basic w-100" id="unit"'); ?>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label"><?= lang('cost', 'cost'); ?> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0">$</span>
                                    <?= form_input('cost', $product->cost, 'class="form-control border-start-0" id="cost" placeholder="0.00"'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><?= lang('price', 'price'); ?> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0">$</span>
                                    <?= form_input('price', $product->price, 'class="form-control border-start-0" id="price" placeholder="0.00"'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3"> 
                        <div class="sticky-top" style="top: 1rem; z-index: 1;">
                            <label class="form-label d-block text-center mb-2 fw-bold"><?=lang('image')?></label>
                            
                            <div class="image-upload-box mx-auto shadow-sm" id="imageWrapper" onclick="$('#imageInput').click()">
                                <div id="uploadPlaceholder" class="<?= $product ? 'd-none' : 'd-flex' ?> flex-column align-items-center justify-content-center h-100 text-muted">
                                    <span class="material-icons-outlined fs-2 text-muted">cloud_upload</span>
                                    <span class="fw-bold mt-1" style="font-size: 0.7rem;">Upload Photo</span>
                                </div>
                                <img id="imagePreview" src="<?= $product ? base_url('assets/uploads/').$product->image : '' ?>" class="<?= $product ? 'd-block' : 'd-none' ?> w-100 h-100 object-fit-contain p-1">
                                <input type="file" id="imageInput" name="userfile" accept="image/*" class="d-none">
                            </div>
                            
                            <div class="text-center mt-2">
                                <span class="badge bg-light text-muted border">Max 2MB (JPG/PNG)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-1">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input type="checkbox" class="form-check-input" <?=$product->active==1?'checked':''?> value="1" name="display" id="display">
                            <label class="form-check-label" for="display"><?=lang('display')?></label>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-1">
                        <div class="d-flex justify-content-start gap-2 mt-1 pt-2">
                            <button type="submit" class="btn btn-primary px-4 shadow-sm" id="btnSave">
                                <span class="material-icons-outlined align-middle fs-6 me-1">save</span> <?=lang('save')?>
                            </button>
                            <button type="button" class="btn btn-light border px-4">Cancel</button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="productData" class="table table-hover table-sm align-middle mb-0" style="width:100%">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" style="width: 40px;"><?=lang('image')?></th>
                            <th><?=lang('code')?></th>
                            <th><?=lang('name')?></th>
                            <th><?=lang('category')?></th>
                            <th><?=lang('unit')?></th>
                            <th><?=lang('price')?></th>
                            <th><?=lang('created_at')?></th>
                            <th><?=lang('created_by')?></th>
                            <th><?=lang('display')?></th>
                            <th class="text-end pe-3"><?=lang('actions')?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#imageInput').change(function(){
        if(this.files && this.files[0]){
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imagePreview').attr('src', e.target.result).removeClass('d-none').addClass('d-block');
                $('#uploadPlaceholder').removeClass('d-flex').addClass('d-none');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    var table = $('#productData').DataTable({
        processing: true, serverSide: true, responsive: true, autoWidth: false,
        dom: "<'d-flex justify-content-between align-items-center p-3'lf>t<'d-flex justify-content-between align-items-center p-3'ip>",
        ajax: {
            url: '<?php echo site_url('products/get_products'); ?>', type: 'POST',
            data: function(d) { d.<?php echo $this->security->get_csrf_token_name(); ?> = "<?php echo $this->security->get_csrf_hash(); ?>"; }
        },
        columns: [
            { "data": "image", "searchable": false, "orderable": false, "render": dislayImage },
            { data: "code", className: "fw-bold text-dark font-mono small" },
            { data: "name", className: "fw-semibold small" },
            { data: "category", className: "small" },
            { data: "unit", className: "small" },
            { data: "price", className: "text-success fw-bold font-mono small" },
            { data: "created_at", className: "small text-muted" },
            { data: "created_by", className: "small" },
            { data: "active", className: "text-center", "render":Active },
            { data: "Actions", searchable: false, orderable: false, className: "text-center pe-3" }
        ],
        language: { search: "", searchPlaceholder: "Search..." }
    });
});
</script>