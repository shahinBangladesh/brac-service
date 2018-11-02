<style type="text/css">
    .bg-blue, .jq-toast-wrap .jq-toast-single, .weather-gradient .left-block-wrap, .fc-unthemed .fc-today, .bg-primary{background:green !important;}
</style>
@if($errors->any())
    @if($errors->any())
        <ul class="alert alert-danger fade in animated slideInRight alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"><i  class="fa fa-times" aria-hidden="true"></i></a>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
@endif
{{--set some message after action--}}
@if (Session::has('message'))
    <script type="text/javascript">
    $(window).on("load",function(){
        window.setTimeout(function(){
            $.toast({
                heading: '{{ Session::get("message") }}',
                text: '',
                position: 'bottom-left',
                loaderBg:'#7BAB44',
                icon: '',
                hideAfter: 150000, 
                stack: 6
            });
        }, 1000);
    });
    /*****Load function* end*****/
    </script>
@endif