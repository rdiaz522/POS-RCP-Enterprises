 var stepper3 = new Stepper(document.querySelector('#stepper3'), {
        animation: true
  })
 $(document).ready(function(){
	  $("*").dblclick(function(e){
	    e.preventDefault();
	  });
	  $('#firstname').focus();

});
 var counter =  localStorage.getItem('counter');
 var id_num = 2000 + Number(counter);
 var bool = localStorage.getItem('bool')
$(document).ready(function(){

		if(localStorage.getItem('bool') == 1){
			$('#btnEnable').prop('disabled', true);
			$('#btnDisable').prop('disabled', false);
			$('#solo_parent_id').val(id_num);
			$('#btnEnable').attr('class', 'btn btn-secondary btn-sm text-white');
			$('#btnDisable').attr('class','btn btn-primary btn-sm text-white');
			$('#solo_parent_id').prop('disabled', true);
		}

		if(localStorage.getItem('bool') == 0){
			$('#btnEnable').prop('disabled', false);
			$('#btnDisable').prop('disabled', true);
			$('#solo_parent_id').val('');
			$('#btnEnable').attr('class', 'btn btn-primary btn-sm text-white');
			$('#btnDisable').attr('class','btn btn-secondary btn-sm text-white');
			$('#solo_parent_id').prop('disabled', false);
		}

		$('#btnEnable').click(function(){
			bool = localStorage.setItem('bool', 1);
			$(this).prop('disabled', true);
			$('#btnDisable').attr('class', 'btn btn-primary btn-sm text-white');
			$(this).attr('class','btn btn-secondary btn-sm text-white');
			$('#btnDisable').prop('disabled',false);
			console.log(localStorage.getItem('bool'));
			$('#solo_parent_id').val(id_num);
			$('#solo_parent_id').prop('disabled', true);
			toastr.info('Auto-Increment','ENABLED!');
		})

		$('#btnDisable').click(function(){
			bool = localStorage.setItem('bool', 0);
			$(this).prop('disabled', true);
			$('#btnEnable').attr('class', 'btn btn-primary btn-sm text-white');
			$(this).attr('class','btn btn-secondary btn-sm text-white');
			$('#btnEnable').prop('disabled',false);
			console.log(localStorage.getItem('bool'));
			$('#solo_parent_id').val('');
			$('#solo_parent_id').prop('disabled', false);
			toastr.error('Auto-Increment','DISABLED!');
		})
})

 var randomNum =  Math.floor(Math.random() * 100000) + 1013;
 $(document).ready(function(){
 	$('#search').on('click' , function(){
 		$.ajax({
 			url:'ajax.inc/searchParent.php',
 			method:"POST",
 			data:{
 				search_id:$('#search_id').val()
 			},
 			dataType:'JSON',
 			success:function(data){
 				$('#search').attr('disabled', true);
 				setInterval(function(){
 					$('#search').attr('disabled', false);
 				},1000);
 				if(data != 0){
 					$("#childs > tr").remove();
	 				$('#firstname').val(data.firstname);
	 				$('#lastname').val(data.lastname);
	 				$('#middlename').val(data.middlename);
	 				$('#solo_parent_id').val(data.solo_parent_id);
	 				$('#address').val(data.address);
	 				$('#date_of_birth').val(data.birthdate);
	 				$('#age').val(data.age);
	 				$('#place_of_birth').val(data.place_of_birth);
	 				$('#educ_attainment').val(data.educ_attainment);
	 				$('#school_last_attended').val(data.school_last_attended);
	 				$('#occupation').val(data.occupation);
	 				$('#name_of_employer').val(data.name_of_employer);
	 				$('#monthly_income').val(data.monthly_income);
	 				$('#date_record').val(data.date_record);
	 				$('#family_resource').val(data.family_resource);
	 				$('#needs').val(data.needs);
	 				$('#classification').val(data.classification)
	 				$('#submitPersonInfo').attr('disabled', false);
	 				$('#search_id').val('');
	 				toastr.success('DATA FOUND!','SUCCESSFULLY');
 				}
 				if(data == 0){
 					toastr.error('NO DATA FOUND!','ERROR');
 				}
 			},
 			error:function(data){
	 				$('#firstname').val('');
	 				$('#lastname').val('');
	 				$('#middlename').val('');
	 				$('#solo_parent_id').val('');
	 				$('#address').val('');
	 				$('#date_of_birth').val('');
	 				$('#age').val('');
	 				$('#place_of_birth').val('');
	 				$('#educ_attainment').val('');
	 				$('#school_last_attended').val('');
	 				$('#occupation').val('');
	 				$('#name_of_employer').val('');
	 				$('#monthly_income').val('');
	 				$('#date_record').val('');
	 				$('#family_resource').val('');
	 				$('#needs').val('');
	 				$('#classification').val('')
	 				$('#search_id').val('');
 			}
 		})

 		$.ajax({
 			url:'ajax.inc/searchChild.php',
 			method:'POST',
 			data:{
 				id:$('#search_id').val()
 			},
 			dataType:'JSON',
 			success:function(data){
 				for(var x = 0; x < data.length;x++){
 					$('#childs').prepend(
					"<tr class='post"+data[x].child_id+"'>"+ 
					 '<th >'+ capLetter(data[x].fname) +' '+ capLetter(data[x].minitial) + ' ' + capLetter(data[x].lname) +'</th>' +
					 '<th>' + capLetter(data[x].relationship) + '</th>' +
					 '<th class="hideTh">' + capLetter(data[x].stat_educ_attnt) + '</th>' +
					 '<th class="hideTh">' + data[x].birthdate + '</th>' +
					 '<th class="hideTh">' + capLetter(data[x].occupation) + '</th>' +
					 '<th class="hideTh">' + data[x].income + '</th>' +
					 '<th><a class="btn btn-primary text-white edit" data-id="'+ data[x].child_id +'"><i class="fas fa-user-edit"></i></a> <a class="delete btn btn-danger text-white" data-id="'+data[x].child_id+'"><i class="fas fa-trash-alt"></i></a></th>' +
					'</tr>' 
					);

 				}			
 			},
 			error:function(data){
 				console.log(data);
 			}
 		})
 	})

 	$('#frmSearch').submit(function(e){
 		$.ajax({
 			url:'ajax.inc/searchParent.php',
 			method:"POST",
 			data:{
 				search_id:$('#search_id').val()
 			},
 			dataType:'JSON',
 			success:function(data){
 				console.log(data);
 				$('#search_id').attr('disabled', true);
 				setInterval(function(){
 					$('#search_id').attr('disabled', false);
 				},1000);
 				if(data != 0){
 					$("#childs > tr").remove();
	 				$('#firstname').val(data.firstname);
	 				$('#lastname').val(data.lastname);
	 				$('#middlename').val(data.middlename);
	 				$('#solo_parent_id').val(data.solo_parent_id);
	 				$('#address').val(data.address);
	 				$('#date_of_birth').val(data.birthdate);
	 				$('#age').val(data.age);
	 				$('#place_of_birth').val(data.place_of_birth);
	 				$('#educ_attainment').val(data.educ_attainment);
	 				$('#school_last_attended').val(data.school_last_attended);
	 				$('#occupation').val(data.occupation);
	 				$('#name_of_employer').val(data.name_of_employer);
	 				$('#monthly_income').val(data.monthly_income);
	 				$('#date_record').val(data.date_record);
	 				$('#family_resource').val(data.family_resource);
	 				$('#needs').val(data.needs);
	 				$('#classification').val(data.classification)
	 				$('#submitPersonInfo').attr('disabled', false);
	 				$('#search_id').val('');
	 				toastr.success('DATA FOUND!','SUCCESSFULLY');
 				}
 				if(data == 0){
 					toastr.error('NO DATA FOUND!','ERROR');
 				}
 			},
 			error:function(data){
	 				$('#firstname').val('');
	 				$('#lastname').val('');
	 				$('#middlename').val('');
	 				$('#solo_parent_id').val('');
	 				$('#address').val('');
	 				$('#date_of_birth').val('');
	 				$('#age').val('');
	 				$('#place_of_birth').val('');
	 				$('#educ_attainment').val('');
	 				$('#school_last_attended').val('');
	 				$('#occupation').val('');
	 				$('#name_of_employer').val('');
	 				$('#monthly_income').val('');
	 				$('#date_record').val('');
	 				$('#family_resource').val('');
	 				$('#needs').val('');
	 				$('#classification').val('')
	 				$('#search_id').val('');
 			}
 		})

 		$.ajax({
 			url:'ajax.inc/searchChild.php',
 			method:'POST',
 			data:{
 				id:$('#search_id').val()
 			},
 			dataType:'JSON',
 			success:function(data){
 				for(var x = 0; x < data.length;x++){
 					$('#childs').prepend(
					"<tr class='post"+data[x].child_id+"'>"+ 
					 '<th>'+ capLetter(data[x].fname) +' '+ capLetter(data[x].minitial) + ' ' + capLetter(data[x].lname) +'</th>' +
					 '<th>' + capLetter(data[x].relationship) + '</th>' +
					 '<th class="hideTh">' + capLetter(data[x].stat_educ_attnt) + '</th>' +
					 '<th class="hideTh">' + data[x].birthdate + '</th>' +
					 '<th class="hideTh">' + capLetter(data[x].occupation) + '</th>' +
					 '<th class="hideTh">' + data[x].income + '</th>' +
					 '<th><a class="btn btn-primary text-white edit" data-id="'+ data[x].child_id +'"><i class="fas fa-user-edit"></i></a> <a class="delete btn btn-danger text-white" data-id="'+data[x].child_id+'"><i class="fas fa-trash-alt"></i></a></th>' +
					'</tr>' 
					);

 				}			
 			},
 			error:function(data){
 				console.log(data);
 			}
 		})

 		e.preventDefault();
 	})
 })

