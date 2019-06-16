@extends('admin.change_password')

@section('content')
    <title>节点信息编辑</title>
    </head>
    <body>
    <div class="pd-20">
        <div class="Huiform">
            <form id="form-change-password">

                <table class="table table-bg">
                    <tbody>
                    <tr>
                        <th></th>
                        <td>
                  <span class="select-box" style='width:200px;'>
	            <select  class='select' name="pid" size="1">
                 <option value="0">栏目标题</option>
                    @foreach($arr as $k => $v)
                        <option value="{{$v['id']}}">{{$v['name']}}</option>
                    @endforeach
                    </select>
	                         </span>
                        </td>
                    </tr>

                    <tr>
                        <th width="100" class="text-r">节点名称：</th>

                        <td><input type="text" style="width:200px" class="input-text name" value="" placeholder=""  name="name"></td>
                    </tr>

                    @csrf

                    <tr>
                        <th class="text-r"> 字段名称：</th>
                        <td><input type="text" style="width:200px" class="input-text action" value="" placeholder=""  name="action"></td>
                    </tr>

                    <tr>
                        <th class="text-r"> 样式：</th>
                        <td><input type="text" style="width:200px" class="input-text style" value="" placeholder="可以留空 无需填写"  name="style"></td>
                    </tr>

                    <tr>
                        <th></th>
                        <td><button class="btn btn-success radius" type="submit"><i class="icon-ok"></i> 确定</button></td>
                    </tr>

                    </tbody>
                </table>
            </form>
        </div>
    </div>
@endsection

@section('javascript_logic')
    <script type="text/javascript">
        $(function(){
            $("#form-change-password").validate({
                rules:{
                    name:{
                        required:true,
                        minlength:1,
                        maxlength:160
                    }
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    var url = '{{route('permission.add_post')}}';
                    $(form).ajaxSubmit({
                        type: 'post',
                        url:url,
                        async:false,
                        success: function(data){
                            console.log(data);
                            if(data.status == 1){
                                layer.msg(data.msg, {icon: 1, time: 2000},function (){
                                    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                    parent.location.reload();
                                    parent.layer.close(index);
                                })
                            }else{
                                layer.msg(data.msg, {icon: 2, time: 2000},function (){
                                    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                    parent.location.reload();
                                    parent.layer.close(index);
                                })
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection

