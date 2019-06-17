
<script type="text/javascript" src="{{asset('h-ui/lib/jquery/1.9.1/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('h-ui/lib/layer/2.4/layer.js')}}"></script>
@if(!empty(session('tip')))
    　　
    <div class="alert alert-success" role="alert" style="z-index: 999">
        　　　　{{session('tip')}}
    </div>
    <script>
        setInterval(function(){
            $('.alert').remove();
        },3000);
    </script>
@endif


@if (isset($arr['url']))

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script type="application/javascript">
        setInterval(function(){
            document.getElementById('logout-form').submit();
        },3000);
    </script>
@endif
