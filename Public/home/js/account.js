$(function(){
    area.init('area');
	//切换地址
	$('.content-address').on('click','.radio',function(){
		if ($('#csaq').is('.waq_edit')){
            $(this).parents('.consignee-item').find('.compile .copyreader').trigger('click');
        }
        $(this).siblings('.radio-img').addClass('pitchOn');
		$(this).parents('.consignee-item').siblings('.consignee-item').find('.radio-img').removeClass('pitchOn');
		//修改收货地址
		$('.m-city').html($(this).find('.city').html());
		$('.m-particular').html($(this).find('.city-particular').html());
		$('.m-name').html($(this).find('.e-name').html());
		$('.m-number').html($(this).find('.codeNumber').html());
        //隐藏使用新地址按钮
        $('.content-address .consignee-item.new-ress').hide();
        //	使添加新地址的单选框和地址框隐藏
        $('.add-address.new').hide();
		//	让添加新地址的按钮显示
        $('.new-address').show();

	});
	//	添加新地址
	$('.new-address').click(function(){
        //清空三级联动的数据以及表数据
        $("#area1").find("option[text='请选择省']").attr("selected",true);
        $('#csaq')[0].reset();
        $('#area1').trigger('change');
		$('#aq_addressa').val('');
        $('#csaq').removeClass('waq_edit');
		//让当前元素隐藏
		$(this).hide();
		//取消掉其他单选框的背景
		$(this).siblings('.consignee-item').find('.radio-img').removeClass('pitchOn');
		//	使添加新地址的单选框和地址框显示
		$('.new-ress,.new').show();
		//使添加新地址的单选框添加背景
		$('.content-address .consignee-item.new-ress .radio-img').addClass('pitchOn');
	})
	//点击取消
$('.btn-qu').click(function(){
	//使添加新地址的单选框和地址框隐藏
	$('.add-address.new').hide();
	//让添加新地址的按钮显示
	$('.new-address').show();
	//让第一个第值默认选中
	$('.content-address .consignee-item').eq(0).find('.radio-img').addClass('pitchOn');
    $('.content-address .consignee-item').eq(0).find('.radio').trigger('click');
	$('.content-address .consignee-item').eq(0).siblings('.consignee-item').find('.radio-img').removeClass('pitchOn');
	//清空三级联动的数据以及表数据
    $("#area1").find("option[text='请选择省']").attr("selected",true);
    $('#csaq')[0].reset();
    $('#area1').trigger('change');
    $('#aq_addressa').val('');
    $('#csaq').removeClass('waq_edit');
    $('#waq_address_text').html("");
    //隐藏使用新地址按钮
    $('.content-address .consignee-item.new-ress').hide();
});
//点击编辑
$('.content-address').on('click','.copyreader',function(){
	//修改默认的选中地址
    $('.m-city').html($(this).parents('.consignee-item').find('.city').html());
    $('.m-particular').html($(this).parents('.consignee-item').find('.city-particular').html());
    $('.m-name').html($(this).parents('.consignee-item').find('.e-name').html());
    $('.m-number').html($(this).parents('.consignee-item').find('.codeNumber').html());

    uaid=$(this).attr('uaid');
    var THIS =this;
	$('[name=id]').val(uaid);
    $('.add-address.new').hide();
    // $('.consignee-item.new-ress').hide();
	//让添加新地址的按钮显示
	$('.new-address').show();
    $('.add-address.new').show();
    $('#csaq').addClass('waq_edit');
	//让第一个第值默认选中
	$('.consignee-item').eq(0).find('.radio-img').addClass('pitchOn');
	//选中背景图
	$(this).parents('.consignee-item').find('.radio-img').addClass('pitchOn');
	//让其他兄弟元素的背景图消失
	$(this).parents('.consignee-item').siblings('.consignee-item').find('.radio-img').removeClass('pitchOn');

	//new-address消失
	$('.new-address').hide();
    //异步获取数据
	$.post(ajaxGetUinfo,{uaid:uaid},function (res) {

		//设置就收货人
		$('input[name=uname]').val(res.uname);
		//获取旧地址
        $('#area1').val(res.site[0]);
        $('#area1').trigger('change');

        $('#area2').val(res.site[1]);
        $('#area2').trigger('change');

        $('#area3').val(res.site[2]);
        $('#area3').trigger('change');
        //获取详细地址
		$('#waq_address_text').html(res.address);
		//获取邮编
		$('[name=postcode]').val(res.postcode);
		//获取手机
		$('[name=tel]').val(res.tel);

    },'json');
})
	
	
	
	$('.invoice .radio').click(function(){
		$(this).parent().find('.radio-img').addClass('pitchOn');
		$(this).parent().siblings('.consignee-item').find('.radio-img').removeClass('pitchOn');
			if($(this).hasClass('yes')){
					$('.con').show();			
				}else{
					$('.con').hide();
				}
	
	
	})
	
	
	
	// $('.tongyong').click(function(){
     //    $(this).addClass('active');
	// 	$(this).siblings().removeClass('active');
	// 	if($(this).hasClass('danwei')){
	// 		$('.danweiname').show();
	// 	}else{
	// 		$('.danweiname').hide();
	// 	}
	// })
	
	
	
	
})