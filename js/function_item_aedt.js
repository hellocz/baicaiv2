$(function(){
	var c=$("#J_cate_id"),
	 	t=$("#J_title"),
		ot=$("#J_otitle"),
		it=$("#intro"),
		lt=$("input[name='link_type[]']"),
		lu=$("input[name='link_url[]']"),
		jt=$("#J_tags"),
		p=$("#price"),
		e=$("#express"),
		og=$("#orig_id"),
		ib=$("#isbest"),
		ih=$("#ishot"),
		ist=$("#istop"),
		ct=$("#content"),
		at=$("#add_time"),
		seot=$("#seo_title"),
		seok=$("#seo_keys"),
		seod=$("#seo_desc"),
		ps=$("#ispost"),
		id=$("#id"),
		frm=$("#info_form"),
		st=$("#status");
	t.change(function(){//编辑标题触发保存草稿
		if(t.val()!=""){
			sv();
		}					  
	});
	var sv=function(){//保存草稿
		editor.sync();
		//链接名称
		var lty='';
		for(var m=0;m<lt.length;m++){
			if(lty==""){
				lty=lt.eq(m).val();	
			}else{
				lty=lty+"|||"+lt.eq(m).val();	
			}
		}
		//链接地址
		var ltu='';
		for(var m=0;m<lu.length;m++){
			if(ltu==""){
				ltu=lu.eq(m).val();	
			}else{
				ltu=ltu+"|||"+lu.eq(m).val();	
			}
		}
		if(ps.attr("checked")){psv=1;}else{psv=0;}
		if(ib.attr("checked")){isbest=1;}else{isbest=0;}
		if(ih.attr("checked")){ishot=1;}else{ishot=0;}
		if(ist.attr("checked")){istop=1;}else{istop=0;}
		$.post("index.php?m=ajax&a=item_acg",{cate_id:c.val(),title:t.val(),otitle:ot.val(),intro:it.val(),link_type:lty,link_url:ltu,tags:jt.val(),price:p.val(),express:e.val(),ispost:psv,content:ct.val(),id:id.val(),add_time:at.val(),seo_title:seot.val(),seo_keys:seok.val(),seo_desc:seod.val(),orig_id:og.val(),isbest:isbest,ishot:ishot,istop:istop},
		function(r){																																																	   			if(r.status==1){
				st.val(0);
				$.pinphp.tip({content:r.msg});
			}else{
				$.pinphp.tip({content:r.msg, icon:'error'});
			}
		},"JSON");
		
	}
});