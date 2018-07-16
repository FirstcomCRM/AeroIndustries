/* CUSTOM FUNCTIONS */


/*********************************************************
 *
 *	MISC
 *
 *
*********************************************************/

    $('.back-button').click(function(){
        goBack();
    });
    function goBack() {
        window.history.back();
    }

    $('.close-button').click(function(){
    	closeWindow();
    });
    function closeWindow(){
    	window.close();
    }


	/*********************************************************
	 *	ALL :: DATEPICKER
	 *
	*********************************************************/

	  $(function () {
	    //Date picker
	    $('#datepicker').datepicker({
	      autoclose: true,
	      format: 'yyyy-mm-dd'
	    });
	    $('#datepicker0').datepicker({
	      autoclose: true,
	      format: 'yyyy-mm-dd'
	    });
	    $('#datepicker1').datepicker({
	      autoclose: true,
	      format: 'yyyy-mm-dd'
	    });
	    $('#datepicker2').datepicker({
	      autoclose: true,
	      format: 'yyyy-mm-dd'
	    });
	    $('#datepicker3').datepicker({
	      autoclose: true,
	      format: 'yyyy-mm-dd'
	    });
	    $('#datepicker4').datepicker({
	      autoclose: true,
	      format: 'yyyy-mm-dd'
	    });
	    $('#datepicker5').datepicker({
	      autoclose: true,
	      format: 'yyyy-mm-dd'
	    });
	    $('#datepicker6').datepicker({
	      autoclose: true,
	      format: 'yyyy-mm-dd'
	    });
	    $('#datepicker7').datepicker({
	      autoclose: true,
	      format: 'yyyy-mm-dd'
	    });
	    $('#datepicker8').datepicker({
	      autoclose: true,
	      format: 'yyyy-mm-dd'
	    });
	    $('#datepicker9').datepicker({
	      autoclose: true,
	      format: 'yyyy-mm-dd'
	    });
	    $('#datepicker10').datepicker({
	      autoclose: true,
	      format: 'yyyy-mm-dd'
	    });
	  });

	/*********************************************************
	 *	ALL :: PRINT FUNCTION
	 *
	*********************************************************/
		$('.print-button').click(function(){
		    window.print();
		});

	/*********************************************************
	 *	ALL :: PRINT STICKER FUNCTION
	 *
	*********************************************************/
		$('.print-sticker').click(function(){
			var id = $('#re-no').val();
		    window.location = '?r=stock/print-sticker&id=' + id;

		});


	/*********************************************************
	 *	ALL :: SEARCH DROP DOWN
	 *
	*********************************************************/
		$(".select2").select2();
		$(".select3").select2({ width: '100%' });


	/*********************************************************
	 *	ALL :: Fixing Kartik-v/export dropdown now dropping
	 *
	*********************************************************/

		$(".export-export-all").click(function(e){
		     $('.export-menu').find(".dropdown-menu").not(".kv-checkbox-list").toggle('fast');
		    e.stopPropagation();
		});
		$('.export-column').click(function(e){
		     $('.kv-checkbox-list').toggle('fast');
		    e.stopPropagation();
		});

		$('.print-dropdown').click(function(e){
			var classes = $(this).attr('class').split(' ');
			var classSe = classes[4];

	    	$('.drop-dropdown-' + classSe).toggle('fast');
		    e.stopPropagation();
		});

		$('.checklist-dropdown').click(function(e){
			var classes = $(this).attr('class').split(' ');
			var classSe = classes[4];

	    	$('.checklist-dropdown-' + classSe).toggle('fast');
		    e.stopPropagation();
		});

		$('.generate-dropdown').click(function(e){
			var classes = $(this).attr('class').split(' ');
			var classSe = classes[4];

	    	$('.generate-dropdown-' + classSe).toggle('fast');
		    e.stopPropagation();
		});

		$(document).click(function(){
		  $('.export-menu').find(".dropdown-menu").not(".kv-checkbox-list").hide();
		  $('.kv-checkbox-list').hide();
		  $('.drop-dropdown').hide();
		  $('#search-result').hide();
		});

		$(document).ready(function(){
			if ( $('#w0-success-0').length || $('#w1-success-0').length ||  $('#w2-success-0').length) {
				$('.requisition-dropdown').click(function(){
				     $('.requisition-dropdown').addClass('open');
				});

				$('.po-dropdown').click(function(){
				     $('.po-dropdown').addClass('open');
				});
			}
		})



/*********************************************************
 *
 *	USER PERMISSION
 *
 *
*********************************************************/
	$('#userGroup').change(function(){
		$('#w0').submit();
	});
	$('#controllerName').change(function(){
		$('#w0').submit();
	});
	$('#select-all').click(function(event) {
	    $(':checkbox').each(function() {
	        this.checked = true;
	    });
	});


/*********************************************************
 *
 *	CUSTOMER
 *
 *
*********************************************************/

		/*********************************************************
		 *	CUSTOMER :: AJAX ADD COMPANY ADDRESS
		 *
		*********************************************************/

			function addCompanyAddress(){
				var numItems = $('.company-addresses-input').length;
				$('.company-addresses').append(''+
					'<div class="col-sm-12 col-xs-12">    '+
						'<div class="form-group field-address-address">'+
							'<div class="col-sm-3 text-right">'+
								'<label class="control-label" for="address-address">Company Address '+(numItems+1)+'</label></div>'+
							'<div class="col-sm-9 col-xs-12">'+
								'<textarea id="address-address" class="form-control company-addresses-input" name="Address[address][]"></textarea>'+
							'</div>'+
							'<div class="help-block"></div>'+
						'</div>'+
						'<div class="form-group field-address-address_type">'+
							'<input type="hidden" id="address-address_type" class="form-control" name="Address[address_type][]" value="address">'+
							'<div class="help-block"></div>'+
						'</div>'+
					'</div>'+
				'');
			}

		/*********************************************************
		 *	CUSTOMER :: AJAX ADD SHIPPING ADDRESS
		 *
		*********************************************************/

			function addShippingAddress(){
				var numItems = $('.shipping-addresses-input').length;
				$('.shipping-addresses').append(''+
					'<div class="col-sm-12 col-xs-12">    '+
						'<div class="form-group field-address-address">'+
							'<div class="col-sm-3 text-right">'+
								'<label class="control-label" for="address-address">Shipping Address '+(numItems+1)+'</label></div>'+
							'<div class="col-sm-9 col-xs-12">'+
								'<textarea id="address-address" class="form-control shipping-addresses-input" name="Address[address][]"></textarea>'+
							'</div>'+
							'<div class="help-block"></div>'+
						'</div>'+
						'<div class="form-group field-address-address_type">'+
							'<input type="hidden" id="address-address_type" class="form-control" name="Address[address_type][]" value="shipping">'+
							'<div class="help-block"></div>'+
						'</div>'+
					'</div>'+
				'');
			}

		/*********************************************************
		 *	CUSTOMER :: AJAX ADD BILLING ADDRESS
		 *
		*********************************************************/

			function addBillingAddress(){
				var numItems = $('.billing-addresses-input').length;
				$('.billing-addresses').append(''+
					'<div class="col-sm-12 col-xs-12">    '+
						'<div class="form-group field-address-address">'+
							'<div class="col-sm-3 text-right">'+
								'<label class="control-label" for="address-address">Billing Address '+(numItems+1)+'</label></div>'+
							'<div class="col-sm-9 col-xs-12">'+
								'<textarea id="address-address" class="form-control billing-addresses-input" name="Address[address][]"></textarea>'+
							'</div>'+
							'<div class="help-block"></div>'+
						'</div>'+
						'<div class="form-group field-address-address_type">'+
							'<input type="hidden" id="address-address_type" class="form-control" name="Address[address_type][]" value="billing">'+
							'<div class="help-block"></div>'+
						'</div>'+
					'</div>'+
				'');
			}

