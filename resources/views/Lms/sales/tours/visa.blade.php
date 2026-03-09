<div class="tab-pane fade" id="tour-visa" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
    <form id="tour-visa-form">
        <input type="hidden" name="id" value="0">
        <input type="hidden" name="account_code" value="{{ $result[0]->ledger }}">
                <div class="row">
                    <div class="form-group col-md-12">
                        <select name="pax_name[]" class="form-control form-control-sm select2 tour_pax_list" multiple></select>
                    </div>
                    <!--col-->
                    <div class="form-group col-md-2">
                        <label for="exampleInputEmail1">Visa Type</label>
                        <select name="visa_type" class="form-control form-control-sm select2">
                            {!! App\Helpers\CommonHelper::visa_type() !!}
                        </select>
                    </div>
                    <!--col-->
                    <div class="form-group col-md-2">
                        <label>Visa No.</label>
                        <input name="visa_no" type="text" class="form-control form-control-sm" placeholder="Visa Number">
                    </div>
                    <!--col-->
                    <div class="form-group col-md-2">
                        <label for="exampleInputEmail1">Visa Country</label>
                        <select name="visa_country" class="form-control form-control-sm select2">
                            {!! App\Models\Country::dropdown() !!}
                        </select>
                    </div>
                    <!--col-->
                    <div class="form-group col-md-2">
                        <label>Visa Rate</label>
                        <input type="text" name="receiveable" class="form-control form-control-sm" placeholder="Visa Rate">
                    </div>
                    <!--col-->
                    <div class="form-group col-md-2">
                        <label for="exampleInputEmail1">Currency</label>
                        <select name="currency" class="form-control form-control-sm">
                            <option value="">Pkr</option>
                        </select>
                    </div>
                    <!--col-->
                    <div class="form-group col-md-2">
                        <label for="exampleInputEmail1">Currency Rate</label>
                        <input type="text" name="currency_rate" class="form-control form-control-sm" placeholder="Currency Rate">
                    </div>
                    <!--col-->
                </div>
                <!-- Modal footer -->
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-xs" onclick="save_tour_rec('{{ url('lms/tour_visa_store') }}', 'tour-visa-form', 'visa')">Submit</button>
                    <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal" onclick="close_form(5)">Close</button>
                </div>
                <div class="modal-footer">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr class="table-active">
                                <th>#</th>
                                <th>passport</th>
                                <th>Pax Name</th>
                                <th>Visa No</th>
                                <th>Visa Type</th>
                                <th>Visa Country</th>
                                <th>Receiveable</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="get_visa_invDetails"></tbody>
                        </table>
                    </div>
                </div>
    </form>
</div>