

function getCustomerByRegno(){
	var reg_no = $("#reg_no").val();
	 if(reg_no === ""){
	 	$("#reg_no_err").show();
		 return false;
	 }else{
		 window.location.replace(jsmysurl + "new-order/regno/" + window.btoa(reg_no));
	 } 
}

function countDown(countDownDate,eleId){
	alert(countDownDate);
	// Set the date we're counting down to
	var countDownDate = new Date("Jan 5, 2021 15:37:25").getTime();

	// Update the count down every 1 second
	var x = setInterval(function() {

	  // Get today's date and time
	  var now = new Date().getTime();

	  // Find the distance between now and the count down date
	  var distance = countDownDate - now;

	  // Time calculations for days, hours, minutes and seconds
	  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
	  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

	  // Display the result in the element with id="demo"
	  document.getElementById(eleId).innerHTML = days + "d " + hours + "h "
	  + minutes + "m " + seconds + "s ";

	  // If the count down is finished, write some text
	  if (distance < 0) {
	    clearInterval(x);
	    document.getElementById(eleId).innerHTML = "EXPIRED";
	  }
	}, 1000);
}

jQuery(document).ready(function() { 
	"use strict";  

		Layout.Select2bs4();
		Layout.DataTable();
		Layout.Summernote();

	  	$(document).on("click", 'a.dialog-pan', function (e) {
	        e.preventDefault();   
	        Layout.LoadModal($(this).attr("href"), $(this).data("heading") );
	        return false;
	    });

		$( "#NOAddOrUpdate" ).click(function( event ) {
		 // alert( "Test by shakeel." ); 
		  $('#NOAddOrUpdate').prop('disabled', true);
		  $( "#newOrder" ).submit();
		});

		$('#newOrder').on('keyup keypress', function(e) {
			  var keyCode = e.keyCode || e.which;
			  if (keyCode === 13) { 
			    e.preventDefault();
			    return false;
			  }
			});

		
		$('#inv_type').on('change', function (e) { 
	        e.preventDefault();
	       var inv_type =  $('#inv_type').val();
	       if(inv_type == "default"){ 
	       		$('#deposit_val').prop('disabled', true);
	       }else{
				$('#deposit_val').prop('disabled', false);
	       } 
	     });


		$('#payment_method1').on('change', function (e) { 
	        e.preventDefault();
 

	       var payment_method =  $('#payment_method').val();

	       if(payment_method == "both"){   
				$("#card_ref_no").prop('required',true); 
	       }else if(payment_method == "card"){  

				$("#card_ref_no").prop('required',true);

	       }else{
	       	
				$("#card_ref_no").prop('required',false);
	       }
	     });


		$('#payment_method').on('change', function (e) { 
	        e.preventDefault();

	        $('#card_amt').prop('disabled', true);
		    $('#cash_amt').prop('disabled', true);
		    $('#div_card_amt').hide();
			$('#div_cash_amt').hide();

	       var payment_method =  $('#payment_method').val();
	       if(payment_method == "cash"){ 

	       		$('#card_ref_no').prop('disabled', true);

	       }else if(payment_method == "card"){  

				$("#card_ref_no").prop('required',true);

	       }else if(payment_method == "both"){  

				$("#card_ref_no").prop('required',true);

				$('#card_amt').prop('disabled', false);
				$('#cash_amt').prop('disabled', false);
				$('#div_card_amt').show();
				$('#div_cash_amt').show();


	       }else{
	       	
				$("#card_ref_no").prop('required',false);
	       }
	     });

	$('#searchFrm').on('submit', function (e) { 
        e.preventDefault();
        $("#eresDiv").html('<div class="padding10px"><img src="'+jsmysurl+'assets/img/ajax-processing.gif" style="padding-right:0px;"  /></div>');  	
		var url = jsmysurl+"include/plugins/ajax/ajax_respose_files/product.php";

          $.ajax({
            type: 'post',
            url: url,
            data: $('#searchFrm').serialize(),
            success: function (data) {
             $("#resDiv").html(data); 
			 $("#eresDiv").html(""); 
            }
       		
       	});
     });

	$('#stocksearchFrm').on('submit', function (e) { 
        e.preventDefault();
        $("#eresDiv").html('<div class="padding10px"><img src="'+jsmysurl+'assets/img/ajax-processing.gif" style="padding-right:0px;"  /></div>');  	
		var url = jsmysurl+"include/plugins/ajax/ajax_respose_files/stockupdateproduct.php";

          $.ajax({
            type: 'post',
            url: url,
            data: $('#stocksearchFrm').serialize(),
            success: function (data) {
             $("#resDiv").html(data); 
			 $("#eresDiv").html(""); 
            }
       		
       	});
     });

 $('#regno_search').click(function(){ 
	 getCustomerByRegno(); 
 });
 $('#reg_no').focusout(function(){ 
	 //getCustomerByRegno(); 
 });
 
$('#supplier_id_sel').on('change', function () {
  var id = $(this).val(); // get selected value
  if (id > 0) { // require a URL
      window.location = jsmysurl + "new-purchase/supplier/" + id; // redirect
  }
  return false;
}); 

$('#supplier_id_stock').on('change', function () {
  var id = $(this).val(); // get selected value
  if (id > 0) { // require a URL
      window.location = jsmysurl + "stock-update/supplier/" + id; // redirect
  }
  return false;
}); 

$("#ckbCheckAll").click(function () {
    $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    if($(this).prop('checked')){
    	$(".inputBoxClass").prop('disabled', false);
    }else{
    	$(".inputBoxClass").prop('disabled', true);
    }
});

$(".checkBoxClass").click(function () { 
	var val = $(this).val();
	var inputId = "#rec_qty_"+ val; 
    if($(this).prop('checked')){
    	$(inputId).prop('disabled', false);
    }else{
    	$(inputId).prop('disabled', true);
    } 
});

$('#btnPrint').on('click', function () { 
		var contents = $("#print-area").html();
		var frame1 = $('<iframe />');
		frame1[0].name = "frame1";
		frame1.css({ "position": "absolute", "top": "-1000000px" });
		$("body").append(frame1);
		var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
		frameDoc.document.open();
		//Create a new HTML document.
		frameDoc.document.write('<html><head><title></title>');
		frameDoc.document.write('</head><body>');
		//Append the external CSS file.
		frameDoc.document.write('<link href="'+jsmysurl+'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" media="print" rel="stylesheet" type="text/css" />');
		frameDoc.document.write('<link href="'+jsmysurl+'assets/css/adminlte.min.css" media="print" rel="stylesheet" type="text/css" />');
		frameDoc.document.write('<link href="'+jsmysurl+'assets/css/print.css" media="print" rel="stylesheet" type="text/css" />');
		//Append the DIV contents.
		frameDoc.document.write(contents);
		frameDoc.document.write('</body></html>');
		frameDoc.document.close(); 
		setTimeout(function () {
			window.frames["frame1"].focus();
			window.frames["frame1"].print();
			frame1.remove();
		}, 500);
	});
	

}); 

