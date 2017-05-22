$(function(){
	var u=$(".J_url"),
		t=$(".J_title"),
		i=$("#img"),
		f=$("#J_img"),
		s=$(".J_cate_select"),
		c=$("#J_cate"),
		p=$("#price"),
		e=$("#express"),
		ps=$("#ispost"),
		img=$("input[name='imgs[]']"),
		lt=$("input[name='link_type[]']"),
		lu=$("input[name='link_url[]']"),
		ct=$("#content"),
		id=$("#id"),
		st=$("#status"),
		frm=$("#info_form");
	u.change(function(){//±à¼­Â·¾¶´¥·¢±£´æ²Ý¸å
		if(t.val()!=""){
			sv();
		}
	});
	t.change(function(){//±à¼­±êÌâ´¥·¢±£´æ²Ý¸å
		if(t.val()!=""){
			sv();
		}					  
	});
	p.change(function(){
		sv();
	});
	e.change(function(){
		sv();
	});
	ps.change(function(){
		sv();		   
	})
	lt.live("change",function(){
		sv();
	});
	lu.live("change",function(){
		sv();
	});
	var sv=function(){//±£´æ²Ý¸å
		editor.sync();
		//Í¼Æ¬
		var limg='';
		for(var m=0;m<img.length;m++){
			if(limg==""){
				limg=img.eq(m).val();	
			}else{
				limg=limg+"|||"+img.eq(m).val();	
			}
		}
		//Á´½ÓÃû³Æ
		var lty='';
		for(var m=0;m<lt.length;m++){
			if(lty==""){
				lty=lt.eq(m).val();	
			}else{
				lty=lty+"|||"+lt.eq(m).val();	
			}
		}
		//Á´½ÓµØÖ·
		var ltu='';
		for(var m=0;m<lu.length;m++){
			if(ltu==""){
				ltu=lu.eq(m).val();	
			}else{
				ltu=ltu+"|||"+lu.eq(m).val();	
			}
		}
		if(ps.attr("checked")){psv=1;}else{psv=0;}
		$.post("index.php?m=ajax&a=save_item_cg",{url:u.val(),title:t.val(),img:i.val(),cate_id:c.val(),price:p.val(),express:e.val(),ispost:psv,imgs:limg,link_type:lty,link_url:ltu,content:ct.val(),id:id.val(),status:st.val()},
		function(r){																																																	   			if(r.status==1){
				id.val(r.data.id);
				st.val(0);
				frm.attr('action',r.data.aurl);
				tips(r.msg,1);
			}else{
				tips(r.msg,0);	
			}
		},"JSON");
		
	}
	var editor;
	KindEditor.ready(function(K) {
		editor = K.create('#content', {
			uploadJson : '/index.php?g=admin&m=attachment&a=editer_upload',
			fileManagerJson : '/index.php?g=admin&m=attachment&a=editer_manager',
			allowFileManager : true,
			items:['undo','redo','bold','fontsize','forecolor','emoticons','link','unlink', 'image','multiimage','media']
		});
		K('#info_form').bind('submit', function() {
			editor.sync();
		});
	});
});