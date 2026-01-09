<footer class="main-footer">
    <div><span class="fw-bold text-dark">POS SYSTEM</span> &copy; 2026</div>
    <div>Version 5.6</div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    // Page Load Transition
    window.addEventListener('load', function() {
        setTimeout(function() {
            var loader = document.getElementById('pageLoader');
            if (loader) {
                loader.classList.add('hidden');
                setTimeout(function() { loader.style.display = 'none'; }, 400);
            }
        }, 300); 
    });

    $(document).ready(function() {
        // Init Select2
        if ($('.select2-basic').length > 0) {
            $('.select2-basic').select2({ width: '100%', minimumResultsForSearch: Infinity }); 
        }

        // Image Upload Logic
        const fileInput = $('#imageInput');
        const uploadBox = $('#uploadBox');
        
        if (uploadBox.length) {
            uploadBox.on('click', function(e) {
                if (e.target.id === 'imageInput' || $(e.target).closest('#removeImg').length > 0) return;
                fileInput.trigger('click');
            });
            
            fileInput.on('click', function(e) { e.stopPropagation(); });
            
            fileInput.on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(evt) {
                        $('#imagePreview').attr('src', evt.target.result).show();
                        $('.upload-content').hide();
                        $('#removeImg').css('display', 'flex');
                    }
                    reader.readAsDataURL(file);
                }
            });
            
            $('#removeImg').on('click', function(e) {
                e.stopPropagation(); e.preventDefault();
                fileInput.val('');
                $('#imagePreview').hide().attr('src', '');
                $('.upload-content').show();
                $(this).hide();
            });
        }
    });

    // Sidebar Toggle Logic
    function handleSidebarToggle() {
        if (window.innerWidth >= 992) {
            $('body').toggleClass('sidebar-closed'); 
        } else {
            toggleSidebarMobile(); 
        }
    }

    function toggleSidebarMobile() {
        var sidebar = $('#sidebar');
        sidebar.toggleClass('active');
        $('#mobOverlay').toggleClass('show');
    }

    // Accordion Menu Logic
    function toggleSubmenu(element) {
        var $parentLi = $(element).parent();
        if ($parentLi.hasClass('expanded')) {
            $parentLi.removeClass('expanded'); 
        } else {
            $('.menu-item.expanded').removeClass('expanded'); 
            $parentLi.addClass('expanded'); 
        }
    }

    // Active Link Highlight
    function activateLink(element) {
        $('.submenu-link').removeClass('active');
        $(element).addClass('active');
    }

    // Save Function with Button Loader
    function triggerSave() {
        var $btn = $('#btnSave');
        var originalContent = $btn.html();
        $btn.html('<span class="btn-spinner"></span> Saving...').prop('disabled', true);

        setTimeout(function() {
            $btn.html(originalContent).prop('disabled', false);
            var toastHTML = `<div class="custom-toast"><span class="material-icons-outlined text-success fs-3 me-3">check_circle</span><div><div class="fw-bold" style="font-size:13px">Success</div><small class="text-muted" style="font-size:11px">Saved successfully</small></div></div>`;
            $('#toastContainer').append(toastHTML);
            setTimeout(() => { $('.custom-toast').last().fadeOut(300, function(){ $(this).remove(); }); }, 3000);
        }, 800);
    }
</script>
</body>
</html>