/*********************************************************
 *
 *	PURCHASE ORDER
 *
 *
*********************************************************/

		/*********************************************************
		 *	PURCHASE ORDER :: PARTS ONCHANGE CHECK STOCK
		 *
		*********************************************************/

		 $('#purchaseorderdetail-part_id').change(function(){
	        $('.stock-result').empty();
		 	var part_id = $(this).val();
		 	$.post("?r=stock/ajax-checkstock",{
		        selectedStockPartId:part_id
		    },
		    function(data, status){
		        returnData = JSON.parse(data);
		        var qty = 0;
		        var textToAppend = '0 stock';
		        if ( returnData['stQty'] > 0 ) {
		        	qty = parseFloat(returnData['stQty']).toFixed(3);
		        	partType = returnData['partType'];

			        if ( partType == 'tool') {
		        		textToAppend =  qty + ' <a href="?r=tool/index&SearchTool[part_id]='+part_id+'" target="_blank">stock</a>';
			        } else {
		        		textToAppend = qty + ' <a href="?r=stock/stock&cat_id=&part_id='+part_id+'" target="_blank">stock</a>';
			        }
		        }
			        $('.stock-result').append(textToAppend + ' remaining');
		    });
		 });


		/*********************************************************
		 *	PURCHASE ORDER :: ONCHANGE UPDATE INDIVIDUAL SUBTOTAL
		 *
		*********************************************************/

		 function updatePOSubTotal() {
		 	var qty = $('#qty').val();
		 	var unit = $('#unit').val();
		 	var converted_unit = $('#converted_unit').val();
		 	var subTotal = 0;
	 		subTotal = parseFloat(qty * converted_unit);
		 	$('#subtotal').val(subTotal.toFixed(2));
		 }

		/*********************************************************
		 *	PURCHASE ORDER :: ONCHANGE CONVERT UNIT
		 *
		*********************************************************/

		 function convert() {
		 	var unit = parseFloat($('#unit').val());
		 	var conversion_rate = parseFloat($('#currencyRate').val());
		 	var converted_unit = unit * conversion_rate;
		 	$('#converted_unit').val(converted_unit.toFixed(2));
	 		updatePOSubTotal();
		 }

		/*********************************************************
		 *	PURCHASE ORDER :: ONCHANGE UPDATE INDIVIDUAL SUBTOTAL
		 *
		*********************************************************/

		 function addPOItem() {

		 	var qty = $('#qty').val();
		 	var unit = $('#unit').val();
		 	var converted_unit = $('#converted_unit').val();
		 	var subTotal = $('#subtotal').val();
		 	var unitm = $('#unitm').val();
		 	var part = $('#purchaseorderdetail-part_id').val();
		 	if ( qty == '' && unit == '') {
		 		alert('Please key in quantity and unit price');
		 	} else {
		 		if ( qty == '' ) {
			 		alert('Please key in quantity');
			 	} else if ( unit == '' ) {
			 		alert('Please key in unit price');
			 	} else {

				 	var n = $('#n').val();

				    n ++ ;

					$.post("?r=purchase-order/ajax-part",{
				        qty:qty,
				        unit:unit,
				        converted_unit:converted_unit,
				        subTotal:subTotal,
				        part:part,
				        unitm:unitm,
				        n:n
				    },
				    function(data, status){
				        $('.selected-item-list').append(data);
				        // console.log(status);
				    });

				 	$('#n').val(n);
				 	$('#qty').val('');
				 	$('#converted_unit').val('');
				 	$('#unit').val('');
				 	$('#subtotal').val('');
				 	setTimeout(function(){
				 		getPoTotal();
					}, 500);
			 	}

		 	}
		 }

		/*********************************************************
		 *	PURCHASE ORDER :: REMOVE ITEM
		 *
		*********************************************************/

		 function removePOItem(n) {
		 	$('.item-'+n).remove();
		 	setTimeout(function(){
		 		getPoTotal();
			}, 500);
		 }


		/*********************************************************
		 *	PURCHASE ORDER :: ONCHANGE UPDATE TOTAL
		 *
		*********************************************************/
			function getPoTotal(){
				// alert();
				var total = 0;
				var gst = parseFloat($('#gst').val());
				if ( gst ) {
					gst = gst/100;
					$('.subTotalGroup').each(function() {
					    total += parseFloat($(this).val());
					})
					$('#total').val(total.toFixed(2));
					var grandTotal = total * ( 1 + gst );
					$('#totalGST').val(grandTotal.toFixed(2));
				} else {
					$('.subTotalGroup').each(function() {
					    total += parseFloat($(this).val());
					})
					$('#total').val(total.toFixed(2));
					$('#totalGST').val(total.toFixed(2));
					var grandTotal = total;
				}

			}

		/*********************************************************
		 *	PURCHASE ORDER :: CHANGE CURRENCY
		 *
		*********************************************************/

			 $('.currency-selection').change(function(){
				var selectedCurrId = $('.currency-selection').val();
				$.post("?r=purchase-order/ajax-currency",{
			        selectedCurrId:selectedCurrId
			    },
			    function(data, status){
			        returnData = JSON.parse(data);
			    	$('#rateText').empty();
			    	$('#rateText').append(returnData['rate']);
			    	$('#currencyText').empty();
			    	$('#currencyText').append(returnData['iso']);
			    	$('#currencyRate').val(returnData['rate']);
			    	afterConversion();
			    });
			 });


		/*********************************************************
		 *	PURCHASE ORDER :: UPDATE UNIT AFTER CURRENCY CHANGED
		 *
		*********************************************************/

			 function afterConversion() {

				$('.unitGroup').each(function() {
				    var unit = parseFloat($(this).val());
				    var conversion_rate = parseFloat($('#currencyRate').val());
				    var convertedUnit = unit * conversion_rate;
				    var thisId = $(this).attr('id');
				    var explodeId = thisId.split('-');
				    var n = explodeId[1];
				    $('#selected-'+n+'-converted_unit').val(convertedUnit.toFixed(2));
				    $('#selected-'+n+'-subTotal').val((convertedUnit*$('#selected-'+n+'-qty').val()).toFixed(2));
				})
			 }


		/*********************************************************
		 *	PURCHASE ORDER :: GET CUSTOMER ADDRESS
		 *
		*********************************************************/
			 $('.po-supplier').change(function(){
				var supplierId = $('.po-supplier').val();
				// console.log(supplierId);
				if ($('#isEdit').val() == 0 ) {
					window.location = '?r=purchase-order/new&supplier_id='+supplierId;
				} else {
					window.location = '?r=purchase-order/edit&id='+$('#isEdit').val()+'&supplier_id='+supplierId;
				}
				// $.post("?r=purchase-order/ajax-address",{
			 //        supplierId:supplierId
			 //    },
			 //    function(data, status){
			 //    	$('.po_pay_addr').empty();
			 //    	$('.po_pay_addr').append(data);
			 //    });

				// $.post("?r=purchase-order/ajax-attention",{
			 //        supplierId:supplierId
			 //    },
			 //    function(data, status){
			 //    	$('.po-attention').val(data);
			 //    });
			 });


       /*********************************************************
   		 *	GPO PURCHASE ORDER :: GET CUSTOMER ADDRESSES 
   		 *	EDR
   		*********************************************************/
      $('.gpo-supplier').change(function(){
       var supplierId = $('.gpo-supplier').val();
       // console.log(supplierId);
       $.post("?r=general-po/ajax-address",{
             supplierId:supplierId
         },
         function(data, status){
           $('.gpo_pay_addr').empty();
           $('.gpo_pay_addr').append(data);
         });

       $.post("?r=general-po/ajax-attention",{
             supplierId:supplierId
         },
         function(data, status){
           $('.gpo-attention').val(data);
         });
      });

       /*********************************************************
   		 *	GPO PURCHASE ORDER :: GET CUSTOMER ADDRESSES 
   		 *	EDR
   		*********************************************************/
      $('.tpo-supplier').change(function(){
       	var supplierId = $('.tpo-supplier').val();
		// console.log(supplierId);
		if ($('#isEdit').val() == 0 ) {
			window.location = '?r=tool-po/new&supplier_id='+supplierId;
		} else {
			window.location = '?r=tool-po/edit&id='+$('#isEdit').val()+'&supplier_id='+supplierId;
		}	

  //      $.post("?r=tool-po/ajax-address",{
  //            supplierId:supplierId
  //        },
  //        function(data, status){
  //          $('.tpo_pay_addr').empty();
  //          $('.tpo_pay_addr').append(data);
  //        });

  //      $.post("?r=tool-po/ajax-attention",{
  //            supplierId:supplierId
  //        },
  //        function(data, status){
  //          $('.tpo-attention').val(data);
  //        });

  //      	var supplierId = $('.tpo-supplier').val();
		// // console.log(supplierId);
		// if ($('#isEdit').val() == 0 ) {
		// 	window.location = '?r=tool-po/new&supplier_id='+supplierId;
		// } else {
		// 	window.location = '?r=tool-po/edit&id='+$('#isEdit').val()+'&supplier_id='+supplierId;
		// }
      });


		/*********************************************************
		 *	PURCHASE ORDER :: EDIT ITEM
		 *
		*********************************************************/

		 // function editPOItem(n) {
		 // 	$('#selected-'+n+'-qty').removeAttr('readonly');
		 // 	$('#selected-'+n+'-unit').removeAttr('readonly');
		 // 	$('#selected-'+n+'-unitm').removeAttr('readonly');
		 // 	$('.save-button'+n).removeClass('hidden');
		 // 	$('.edit-button'+n).addClass('hidden');

		 // }

		/*********************************************************
		 *	PURCHASE ORDER :: SAVE EDITED ITEM
		 *
		*********************************************************/

		 // function savePOItem(n) {
		 // 	$('#selected-'+n+'-qty').attr('readonly', true);
		 // 	$('#selected-'+n+'-unit').attr('readonly', true);
		 // 	$('.edit-button'+n).removeClass('hidden');
		 // 	$('.save-button'+n).addClass('hidden');

		 // }