$("#orderFrm input").on("keyup keypress", function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});

$("#product").autocomplete({ 
	source: jsmysurl+"include/plugins/ajax/ajax_respose_files/product.php?act=livesearch",	
	minLength: 1,
	select: function(event, ui) {
		var id = ui.item.id; 
	 	var purchase_price 	= ui.item.purchase_price; 
		var stock_value 	= ui.item.stock_value;   
		$("#price").val(purchase_price);	 
		$("#pro_id").val(id);	
		$("#stock_value").val(stock_value);	 
		$("#qty").focus();
	}
});

$("#stock_product").autocomplete({ 
	source: jsmysurl+"include/plugins/ajax/ajax_respose_files/stock.php?act=livesearch",	
	minLength: 1,
	select: function(event, ui) {
		var id = ui.item.id; 
	 	var sale_price 		= ui.item.sale_price; 
		var stock_value 	= ui.item.stock_value;   
		$("#price").val(sale_price);	 
		$("#pro_id").val(id);	
		$("#stock_value").val(stock_value);	 
		$("#qty").focus();
	}
});

$("#service").autocomplete({ 
	source: jsmysurl+"include/plugins/ajax/ajax_respose_files/stock.php?act=livesearchservice",	
	minLength: 1,
	select: function(event, ui) {
		var service_id 		= ui.item.service_id; 
	 	var sale_price 		= ui.item.sale_price;  

		$("#service_price").val(sale_price);	 
		$("#service_id").val(service_id);	 
		$("#service_qty").focus(); 
	}
});

function split( val ) {
	return val.split( /,\s*/ );
}
function extractLast( term ) {
	return split( term ).pop();
}

var description_of_work_ids = new Array();  

$("#description_of_work").autocomplete({  
	source: jsmysurl+"include/plugins/ajax/ajax_respose_files/stock.php?act=livesearchparts",	
	minLength: 0,
	focus: function() {
					// prevent value inserted on focus
					return false;
				},
	select: function(event, ui) {
		var part_id = ui.item.part_id;  
		//var unit_price_box 	= ui.item.unit_price_box; 
		//var stock_val 	= ui.item.stock_val;   
		var terms = split( this.value );
		// remove the current input
		terms.pop();
		// add the selected item
		terms.push( ui.item.value );
		// add placeholder to get the comma-and-space at the end
		terms.push( "" );
		this.value = terms.join( ", " );
		description_of_work_ids.push(part_id); 
		$("#description_of_work_ids").val(description_of_work_ids); 
		return false;  

	}
});




