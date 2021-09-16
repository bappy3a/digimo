<div class="preloader" id="preloader">
    <div class="preloader-inner">
        @if(!empty(get_static_option('preloader_cacncel_button')))
            <button class="cancel-preloader" onclick="disablePreloader()">{{__('Cancel Preloader')}}</button>
        @endif
        <div class="spinner">
            <svg viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                <circle class="length" fill="none" stroke-width="8" stroke-linecap="round" cx="33" cy="33" r="28">
                </circle>
            </svg>
            <svg viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                <circle fill="none" stroke-width="8" stroke-linecap="round" cx="33" cy="33" r="28"></circle>
            </svg>
            <svg viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                <circle fill="none" stroke-width="8" stroke-linecap="round" cx="33" cy="33" r="28"></circle>
            </svg>
            <svg viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                <circle fill="none" stroke-width="8" stroke-linecap="round" cx="33" cy="33" r="28"></circle>
            </svg>
        </div>
    </div>
</div>
<script>
    function disablePreloader() {
        document.querySelector('#preloader').remove();
    }
</script>