/*********************************************************
 *
 *	GENERAL PO
 *
 *
*********************************************************/


		/*********************************************************
		 *	GENERAL PO :: ONCHANGE UPDATE INDIVIDUAL SUBTOTAL
		 *
		*********************************************************/

		 function addGPOItem() {

		 	var qty = $('#qty').val();
		 	var unit = $('#unit').val();
		 	var converted_unit = $('#converted_unit').val();
		 	var subTotal = $('#subtotal').val();
		 	var unitm = $('#unitm').val();
		 	var part = $('#generalpodetail-part_id').val();

		 	if ( qty == '' && unit == '') {
		 		alert('Please key in quantity and unit price');
		 	} else {
		 		if ( qty == '' ) {
			 		alert('Please key in quantity');
			 	} else if ( unit == '' ) {
			 		alert('Please key in unit price');
			 	} else {

				 	var n = $('#n').val();

				    n ++ ;

					$.post("?r=general-po/ajax-part",{
				        qty:qty,
				        unit:unit,
				        converted_unit:converted_unit,
				        subTotal:subTotal,
				        part:part,
				        unitm:unitm,
				        n:n
				    },
				    function(data, status){
				        $('.selected-item-list').append(data);
				        // console.log(status);
				    });

				 	$('#n').val(n);
				 	$('#qty').val('');
				 	$('#converted_unit').val('');
				 	$('#unit').val('');
				 	$('#subtotal').val('');
				 	setTimeout(function(){
				 		getPoTotal();
					}, 500);
			 	}

		 	}
		 }
		 /*********************************************************
		 *	GENERAL PO :: ONCHANGE UPDATE INDIVIDUAL SUBTOTAL
		 *
		*********************************************************/

		 function addTPOItem() {

		 	var qty = $('#qty').val();
		 	var unit = $('#unit').val();
		 	var converted_unit = $('#converted_unit').val();
		 	var subTotal = $('#subtotal').val();
		 	var unitm = $('#unitm').val();
		 	var part = $('#toolpodetail-part_id').val();

		 	if ( qty == '' && unit == '') {
		 		alert('Please key in quantity and unit price');
		 	} else {
		 		if ( qty == '' ) {
			 		alert('Please key in quantity');
			 	} else if ( unit == '' ) {
			 		alert('Please key in unit price');
			 	} else {

				 	var n = $('#n').val();

				    n ++ ;

					$.post("?r=tool-po/ajax-part",{
				        qty:qty,
				        unit:unit,
				        converted_unit:converted_unit,
				        subTotal:subTotal,
				        part:part,
				        unitm:unitm,
				        n:n
				    },
				    function(data, status){
				        $('.selected-item-list').append(data);
				        // console.log(status);
				    });

				 	$('#n').val(n);
				 	$('#qty').val('');
				 	$('#converted_unit').val('');
				 	$('#unit').val('');
				 	$('#subtotal').val('');
				 	setTimeout(function(){
				 		getPoTotal();
					}, 500);
			 	}

		 	}
		 }

