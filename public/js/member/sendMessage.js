$(function(e) {
	tabSub(".sendTabNav",".rightInfo",".listBox");
	//分页
	pages("pages-zjlxr");
	pages("pages-wdgz");
	pages("pages-wdfs");
	
	//联想搜索
	var userName = document.getElementById('find');
	if('oninput' in userName){ 
		userName.addEventListener("input",getWord,false); 
	}else{ 
		userName.onpropertychange = getWord; 
	}
	//搜索结果下拉显示内容
	function getWord(){
		//数据（可获取远程数据）
		var data = [
				{img:'../images/item/1.jpg',name:'哈用户测试1',id:'1'},
				{img:'../images/item/2.jpg',name:'哈用户测试2',id:'2'},
				{img:'../images/item/3.jpg',name:'呵用户测试3',id:'3'},
				{img:'../images/item/4.jpg',name:'呵用户测试4',id:'4'},
				{img:'../images/item/5.jpg',name:'一用户测试5',id:'5'},
				{img:'../images/item/6.jpg',name:'额用户测试6',id:'6'},
				{img:'../images/item/7.jpg',name:'一用户测试7',id:'7'},
				{img:'../images/item/8.jpg',name:'额用户测试8',id:'8'},
			];
		
		var name = userName.value;
		var arr = [];
		if(name){
			data.map((item)=>{
				if(item.name.indexOf(name) >= 0){
					arr.push(item);
				}
			});
		}
		// console.log(arr)
		$(".results").empty();
		if(arr.length > 0){
			$(".results").show();
			arr.map((item)=>{
				$(".results").append('<a href="messageDetails.html?id='+ item.id +'"><img src="'+ item.img +'" class="radius-100" width="24" height="24"><span class="ml-10">'+ item.name +'</span></a>')
			})
		}else{
			$(".results").hide();
		}
	}
});