$(document).ready(function(){
		$(this).scrollTop(0);
		$('#submitPersonInfo').attr('disabled', true);
		$('#addChild2').attr('disabled', false);
		$('#addChild').attr('disabled', true);
		$('input').keyup(function(){
			var id = $('#solo_parent_id').val();
			var firstname = $('#firstname').val();
			var middlename = $('#middlename').val();
			var lastname = $('#lastname').val();
			var age = $('#age').val();
			var sex = $('#sex').val();
			var address = $('#address').val();
			var place_of_birth = $('#place_of_birth').val();
			var educ_attainment = $('#educ_attainment').val();
			var school_last_attended = $('#school_last_attended').val();
			var occupation = $('#occupation').val();
			var name_of_employer = $('#name_of_employer').val();
			var monthly_income = $('#monthly_income').val();
			var date_of_birth = $('#date_of_birth').val();
			var date_record = $('#date_record').val();
			var fname = $('#fname').val();
			var minitial = $('#minitial').val();
			var lname =$('#lname').val();
			var birthdate = $('#birthdate').val();
			var relationship = $('#relationship').val();
			var stat_educ_attnt = $('#stat_educ_attnt').val();
			var occup = $('#occup').val();
			var income = $('#income').val();
			if(id != ''){
				$('#submitPersonInfo').attr('disabled', false);
				console.log('Success');
			}else{
				$('#submitPersonInfo').attr('disabled', true);
			}
			if(fname != '' && lname != ''){
				$('#addChild').attr('disabled' , false);
			}
		})
})