/*********************************************************
 *
 *	QUOTATION
 *
 *
*********************************************************/



		/*********************************************************
		 *	QUOTATION :: ONCHANGE UPDATE INDIVIDUAL SUBTOTAL - For parts
		 *
		*********************************************************/

		 // function changeItemType(itemType) {
		 // 	$('.change-type-button').empty();
		 // 	if ( itemType == 'service') {
		 // 		var cont = '<button onclick="changeItemType(\'part\')" class="btn btn-success">Add Parts</button>';
		 // 		$('.change-type-button').append(cont);

		 // 		$('.item-part').addClass('hidden');
		 // 		$('.item-service').removeClass('hidden');
		 // 		$('#item-type').val('service');


		 // 	} else {
		 // 		var cont = '<button onclick="changeItemType(\'service\')" class="btn btn-primary">Add Services</button>';
		 // 		$('.change-type-button').append(cont);

		 // 		$('.item-service').addClass('hidden');
		 // 		$('.item-part').removeClass('hidden');
		 // 		$('#item-type').val('part');
		 // 	}

		 // }

		/*********************************************************
		 *	QUOTATION :: ONCHANGE UPDATE INDIVIDUAL SUBTOTAL - For parts
		 *
		*********************************************************/

		 function updateQuoSubTotalPar() {
		 	var qty = $('#qty-par').val();
		 	var unit = $('#unit-par').val();
		 	var subTotal = qty * unit;
		 	$('#subtotal-par').val(subTotal.toFixed(2));
		 	getQuoTotal();
		 }
		
		/*********************************************************
		 *	QUOTATION :: CHECK WHETHER WO OR UP
		 *
		*********************************************************/

		$('.quotation-type').change(function(){
			var quotation_type = $('.quotation-type').val();
			if (quotation_type == "work_order") {
				var postUrl = "?r=quotation/ajax-workorder";
			} else {
				var postUrl = "?r=quotation/ajax-uphostery";
			}

			$.post(postUrl,{
		        quotation_type:quotation_type
		    },
		    function(data, status){
		    	$('.work-order-selection').empty();
		    	$('.work-order-selection').select2();
		    	$('.work-order-selection').append(data);
		    });
		});

		/*********************************************************
		 *	QUOTATION :: AUTO SELECT CUSTOMER WHEN WO IS SELECTED
		 *
		*********************************************************/
			$('.work-order-selection').change(function(){
				var woId = $('.work-order-selection').val();
				var quotation_type = $('.quotation-type').val();

				$.post("?r=quotation/ajax-customer",{
			        woId:woId,
			        quotation_type:quotation_type
			    },
			    function(data, status){
			    	$('#quotation-customer_id').val(data).trigger('change');
			    	quotationGetAddress();
			    });
			});

		/*********************************************************
		 *	QUOTATION :: GET CUSTOMER ADDRESS
		 *
		*********************************************************/
			$('#quotation-customer_id').change(function(){
		    	quotationGetAddress();
			});

			function quotationGetAddress(){
				var customerId = $('#quotation-customer_id').val();

				$.post("?r=quotation/ajax-address",{
			        customerId:customerId
			    },
			    function(data, status){
			    	$('#quotation-address').empty();
			    	$('#quotation-address').append(data);
			    });
			}


		/*********************************************************
		 *	QUOTATION :: CONFIRM THE ITEM
		 *
		*********************************************************/

		 function addQuoItemPar() {

		 	var qty = $('#qty-par').val();
		 	var group = $('#group').val();
		 	var unit = $('#unit-par').val();
		 	var subTotal = $('#subtotal-par').val();

		 	var serviceDetail = $('#quotationdetail-service_details').val();
		 	var workType = $('#quotationdetail-work_type').val();
		 	// console.log(serviceDetail);

		 	if ( qty == '' && unit == '') {
		 		alert('Please key in quantity and unit price');
		 	} else {
		 		if ( qty == '' ) {
			 	} else if ( unit == '' ) {
			 		alert('Please key in unit price');
			 	} else {

				 	var n = $('#n').val();

				    n ++ ;

					$.post("?r=quotation/ajax-part",{
				        qty:qty,
				        group:group,
				        unit:unit,
				        subTotal:subTotal,
				        serviceDetail:serviceDetail,
				        n:n,
				        workType:workType
				    },
				    function(data, status){
				        $('.selected-item-list').append(data);
				    });

					$('#quotationdetail-service_details').val('');
				 	$('#n').val(n);
				 	$('#qty-par').val('');
				 	$('#unit-par').val('');
				 	$('#subtotal-par').val('');
				 	$('#group').val('');
				 	setTimeout(function(){
				 		getQuoTotal();
					}, 500);
			 	}
		 	}
		 }

		/*********************************************************
		 *	QUOTATION :: EDIT ITEM
		 *
		*********************************************************/

		 function editQuoItem(n) {
		 	$('#selected-'+n+'-qty').removeAttr('readonly');
		 	$('#selected-'+n+'-unit').removeAttr('readonly');
		 	$('.save-button'+n).removeClass('hidden');
		 	$('.edit-button'+n).addClass('hidden');

		 }

		/*********************************************************
		 *	QUOTATION :: REMOVE ITEM
		 *
		*********************************************************/

		 function removeQuoItem(n) {
		 	$('.item-'+n).remove();
		 	setTimeout(function(){
		 		getQuoTotal();
			}, 500);
		 }

		/*********************************************************
		 *	QUOTATION :: CALCULATE EDITED ITEM
		 *
		*********************************************************/

		 function updateQuoSubtotal(n) {
		 	var qty = $('#selected-'+n+'-qty').val();
		 	var unit = $('#selected-'+n+'-unit').val();
		 	var subTotal = qty * unit;
		 	$('#selected-'+n+'-subTotal').val(subTotal.toFixed(2));
		 	getQuoTotal();
		 }

		/*********************************************************
		 *	QUOTATION :: SAVE EDITED ITEM
		 *
		*********************************************************/

		 function saveQuoItem(n) {
		 	$('#selected-'+n+'-qty').attr('readonly', true);
		 	$('#selected-'+n+'-unit').attr('readonly', true);
		 	$('.edit-button'+n).removeClass('hidden');
		 	$('.save-button'+n).addClass('hidden');

		 }

		/*********************************************************
		 *	QUOTATION :: ONCHANGE UPDATE TOTAL
		 *
		*********************************************************/
			function getQuoTotal(){
				// alert();
				var total = 0;
				var gst = parseFloat($('#gst').val());
				if ( gst ) {
					gst = gst/100;
					$('.subTotalGroup').each(function() {
					    total += parseFloat($(this).val());
					})
					$('#total').val(total.toFixed(2));
					var grandTotal = total * ( 1 + gst );
					$('#totalGST').val(grandTotal.toFixed(2));
				} else {
					$('.subTotalGroup').each(function() {
					    total += parseFloat($(this).val());
					})
					$('#total').val(total.toFixed(2));
					$('#totalGST').val(total.toFixed(2));
				}

			}







