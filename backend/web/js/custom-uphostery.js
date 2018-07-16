
/*********************************************************
 *	
 *	UPHOSTERY
 *	
 *	
*********************************************************/

		/*********************************************************
		 *	UPHOSTERY :: Ajax Search Parts
		 *	
		*********************************************************/

		    $('#uphosterypart-part_no').on('input', function() {
		        // $('.close-search').removeClass('display-none');
		        var partNoKeyed = $('#uphosterypart-part_no').val();
		        $.post("?r=uphostery/search-part",{
		            partNoKeyed:partNoKeyed
		        },
		        function(data, status){
		            $('#search-result').css('display', 'block');
		            $('#search-result').empty();
		            $('#search-result').append(data);
		        });

		    });


		    function upSelectPart(partNo=null) {
		    	var partNoText = "";
		    	partNoText = partNo;
	    	 	$('#uphosterypart-part_no').val(partNoText);	
	    	 	getUpTemplate();
		    }

		/************************************************************
		 *	UPHOSTERY :: index change multiple up's status at once
		 *	
		************************************************************/

			function update_up_status() {
				var uphosteryids = new Array();
				var status = $('#update-status-selection').val();
				var n = 0;
				$('.uphostery-checkbox').each(function () {
			       	uphosteryids[n] = (this.checked ? $(this).val() : "");
			       	n++;
			  	});

			  	$.post("?r=uphostery/update-status",{
		            uphosteryids:uphosteryids,
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
		 *	UPHOSTERY :: Search template by part no
		 *	
		*********************************************************/
		    function getUpTemplate() { 
		        var partNoTemp = $('#uphosterypart-part_no').val();
		        if ( partNoTemp != '' ) {
			        $.post("?r=work-order/get-template",{
			            partNoTemp:partNoTemp
			        },
			        function(data, status){
		        		var returnData = JSON.parse(data);
			            if ( returnData != false ) {
					    	$('#uphosterypart-template_id').val(returnData).change(); 
					    	$('.yes-template').removeClass('hidden');
			    			$('.no-template').addClass('hidden');
		    			}else {
					    	$('#uphosterypart-template_id').val('').change(); 
					    	$('.no-template').removeClass('hidden');
			    			$('.yes-template').addClass('hidden');
		    			}
			        });

			        $.post("?r=uphostery/get-desc",{
			            partNoTemp:partNoTemp
			        },
			        function(data, status){
			            if ( data != false ) {
			        		var returnData = JSON.parse(data);
					    	$('#uphosterypart-desc').val(returnData['description']).change(); 
					    	$('#uphosterypart-manufacturer').val(returnData['manufacturer']).change(); 
		    			} else {
					    	$('#uphosterypart-desc').val(''); 
		    			}
			        });
		        }
	        }

		    function addUpPart() { 
		        var n = parseInt($('#n').val());

		        var part_no = $('#uphosterypart-part_no').val();

		        if ( part_no != '') {
			        var desc = $('#uphosterypart-desc').val();
			        var manufacturer = $('#uphosterypart-manufacturer').val();
			        var model = $('#uphosterypart-model').val();
			        var ac_tail_no = $('#uphosterypart-ac_tail_no').val();
			        var ac_msn = $('#uphosterypart-ac_msn').val();
			        var serial_no = $('#uphosterypart-serial_no').val();
			        var batch_no = $('#uphosterypart-batch_no').val();
			        var location_id = $('#uphosterypart-location_id').val();
			        var template_id = $('#uphosterypart-template_id').val();
			        var quantity = $('#uphosterypart-quantity').val();

			        $.post("?r=uphostery/add-part",{
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
				        quantity:quantity
			        },
			        function(data, status){
			            if ( data != false ) {
			        		var returnData = JSON.parse(data);
					    	$('.part-added tbody').append(returnData); 
					    	n++;
					    	$('#n').val(n);
					    	$('.add-part-section #uphosterypart-part_no').val("");
					        $('.add-part-section #uphosterypart-desc').val("");
					        $('.add-part-section #uphosterypart-manufacturer').val("");
					        $('.add-part-section #uphosterypart-model').val("");
					        $('.add-part-section #uphosterypart-ac_tail_no').val("");
					        $('.add-part-section #uphosterypart-ac_msn').val("");
					        $('.add-part-section #uphosterypart-serial_no').val("");
					        $('.add-part-section #uphosterypart-batch_no').val("");
					        $('.add-part-section #uphosterypart-quantity').val("");
					    	$('#uphosterypart-template_id').val('').change(); 
					    	$('#uphosterypart-location_id').val('').change(); 
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

		    function editUpPart(n){
		    	$('#uphosterypart-id').val($('.edit-id-'+n).val());
		    	$('#uphosterypart-part_no').val($('.edit-part_no-'+n).val());
		    	$('#uphosterypart-manufacturer').val($('.edit-manufacturer-'+n).val());
		    	$('#uphosterypart-model').val($('.edit-model-'+n).val());
		    	$('#uphosterypart-desc').val($('.edit-desc-'+n).val());
		    	$('#uphosterypart-ac_tail_no').val($('.edit-ac_tail_no-'+n).val());
		    	$('#uphosterypart-model').val($('.edit-model-'+n).val());
		    	$('#uphosterypart-ac_tail_no').val($('.edit-ac_tail_no-'+n).val());
		    	$('#uphosterypart-ac_msn').val($('.edit-ac_msn-'+n).val());
		    	$('#uphosterypart-serial_no').val($('.edit-serial_no-'+n).val());
		    	$('#uphosterypart-batch_no').val($('.edit-batch_no-'+n).val());
		    	$('#uphosterypart-location_id').val($('.edit-location_id-'+n).val()).trigger('change.select2');
		    	$('#uphosterypart-quantity').val($('.edit-quantity-'+n).val());

		    	if (  $('.edit-template_id-'+n).val() != '' ) {
			    	$('.no-template').addClass('hidden');
	    			$('.yes-template').removeClass('hidden');
		    	}

		    	$('.add-button').addClass('hidden');
		    	$('.save-button').removeClass('hidden');
		    	$('#m').val(n);
		    }
        	

		    function saveUpPart() { 
		        var m = $('#m').val();

		       	$('.edit-id-'+m).val( $('#uphosterypart-id').val() );
		       	$('.display-part-no-'+m).html( $('#uphosterypart-part_no').val() );
		       	$('.edit-part_no-'+m).val( $('#uphosterypart-part_no').val() );
                $('.display-manufacturer-'+m).html($('#uphosterypart-manufacturer').val());
                $('.edit-manufacturer-'+m).val($('#uphosterypart-manufacturer').val());
                $('.display-model-'+m).html($('#uphosterypart-model').val());
                $('.edit-model-'+m).val($('#uphosterypart-model').val());
                $('.edit-desc-'+m).val($('#uphosterypart-desc').val());
                $('.edit-ac_tail_no-'+m).val($('#uphosterypart-ac_tail_no').val());
                $('.edit-model-'+m).val($('#uphosterypart-model').val());
                $('.edit-ac_tail_no-'+m).val($('#uphosterypart-ac_tail_no').val());
                $('.edit-ac_msn-'+m).val($('#uphosterypart-ac_msn').val());
                $('.edit-serial_no-'+m).val($('#uphosterypart-serial_no').val());
                $('.edit-batch_no-'+m).val($('#uphosterypart-batch_no').val());
                $('.edit-location_id-'+m).val($('#uphosterypart-location_id').val());
                $('.display-quantity-'+m).html($('#uphosterypart-quantity').val());
                $('.edit-quantity-'+m).val($('#uphosterypart-quantity').val());
                $('.edit-template_id-'+m).val($('#uphosterypart-template_id').val());

                $('.add-part-section #uphosterypart-id').val("");
                $('.add-part-section #uphosterypart-part_no').val("");
		        $('.add-part-section #uphosterypart-desc').val("");
		        $('.add-part-section #uphosterypart-manufacturer').val("");
		        $('.add-part-section #uphosterypart-model').val("");
		        $('.add-part-section #uphosterypart-ac_tail_no').val("");
		        $('.add-part-section #uphosterypart-ac_msn').val("");
		        $('.add-part-section #uphosterypart-serial_no').val("");
		        $('.add-part-section #uphosterypart-batch_no').val("");
		        $('.add-part-section #uphosterypart-quantity').val("");
		    	$('#uphosterypart-template_id').val('').change(); 
		    	$('#uphosterypart-location_id').val('').change(); 
		    	$('.no-template').removeClass('hidden');
    			$('.yes-template').addClass('hidden');
		    	$('.add-button').removeClass('hidden');
		    	$('.save-button').addClass('hidden');
    			$('.empty-cart').remove();
		    }


		    function removeUpPart(n){
				var r = confirm("Are you sure to remove the part from this uphostery?");
				if (r == true) {
			    	$('.edit-deleted-'+n).val(1);
			    	$('.part-'+n).css('display','none');	
				} 
		    }

		/*********************************************************
		 *	UPHOSTERY :: Add Technician Column
		 *	
		*********************************************************/
		    $('.add-up-tech').on('click', function() { 
		    	var n = parseInt($('#n').val());
		    	n += 1;
		        $.ajax({url: "?r=uphostery/get-technician", success: function(data){
		            $('.technician-add').append('<div class="tec-'+n+'">' + data + '<div class="col-sm-1"><a href="javascript:unassignStaff('+n+')">Unassign</a></div></div>');
		            $('#n').val(n);
		        }});
		    });


                                                        
                                                    

		/*********************************************************
		 *	UPHOSTERY :: Unassign Staff
		 *	
		*********************************************************/
		    function unassignUpStaff(id){
		    	$('.tec-' + id ).empty();
		    }


    /*********************************************************
	 *	
	 *	AFTER UPHOSTERY
	 *	
	 *	
	*********************************************************/



		/*********************************************************
		 *	UPHOSTERY :: Add ARC records
		 *	
		*********************************************************/
			// function addUphosteryArc() {
			// 	var appen = "<div class='col-sm-12 col-xs-12'><div class='form-group field-datepicker5'><div class='col-sm-3 text-right'><label class='control-label' for='datepicker5'>Date</label></div><div class='col-sm-9 col-xs-12'><input type='text' id='datepicker5' class='form-control' name='UphosteryArc[date][]'><div class='help-block'></div></div></div></div>";
			// 	appen += "<div class='col-sm-12 col-xs-12'><div class='form-group field-uphostery-type'><div class='col-sm-3 text-right'><label class='control-label' for='uphostery-type'>Type</label></div><div class='col-sm-9 col-xs-12'><select id='uphostery-type' class='form-control' name='Uphostery[type][]'><option value='EASA'>EASA</option><option value='FAA'>FAA</option><option value='CAAS'>CAAS</option></select><div class='help-block'></div></div></div></div>";
			// 	$('.arc-box').append(appen);
			// }

		/*********************************************************
		 *	UPHOSTERY :: Print Final Inspection
		 *	
		*********************************************************/
			function getUpFinal(){ 
				var selection = $('#final-inspection-selection').val();
				$.post("?r=uphostery/ajax-getfinal",{
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
		 *	UPHOSTERY :: Add discrepancy
		 *	
		*********************************************************/
		    function addUpDiscrepancy(){
		        var noLoop = parseInt($('#noLoop').val());
		        $.post("?r=uphostery/add-discrepancy",
		        function(data, status){
		            $('.extra-discrepancy').append(data);
		        });
		    }


		/*********************************************************
		 *	UPHOSTERY :: Add discrepancy for hidden damage
		 *	
		*********************************************************/
		    function addUpHiddenDiscrepancy(){
		        var noLoop = parseInt($('#noLoop').val());

		        $.post("?r=uphostery/add-hdiscrepancy",
		        function(data, status){
		            $('.extra-hdiscrepancy').append(data);
		        });
		    }

		/*********************************************************
		 *	UPHOSTERY :: CHECKLIST
		 *
		*********************************************************/

		
			$('#checklistModalUp').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) ;
				var uphostery_id = button.data('uphostery_id') ;
				var uphostery_part_id = button.data('uphostery_part_id') ;
				// $('#modal-req-id').val(reqid);
				// get drop down
				$.post("?r=uphostery/get-checklist",{
		            uphostery_part_id:uphostery_part_id
		        },
		        function(data, status){
		        	$('#checklistModalUp .modal-body').html(data);
		        });
			});