$(document).ready(function(){
        $('#submitPersonInfo').click(function(e){
            $.ajax({
                url:'ajax.inc/soloparentinfo.php',
                method:'POST',
                data:{
                    solo_parent_id: $('#solo_parent_id').val(),
                    firstname: $('#firstname').val(),
                    mi: $('#middlename').val(),
                    lastname: $('#lastname').val(),
                    age : $('#age').val(),
				    sex : $('#sex').val(),
				    address : $('#address').val(),
				    place_of_birth : $('#place_of_birth').val(),
				    educ_attainment : $('#educ_attainment').val(),
				    school_last_attended : $('#school_last_attended').val(),
				    occupation : $('#occupation').val(),
				    name_of_employer : $('#name_of_employer').val(),
				    monthly_income : $('#monthly_income').val(),
				    date_of_birth : $('#date_of_birth').val(),
				    date_record : $('#date_record').val()

                },
                success:function(data){
                    console.log(data);
                    if(data == 0){
                    	$('#solo_parent_id').attr('disabled' , false);
                    	stepper3.to(1)
                    	toastr.error('Make Sure To Check Your Input Fields!' ,'Application Form Error');
                    }
                    if(data == 1){
                    	$('#solo_parent_id').attr('disabled' , true);
                    	stepper3.to(2)
                    }
                }
            })
            e.preventDefault();
            var id = $('#solo_parent_id').val();
            $('#solo_id').val(id);
        })
  })
	$('#date_of_birth').datepicker({
		dateFormat: 'M-dd-yy',
	 	yearRange: "1900:2025",
	 	changeMonth: true,
		changeYear: true,
		onSelect: function() {
			var id = $('#solo_parent_id').val();
			var firstname = $('#firstname').val();
			var middlename = $('#middlename').val();
			var lastname = $('#lastname').val();
			var age = $('#age').val();
			var sex = $('#sex').val();
			var address = $('#address').val();
			var place_of_birth = $('#place_of_birth').val();
			var educ_attainment = $('#educ_attainment').val();
			var school_last_attended = $('#school_last_attended').val();
			var occupation = $('#occupation').val();
			var name_of_employer = $('#name_of_employer').val();
			var monthly_income = $('#monthly_income').val();
			var date_of_birth = $('#date_of_birth').val();
			var date_record = $('#date_record').val();
       		if(id != '' && firstname != '' && middlename != '' && lastname != '' && age != '' && sex != '' && address != '' && place_of_birth != ''  && date_of_birth != '' && date_record != ''){
				$('#submitPersonInfo').attr('disabled', false);
				console.log('Success');
			}else{
				$('#submitPersonInfo').attr('disabled', true);
			}
    	}
	});
	$('#date_record').datepicker({
		dateFormat: 'M-dd-yy',
	 	yearRange: "1900:2025",
	 	changeMonth: true,
		changeYear: true,
		onSelect: function() {
			var id = $('#solo_parent_id').val();
			var firstname = $('#firstname').val();
			var middlename = $('#middlename').val();
			var lastname = $('#lastname').val();
			var age = $('#age').val();
			var sex = $('#sex').val();
			var address = $('#address').val();
			var place_of_birth = $('#place_of_birth').val();
			var educ_attainment = $('#educ_attainment').val();
			var school_last_attended = $('#school_last_attended').val();
			var occupation = $('#occupation').val();
			var name_of_employer = $('#name_of_employer').val();
			var monthly_income = $('#monthly_income').val();
			var date_of_birth = $('#date_of_birth').val();
			var date_record = $('#date_record').val();
       		if(id != '' && firstname != '' && middlename != '' && lastname != '' && age != '' && sex != '' && address != '' && place_of_birth != ''  && date_of_birth != '' && date_record != ''){
				$('#submitPersonInfo').attr('disabled', false);
				console.log('Success');
			}else{
				$('#submitPersonInfo').attr('disabled', true);
			}
    	}
	})
	;
	$('#birthdate').datepicker({
		dateFormat: 'M-dd-yy',
	 	yearRange: "1900:2025",
	 	changeMonth: true,
		changeYear: true
	});