$("#psize").autocomplete({  
	source: function(request, response) {
    $.getJSON(jsmysurl +"include/plugins/ajax/ajax_respose_files/stock.php", { act:'livesearchparts', ptype: $('#ptype').val(), psize: $('#psize').val() }, 
              response);
  	}, 
	minLength: 1 
});

 

function addProducts()
{
	"use strict";
 	var xmlhttp; 
	$("#eresDiv").html('<div class="padding10px"><img src="'+jsmysurl+'assets/img/ajax-processing.gif" style="padding-right:0px;"  /></div>');  	
	var pro_id 		= $("#pro_id").val();  
	var qty 		= 0;  
	if($("#qty").val() !== ""){
		qty	= parseInt($("#qty").val());  
	} 
	var stock_product	= parseInt($("#stock_product").val());  
	var stock_value	= parseInt($("#stock_value").val());  
	var price	= parseFloat(Math.round($("#price").val() * 100) / 100).toFixed(2);  
	
	if(qty > stock_value){ 
		$("#eresDiv").html('<div  class="alert alert-danger"><button class="close" data-close="alert"></button><span>Available quantity is less then order quantity</span></div>');	
		return false;
	} 
 
	if(pro_id === "" || price === "" ||  price === '0.00'  || qty ===  0   ){ 
		$("#eresDiv").html('<div  class="alert mt-2 alert-danger"><button class="close" data-close="alert"></button><span>All the feilds are mandatory. Please check again and process!</span></div>');	
		return false;
	}
	var url="&pro_id="+pro_id+"&qty="+qty+"&price="+price+"&stock_value="+stock_value+"&stock_product="+stock_product;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$("#resDiv").html(xmlhttp.responseText); 
			$("#eresDiv").html(""); 
			$("#price").val("");	
			$("#stock_value").val("");	 
			$("#pro_id").val("");	
			$("#stock_product").val("");	
			$("#product").val("");	
			$("#qty").val("");	 	 
			$("#product").focus();
			$("#stock_product").focus();
			
		 }else{
			 $("#eresDiv").html('<div class="padding10px"><img src="'+jsmysurl+'assets/img/ajax-processing.gif" style="padding-right:0px;"  /></div>');  
		}
	  }
	xmlhttp.open("GET",jsmysurl+"include/plugins/ajax/ajax_respose_files/new_order.php?act=addProduct"+url,true);
	xmlhttp.send();
}



function findProducts()
{
	"use strict";
 	var xmlhttp; 
	$("#eresDiv").html('<div class="padding10px"><img src="'+jsmysurl+'assets/img/ajax-processing.gif" style="padding-right:0px;"  /></div>');  	
	
	var supplier_id 	= $("#supplier_id_sel").val();  
	var size 			= $("#size").val();   
 
	var url="&supplier_id="+supplier_id+"&size="+size;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$("#resDiv").html(xmlhttp.responseText); 
			$("#eresDiv").html("");  
		 }else{
			 $("#eresDiv").html('<div class="padding10px"><img src="'+jsmysurl+'assets/img/ajax-processing.gif" style="padding-right:0px;"  /></div>');  
		}
	  }
	xmlhttp.open("GET",jsmysurl+"include/plugins/ajax/ajax_respose_files/product.php?act=findProduct"+url,true);
	xmlhttp.send();
}

function AdvanceSearch()
{
	$("#AdvanceSearchTr").toggle();  
}

function removeProducts(proID)
{
 	var xmlhttp; 
	$("#eresDiv").html('<div class="padding10px"><img src="'+jsmysurl+'assets/img/ajax-processing.gif" style="padding-right:0px;"  /></div>');   
 
	var url="&pro_id="+proID;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$("#resDiv").html(xmlhttp.responseText); 
			$("#eresDiv").html("");  
		 }else{
			 $("#eresDiv").html('<div class="padding10px"><img src="images/ajax-processing.gif" style="padding-right:0px;"  /></div>');  
		}
	  }
	xmlhttp.open("GET",jsmysurl+"include/plugins/ajax/ajax_respose_files/product.php?act=addProduct&action=del"+url,true);
	xmlhttp.send();
}


