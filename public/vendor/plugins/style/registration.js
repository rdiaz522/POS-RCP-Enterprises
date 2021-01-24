$('.datepicker').datepicker({
    dateFormat: 'M-dd-yy',
   	yearRange: "1900:2025",
   	changeMonth: true,
  	changeYear: true,
});
$('.datepicker1').datepicker({
    dateFormat: 'M-dd-yy',
   	yearRange: "1900:2025",
   	changeMonth: true,
  	changeYear: true,
    onSelect: function(data){
      var date = new Date(formatDate(data));
      var year = date.getFullYear();
      var month = (date.getMonth() + 1);
      var day = date.getDate(); 
      var now = new Date();
      var y = now.getFullYear();
      var m = now.getMonth() + 1;
      var d = now.getDate();

      if(y < year){
          $('#save').attr('disabled' , false);
      }else{
        if(y <= year){
            if(m  <= month){
              if(d < day){
                   $('#save').attr('disabled' , false);
              }else{
                 $('#save').attr('disabled' , true);
              }
            }else{
               $('#save').attr('disabled' , true);
            }
        }else{
           $('#save').attr('disabled' , true);
        }
      }

    }
});
$(document).ready(function(){
      $('#id').focus();
      $('#firstname').prop('disabled', true);
      $('#middlename').prop('disabled', true);
      $('#lastname').prop('disabled', true);
      $('#address').prop('disabled', true);
      $('#date-picker-example').prop('disabled', true);


			$('#profile').on('change' , function(e){
				loadImage(
			    e.target.files[0],
			    function(img) {
			    	$('#preview1').html(img);
			    },
			    { 
                  maxWidth: 160,
                  maxHeight: 160,
                  orientation: true,
                  canvas: true
			     } // Options
			  );
			});
});
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}
$('#save').attr('disabled', true);

