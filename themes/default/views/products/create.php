<main class="app-container">
    <?php echo form_open_multipart(isset($product->id) ? "products/edit/".$product->id : "products/create", ['id' => 'createForm']); ?>
    
    <div class="card shadow-none border-0 rounded-0 h-100">
        
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center" style="border-color: #f3f4f6;">
            <div>
                <span class="material-icons-outlined fs-5 align-middle me-1 text-dark">inventory_2</span>
                <span class="fw-bold text-dark">PRODUCT ENTRY</span> <span class="label-kh ms-1 text-muted">(បង្កើតទំនិញ)</span>
            </div>
            <div class="text-muted small"><?= date('d-M-Y') ?></div>
        </div>
        
        <div class="card-body p-3">
            <div class="row g-4">
                <div class="col-lg-9 col-12">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label"><?= lang('code', 'code'); ?> <span class="label-kh">(កូដ)</span> <span class="text-danger">*</span></label>
                            <?php echo form_input('code', (isset($product->code) ? $product->code : ''), 'class="form-control" id="code" placeholder="P-2026-001"'); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?= lang('name', 'name'); ?> <span class="label-kh">(ឈ្មោះ)</span> <span class="text-danger">*</span></label>
                            <?php echo form_input('name', (isset($product->name) ? $product->name : ''), 'class="form-control" id="name" placeholder="Product Name"'); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?= lang('category', 'categorySelect'); ?> <span class="label-kh">(ប្រភេទ)</span> <span class="text-danger">*</span></label>
                            <?php 
                                $catArr = array(); foreach ($categories as $cate) { $catArr[$cate->id] = $cate->name; } 
                                echo form_dropdown('category', $catArr, (isset($product->category_id) ? $product->category_id : ''), 'class="form-select select2" style="width:100%"'); 
                            ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?= lang('unit', 'unit'); ?> <span class="label-kh">(ខ្នាត)</span> <span class="text-danger">*</span></label>
                            <?php 
                                $unitArr = array(); foreach ($units as $u) { $unitArr[$u->id] = $u->name; } 
                                echo form_dropdown('unit', $unitArr, (isset($product->unit_id) ? $product->unit_id : ''), 'class="form-select select2" style="width:100%"'); 
                            ?>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?= lang('cost', 'cost'); ?> <span class="label-kh">(ថ្លៃដើម)</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <?php echo form_input('cost', (isset($product->cost) ? $product->cost : '0.00'), 'class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?= lang('price', 'price'); ?> <span class="label-kh">(តម្លៃលក់)</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <?php echo form_input('price', (isset($product->price) ? $product->price : '0.00'), 'class="form-control fw-bold text-primary"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?= lang('alert_quantity', 'alert_quantity'); ?> <span class="label-kh">(បរិមាណ)</span></label>
                            <?php echo form_input('alert_quantity', (isset($product->alert_quantity) ? $product->alert_quantity : '10'), 'class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-12 d-flex justify-content-center">
                    <div style="width: 100%; max-width: 200px;">
                        <label class="form-label text-center d-block mb-2"><?= lang('image', 'image'); ?> <span class="label-kh">(រូបភាព)</span></label>
                        
                        <div class="image-upload-wrapper w-100" id="uploadBox" onclick="triggerUpload()" style="height: 200px; border: 1px dashed #e5e7eb; background: #f9fafb; position: relative; border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <?php $hasImage = isset($product->image) && !empty($product->image); $imgSrc = $hasImage ? base_url('assets/uploads/').$product->image : ''; ?>
                            
                            <button type="button" class="btn-remove-img shadow-sm" id="removeImg" onclick="removeImage(event)" style="<?= $hasImage ? 'display:flex' : 'display:none' ?>; position: absolute; top: -10px; right: -10px; background: white; border: 1px solid #e5e7eb; border-radius: 50%; width: 28px; height: 28px; align-items: center; justify-content: center; color: #ef4444; z-index: 10;">
                                <span class="material-icons-outlined fs-6">close</span>
                            </button>
                            
                            <div class="upload-content text-center" style="<?= $hasImage ? 'display:none' : '' ?>">
                                <div class="mb-2 text-primary opacity-50"><span class="material-icons-outlined" style="font-size: 42px;">cloud_upload</span></div>
                                <div class="text-dark fw-bold small">Click to Upload</div>
                            </div>
                            
                            <img src="<?= $imgSrc ?>" id="imagePreview" style="<?= $hasImage ? 'display:block' : 'display:none' ?>; width:100%; height:100%; object-fit:contain; padding: 5px;">
                            <input type="file" id="imageInput" name="userfile" accept="image/*" style="display:none;">
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-2 pt-2 border-top" style="border-color: #f3f4f6 !important;">
                    <div class="d-flex justify-content-start gap-2">
                        <button type="submit" class="btn btn-primary shadow-sm"><span class="material-icons-outlined fs-6 me-1" style="vertical-align: middle;">save</span> <?=lang('save')?></button>
                        <button type="button" class="btn btn-white shadow-sm" onclick="triggerSaveNew()"><span class="material-icons-outlined fs-6 me-1" style="vertical-align: middle;">add_circle</span> Save & New</button>
                        <a href="<?= base_url('products') ?>" class="btn btn-white"><span class="material-icons-outlined fs-6 me-1" style="vertical-align: middle;">close</span> Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</main>