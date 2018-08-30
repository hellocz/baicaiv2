$(function(e) {
	tabSub(".sendTabNav",".rightInfo",".listBox");
	//分页
	// pages("pages-zjlxr");
	// pages("pages-wdgz");
	// pages("pages-wdfs");
	$('#pages-contacts').length && ajaxPages('pages-contacts', page_contacts, content_contacts);
	$('#pages-follows').length && ajaxPages('pages-follows', page_follows, content_follows);
	$('#pages-fans').length && ajaxPages('pages-fans', page_fans, content_fans);

	//联想搜索
	var userName = document.getElementById('find');
	if('oninput' in userName){ 
		console.log('1');
		userName.addEventListener("input",getWord,false); 
	}else{ 
		console.log('2');
		userName.onpropertychange = getWord; 
	}
	//搜索结果下拉显示内容
	function getWord(){
		// //数据（可获取远程数据）
		// var data = [
		// 		{img_url:'../images/item/1.jpg',username:'哈用户测试1',ftid:'1'},
		// 		{img_url:'../images/item/2.jpg',username:'哈用户测试2',ftid:'2'},
		// 		{img_url:'../images/item/3.jpg',username:'呵用户测试3',ftid:'3'},
		// 		{img_url:'../images/item/4.jpg',username:'呵用户测试4',ftid:'4'},
		// 		{img_url:'../images/item/5.jpg',username:'一用户测试5',ftid:'5'},
		// 		{img_url:'../images/item/6.jpg',username:'额用户测试6',ftid:'6'},
		// 		{img_url:'../images/item/7.jpg',username:'一用户测试7',ftid:'7'},
		// 		{img_url:'../images/item/8.jpg',username:'额用户测试8',ftid:'8'},
		// 	];
		
		var name = userName.value;
		var arr = [];

		// if(name){
		// 	data.map((item)=>{
		// 		if(item.username.indexOf(name) >= 0){
		// 			arr.push(item);
		// 		}
		// 	});
		// }

		//取数据
		$.ajax({
			 url: PINER.root + '/?m=message&a=search_target',
			 type: 'POST',
			 data: {
				 search_uname: name
			 },
			 dataType: 'json',
			 async: false, //同步
			 success: function(result){
				 if(result.status == 1){
					 //列表动态添加
					 arr = result.data;
				 }
			 }
		});

		// console.log(arr)
		$(".results").empty();
		if(arr.length > 0){
			$(".results").show();
			arr.map((item)=>{
				$(".results").append('<a href="/?m=message&a=talk&ftid='+ item.ftid +'"><img src="'+ item.img_url +'" class="radius-100" width="24" height="24"><span class="ml-10">'+ item.username +'</span></a>')
			})
		}else{
			$(".results").hide();
		}
	}
});