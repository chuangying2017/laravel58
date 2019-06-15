@extends('admin.change_password')

@section('content')
    <title>节点信息编辑</title>
    </head>
    <body>
    <div class="pd-20">
        <div class="Huiform">
            <form action="" method="post">

                <table class="table table-bg">
                    <tbody>
                    <tr>
                        <th></th>
                        <td>
                  <span class="select-box" style='width:200px;'>
	            <select  class='select' name="pid" size="1">
                 <option value="0">栏目标题</option>
               {{--     <volist name="list" id="vo">
                            <option value="<{$vo.id}>"><{$vo.tree}></option>
                    </volist>--}}
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
                        <td><input type="text" style="width:200px" class="input-text control_action" value="" placeholder=""  name="action"></td>
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
                        minlength:6,
                        maxlength:160
                    },
                    action:{
                        required:true,
                        minlength:6,
                        maxlength:160,
                    },
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit();
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.$('.btn-refresh').click();
                    parent.layer.close(index);
                }
            });
        });
    </script>
@endsection

