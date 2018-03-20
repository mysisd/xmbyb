/**
 * Created by Administrator on 2018/2/4 0004.
 */
$(function () {
    // 头部切换
   $("#navs").slide({ type: "menu", titCell: ".nLi", targetCell: ".sub", effect: "slideDown", delayTime: 300, triggerTime: 0,});

    $('.it').hover( //鼠标滑过导航栏目时
        function(){
            $('.sub').show(); //显示下拉列表
            // $(this).css({'color':'red','background-color':'orange'}); //设置导航栏目样式，醒目
        },
        function(){
            $('.sub').hide(); //鼠标移开后隐藏下拉列表
        }
    );
    $('.sub').hover( //鼠标滑过下拉列表自身也要显示，防止无法点击下拉列表
        function(){
            $('.sub').show();
        }
    )
    $('.add-button').click(function () {
      $('#layui-layer-shade1').show();
      $('#layui-layer1').show();

    })
    $('#cancel').click(function () {
        $('#close').trigger('click');
    })
    $('#layui-layer-shade1').click(function(){
        $("#layui-layer1").hide();
        $('#layui-layer-shade1').hide();
    });
    $('#close').click(function () {
        $("#layui-layer1").hide();
        $('#layui-layer-shade1').hide();
    })
    $('#savebt').click(function () {
        var department_name=$('#department_name').val();
        var  describe=$('#department_describe').val();
        var parent_id=$('#parent_id option:selected') .val();//选中的值;
        if(describe==''||department_name==''){
            alert('内容不能为空');
            return false;
        }
        $.ajax({
            url:'/manager/index/Create',
            type:'post',
            dataType:'json',
            data:{'department_name':department_name,'describe':describe,'parent_id':parent_id},
            success:function (data) {
                if(data.res=='success'){
                    alert('添加成功');

                }else if(data.res=='error'){
                    alert('添加失败');
                }
            }
        })
    })


})