$(document).ready(function(){
    $('#searching').on('click', function(){
      $('#firstname').prop('disabled', true);
      $('#middlename').prop('disabled', true);
      $('#lastname').prop('disabled', true);
      $('#address').prop('disabled', true);
      $('#date-picker-example').prop('disabled', true);
       $.ajax({
          url:'ajax.inc/childs.php',
          method:'POST',
          data:{id:$('#id').val()},
          dataType:'JSON',
          success:function(data){
            $('#fullname').text('');
            $('#birthdate').text('');
            $('#relationship').text('');
            for(var x = 0; x < data.length;x++){
              console.log(data[x].fullname);
              $('#fullname').append(data[x].fullname + '<br>');
              $('#birthdate').append(data[x].birthdate + '<br>');
              $('#relationship').append(data[x].relationship + '<br>');
            };
          },
          error:function(data){
            console.log(data);
          }
        })

        $.ajax({
            url:'ajax.inc/search_id.php',
            method:'POST',
            data:{
                id:$('#id').val()
            },
            dataType:'JSON',
            success:function(data){
                console.log(data);
                if(data.status_id == 'On Process' && data.status == 'Renewed'){
                  $('.ribb').html("<div class='ribbon bg-info'>" +
                          'On Process'
                        + "</div>")
                   $('#addtoprint').prop('disabled', true);
                }else if(data.status_id == 'NO ID' && data.status == 'Renewed'){
                  $('.ribb').html("<div class='ribbon bg-danger'>" +
                          'NO ID'
                      + "</div>")
                   $('#addtoprint').prop('disabled', false);
                }else if(data.status_id == 'NO ID' && data.status == 'Expired'){
                  $('.ribb').html("<div class='ribbon bg-danger'>" +
                          'NO ID'
                      + "</div>")
                   $('#addtoprint').prop('disabled', true);
                }else if(data.status_id == 'HAVE ID' && data.status == 'Renewed'){
                  $('.ribb').html("<div class='ribbon bg-success'>" +
                          'HAVE ID'
                      + "</div>")
                    $('#addtoprint').prop('disabled', true);
                }else{
                   $('.ribb').html("<div class='ribbon bg-danger'>" +
                          'NO ID'
                      + "</div>")
                   $('#addtoprint').prop('disabled', false);
                }
                
                if(data.count == 8){
                  $('#addtoprint').attr('class','btn btn-danger btn-sm')
                  $('#addtoprint').prop('disabled', true);
                }
                var newSrc = 'images/' + data.profile_pic;
                $('#img_id').attr('src', newSrc);
                $('.id_no').html('ID No.' + '<u>' + data.soloparent_id + '</u>' + '(' + data.status +')'); 
                $('#preview1').html('<img src="images/'+ data.profile_pic +'" class="img-fluid">');  
                $('input[name=soloparent_id]').val(data.soloparent_id);
                var fullname = data.firstname +' '+ data.middlename +'. '+ data.lastname;
                $('#names').html(fullname);
                $('.address').html('Address: '+'<u style="font-weight:900">'+ data.address + '</u>');
                $('.dateofbirth').html('Date of Birth: ' + '<u style="font-weight:900">' + data.birthdate);
                $('#profile_pic').val(data.profile_pic);
                $('.sex').html('Sex: ' + data.sex);
                $('.exp_until').html('This card is issued and valid until  '+ '<u style="font-weight:900">' +data.expiry_date+'</u>');
                 $('input[name=soloparent_id]').val(data.soloparent_id);
                 $('input[name=firstname]').val(data.firstname);
                      $('input[name=middlename]').val(data.middlename);
                      $('input[name=lastname]').val(data.lastname);
                      $('input[name=address]').val(data.address);
                      $('input[name=date_registered]').val(data.date_registered);
                      $('input[name=expiry_date]').val(data.expiry_date);
                      var date = new Date(formatDate(data.expiry_date));
                      var year = date.getFullYear();
                      var month = (date.getMonth() + 1);
                      var day = date.getDate(); 
                      var now = new Date();
                      var y = now.getFullYear();
                      var m = now.getMonth() + 1;
                      var d = now.getDate();
                      if(data.expiry_date != ''){
                            if(y < year){
                              $('input[name=expiry_date]').attr('disabled', true);
                               $('#save').attr('disabled', true);
                               $('#exp').html('');
                          }else{
                            if(y <= year){
                                if(m <= month){
                                    if(d < day){
                                      $('input[name=expiry_date]').attr('disabled', true);
                                      $('#save').attr('disabled', true);
                                       $('#exp').html('');
                                    }else{
                                       $('#save').attr('disabled', true);
                                      $('input[name=expiry_date]').attr('disabled', false);
                                      $('#exp').html('Expired!');
                                    }
                                }else{
                                  $('input[name=expiry_date]').attr('disabled', false);
                                    $('#save').attr('disabled', true);
                                   $('#exp').html('Expired!');
                                }
                            }else{
                              $('input[name=expiry_date]').attr('disabled', false);
                               $('#save').attr('disabled', true);
                               $('#exp').html('Expired!');
                            } 
                          }
                      }else{
                           $('input[name=expiry_date]').attr('disabled', false);
                            $('#save').attr('disabled', true);
                           $('#exp').html('Expired!');
                      }
                      toastr.success('Data Found!' ,'SEARCHING ID #');
            },
            error:function(data){
              console.log(data);
                $('#id').val('');
                    $('input[name=firstname]').val('');
                    $('input[name=middlename]').val('');
                    $('input[name=lastname]').val('');
                    $('input[name=address]').val('');
                    $('input[name=date_registered]').val('');
                     $('input[name=expiry_date]').val('');
                     toastr.error('No Data Found!' ,'SEARCHING ID #');
            }
        })
    })
    $('#personFrm').submit(function(e){
      $('#firstname').prop('disabled', true);
      $('#middlename').prop('disabled', true);
      $('#lastname').prop('disabled', true);
      $('#address').prop('disabled', true);
      $('#date-picker-example').prop('disabled', true);

        var id = $('#id').val();
        $.ajax({
          url:'ajax.inc/childs.php',
          method:'POST',
          data:{id:$('#id').val()},
          dataType:'JSON',
          success:function(data){
            $('#fullname').text('');
            $('#birthdate').text('');
            $('#relationship').text('');
            for(var x = 0; x < data.length;x++){
              console.log(data[x].fullname);
              $('#fullname').append(data[x].fullname + '<br>');
              $('#birthdate').append(data[x].birthdate + '<br>');
              $('#relationship').append(data[x].relationship + '<br>');
            };
          },
          error:function(data){
            console.log(data);
          }
        })

        if(id != ''){
            $.ajax({
            url:'ajax.inc/search_id.php',
            method:'POST',
            data:{
                id:$('#id').val()
            },
            dataType:'JSON',
            success:function(data){
                console.log(data);
                if(data.status_id == 'On Process' && data.status == 'Renewed'){
                  $('.ribb').html("<div class='ribbon bg-info'>" +
                          'On Process'
                        + "</div>")
                   $('#addtoprint').prop('disabled', true);
                }else if(data.status_id == 'NO ID' && data.status == 'Renewed'){
                  $('.ribb').html("<div class='ribbon bg-danger'>" +
                          'NO ID'
                      + "</div>")
                   $('#addtoprint').prop('disabled', false);
                }else if(data.status_id == 'NO ID' && data.status == 'Expired'){
                  $('.ribb').html("<div class='ribbon bg-danger'>" +
                          'NO ID'
                      + "</div>")
                   $('#addtoprint').prop('disabled', true);
                }else if(data.status_id == 'HAVE ID' && data.status == 'Renewed'){
                  $('.ribb').html("<div class='ribbon bg-success'>" +
                          'HAVE ID'
                      + "</div>")
                    $('#addtoprint').prop('disabled', true);
                }else{
                   $('.ribb').html("<div class='ribbon bg-danger'>" +
                          'NO ID'
                      + "</div>")
                   $('#addtoprint').prop('disabled', true);
                }
                
                if(data.count == 8){
                  $('#addtoprint').attr('class','btn btn-danger btn-sm')
                  $('#addtoprint').prop('disabled', true);
                }
                var newSrc = 'images/' + data.profile_pic;
                $('#img_id').attr('src', newSrc);
                $('.id_no').html('ID No.' + '<u>' + data.soloparent_id + '</u>' + '(' + data.status +')'); 
                $('#preview1').html('<img src="images/'+ data.profile_pic +'" class="img-fluid">');  
                $('input[name=soloparent_id]').val(data.soloparent_id);
                var fullname = data.firstname +' '+ data.middlename +'. '+ data.lastname;
                $('#names').html(fullname);
                $('.address').html('Address: '+'<u style="font-weight:900">'+ data.address + '</u>');
                $('.dateofbirth').html('Date of Birth: ' + '<u style="font-weight:900">' + data.birthdate);
                $('#profile_pic').val(data.profile_pic);
                  $('.sex').html('Sex: ' + data.sex);
                $('.exp_until').html('This card is issued and valid until  '+ '<u style="font-weight:900">' +data.expiry_date+'</u>');
                 $('input[name=soloparent_id]').val(data.soloparent_id);
                 $('input[name=firstname]').val(data.firstname);
                      $('input[name=middlename]').val(data.middlename);
                      $('input[name=lastname]').val(data.lastname);
                      $('input[name=address]').val(data.address);
                      $('input[name=date_registered]').val(data.date_registered);
                      $('input[name=expiry_date]').val(data.expiry_date);
                      var date = new Date(formatDate(data.expiry_date));
                      var year = date.getFullYear();
                      var month = (date.getMonth() + 1);
                      var day = date.getDate(); 
                      var now = new Date();
                      var y = now.getFullYear();
                      var m = now.getMonth() + 1;
                      var d = now.getDate();
                      if(data.expiry_date != ''){
                            if(y < year){
                              $('input[name=expiry_date]').attr('disabled', true);
                               $('#save').attr('disabled', true);
                               $('#exp').html('');
                          }else{
                            if(y <= year){
                                if(m <= month){
                                    if(d < day){
                                      $('input[name=expiry_date]').attr('disabled', true);
                                      $('#save').attr('disabled', true);
                                       $('#exp').html('');
                                    }else{
                                       $('#save').attr('disabled', true);
                                      $('input[name=expiry_date]').attr('disabled', false);
                                      $('#exp').html('Expired!');
                                    }
                                }else{
                                  $('input[name=expiry_date]').attr('disabled', false);
                                    $('#save').attr('disabled', true);
                                   $('#exp').html('Expired!');
                                }
                            }else{
                              $('input[name=expiry_date]').attr('disabled', false);
                               $('#save').attr('disabled', true);
                               $('#exp').html('Expired!');
                            } 
                          }
                      }else{
                           $('input[name=expiry_date]').attr('disabled', false);
                          $('#save').attr('disabled', true);
                           $('#exp').html('Expired!');
                      }
                      toastr.success('Data Found!' ,'SEARCHING ID #');
              },
              error:function(data){
                console.log(data);
                  $('#id').val('');
                      $('input[name=firstname]').val('');
                      $('input[name=middlename]').val('');
                      $('input[name=lastname]').val('');
                      $('input[name=address]').val('');
                      $('input[name=date_registered]').val('');
                       $('input[name=expiry_date]').val('');
                       toastr.error('No Data Found!' ,'SEARCHING ID #');
              }
          })
        }
        e.preventDefault();
    })

})
$(document).ready(function(){
  $('#save').click(function(){
      $('#firstname').prop('disabled', false);
      $('#middlename').prop('disabled', false);
      $('#lastname').prop('disabled', false);
      $('#address').prop('disabled', false);
      $('#date-picker-example').prop('disabled', false);
    var formData = new FormData(document.getElementById("personFrm"));
        $.ajax({
        url:'ajax.inc/soloparent_records.php',
        method:'POST',
        data: formData,
        contentType:false,
        cache:false,
        processData:false,
        success:function(data){
          console.log(data);
          if(data = 'Success'){
            $('input[name=profile]').val('');
            $('input[name=firstname]').val('');
            $('input[name=middlename]').val('');
            $('input[name=lastname]').val('');
            $('input[name=address]').val('');
            $('input[name=date_registered]').val('');
            $('input[name=expiry_date]').val('');
            $('#id').val('');
            $('#preview1').html('<img src="images/avatar.jpg" class="img-fluid">');
             toastr.success('Successfully!' ,'REGISTRATION');
             $('#save').attr('disabled', true);

          }
        },
        error:function(data){
          console.log(data)
        }
      })
  })
})
  toastr.options.progressBar = true;
  toastr.options.closeButton =true;
  toastr.options.showEasing = 'swing';
  toastr.options.closeEasing = 'swing';
  toastr.options.showMethod = 'slideDown';
  toastr.options.newestOnTop = true;
  toastr.options.hideMethod = 'slideUp';
  toastr.options.closeMethod = 'slideUp';
  toastr.options.timeOut = '7000';