/*********************************************************
 *
 *	STOCK
 *
 *
*********************************************************/


		/*********************************************************
		 *	STOCK :: CALCULATE FREIGHT
		 *
		*********************************************************/

			$('#stock-freight-top').keyup(function() {
			    calculateFreight();
			});


			function calculateFreight() {
				var total_freight = parseFloat($('#stock-freight-top').val());
				var freightQtyCount = parseInt($('#freightQtyCount').val());
				var average_freight = total_freight / freightQtyCount;

		        $(".ave-freight").each(function(key, value) {
		        	var extractPartId = $(this).attr("class").split(' ');
		        	var extractPartId2 = extractPartId[2].split('-');
		        	var partId = extractPartId2[2];
		        	var partQty = parseFloat($('.each-qty-freight-'+partId).val());
		        	var usdPrice = parseFloat($('#orgemagi-'+key).val());
		        	var newPrice = usdPrice+parseFloat((partQty*average_freight).toFixed(2));
					$(this).val(parseFloat((partQty*average_freight).toFixed(2)));
		        	if ( newPrice > -1 ) {
		        	console.log(newPrice);
				    	$('.usd_price_' + key).val(newPrice.toFixed(2));
				    } else {
						$('#stock-usd_price').val($('#orgemagi-'+key).val());
				    }
				});


			}

		/*********************************************************
		 *	STOCK :: PO ID ONCHANGE RETRIEVE ALL PO DATA
		 *
		*********************************************************/

			function stockInPo() {
				var poIdGet = $('#stock-purchase_order_id').val();
				var poIdEx = poIdGet.split('-');
				var poId = poIdEx[0];
				var poType = poIdEx[1];
				window.location = '?r=stock/new&id=' + poId + '&ty=' + poType;
			}

		/*********************************************************
		 *	RECEIVING LABEL :: RE ID ONCHANGE RETRIEVE ALL RE DATA
		 *
		*********************************************************/

			function printStickerRe() {
				var poId = $('#stock-purchase_order_id').val();
				window.location = '?r=stock/print-sticker&id=' + poId;
			}



		/*********************************************************
		 *	RECEIVING LABEL :: RE ID ONCHANGE RETRIEVE ALL RE DATA
		 *
		*********************************************************/

			function printSticker(stockId) {
				var qty = $('#qty-to-print-'+stockId).val();
				var pt = $('#pt-'+stockId).val();
				window.location = '?r=stock/sticker&id=' + stockId + '&q=' + qty + '&pt=' + pt;
			}


		/************************************************************
		 *	STOCK :: STOCK ISSUE CHANGE STOCK ID OF THE REQUISITION
		 *
		************************************************************/


			$('#editStockId').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) ;
				var partid = button.data('partid') ;
				var stockid = button.data('stockid') ;
				var reqid = button.data('reqid') ;
				$('#modal-req-id').val(reqid);
				// get drop down
				$.post("?r=stock/get-stockdropdown",{
		            partid:partid
		        },
		        function(data, status){
		        	$('.stock-dropdown').html(data);
		        });
				// get stock info
				$.post("?r=stock/get-stockinfo",{
		            stockid:stockid
		        },
		        function(data, status){
		      		$('.modal-show-stock-detail').empty();
		      		$('.modal-show-stock-detail').append(data);
		        });
			});


			$('.stock-dropdown').change(function(){
				var stockid = $('.stock-dropdown').val() ;
				// get stock info
				$.post("?r=stock/get-stockinfo",{
		            stockid:stockid
		        },
		        function(data, status){
		      		$('.modal-show-stock-detail').empty();
		      		$('.modal-show-stock-detail').append(data);
		        });
			});



			$('.save-stock-id').click(function(){
				$.ajax({
					type: "POST",
					url: "?r=work-order/save-stockid",
					data: {
						stockid: $('.stock-dropdown').val(),
						reqid: $('#modal-req-id').val()
					},
					success: function(data){
						$('.close-modal').click();
						window.location.reload();
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						alert("ERROR!!!");
					}
				});
			});

/*********************************************************
 *
 *	TEMPLATE
 *
 *
*********************************************************/


		/*********************************************************
		 *	TEMPLATE :: Add alternate part no.
		 *
		*********************************************************/
			$('.btn-add-alt').click(function(){
				var no = parseInt($('#no').val()) + 1;
				$('#no').val(no);
				$('.btn-add-alt').attr('data-target','#alt-part-'+no);

			});


