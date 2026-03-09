<style>
    .form-group{ margin-bottom: 0.2rem !important;}
    ul{
        list-style: none !important;
        padding: 0px !important;
    }
    .ms-options-wrap > .ms-options > ul label{
        padding: 4px 4px;
    }
    .day_rate label{ font-style: italic; color: red; text-align: center}
</style>
<div class="modal" id="new">
    <div class="modal-dialog modal-xl" style="max-width:98%;">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-warning">
                    <h5 class="modal-title">Hotel Rate</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">City</label>
                            <select name="city_id" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                <?php echo App\Models\City::dropdown(); ?>

                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Hotel Name</label>
                            <select name="hotel_id" class="form-control form-control-sm select2" onchange="add_new_hotel(this)">
                                <option value="">Select Hotel</option>
                                <?php echo App\Models\Hotel::dropdown(); ?>

                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Contact Number</label>
                            <input type="text" name="contact" class="form-control form-control-sm" placeholder="Contact Number">
                        </div>
                        
                            
                            
                                
                                
                            
                        
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Room Type</label>
                            <select name="room_type" class="form-control form-control-sm select2" onchange="add_new_room(this)">
                                <option value="">Select Room</option>
                                <?php echo \App\Helpers\CommonHelper::room_type(); ?>

                            </select>
                        </div>
                    </div>
                    <!--row-->
                    <div class="row">
                        <div class="col-md-12" id="room_type">
                            <h6 class="timeline-header bg-lightblue p-1"><a href="#">Room Details</a></h6>
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Purchase</label>
                                        <input type="text" name="purchase" class="form-control form-control-sm purchase_price sp " onkeyup="calculate_rate(this)" onkeyup="calculate_rate(this)" placeholder="Enter..." >
                                    </div>
                                </div>
                                <!--col-->
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Sale Tax</label>
                                        <input type="text" name="sale_tax" class="form-control form-control-sm sale_tax sst" onkeyup="calculate_rate(this)" onkeyup="calculate_rate(this)" placeholder="Enter..." >
                                    </div>
                                </div>
                                <!--col-->
                                <div class="form-group col-md-1">
                                    <label>VAT</label>
                                    <input type="text" name="vat" class="form-control form-control-sm vat svat" onkeyup="calculate_rate(this)" placeholder="Enter..">
                                </div>
                                <!--col-->
                                <div class="form-group col-md-1">
                                    <label>With Holding</label>
                                    <input type="text" name="wh" class="form-control form-control-sm wh swh" onkeyup="calculate_rate(this)" onkeyup="calculate_rate(this)" placeholder="Enter..." >
                                </div>
                                <!--col-->
                                <div class="form-group col-md-1">
                                    <label style="font-size: 12px">Other Charges</label>
                                    <input type="text" name="oc" class="form-control form-control-sm oc soc" onkeyup="calculate_rate(this)" placeholder="Enter..">
                                </div>
                                <!--col-->
                                <div class="form-group col-md-1">
                                    <label>Net Cost</label>
                                    <input type="text" name="net_purchase" class="form-control form-control-sm net_sale snet" onkeyup="calculate_rate(this)" onkeyup="calculate_rate(this)" placeholder="Enter..." >
                                </div>
                                <!--col-->
                                
                                    
                                    
                                        
                                    
                                
                                
                                
                                    
                                    
                                        
                                        
                                    
                                
                                
                                
                                    
                                    
                                
                                <div class="form-group col-md-1">
                                    <label>For Month</label>
                                    <select class="form-control form-control-sm" name="month">
                                        <?php for($i=1; $i<=12; $i++): ?>
                                        <option value="<?php echo e($i); ?>"><?php echo e(date("F", strtotime(date("Y") ."-". $i ."-01"))); ?></option>
                                            <?php endfor; ?>
                                    </select>
                                </div>
                                
                                    
                                
                            </div>
                            <!--row-->
                            <div class="row day_rate">
                                <?php for($i=1; $i<=31; $i++): ?>
                                    <div class="form-group col-md-1">
                                        <label><?php echo e($i); ?></label>
                                        <input type="text" name="validity_date_rate[<?php echo e($i); ?>]" class="form-control form-control-sm single_bed_rate validity_date_rate<?php echo e($i); ?>" placeholder="Enter">
                                    </div>
                                    <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    <!--row-->
                    
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_rec()">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div><?php /**PATH E:\new-projects\htdocs\uotrips\resources\views/providors/hotels/modal.blade.php ENDPATH**/ ?>