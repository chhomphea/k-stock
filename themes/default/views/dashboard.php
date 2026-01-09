<main class="app-container">
    <form id="createForm" style="height: 100%;">
        <div class="card card-full">
            <div class="card-header">
                <span>General Information</span>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-lg-8 col-12">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Code <span class="label-kh">(កូដ)</span> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="P-2026-001">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Name <span class="label-kh">(ឈ្មោះ)</span> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Product Name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category <span class="label-kh">(ប្រភេទ)</span> <span class="text-danger">*</span></label>
                                <select class="form-select select2-basic"><option>Beer</option><option>Water</option></select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Unit <span class="label-kh">(ខ្នាត)</span> <span class="text-danger">*</span></label>
                                <select class="form-select select2-basic"><option>Can</option><option>Box</option></select>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label">Cost <span class="label-kh">(ថ្លៃដើម)</span> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" value="0.00">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Price <span class="label-kh">(តម្លៃលក់)</span> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control fw-bold text-primary" value="0.00">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Alert <span class="label-kh">(បរិមាណ)</span></label>
                                <input type="number" class="form-control" value="10">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-12 image-upload-container">
                        <div style="width: 150px;">
                            <label class="form-label text-center d-block">Image <span class="label-kh">(រូបភាព)</span></label>
                            <div class="image-upload-wrapper" id="uploadBox">
                                <button type="button" class="btn-remove-img" id="removeImg"><span class="material-icons-outlined fs-5">close</span></button>
                                
                                <div class="upload-content text-center">
                                    <div class="mb-2 text-primary">
                                        <span class="material-icons-outlined" style="font-size: 32px;">cloud_upload</span>
                                    </div>
                                    <div class="text-dark fw-bold small">Click to Upload</div>
                                    <div class="text-muted" style="font-size:11px">4x4 cm</div>
                                </div>
                                <img src="" id="imagePreview" style="display:none; width:100%; height:100%; object-fit:cover; border-radius:inherit; position:absolute;">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-4 pt-3 border-top">
                        <div class="d-flex justify-content-start gap-2 action-buttons">
                            <button type="button" class="btn btn-primary" id="btnSave" onclick="triggerSave()">
                               <span class="material-icons-outlined fs-6 me-1" style="vertical-align: middle;">save</span> Save
                            </button>
                            <button type="button" class="btn btn-save-new" onclick="triggerSave()">
                               <span class="material-icons-outlined fs-6 me-1" style="vertical-align: middle;">add_circle</span> Save & New
                            </button>
                            <button type="button" class="btn btn-danger-custom" onclick="window.location.reload()">
                               <span class="material-icons-outlined fs-6 me-1" style="vertical-align: middle;">close</span> Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>