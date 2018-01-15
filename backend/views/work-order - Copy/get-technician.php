<?php 

    $data = '';
    if ( !empty ( $staffTechnician ) ) {
        foreach ( $staffTechnician as $t ) {
        	$tId = $t->id;
        	$tName = $t->name;
            $data .= "<option value='$tName'>$tName</option>";
            

        }
    } else {
        $data = '<option>No result found!</option>';
    }
?>

<div class="col-sm-6 col-xs-12">
	<div class="form-group field-workorderstaff-staff_name">
		<div class="col-sm-3 text-right">
		<label class="control-label" for="workorderstaff-staff_name">Technician</label>
		</div>
		<div class="col-sm-9 col-xs-12">
		<select id="workorderstaff-staff_name" class="form-control select2" name="WorkOrderStaff[staff_name][]">
			<?= $data ?>
		</select>
		<div class="help-block">
		</div>
		</div>
	</div>
	<div class="form-group field-workorderstaff-staff_type">
		<input type="hidden" id="workorderstaff-staff_type" class="form-control" name="WorkOrderStaff[staff_type][]" value="technician">
		<div class="help-block">
		</div>
	</div>
</div>
<div class="col-sm-5 col-xs-12">    
	<div class="form-group field-workorderstaff-staff_name">
		<div class="col-sm-3 text-right"><label class="control-label" for="workorderstaff-staff_name">Inspector</label></div>
		<div class="col-sm-9 col-xs-12"><select id="workorderstaff-staff_name" class="form-control" name="WorkOrderStaff[staff_name][]">
			<?= $data ?>
		</select>
		<div class="help-block"></div></div>
	</div>                                           													
	<div class="form-group field-workorderstaff-staff_type">
		<input type="hidden" id="workorderstaff-staff_type" class="form-control" name="WorkOrderStaff[staff_type][]" value="inspector">
		<div class="help-block"></div>
	</div>
</div>