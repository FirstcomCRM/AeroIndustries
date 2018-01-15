    <div class="col-sm-12 col-xs-12">    
        <div class="form-group field-workpreliminary-discrepancy">
            <div class="col-sm-3 text-right">
                <label class="control-label" for="workpreliminary-discrepancy">Discrepancy</label>
            </div>
            <div class="col-sm-9 col-xs-12">
                <textarea id="workpreliminary-discrepancy" class="form-control" name="WorkHiddenDamage[discrepancy][]" maxlength="2000" rows="4"></textarea>
                <div class="help-block">
                </div>
            </div>
        </div>
    </div> 


    <div class="col-sm-12 col-xs-12">    
        <div class="form-group field-workpreliminary-corrective">
            <div class="col-sm-3 text-right">
                <label class="control-label" for="workpreliminary-corrective">Corrective</label>
            </div>
            <div class="col-sm-9 col-xs-12">
                <textarea id="workpreliminary-corrective" class="form-control" name="WorkHiddenDamage[corrective][]" maxlength="2000" rows="4"></textarea>
                <div class="help-block">
                </div>
            </div>

        </div>
    </div>  


    <div class="col-sm-12 col-xs-12">    
        <div class="form-group field-workpreliminary-repair_supervisor">
            <div class="col-sm-3 text-right">
                <label class="control-label" for="workpreliminary-repair_supervisor">Repair Supervisor</label>
            </div>
            <div class="col-sm-9 col-xs-12">
                <select id="workpreliminary-repair_supervisor" class="select2 form-control" name="WorkHiddenDamage[repair_supervisor][]">
                <?php foreach ( $getStaff as $gS )  { ?>
                    <option value="<?=$gS->name?>"><?=$gS->name?></option>
                <?php } ?>
                </select>
                <div class="help-block">
                </div>
            </div>

        </div>
    </div>   