function removeServices(service_id)
{
 	var xmlhttp; 
	$("#serErDiv").html('<div class="padding10px"><img src="'+jsmysurl+'assets/img/ajax-processing.gif" style="padding-right:0px;"  /></div>');     
	var url="&service_id="+service_id;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$("#serDiv").html(xmlhttp.responseText); 
			$("#serErDiv").html("");  
		 }else{
			 $("#serErDiv").html('<div class="padding10px"><img src="images/ajax-processing.gif" style="padding-right:0px;"  /></div>');  
		}
	  }
	xmlhttp.open("GET",jsmysurl+"include/plugins/ajax/ajax_respose_files/product.php?act=addServices&action=del"+url,true);
	xmlhttp.send();
}






function addParts()
{
	"use strict";
 	var xmlhttp; 
	$("#acceresDiv").html('<div class="padding10px"><img src="'+jsmysurl+'assets/img/ajax-processing.gif" style="padding-right:0px;"  /></div>');  	
	var description_of_work_ids 		= $("#description_of_work_ids").val();  
	var dow_price						= $("#dow_price").val();  
	var description						= $("#description").val();  
	var description_of_work				= $("#description_of_work").val();   
 
	if(description_of_work_ids === "" || dow_price === ""  ){ 
		$("#acceresDiv").html('<div  class="alert alert-danger"><button class="close" data-close="alert"></button><span>All the feilds are mandatory. Please check again and process!</span></div>');	
		return false;
	}
	var url="&description_of_work_ids="+description_of_work_ids+"&dow_price="+dow_price+"&description="+description+"&description_of_work="+description_of_work;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$("#accresDiv").html(xmlhttp.responseText); 
			$("#acceresDiv").html(""); 
			$("#description_of_work_ids").val("");	
			$("#dow_price").val("");	 
			$("#description").val("");	
			$("#description_of_work").val("");	 
			$("#description_of_work").focus();
			
		 }else{
			 $("#acceresDiv").html('<div class="padding10px"><img src="'+jsmysurl+'assets/img/ajax-processing.gif" style="padding-right:0px;"  /></div>');  
		}
	  }
	xmlhttp.open("GET",jsmysurl+"include/plugins/ajax/ajax_respose_files/product.php?act=addParts"+url,true);
	xmlhttp.send();
}



function removeAccessories(del_id)
{
 	var xmlhttp; 
	$("#acceresDiv").html('<div class="padding10px"><img src="images/ajax-processing.gif" style="padding-right:0px;"  /></div>');   
 
	var url="&del_id="+del_id;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$("#accresDiv").html(xmlhttp.responseText); 
			$("#acceresDiv").html("");  
		 }else{
			 $("#acceresDiv").html('<div class="padding10px"><img src="images/ajax-processing.gif" style="padding-right:0px;"  /></div>');  
		}
	  }
	xmlhttp.open("GET",jsmysurl+"include/plugins/ajax/ajax_respose_files/product.php?act=addProduct&action=del"+url,true);
	xmlhttp.send();
}




function addServices()
{
	"use strict";
 	var xmlhttp; 
	$("#serDiv").html('<div class="padding10px"><img src="'+jsmysurl+'assets/img/ajax-processing.gif" style="padding-right:0px;"  /></div>');  	
	var service 		= $("#service").val(); 
	var service_id 		= $("#service_id").val();   
	var qty 		= 0;  
	if($("#service_qty").val() !== ""){
		qty	= parseInt($("#service_qty").val());  
	} 
	var service_price	= parseFloat(Math.round($("#service_price").val() * 100) / 100).toFixed(2);  
	
 	if(service_id === "" || service_price === "" ||  service_price === '0.00'  || qty ===  0   ){  
		$("#serErDiv").html('<div  class="alert alert-danger"><button class="close" data-close="alert"></button><span>All the feilds are mandatory. Please check again and process!</span></div>');	
		return false;
	}
	var url="&service_id="+service_id+"&qty="+qty+"&service_price="+service_price+"&service="+service;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$("#serDiv").html(xmlhttp.responseText); 
			$("#serErDiv").html("");  
			$("#service_price").val("");	 
			$("#service_id").val("");	 
			$("#service_qty").val(""); 
			$("#service").val(""); 
			$("#service").focus();
			
		 }else{
			 $("#serErDiv").html('<div class="padding10px"><img src="'+jsmysurl+'assets/img/ajax-processing.gif" style="padding-right:0px;"  /></div>');  
		}
	  }
	xmlhttp.open("GET",jsmysurl+"include/plugins/ajax/ajax_respose_files/new_order.php?act=addServices"+url,true);
	xmlhttp.send();
}