function capLetter(string) {
	 return string.charAt(0).toUpperCase() + string.slice(1);
}	

	$('#addChild').click(function(e){
		var rand = Math.floor(Math.random() * 100000000);
		var rand1 = Math.floor(Math.random() * 10000000);
		var rand3 = Math.floor(Math.random() * 10000000);
		var rand4 = Math.floor(Math.random() * 100);
		var randomNum = rand + rand1 + rand3 + rand4;
		$.ajax({
			url:'ajax.inc/addFamComp.php',
			method:'POST',
			data:{
				solo_id:$('#solo_id').val(),
				child_id: randomNum,
				fname:$('#fname').val(),
				minitial:$('#minitial').val(),
				lname:$('#lname').val(),
				birthdate:$('#birthdate').val(),
				relationship:$('#relationship').val(),
				stat_educ_attnt:$('#stat_educ_attnt').val(),
				occup:$('#occup').val(),
				income:$('#income').val()

			},
			dataType:'JSON',
			success:function(data){
				console.log(data);
				$('#addChild2').attr('disabled', false);
				$('#addChild').attr('disabled', true);
				$('#childs').prepend(
					"<tr class='post"+data.child_idsh+"'>"+ 
					 '<th>'+ capLetter(data.fname) +' '+ capLetter(data.minitial) + ' ' + capLetter(data.lname) +'</th>' +
					 '<th>' + capLetter(data.relationship) + '</th>' +
					 '<th class="hideTh">' + capLetter(data.stat_educ_attnt) + '</th>' +
					 '<th class="hideTh">' + data.birthdate + '</th>' +
					 '<th class="hideTh">' + capLetter(data.occup) + '</th>' +
					 '<th class="hideTh">' + data.income + '</th>' +
					 '<th><a class="btn btn-primary text-white edit" data-id="'+ data.child_idsh +'"><i class="fas fa-user-edit"></i></a> <a class="delete btn btn-danger text-white" data-id="'+data.child_idsh+'"><i class="fas fa-trash-alt"></i></a></th>' +
					'</tr>' 
					);
				$('#fname').val('');
				$('#minitial').val('');
				$('#lname').val('');
				$('#birthdate').val('');
				$('#stat_educ_attnt').val('');
				$('#occup').val('');
				$('#income').val('');
				$('#relationship').val('');
			},
			error:function(data){
				console.log(data);
			}

		})
		e.preventDefault();
	})