/*********************************************************
 *
 *	WORK ORDER
 *
 *
*********************************************************/

		/*********************************************************
		 *	WORK ORDER :: CHECKLIST
		 *
		*********************************************************/

		
			$('#checklistModal').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) ;
				var work_order_id = button.data('work_order_id') ;
				var work_order_part_id = button.data('work_order_part_id') ;
				// $('#modal-req-id').val(reqid);
				// get drop down
				$.post("?r=work-order/get-checklist",{
		            work_order_part_id:work_order_part_id
		        },
		        function(data, status){
		        	$('#checklistModal .modal-body').empty();
		        	$('#checklistModal .modal-body').append(data);
		        });
			});


		/*********************************************************
		 *	WORK ORDER :: Ajax Search Parts
		 *
		*********************************************************/

		    $('#workorderpart-part_no').on('input', function() {

		        // $('.close-search').removeClass('display-none');
		        var partNoKeyed = $('#workorderpart-part_no').val();

		        $.post("?r=work-order/search-part",{
		            partNoKeyed:partNoKeyed
		        },
		        function(data, status){
		            $('#search-result').css('display', 'block');
		            $('#search-result').empty();
		            $('#search-result').append(data);
		        });

		    });


		    function woSelectPart(partNo=null) {
		    	var partNoText = "";
		    	partNoText = partNo;
	    	 	$('#workorderpart-part_no').val(partNoText);
	    	 	getTemplate();
		    }


		/************************************************************
		 *	WORK ORDER :: index change multiple wo's status at once
		 *
		************************************************************/

			function update_status() {
				var workorderids = new Array();
				var status = $('#update-status-selection').val();
				var n = 0;
				$('.work-order-checkbox').each(function () {
			       	workorderids[n] = (this.checked ? $(this).val() : "");
			       	n++;
			  	});

			  	$.post("?r=work-order/update-status",{
		            workorderids:workorderids,
		            status:status
		        },
		        function(data, status){
		            if ( data != 1) {
			    		alert('Unable to change status');
	    			}else {
				    	window.location.reload();
	    			}
		        });
			}


		/*********************************************************
		 *	WORK ORDER :: Search template by part no
		 *
		*********************************************************/
		    // $('#workorder-part_no').on('input', function() {
		    function getTemplate() {
		        var partNoTemp = $('#workorderpart-part_no').val();
		        if ( partNoTemp != '' ) {
			        $.post("?r=work-order/get-template",{
			            partNoTemp:partNoTemp
			        },
			        function(data, status){
		        		var returnData = JSON.parse(data);
			            if ( returnData != false ) {
					    	$('#workorderpart-template_id').val(returnData).change();
					    	$('.yes-template').removeClass('hidden');
			    			$('.no-template').addClass('hidden');
		    			}else {
					    	$('#workorderpart-template_id').val('').change();
					    	$('.no-template').removeClass('hidden');
			    			$('.yes-template').addClass('hidden');
		    			}
			        });

			        $.post("?r=work-order/get-desc",{
			            partNoTemp:partNoTemp
			        },
			        function(data, status){
			            if ( data != false ) {
			        		var returnData = JSON.parse(data);
					    	$('#workorderpart-desc').val(returnData['description']).change();
					    	$('#workorderpart-manufacturer').val(returnData['manufacturer']).change();
		    			} else {
					    	$('#workorderpart-desc').val('');
		    			}
			        });
		        }
	        }
		    // });

	   //      $('#w0').submit(function()){
		  //       if ($('#added-part_no').length > 0) {
				//   alert();
				// }
	   //      });

		    function addPart() {
		        var n = parseInt($('#n').val());

		        var part_no = $('#workorderpart-part_no').val();

		        if ( part_no != '') {
			        var desc = $('#workorderpart-desc').val();
			        var manufacturer = $('#workorderpart-manufacturer').val();
			        var model = $('#workorderpart-model').val();
			        var ac_tail_no = $('#workorderpart-ac_tail_no').val();
			        var ac_msn = $('#workorderpart-ac_msn').val();
			        var serial_no = $('#workorderpart-serial_no').val();
			        var batch_no = $('#workorderpart-batch_no').val();
			        var location_id = $('#workorderpart-location_id').val();
			        var template_id = $('#workorderpart-template_id').val();
			        var quantity = $('#workorderpart-quantity').val();
			        var productive_hour = $('#workorderpart-productive_hour').val();
			        var man_hour = $('#workorderpart-man_hour').val();
			        var new_part_no = $('#workorderpart-new_part_no').val();

			        $.post("?r=work-order/add-part",{
			        	n:n,
			            part_no:part_no,
				        desc:desc,
				        manufacturer:manufacturer,
				        model:model,
				        ac_tail_no:ac_tail_no,
				        ac_msn:ac_msn,
				        serial_no:serial_no,
				        batch_no:batch_no,
				        location_id:location_id,
				        template_id:template_id,
				        quantity:quantity,
				        productive_hour:productive_hour,
				        man_hour:man_hour,
				        new_part_no:new_part_no
			        },
			        function(data, status){
			            if ( data != false ) {
			        		var returnData = JSON.parse(data);
					    	$('.part-added tbody').append(returnData);
					    	n++;
					    	$('#n').val(n);
					    	$('.add-part-section #workorderpart-part_no').val("");
					        $('.add-part-section #workorderpart-desc').val("");
					        $('.add-part-section #workorderpart-manufacturer').val("");
					        $('.add-part-section #workorderpart-model').val("");
					        $('.add-part-section #workorderpart-ac_tail_no').val("");
					        $('.add-part-section #workorderpart-ac_msn').val("");
					        $('.add-part-section #workorderpart-serial_no').val("");
					        $('.add-part-section #workorderpart-batch_no').val("");
					        $('.add-part-section #workorderpart-quantity').val("");
					        $('.add-part-section #workorderpart-productive_hour').val("");
					        $('.add-part-section #workorderpart-man_hour').val("");
					        $('.add-part-section #workorderpart-new_part_no').val("");
					    	$('#workorderpart-template_id').val('').change();
					    	$('#workorderpart-location_id').val('').change();
					    	$('.no-template').removeClass('hidden');
			    			$('.yes-template').addClass('hidden');
			    			$('.empty-cart').remove();
		    			} else {
		    			}
			        });
		        } else {
		        	alert('Please fill up content');
		        }
		    }

		    function editPart(n){
		    	$('#workorderpart-id').val($('.edit-id-'+n).val());
		    	$('#workorderpart-part_no').val($('.edit-part_no-'+n).val());
		    	$('#workorderpart-manufacturer').val($('.edit-manufacturer-'+n).val());
		    	$('#workorderpart-model').val($('.edit-model-'+n).val());
		    	$('#workorderpart-desc').val($('.edit-desc-'+n).val());
		    	$('#workorderpart-ac_tail_no').val($('.edit-ac_tail_no-'+n).val());
		    	$('#workorderpart-model').val($('.edit-model-'+n).val());
		    	$('#workorderpart-ac_tail_no').val($('.edit-ac_tail_no-'+n).val());
		    	$('#workorderpart-ac_msn').val($('.edit-ac_msn-'+n).val());
		    	$('#workorderpart-serial_no').val($('.edit-serial_no-'+n).val());
		    	$('#workorderpart-batch_no').val($('.edit-batch_no-'+n).val());
		    	$('#workorderpart-location_id').val($('.edit-location_id-'+n).val()).trigger('change.select2');
		    	$('#workorderpart-quantity').val($('.edit-quantity-'+n).val());
		    	$('#workorderpart-man_hour').val($('.edit-man_hour-'+n).val());
		    	$('#workorderpart-new_part_no').val($('.edit-new_part_no-'+n).val());
		    	$('#workorderpart-productive_hour').val($('.edit-productive_hour-'+n).val());

		    	if (  $('.edit-template_id-'+n).val() != '' ) {
			    	$('.no-template').addClass('hidden');
	    			$('.yes-template').removeClass('hidden');
		    	}

		    	$('.add-button').addClass('hidden');
		    	$('.save-button').removeClass('hidden');
		    	$('#m').val(n);
		    }


		    function savePart() {
		        var m = $('#m').val();

		       	$('.edit-id-'+m).val( $('#workorderpart-id').val() );
		       	$('.display-part_no-'+m).val( $('#workorderpart-part_no').val() );
		       	$('.edit-part_no-'+m).val( $('#workorderpart-part_no').val() );
                $('.display-manufacturer-'+m).val($('#workorderpart-manufacturer').val());
                $('.edit-manufacturer-'+m).val($('#workorderpart-manufacturer').val());
                $('.display-model-'+m).val($('#workorderpart-model').val());
                $('.edit-model-'+m).val($('#workorderpart-model').val());
                $('.edit-desc-'+m).val($('#workorderpart-desc').val());
                $('.edit-ac_tail_no-'+m).val($('#workorderpart-ac_tail_no').val());
                $('.edit-model-'+m).val($('#workorderpart-model').val());
                $('.edit-ac_tail_no-'+m).val($('#workorderpart-ac_tail_no').val());
                $('.edit-ac_msn-'+m).val($('#workorderpart-ac_msn').val());
                $('.edit-serial_no-'+m).val($('#workorderpart-serial_no').val());
                $('.edit-batch_no-'+m).val($('#workorderpart-batch_no').val());
                $('.edit-location_id-'+m).val($('#workorderpart-location_id').val());
                $('.display-quantity-'+m).val($('#workorderpart-quantity').val());
                $('.edit-quantity-'+m).val($('#workorderpart-quantity').val());
                $('.edit-template_id-'+m).val($('#workorderpart-template_id').val());
                $('.edit-man_hour-'+m).val($('#workorderpart-man_hour').val());
                $('.edit-new_part_no-'+m).val($('#workorderpart-new_part_no').val());
                $('.edit-productive_hour-'+m).val($('#workorderpart-productive_hour').val());

                $('.add-part-section #workorderpart-id').val("");
                $('.add-part-section #workorderpart-part_no').val("");
		        $('.add-part-section #workorderpart-desc').val("");
		        $('.add-part-section #workorderpart-manufacturer').val("");
		        $('.add-part-section #workorderpart-model').val("");
		        $('.add-part-section #workorderpart-ac_tail_no').val("");
		        $('.add-part-section #workorderpart-ac_msn').val("");
		        $('.add-part-section #workorderpart-serial_no').val("");
		        $('.add-part-section #workorderpart-batch_no').val("");
		        $('.add-part-section #workorderpart-quantity').val("");
		        $('.add-part-section #workorderpart-man_hour').val("");
		        $('.add-part-section #workorderpart-new_part_no').val("");
		        $('.add-part-section #workorderpart-productive_hour').val("");
		    	$('#workorderpart-template_id').val('').change();
		    	$('#workorderpart-location_id').val('').change();
		    	$('.no-template').removeClass('hidden');
    			$('.yes-template').addClass('hidden');
		    	$('.add-button').removeClass('hidden');
		    	$('.save-button').addClass('hidden');
    			$('.empty-cart').remove();
		    }


		    function removePart(n){
				var r = confirm("Are you sure to remove the part from this work order?");
				if (r == true) {
			    	$('.edit-deleted-'+n).val(1);
			    	$('.part-'+n).css('display','none');
				}
		    }

		/*********************************************************
		 *	WORK ORDER :: Add Technician Column
		 *
		*********************************************************/
		    $('.add-tech').on('click', function() {
		    	var n = parseInt($('#n').val());
		    	n += 1;
		        $.ajax({url: "?r=work-order/get-technician", success: function(data){
		            $('.technician-add').append('<div class="tec-'+n+'">' + data + '<div class="col-sm-1"><a href="javascript:unassignStaff('+n+')">Unassign</a></div></div>');
		            $('#n').val(n);
		        }});
		    });





		/*********************************************************
		 *	WORK ORDER :: Unassign Staff
		 *
		*********************************************************/
		    function unassignStaff(id){
		    	$('.tec-' + id ).empty();
		    }




	/*********************************************************
	 *
	 *	STOCK OUT
	 *
	 *
	*********************************************************/

		/*********************************************************
		 *	WORK ORDER :: Get the maximum stock quantity for stock out
		 *
		*********************************************************/
	    	function changeAvailableStock() {

				var selectedStockPartId = $('#so-part_id').val();

			 	$('#so-qty').val('');
			 	$('#so-st_qty').val('');

		        $.post("?r=stock/ajax-checkstock",{
		            selectedStockPartId:selectedStockPartId
		        },
		        function(data, status){
			        returnData = JSON.parse(data);
			        var partId = returnData['partId'];
			        var totalAddedQty = 0;
			        var totalAvailableQty = parseFloat(returnData['stQty']);
			        $(".stock-qty-" + partId).each(function() {
					    totalAddedQty += parseFloat($(this).val());
					});
					totalAvailableQty -= totalAddedQty;
			        // check through the form here, to get the added qty
			        $('#so-st_qty').val(parseFloat(totalAvailableQty).toFixed(3));
		        });
	    	}

			$('#so-part_id').change(function(){
				changeAvailableStock();
			});

		/*********************************************************
		 *	WORK ORDER :: Limit the qty input for stock out
		 *
		*********************************************************/

			$('#so-qty').keyup(function(){
				checkStockInput();
			});


			function checkStockInput() {
				var soQty = 0;
				if ( parseFloat($('#so-qty').val()) > 0 ) {
					soQty = parseFloat($('#so-qty').val());
				}
				var stQty = parseFloat($('#so-st_qty').val());

				if ( soQty > stQty ) {
					alert('Not enough stock!');
					$('#so-qty').val(0);
				}

			}


		/*********************************************************
		 *	WORK ORDER :: Add Stock Required
		 *
		*********************************************************/

			function addStockRequired() {

				var soQty = $('#so-qty').val();
				var soPartId = $('#so-part_id').val();
				var soRemark = $('#so-remark').val();
				var soUom = $('#so-uom').val();

				var stQty = $('#so-st_qty').val();

				if ( soPartId == 'empt' ) {
			 		alert('Please select stock');
		 		} else {

				 	var n = $('#n').val();

				    n ++ ;

					$.post("?r=stock/ajax-addstock",{
						n:n,
				        soQty:soQty,
				        soPartId:soPartId,
				        soRemark:soRemark,
				        stQty:stQty,
				        soUom:soUom,
				    },
				    function(data, status){
				        // console.log(data);
				        $('.added-required').append(data);
				    });

				 	$('#n').val(n);
				 	$('#so-qty').val('');
				 	$('#so-part_id').select2("val", "empt");
				 	$('#so-remark').val('');
				 	$('#so-st_qty').val('');


		 		}
			}

		/*********************************************************
		 *	WORK ORDER :: Stock Requisition change work order id
		 *
		*********************************************************/
			$('.selected-wo').change(function() {
				var selectedWo = $('.selected-wo').val();
				window.location = '?r=work-order/issue&work_order=' + selectedWo;
			});

		/*********************************************************
		 *	WORK ORDER :: Stock Return change work order id
		 *
		*********************************************************/
			$('.selected-wo-return').change(function() {
				var selectedWo = $('.selected-wo-return').val();
				window.location = '?r=work-order/return&work_order=' + selectedWo;
			});


		/*********************************************************
		 *	WORK ORDER :: Remove Stock
		 *
		*********************************************************/
			function removeStock(n) {
			 	$('.stock-added-'+n).remove();
			 	$('#so-qty').val('');
			 	$('#so-part_id').val('');
			 	$('#so-remark').val('');
			 	$('#so-st_qty').val('');
				changeAvailableStock();

				// if the stock id is selected then add the quantity back to the so-st_qty
			}



		/*********************************************************
		 *	WORK ORDER :: Submit stock out
		 *
		*********************************************************/
			$('.submit-btn').click(function(e){

				if( $('#gt').val() ) {
					var r = confirm("Are you sure you want to submit?");
					if ( r == true ) {
						$('.stock-out-form form').submit();
					}

				} else {
					alert('Please add stock!');
				}
			}) ;
			$('.submit-btn-return').click(function(e){

				if( $('#gt').val() ) {
					var r = confirm("Are you sure you want to submit?");
					if ( r == true ) {
						$('.stock-return-form form').submit();
					}

				} else {
					alert('Please add stock!');
				}
			}) ;

		/*************************************************************
		 *	WORK ORDER :: Stock return refresh page with work order id
		 *
		*************************************************************/
			$('.return-wo').change(function(e){
				var workOrderId = $('.return-wo').val();
				window.location = '?r=work-order/return&woid=' + workOrderId;
			});



    /*********************************************************
	 *
	 *	AFTER WORK ORDER
	 *
	 *
	*********************************************************/



		/*********************************************************
		 *	WORK ORDER :: Add ARC records
		 *
		*********************************************************/
			// function addWorkOrderArc() {
			// 	var appen = "<div class='col-sm-12 col-xs-12'><div class='form-group field-datepicker5'><div class='col-sm-3 text-right'><label class='control-label' for='datepicker5'>Date</label></div><div class='col-sm-9 col-xs-12'><input type='text' id='datepicker5' class='form-control' name='WorkOrderArc[date][]'><div class='help-block'></div></div></div></div>";
			// 	appen += "<div class='col-sm-12 col-xs-12'><div class='form-group field-workorder-type'><div class='col-sm-3 text-right'><label class='control-label' for='workorder-type'>Type</label></div><div class='col-sm-9 col-xs-12'><select id='workorder-type' class='form-control' name='WorkOrder[type][]'><option value='EASA'>EASA</option><option value='FAA'>FAA</option><option value='CAAS'>CAAS</option></select><div class='help-block'></div></div></div></div>";
			// 	$('.arc-box').append(appen);
			// }

		/*********************************************************
		 *	WORK ORDER :: Print Final Inspection
		 *
		*********************************************************/
			function getFinal(){
				var selection = $('#final-inspection-selection').val();
				$.post("?r=work-order/ajax-getfinal",{
					selection:selection
			    },
			    function(data, status){
			    	if (data != false){
			        	returnData = JSON.parse(data);
			        	$('.final-title').empty();
			        	$('.final-title').append('<strong>' + returnData['title'] + '</strong>');
			        	$('.final-content').empty();
			        	$('.final-content').append(returnData['content']);
			        	$('.final-form-no').empty();
			        	$('.final-form-no').append(returnData['form_no']);
			    	} else {
			        	console.log('data');
			    	}
			    });

			}


		/*********************************************************
		 *	WORK ORDER :: Add discrepancy
		 *
		*********************************************************/
		    function addDiscrepancy(){
		        var noLoop = parseInt($('#noLoop').val());
		        $.post("?r=work-order/add-discrepancy",
		        function(data, status){
		            $('.extra-discrepancy').append(data);
		        });
		    }


		/*********************************************************
		 *	WORK ORDER :: Add discrepancy for hidden damage
		 *
		*********************************************************/
		    function addHiddenDiscrepancy(){
		        var noLoop = parseInt($('#noLoop').val());

		        $.post("?r=work-order/add-hdiscrepancy",
		        function(data, status){
		            $('.extra-hdiscrepancy').append(data);
		        });
		    }