$('#addtoprint').prop('disabled', true);
$(document).ready(function(){
    $('#addtoprint').click(function(){
        $.ajax({
          url:'ajax.inc/update_id.php',
          method:"POST",
          data:{id: $('input[name=soloparent_id]').val()},
          success:function(data){
              console.log(data);
              var newSrc = 'images/' + 'avatar.jpg';
                $('#img_id').attr('src', newSrc);
                $('.id_no').html('ID No.' + '<u>' + '' + '</u>' + '(' + '' +')'); 
                $('#preview1').html('<img src="images/'+ 'avatar.jpg' +'" class="img-fluid">');  
                $('input[name=soloparent_id]').val('');
                var fullname = '' +' '+ ''+'. '+ '';
                $('#names').html('');
                $('.address').html('Address: '+'<u style="font-weight:900">'+''+ '</u>');
                $('.dateofbirth').html('Date of Birth: ' + '<u style="font-weight:900">' + '');
                $('#profile_pic').val('');
                $('.sex').html('Sex: ' + '');
                $('.exp_until').html('This card is issued and valid until  '+ '<u style="font-weight:900">' +''+'</u>');
                toastr.success('Must Be 8 Solo Parent Add To Print' ,'ON PROCESSING');
                $('#addtoprint').prop('disabled', true);
                
          }
        })
    })
})
$('#reset').prop('disabled', true);
$(document).ready(function(){
    $('#reset').click(function(){
        $.ajax({
            url:'ajax.inc/reset.php',
            method:'POST',
            success:function(data){
                if(data == 1){
                   toastr.warning('Successfully!' ,'RESET');
                }else{
                  toastr.error('FAILED!' ,'RESET');
                }
            }
        })
    })
})




// Restricts input for the given textbox to the given inputFilter.
function setInputFilter(textbox, inputFilter) {
  ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
    textbox.addEventListener(event, function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  });
}
setInputFilter(document.getElementById('id'), function(value) {
  return /^[0-9]*$/i.test(value); });
setInputFilter(document.getElementById('date-picker-example1'), function(value) {
  return /^[]*$/i.test(value); });