$(document).on('click' , '.edit' , function(){
	var id_child = $(this).attr('data-id');
	$('#showEdit').modal('show');
	$('.modal-title').text('Edit Household Member');
	$('#e_birthdate').datepicker({
		dateFormat: 'M-dd-yy',
	 	yearRange: "1900:2025",
	 	changeMonth: true,
		changeYear: true
	})
	$.ajax({
		url:'ajax.inc/returnChilds.php',
		method:'POST',
		data:{id:id_child},
		dataType:'JSON',
		success:function(data){
			console.log(data);
				$('input[name=id_child]').val(data.child_idd);
				$('input[name=e_fname]').val(data.fname);
				$('input[name=e_minitial]').val(data.minitial);
				$('input[name=e_lname]').val(data.lname);
				$('input[name=e_birthdate]').val(data.birthdate);
				$('select[name=e_relationship]').val(data.relationship);
				$('input[name=e_occupation]').val(data.occupation);
				$('input[name=e_stat_educ_attnt]').val(data.stat_educ_attnt);
				$('input[name=e_income]').val(data.income);
		}

	});
})
$('#saveChanges').click(function(){
		$.ajax({
			url:'ajax.inc/editChild.php',
			method:'POST',
			data:{
				id:$('input[name=id_child]').val(),
				fname:$('input[name=e_fname]').val(),
				minitial:$('input[name=e_minitial]').val(),
				lname:$('input[name=e_lname]').val(),
				birthdate:$('input[name=e_birthdate]').val(),
				relationship:$('select[name=e_relationship]').val(),
				occupation:$('input[name=e_occupation]').val(),
				stat_educ_attnt:$('input[name=e_stat_educ_attnt]').val(),
				income:$('input[name=e_income]').val(),
			},
			dataType:'JSON',
			success:function(data){
				console.log(data.child_ids);
				$('.post'+data.child_ids+'').replaceWith(
					"<tr class='post"+data.child_ids+"'>"+ 
					 '<th>'+ capLetter(data.fname) +' '+ capLetter(data.minitial) + ' ' + capLetter(data.lname) +'</th>' +
					 '<th>' + capLetter(data.relationship) + '</th>' +
					 '<th class="hideTh">' + capLetter(data.stat_educ_attnt) + '</th>' +
					 '<th class="hideTh">' + data.birthdate + '</th>' +
					 '<th class="hideTh">' + capLetter(data.occupation) + '</th>' +
					 '<th class="hideTh">' + data.income + '</th>' +
					 '<th><a class="btn btn-primary text-white edit" data-id="'+ data.child_ids +'"><i class="fas fa-user-edit"></i></a> <a class="delete btn btn-danger text-white" data-id="'+data.child_ids+'"><i class="fas fa-trash-alt"></i></a></th>' +
					'</tr>' 
				);
				$('#showEdit').modal('hide');
				toastr.success('Save Changes' , 'UPDATED!');
			},
			error:function(data){
				console.log(data);
			}
	})
})

$('#addChild2').click(function(e){
	var id = $('#solo_id').val();
	$('#solo_class_id').val(id);
	e.preventDefault();
})	

$('#addClass').on('click' , function(){
	$.ajax({
		url:'ajax.inc/classification.php',
		method:'POST',
		data:{
			solo_id: $('#solo_class_id').val(),
			desc: $('#classification').val()
		},
		success:function(data){
			console.log(data);
		}
	})
	var id = $('#solo_class_id').val();
	$('#solo_needs_id').val(id);
})
$('#addNeeds').on('click', function(){
	$.ajax({
		url:'ajax.inc/needs.php',
		method:'POST',
		data:{
			solo_id:$('#solo_needs_id').val(),
			desc:$('#needs').val()
		},
		success:function(data){
			console.log(data);
		}
	})
	var id = $('#solo_needs_id').val();
	$('#solo_fam_id').val(id);

})