/*********************************************************
 *
 *	DELIVERY ORDER
 *
 *
*********************************************************/


		/*********************************************************
		 *	DELIVERY ORDER :: Add in do detail
		 *
		*********************************************************/
		    function addDODetail(){

		        var noLoop = parseInt($('#noLoop').val());

		        $.post("?r=delivery-order/ajax-part",{
		            noLoop:noLoop
		        },
		        function(data, status){
		            $('.do-detail-body').append(data);
	        		$('#noLoop').val(noLoop+1);
		        });
		    }



		/*********************************************************
		 *	DELIVERY ORDER :: GET CUSTOMER ADDRESS
		 *
		*********************************************************/
			$('#deliveryorder-customer_id').change(function(){
				var customerId = $('#deliveryorder-customer_id').val();

				$.post("?r=delivery-order/ajax-address",{
			        customerId:customerId
			    },
			    function(data, status){
			    	$('#deliveryorder-ship_to').empty();
			    	$('#deliveryorder-ship_to').append(data);
			    });
			});

/*********************************************************
 *
 *	TRAVELLER
 *
 *
*********************************************************/


		/*********************************************************
		 *	TRAVELLER :: Discontinue
		 *
		*********************************************************/
		    $('#traveller-status').change(function(){
				var st = $('#traveller-status').val();
				if ( st == 'inactive') {
					$('.disc-reas').removeClass('hidden');
				} else {
					$('.disc-reas').addClass('hidden');
				}
		    });


/*********************************************************
 *
 *	CALIBRATION
 *
 *
*********************************************************/


		/*********************************************************
		 *	CALIBRATION :: Select tool from the tool index
		 *
		*********************************************************/

	 	$('.calibrate-button').click(function(){
			var i = 0;
			var opurl = '';

			$('input:checkbox.tool-checkbox').each(function () {
				if ( this.checked ) {
					toolId = $(this).val().trim();
					opurl += encodeURI('&tid['+ i +']=' + toolId);
					i++;
				}
		  	});
		  	window.location = '?r=calibration/multiple' + opurl;
		 });
