<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
@yield('site_scripts')
<script src={{asset('assets/frontend/js/lib/breaking-news-ticker.min.js')}}></script>
<script>
    $(document).ready(function () {
        $("#newsTicker2").breakingNews({
            direction: "rtl",
        });
    });
</script>
<script src="{{asset('js/share.js')}}"></script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v19.0&appId=472649630378485" nonce="XOlf1Fd2"></script>
<script src={{asset('assets/frontend/js/custom.js')}}></script>
