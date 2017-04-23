$(function(){
	
//	切换地址
	$('.content-address .consignee-item .radio').click(function(){
		$(this).parent().find('.radio-img').addClass('pitchOn');
		$(this).parent().siblings('.consignee-item').find('.radio-img').removeClass('pitchOn');
		
	});
//	添加新地址
	$('.new-address').click(function(){
		$('.edit').hide();
//		让当前元素隐藏
		$(this).hide();
//		取消掉其他单选框的背景
		$(this).siblings('.consignee-item').find('.radio-img').removeClass('pitchOn');
		//	使添加新地址的单选框和地址框显示
		$('.new-ress,.new').show();
//		使添加新地址的单选框添加背景
		$('.new-ress .radio-img').addClass('pitchOn');
	})
//	点击取消
$('.btn-qu').click(function(){
//	使添加新地址的单选框和地址框隐藏
	$('.new-ress,.new').hide();
//	让添加新地址的按钮显示
	$('.new-address').show();
//	让第一个第值默认选中
	$('.consignee-item').eq(0).find('.radio-img').addClass('pitchOn');
	
})
//点击编辑
$('.copyreader').click(function(){
	
	//	使添加新地址的单选框和地址框隐藏
	$('.new-ress,.new').hide();
//	让添加新地址的按钮显示
	$('.new-address').show();
//	让第一个第值默认选中
	$('.consignee-item').eq(0).find('.radio-img').addClass('pitchOn');
	
	
//	选中背景图
	$(this).parents('.consignee-item').find('.radio-img').addClass('pitchOn');
//	让其他兄弟元素的背景图消失
	$(this).parents('.consignee-item').siblings('.consignee-item').find('.radio-img').removeClass('pitchOn');
//	让编辑页面显示
	$('.edit').show();
//	获得相应的内容
	var name = $(this).parents('.consignee-item').find('.e-name').html();
	var cityParticular = $(this).parents('.consignee-item').find('.city-particular').html();
	var codeNumber = $(this).parents('.consignee-item').find('.codeNumber').html();
	var city = $(this).parents('.consignee-item').find('.city').html();
//	将获得的内容写入样式中
	$('.edit .s-name #name').val(name);
	$('.edit .shouji #shouji').val(codeNumber);
	$('.edit .address-s #particular').val(cityParticular);
	
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
	
	
	
	$('.tongyong').click(function(){
		$(this).addClass('active');
		$(this).siblings().removeClass('active');
		if($(this).hasClass('danwei')){
			$('.danweiname').show();			
		}else{
			$('.danweiname').hide();
		}
	})
	
	
	
	
})