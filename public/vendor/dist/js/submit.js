$(document).ready(function() {

    if($(".dashboard").prop("href")==window.location.href){
        $('.sidebar-menu > .dashboards').prop("class","active dashboards"); 
    }
    else{
      var host = window.location.origin;
      if(host + '/index.php/index.php/getWhatSales' == window.location.href){
          $('.sidebar-menu > .dashboards').prop("class","active dashboards");
      }else{
         $('.sidebar-menu > .dashboards').prop("class","");
      }
    }   
     if($(".inventory").prop("href")==window.location.href){
         $('.sidebar-menu > .inventorys').prop("class","active inventorys");
    }
    else{
         $('.sidebar-menu > .inventorys').prop("class","");
     }

     if($(".inv").prop("href")==window.location.href){
        
         $('.sidebar-menu > .invs').prop("class","active invs");
         
      }
      else{
            var host = window.location.origin;
            if(host + '/index.php/index.php/getStocker' == window.location.href){
                  $('.sidebar-menu > .invs').prop("class","active invs");
            }else{
                  $('.sidebar-menu > .invs').prop("class","");
            }
      }

     if($(".categories").prop("href")==window.location.href){
      $('.sidebar-menu > .categoriess').prop("class","active categoriess");
      }
      else{
         $('.sidebar-menu > .categoriess').prop("class","");
      }

      if($(".supplier").prop("href")==window.location.href){
         $('.sidebar-menu > .suppliers').prop("class","active suppliers");
         }
      else{
            $('.sidebar-menu > .suppliers').prop("class","");
      }

      if($(".user").prop("href")==window.location.href){
         $('.sidebar-menu > .users').prop("class","active users");
         }
      else{
            $('.sidebar-menu > .users').prop("class","");
      }

      if($(".customer").prop("href")==window.location.href){
         $('.sidebar-menu > .customers').prop("class","active customers");
         }
      else{
            $('.sidebar-menu > .customers').prop("class","");
      }

      if($(".stock").prop("href")==window.location.href){
         $('.sidebar-menu > .stocks').prop("class","active stocks");
         }
      else{
         var host = window.location.origin;
         if(host + '/index.php/index.php/getWhatStock' == window.location.href){
               $('.sidebar-menu > .stocks').prop("class","active stocks");
         }else{
            $('.sidebar-menu > .stocks').prop("class","");
         }
      }
 

     $('#dashboard').on('click', function(){
        $('.loading-spinner').show();
        $('#notblur').attr('id', 'blur');
     })

     $('#stock').on('click', function(){
      $('.loading-spinner').show();
      $('#notblur').attr('id', 'blur');
     })

      $('#user').on('click', function(){
         $('.loading-spinner').show();
         $('#notblur').attr('id', 'blur');
      })

      $('#customer').on('click', function(){
         $('.loading-spinner').show();
         $('#notblur').attr('id', 'blur');
      })

     $('#inventory').on('click', function(){
      $('.loading-spinner').show();
      $('#notblur').attr('id', 'blur');
     })

     $('#inv').on('click', function(){
      $('.loading-spinner').show();
      $('#notblur').attr('id', 'blur');
     })

     $('#categories').on('click', function(){
      $('.loading-spinner').show();
      $('#notblur').attr('id', 'blur');
     })

     $('#supplier').on('click', function(){
        $('.loading-spinner').show();
        $('#notblur').attr('id', 'blur');
     })

     $('#viewoutofstock').on('click', function(){
         $('#stocker').val(0);
         $('.loading-spinner').show();
         $('#notblur').attr('id', 'blur');
         $('#frmStocker').submit();
     })

     $('#viewcriticalstock').on('click', function(){
         $('#stocker').val(5);
         $('.loading-spinner').show();
         $('#notblur').attr('id', 'blur');
         $('#frmStocker').submit();
     })
});


