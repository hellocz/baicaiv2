// JavaScript Document
 $(document).ready(function(e) { 
	 $(".l_f1 li").hover(
		function () {
		  $(this).children("p").show();
		},
		function () {
		  $(this).children("p").hide();
		}
	  ); 

  });
 
  $(document).ready(function(e) { 
	 $(".w_lk_h").hover(
		function () {
		  $(this).children(".w_l_rwm").show();
		},
		function () {
		  $(this).children(".w_l_rwm").hide();
		}
	  ); 

  });
 
 
 // tasktab
function setTab(name,cursel,n,css){
 for(i=1;i<=n;i++){
  var menu=document.getElementById(name+i);
  var con=document.getElementById("con_"+name+"_"+i);
  menu.className=i==cursel?css:"";
  con.style.display=i==cursel?"block":"none";
 }
}