var n=count=0;
      var t=null;
      $(function(){
        $("#slide >div:gt(0)").hide();
        count=$("#slide >div").length;
        autoPlay();
        $("#slide").hover(function(){
          clearInterval(t);
        },function(){
          autoPlay();
        });
        $("#slide_p >span").each(function(index){
          $(this).mouseover(function(){
            play(index);
          });
        });
      });     
      function play(num){
        n=num;
        $("#slide >div").fadeOut(500);
        $("#slide >div").eq(n).fadeIn(1000);
        $("#slide_p >span").removeClass('cur');
        $("#slide_p >span").eq(n).addClass('cur');
      }
      function autoPlay(){
        t=setInterval(function(){
          n++;
          if(n>=count) n=0;
          play(n);
        },5000);
      }