
$(document).ready(function() {
    $( document ).ajaxStart(function() {
        $( "#loading" ).show();
    });
     $( document ).ajaxStop(function() {
        $( "#loading" ).hide();
    });
  $("#cContactName, #cEmail, #cTele, #cFax,#cWebsite, input[name='reseller'],input[name='taxexempt']").attr("disabled",true); 
  var states = '<option value="">Select State</option>' +
				'<option value="AB">AB</option>' +
				'<option value="AK">AK</option>' +
				'<option value="AL">AL</option>' +
				'<option value="AR">AR</option>' +
				'<option value="AZ">AZ</option>' +
				'<option value="BC">BC</option>' +
				'<option value="CA">CA</option>' +
				'<option value="CO">CO</option>' +
				'<option value="CT">CT</option>' +
				'<option value="DC">DC</option>' +
				'<option value="DE">DE</option>' +
				'<option value="FL">FL</option>' +
				'<option value="GA">GA</option>' +
				'<option value="HI">HI</option>' +
				'<option value="IA">IA</option>' +
				'<option value="ID">ID</option>' +
				'<option value="IL">IL</option>' +
				'<option value="IN">IN</option>' +
				'<option value="KS">KS</option>' +
				'<option value="KY">KY</option>' +
				'<option value="LA">LA</option>' +
				'<option value="MA">MA</option>' +
				'<option value="MB">MB</option>' +
				'<option value="MD">MD</option>' +
				'<option value="ME">ME</option>' +
				'<option value="MI">MI</option>' +
				'<option value="MN">MN</option>' +
				'<option value="MO">MO</option>' +
				'<option value="MS">MS</option>' +
				'<option value="MT">MT</option>' +
				'<option value="NB">NB</option>' +
				'<option value="NC">NC</option>' +
				'<option value="ND">ND</option>' +
				'<option value="NE">NE</option>' +
				'<option value="NH">NH</option>' +
				'<option value="NJ">NJ</option>' +
				'<option value="NL">NL</option>' +
				'<option value="NM">NM</option>' +
				'<option value="NS">NS</option>' +
				'<option value="NT">NT</option>' +
				'<option value="NU">NU</option>' +
				'<option value="NV">NV</option>' +
				'<option value="NY">NY</option>' +
				'<option value="OH">OH</option>' +
				'<option value="OK">OK</option>' +
				'<option value="ON">ON</option>' +
				'<option value="OR">OR</option>' +
				'<option value="PA">PA</option>' +
				'<option value="PE">PE</option>' +
				'<option value="QC">QC</option>' +
				'<option value="RI">RI</option>' +
				'<option value="SC">SC</option>' +
				'<option value="SD">SD</option>' +
				'<option value="SK">SK</option>' +
				'<option value="TN">TN</option>' +
				'<option value="TX">TX</option>' +
				'<option value="UT">UT</option>' +
				'<option value="VA">VA</option>' +
				'<option value="VT">VT</option>' +
				'<option value="WA">WA</option>' +
				'<option value="WI">WI</option>' +
				'<option value="WV">WV</option>' +
				'<option value="WY">WY</option>' +
				'<option value="YT">YT</option>';
   var settings = {
	url: "./includes/upload.php",
	method: "POST",
	allowedTypes:"jpg,png,gif,doc,pdf,zip",
	fileName: "myfile",
	multiple: true,
	onSuccess:function(files,data,xhr)
	{
		$("#status").html("<font color='green'>Upload is success</font>");
		
	},
	onError: function(files,status,errMsg)
	{		
		$("#status").html("<font color='red'>Upload is Failed</font>");
	}
   }

  
  $( "#resellerNo" ).click(function() {
      $('#resellerState').hide();
      $('#addReseller').hide();
      $('#totalSellerCert').val(0);
  });
  
  $( "#resellerYes" ).click(function() {
      $('#resellerState').show();
      $('#addReseller').show();
      $('#totalSellerCert').val($('#resellerState p').size());
  });
  
  $( "#taxExmptNo" ).click(function() {
      $('#taxExmptState').hide();
      $('#addTaxExmpt').hide();
      $('#totalTaxCert').val(0);
  });
  $( "#taxExmptYes" ).click(function() {
      $('#taxExmptState').show();
      $('#addTaxExmpt').show();
      $('#totalTaxCert').val($('#taxExmptState p').size());
  });
  
  $.validator.addMethod("usPhoneFormat", function (value, element) {
    return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(value);
  }, "Enter a valid phone number.");
  
  $.validator.addMethod("usfaxFormat", function (value, element) {
    return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(value);
  }, "Enter a valid fax number.");
  
   $("#cTele,#cFax").mask("?(999) 999-9999");
  
 
   $("#tax-collection").submit(function(){
    var boxes = $('input[name=reseller]:checked');
    if($(boxes).size() == 0) {
     alert("Is a customer reseller ? field is required");
      $("#fileuploadError").val(0);
     return false;
    }
    var countboxes = $('input[name=taxexempt]:checked');
    if($(countboxes).size() == 0) {
     alert("Is a customer tax exempt ? field is required");
      $("#fileuploadError").val(0);
     return false;
    }

    var resellerVal = $("#resellerYes").is(":checked");
    var taxExm = $("#taxExmptYes").is(":checked");   
    var throwErrortax = false;
    var throwError = false;
    
    if (resellerVal) {      
       $("#resellerState p").each(function(index){        
          if($(this).find("select").val() == '') {           
            throwError = true;
            $("#fileuploadError").val(0);
          }
          if($(this).find("input").val() == '') {           
            throwError = true;
            $("#fileuploadError").val(0);
          }
          
       });
    }   
    if (throwError) {
      //code
      $("#resellerState").prepend("<div class='nomatchdrop'>Please make sure customer reseller state and file upload filed is not empty</div>");
      $(".nomatchdrop").delay(800).fadeOut(3500);
      return false;
    }
    
    if (taxExm) {
       var throwErrortax = false;
     
       $("#taxExmptState p").each(function(index){        
          if($(this).find("select").val() == '') {           
            throwErrortax = true;
            $("#fileuploadError").val(0);
          }
          if($(this).find("input").val() == '') {           
            throwErrortax = true;
            $("#fileuploadError").val(0);
          }
          
       });
    }
    if (throwErrortax) {
      //code
      $("#taxExmptState").prepend("<div class='nomatchdrop'>Please make sure customer tax exempt state and file upload filed is not empty</div>");
      $(".nomatchdrop").delay(800).fadeOut(3500);
      return false;
    }    
    $("#fileuploadError").val(1);
    return true;
  
   });
  
  
   $("#tax-collection").validate({
        
        // Specify the validation rules
        rules: {
            cNumber: "required",
            cContactName: "required",
            cEmail: {
                required: true,
                email: true
            },
            cTele: {
                required: true ,
                usPhoneFormat: true,
            },
            cFax: {
              /*required: true,*/
              usfaxFormat: true,
            }
        },
        
        // Specify the validation error messages
        messages: {
            cNumber: "Customer number is required",
            cContactName: "Contact name is required",
            cTele: {               
                required: "Telephone is required",
                usfaxFormat: "Enter a valid phone number"
            },
            cEmail: "Please enter a valid email address",
            cFax: {
               /* required : "Fax is required",*/
                 usfaxFormat: "Enter a valid fax number"
            }            
        },
        
      
        submitHandler: function(form) {
           if($("#fileuploadError").val()!=0) {
            $( "#loading" ).show();
           }
            form.submit();
        }
    });
   
    //Ajax trigger for validating customer number
    $( "#cNumber" ).blur(function() {
        var request = $.ajax({
	  url: "./process.php",
	  type: "POST",
	  data: { type : 'validateCustomerNumber', cNumber : $( "#cNumber" ).val() },
	  dataType: "json"
	});
        
	request.done(function( data ) {
	   if (data.result != 'no matching record found') {
		var result = data.result;
		var rid    = result.rid;
		var recs   = result.recs;      
        $("#cContactName, #cEmail, #cTele, #cFax,#cWebsite,input[name='reseller'],input[name='taxexempt']").attr("disabled",false); 
		$( "#rid" ).val(rid);
		$('#cContactName').val(recs[8]);
		$('#cEmail').val(recs[9]);
		$('#cTele').val(recs[10]);
		$('#cFax').val(recs[11]);
		$('#cWebsite').val(recs[12]);
        	$('#btnSubmit').removeAttr('disabled');
	    } else {
		//alert( 'no matching record found' )
        $("#cContactName, #cEmail, #cTele, #cFax,#cWebsite,input[name='reseller'],input[name='taxexempt']").attr("disabled",true); 
        $("#tax-collection").prepend("<div class='nomatch'>No matching record found</div>").fadeIn('slow');
        $(".nomatch").delay(800).fadeOut(3500);
        $('#btnSubmit').attr('disabled', 'true');
        $('#cContactName').val('');
		$('#cEmail').val('');
		$('#cTele').val('');
		$('#cFax').val('');
		$('#cWebsite').val('');
	   }
  	   //$( "#log" ).html( msg );
	});
    });
   
   
  $(function() {
       // Add or remove reseller files
        var resellerDiv = $('#resellerState');
        var i = $('#resellerState p').size() + 1;
        $('#addReseller').on('click', function() {
            $('<p> '+
                   '<select id="selectResellerState_'+i+'" name="selectResellerState_'+i+'">'+
                    states + '</select>'+
                    '<input type="file" name="cResellerDoc_'+i+'" id="cResellerDoc_'+i+'">' + 
                    '<a href="#" class="remSell">Remove</a>' +
                    '</p>').appendTo(resellerDiv);
            $('#totalSellerCert').val(i);
            i++;
            
            return false;
        });
        $("#resellerState").on("click", "a.remSell", function(){
            if( i > 2 ) {
                $(this).parents('p').remove();
                i--;                
            }
            
            $('#totalSellerCert').val($('#resellerState p').size());
            return false;
        });
        
        //Add or remove taxexmpt files        
        var taxExmptDiv = $('#taxExmptState');
        var j = $('#taxExmptState p').size() + 1;
        
        $('#addTaxExmpt').on('click', function() {
            $('<p> '+
                   '<select id="selectTaxExmptState_'+j+'" name="selectTaxExmptState_'+j+'">'+
                    states + '</select>'+
                    '<input type="file" name="cTaxExmptDoc_'+j+'" id="cTaxExmptDoc_'+j+'">' + 
                    '<a href="#" class="remTaxExmpt">Remove</a>' +
                    '</p>').appendTo(taxExmptDiv);
            $('#totalTaxCert').val(j);
            j++;
            
            return false;
        });
        $("#taxExmptState").on("click", "a.remTaxExmpt", function(){
            if( j > 2 ) {
                $(this).parents('p').remove();
                j--;                
            }
            $('#totalTaxCert').val($('#taxExmptState p').size());
            return false;
        });
    });
});

