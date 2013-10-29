
$(document).ready(function() {
  
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
   $("#mulitplefileuploaderReseller").uploadFile(settings);
   $("#mulitplefileuploaderTaxExmpt").uploadFile(settings);


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
                required: true                
            },
            cFax: "required",
            cWebsite: "required"
        },
        
        // Specify the validation error messages
        messages: {
            cNumber: "customer number is required",
            cContactName: "contact name is required",
            cTele: {
                required: "telephone is required",                
            },
            cEmail: "Please enter a valid email address",
            cFax: "fax is required",
            cWebsite: "website is required"
        },
        
        submitHandler: function(form) {
            form.submit();
        }
    });

    //Ajax trigger for validating customer number
    $( "#cNumber" ).blur(function() {
        var request = $.ajax({
	  url: "./process.php",
	  type: "POST",
	  data: { type : 'validateCustomerNumber', customerNumber : $( "#cNumber" ).val() },
	  dataType: "json"
	});
        
	request.done(function( data ) {
  	   //$( "#log" ).html( msg );
	});
    });
   
});
