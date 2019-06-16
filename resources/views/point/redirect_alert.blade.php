

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
