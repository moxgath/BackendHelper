<script type="text/javascript">
    var summernoteUploadUrl = "{{ route('summernote.upload') }}";
    var summernoteToken     = "{{ csrf_token() }}";
</script>
<!-- Vendor -->
<script src="{{ asset('vendor/backendhelper/vendor/jquery/jquery.js') }}"></script>
<script src="{{ asset('vendor/backendhelper/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
<script src="{{ asset('vendor/backendhelper/vendor/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset('vendor/backendhelper/vendor/nanoscroller/nanoscroller.js') }}"></script>
<script src="{{ asset('vendor/backendhelper/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('vendor/backendhelper/vendor/magnific-popup/magnific-popup.js') }}"></script>
<script src="{{ asset('vendor/backendhelper/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>

<script src="{{ asset('vendor/backendhelper/vendor/select2/select2.js') }}"></script>
<script src="{{ asset('vendor/backendhelper/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('vendor/backendhelper/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js') }}"></script>
<script src="{{ asset('vendor/backendhelper/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>

<script src="{{ asset('vendor/backendhelper/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js') }}"></script>
<script src="{{ asset('vendor/backendhelper/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('vendor/backendhelper/vendor/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>
<script src="{{ asset('vendor/backendhelper/js/typeahead.js') }}"></script>
<script src="{{ asset('vendor/backendhelper/vendor/ios7-switch/ios7-switch.js') }}"></script>
<script src="{{ asset('vendor/backendhelper/vendor/summernote/summernote.js') }}"></script>
<script src="{{ asset('vendor/backendhelper/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('vendor/backendhelper/vendor/toastr/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/backendhelper/js/custom.js') }}"></script>
    
<script src="{{ asset('vendor/backendhelper/javascripts/theme.js') }}"></script>
<script src="{{ asset('vendor/backendhelper/javascripts/theme.custom.js') }}"></script>
<script src="{{ asset('vendor/backendhelper/javascripts/theme.init.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.summernote')._summernote({
            height: 400
        });
        $('button[type="reset"]').click(function() {
            $('.summernote').code('');
        });
        $('form').submit(function(e) {
            var summernote = $(this).find('.summernote');
            if(summernote.length) {
                summernote.each(function(index, ele) {
                    var code = $(ele).summernote('code');
                    $(ele).summernote('code', code);
                });
            }
        });
        $('.nano ul.nav-main a[href="{{ url()->full() }}"]').parent().addClass('nav-active').parents('li.nav-parent').addClass('nav-expanded nav-active');
        @if(session('toastr'))
            @php
                $action = array_keys(session('toastr'))[0];
                $text   = array_values(session('toastr'))[0];
            @endphp
            toastr.{{ $action }}('{!! $text !!}');
        @endif
    });
</script>
@stack('javascript')