$('#addFamily').on('click', function(){
	$.ajax({
		url:'ajax.inc/family.php',
		method:'POST',
		data:{
			solo_id: $('#solo_fam_id').val(),
			desc: $('#family_resource').val()
		},
		success:function(data){
			var no;
			$('input').val('');
			$('#solo_parent_id').attr('disabled' , false);
			console.log(data);
			$('textarea').val('');
			$("#childs > tr").remove();
			$(window).scrollTop(0);
			if(data == 1){
				setTimeout(function(){
				toastr.success('Submitted Successfully!' ,'Application Form');
				},1000);

				if(localStorage.getItem('bool') == 1){
					counter++; 
		 			localStorage.setItem('counter', counter);
				}

				$('#firstname').focus();
				setTimeout(function(){
					location.reload();
				},3000);

			}
			if(data == 2){
				setTimeout(function(){
					toastr.success('UPDATED Successfully!' ,'Application Form');
				},2000);
				$('#solo_parent_id').val(rand);
				$('#firstname').focus();
			}
		},
		error:function(data){
			toastr.error('ERROR!');
		}
	})

	$.ajax({
		url:'ajax.inc/logbook.php',
		method:'POST',
		data:{
			solo_id: $('#solo_fam_id').val()
		},
		success:function(data){
			console.log(data);
		}

	})
})
$(document).on('click' ,'.delete' , function(){
	var ids_child = $(this).attr('data-id');
	$('input[name=id_child]').val(ids_child);
	$('#showDelete').modal('show');
	$('.modal-title').text('Are you sure want to Remove this Household Member?');
	console.log(ids_child);
	$('#remove').click(function(){
		$.ajax({
			url:'ajax.inc/removeChild.php',
			method:'POST',
			data:{id:$('input[name=id_child]').val()},
			success:function(data){
				$('.post'+data+'').remove();
				$('#showDelete').modal('hide');
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
setInputFilter(document.getElementById('firstname'), function(value) {
  return /^[a-z -.,]*$/i.test(value); });
setInputFilter(document.getElementById('middlename'), function(value) {
  return /^[a-z ]*$/i.test(value); });
setInputFilter(document.getElementById('lastname'), function(value) {
  return /^[a-z -]*$/i.test(value); });
setInputFilter(document.getElementById('school_last_attended'), function(value) {
  return /^[a-z ,-]*$/i.test(value); });
setInputFilter(document.getElementById('occupation'), function(value) {
  return /^[a-z 0-9 ,-.]*$/i.test(value); });
setInputFilter(document.getElementById('name_of_employer'), function(value) {
  return /^[a-z 0-9 ,-.]*$/i.test(value); });
setInputFilter(document.getElementById('monthly_income'), function(value) {
  return /^[a-z 0-9 ,-./]*$/.test(value); });
setInputFilter(document.querySelector("#age"), function(value) {
  return /^[0-9]*$/.test(value); });
setInputFilter(document.querySelector("#search_id"), function(value) {
  return /^[0-9]*$/.test(value); });
setInputFilter(document.getElementById('date_of_birth'), function(value) {
  return /^[]*$/i.test(value); });
setInputFilter(document.getElementById('date_record'), function(value) {
  return /^[]*$/i.test(value); });

setInputFilter(document.getElementById('fname'), function(value) {
  return /^[a-z -,.]*$/i.test(value); });
setInputFilter(document.getElementById('minitial'), function(value) {
  return /^[a-z ]*$/i.test(value); });
setInputFilter(document.getElementById('lname'), function(value) {
  return /^[a-z -]*$/i.test(value); });
setInputFilter(document.getElementById('stat_educ_attnt'), function(value) {
  return /^[a-z 0-9 ,-]*$/i.test(value); });
setInputFilter(document.getElementById('occup'), function(value) {
  return /^[a-z 0-9 ,-]*$/i.test(value); });
setInputFilter(document.getElementById('income'), function(value) {
  return /^[a-z 0-9 ,-]*$/.test(value); });
$(document).ready(function(){
	/*$('#solo_parent_id').attr('disabled', true)
	$('#solo_parent_id').val(randomNum);*/
})


