
<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Umrah</li>
                            <li class="breadcrumb-item active">Umrah Draft Trips</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-0">
                        <div class="card-header">
                            <form id="search-aform">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Agents</label>
                                            <select name="agentID" class="form-control form-control-sm select2">
                                                <option value="">Select Agent</option>
                                                <?php echo \App\Models\Accounts\Agent::agent(); ?>

                                            </select>
                                        </div>
                                    </div>
                                    <!--col-->
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label style="visibility: hidden">dfafsfdfdff</label>
                                            <button type="button" class="btn btn-primary btn-xs" onclick="get_data(1)"><i class="fa fa-search"></i> </button>
                                        </div>
                                    </div>
                                </div>
                                <!--row-->
                            </form>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>trip#</th>
                                    <th>Company</th>
                                    <th>Agent</th>
                                    <th>PNR</th>
                                    <th>Arrival</th>
                                    <th>Departure</th>
                                    <th>Arrival Sector</th>
                                    <th>Departure Sector</th>
                                    <th>Total Pax</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="get_data"></tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <div class="pagination-panel"></div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function () {
            $(".select2").select2();
        })
        get_data(1);
        function get_data(page){
            $("#loader").show();
            $.ajax({
                url:"<?php echo e(url('agent_management/get_umrah_draft')); ?>?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                data:$("#search-aform").serialize(),
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        tt=Number(data.data[i].total_transport)+Number(data.data[i].total_hotel)+Number(data.data[i].total_visa)+Number(data.data[i].total_flight)+Number(data.data[i].transport_brn_price)+Number(data.data[i].hotel_brn_price);
                        htmlData += '<tr id="' + data.data[i].id + '">';
                        htmlData += '<td>' + (Number(i) + 1) + '</td>';
                        htmlData += '<td>uotrip00'+data.data[i].id+'</td>';
                        htmlData += '<td>'+data.data[i].comp_name+'</td>';
                        htmlData+='<td>'+data.data[i].agentName+'</td>';
                        htmlData += '<td>'+data.data[i].pnr+'</td>';
                        htmlData += '<td>'+data.data[i].arr_date+' '+data.data[i].arr_time+'</td>';
                        htmlData += '<td>'+data.data[i].dep_date+' '+data.data[i].dep_dime+'</td>';
                        htmlData += '<td>'+data.data[i].arr_sector+'</td>';
                        htmlData += '<td>'+data.data[i].dep_sector+'</td>';
                        htmlData += '<td>'+data.data[i].totalPax+'</td>';
                        htmlData += '<td>'+(tt).toFixed(2)+'</td>';
                        htmlData += '<td>';
                        htmlData += '<a  class="btn btn-primary btn-xs" href="<?php echo e(url('agent_management/agent_umrah/')); ?>/'+data.data[i].id+'/edit"><i class="fa fa-eye"></i> View</a>';
                        htmlData += '</td>';
                        htmlData += '</tr>';
                    }
                    $("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                    $("#loader").hide();
                }
            })
        }

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/agents/umrah_draft/index.blade.php ENDPATH**/ ?>