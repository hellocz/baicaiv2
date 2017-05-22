// JavaScript Document
 $(document).ready(function(e) {
             $(".w_h_l8").hover(
				  function () {
					$(this).children(".w_xs2").show();
				  },
				  function () {
					$(this).children(".w_xs2").hide("");
				  }
				); 

           }) 
	 
	 
	  $(document).ready(function(e) {
             $(".w_h_l2").hover(
				  function () {
					$(this).children(".w_l2_z").show();
					
				  },
				  function () {
					$(this).children(".w_l2_z").hide("");
				  }
				); 

           }) 
	   $(document).ready(function(e) {
             $(".w_l2_z li").hover(
				  function () {
					$(this).children(".w_xlzc").show();
					
				  },
				  function () {
					$(this).children(".w_xlzc").hide("");
				  }
				); 

           }) 
	   
	   
	    // tasktab
function setTab(name,cursel,n,css){
 for(i=1;i<=n;i++){
  var menu=document.getElementById(name+i);
  var con=document.getElementById("con_"+name+"_"+i);
  menu.className=i==cursel?css:"";
  con.style.display=i==cursel?"block":"none";
 }
}



$(document).ready(function(e) {
    setTimeout(function(){
        console.log(111);
        var str=$('body').html();
        console.log(str);    
        str=str.replace("&#65279","");        
    },500)

})