$(document).ready(function(){

    if($(".dashboard").prop("href")==window.location.href){
        $('.dashboard').prop("class","nav-link active");
    }
    else{
      $('.dashboard').prop("class","nav-link");
     }

     if($(".appli").prop("href")==window.location.href){

        $('.appli').prop("class","nav-link active");
    }
    else{
        $('.appli').prop("class","nav-link");
     }

     if($(".regis").prop("href")==window.location.href){
        
        $('.regis').prop("class","nav-link active");
    }
    else{
        $('.regis').prop("class","nav-link");
     }

     if($(".sololist").prop("href")==window.location.href){
        
        $('.sololist').prop("class","nav-link active");
    }
    else{
        $('.sololist').prop("class","nav-link");
     }

     if($(".booklog").prop("href")==window.location.href){
        
        $('.booklog').prop("class","nav-link active");
    }
    else{
        $('.booklog').prop("class","nav-link");
     }



})

function displayPreview(files){
    let _URL = window.URL;
    let ok = 1;
    let file = files[0];
    let img = new Image();
    let sizeKB = file.size / 1024;
    img.onload = function(){
        $('#preview1').prepend(img);
            if($('#preview1> img').length > 1){
            $('#preview1 > img').last().remove();
        }
    }
img.src = _URL.createObjectURL(file);
}

$(document).ready(function(){
    loadCount();
    let x = 0;
    let count_old = 7;
   function loadCount(){
       $.ajax({
        url:'ajax.inc/countPrint.php',
        method:'POST',
        success:function(data){
          if(data == 8){
            $('#reset').prop('disabled', false);
            $('#countPrint').attr('class','right badge badge-danger');
            $('#countPrint').html(data);
                if(data > count_old){
                    if(x == 0){
                        $(document).Toasts('create', {
                            class: 'bg-success', 
                            title: 'PRINT ID IS NOW READY!!',
                            subtitle:'Close',
                            body: 'Please Click PRINT ID Button on Sidebar Menu.'
                         })
                    }else{
                          count_old = data;
                    }
                }x = 1;
          }else{
            $('#countPrint').html(data);
            $('#reset').prop('disabled', true);
          }
          
        }
      })
   }
   setInterval(function(){
      loadCount();
   },1000);
})

$(document).ready(function(){
    $('#mytable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
    });
  })

  $(document).ready(function(){
    function loadData(){
        $.ajax({
            url:'totalsoloparent.php',
            method:'POST',
            success:function(data){
                $('#totalParent').html(data);
            }
        })
    }
    loadData();

    setInterval(function(){
        loadData();
    },1000);
  })

  $(document).ready(function(){
      $('#file').on('change', function(){
        $('#myFrmImport').submit();
        console.log('TGest');
      });  
  });

 $(document).ready(function(){
    $(document).on('click' , '.soloparent' , function(){
        $('#viewsoloparent').modal('show');

        $('#date1').datepicker({
            dateFormat: 'M-dd-yy',
            yearRange: "1900:2025",
            changeMonth: true,
            changeYear: true,
        });
        $('#date2').datepicker({
            dateFormat: 'M-dd-yy',
            yearRange: "1900:2025",
            changeMonth: true,
            changeYear: true,
        });
    })
 })

 $(document).ready(function(){
    $(document).on('click','.claimed' , function(){
        $('#viewclaimed').modal('show');

        $('#claimDate1').datepicker({
            dateFormat: 'M-dd-yy',
            yearRange: "1900:2025",
            changeMonth: true,
            changeYear: true,
        });
        $('#claimDate2').datepicker({
            dateFormat: 'M-dd-yy',
            yearRange: "1900:2025",
            changeMonth: true,
            changeYear: true,
        });

    })
 }) 
   $(document).ready(function(){
    $(document).on('click','.renewed' , function(){
        $('#viewRenewed').modal('show');

        $('#renewedDate1').datepicker({
            dateFormat: 'M-dd-yy',
            yearRange: "1900:2025",
            changeMonth: true,
            changeYear: true,
        });
        $('#renewedDate2').datepicker({
            dateFormat: 'M-dd-yy',
            yearRange: "1900:2025",
            changeMonth: true,
            changeYear: true,
        });

    })
 })
$(document).ready(function(){
    $(document).on('click', '.create' , function(){
        $('#viewCreate').modal('show');
        $('#btnCreate').prop('disabled', true);
        $('input').keyup(function(){
            if($('#username').val() != '' && $('#password').val() != ''){
                $('#btnCreate').prop('disabled', false);
            }else{
                $('#btnCreate').prop('disabled', true);
            }
        })
    })
})




   $(document).ready(function(){
    $(document).on('click','.expired' , function(){
        $('#viewExpired').modal('show');

        $('#expiredDate1').datepicker({
            dateFormat: 'M-dd-yy',
            yearRange: "1900:2025",
            changeMonth: true,
            changeYear: true,
        });
        $('#expiredDate2').datepicker({
            dateFormat: 'M-dd-yy',
            yearRange: "1900:2025",
            changeMonth: true,
            changeYear: true,
        });

    })
 })  

   $(document).ready(function(){
    $(document).on('click','.expiring' , function(){
        $('#viewExpired').modal('show');

        $('#expiredDate1').datepicker({
            dateFormat: 'M-dd-yy',
            yearRange: "1900:2025",
            changeMonth: true,
            changeYear: true,
        });
        $('#expiredDate2').datepicker({
            dateFormat: 'M-dd-yy',
            yearRange: "1900:2025",
            changeMonth: true,
            changeYear: true,
        });

    })
 })  
 $(document).ready(function(){
    $(document).on('click','.printing' , function(){
        $('#viewPrint').modal('show');
        $.ajax({
            url:'ajax.inc/soloparent_id.php',
            method:'POST',
            dataType:'JSON',
            success:function(data){
                $('#printNames > tr').remove();
                console.log(data);
                var j = 0;
                for(var i = 0;i < data.length;i++){
                    j++;
                    $('#id_'+ j).val(data[i].id);
                    console.log(j);
                }           
                for(var x = 0;x < data.length;x++){
                $('#printNames').append('<tr>'+
                        '<th>' + data[x].fullname + '</th>' +
                        '<th>' + data[x].status + '</th>' +
                        '<th>' + data[x].status_id + '</th>' +
                '</tr>');
                }
            },
            error:function(data){
                console.log(data);
            }
        })
        $('#expiredDate1').datepicker({
            dateFormat: 'M-dd-yy',
            yearRange: "1900:2025",
            changeMonth: true,
            changeYear: true,
        });
        $('#expiredDate2').datepicker({
            dateFormat: 'M-dd-yy',
            yearRange: "1900:2025",
            changeMonth: true,
            changeYear: true,
        });

    })
 })  
  
  