
<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Api Management</li>
                            <li class="breadcrumb-item">Flight</li>
                            <li class="breadcrumb-item active">Booking Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <h5 class="card-header text-center">Flight Booking</h5>
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <address>
                                        <strong>Client Name:</strong> Muhammad Azeem Khalid<br>
                                        <strong>Payment Status:</strong> Pending<br>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <address>
                                        <i class="fa fa-phone"></i> <strong>Phone:</strong>923244659501<br>
                                        <strong>Email:</strong> info@uotrips.com<br>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>Booking ID:</b> 4F3S8J<br>
                                    <b>Payment Due:</b> 2/22/2014<br>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Passport</th>
                                            <th>Ticket</th>
                                            <th>Flight</th>
                                            <th>PNR</th>
                                            <th>Departure</th>
                                            <th>Arrival</th>
                                            <th>Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Naeem Khalid</td>
                                            <td>455-981-221</td>
                                            <td>123-776677-2</td>
                                            <td>655tr</td>
                                            <td>655tr</td>
                                            <td>2022-02-11 10:20</td>
                                            <td>2022-02-11 14:30</td>
                                            <td class="text-right">64.40$</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Hamza Khalid</td>
                                            <td>455-981-221</td>
                                            <td>123-776677-3</td>
                                            <td>655tr</td>
                                            <td>655tr</td>
                                            <td>2022-02-11 10:20</td>
                                            <td>2022-02-11 14:30</td>
                                            <td class="text-right">64.40$</td>
                                        </tr>
                                        <tr>
                                            <th class="text-right" colspan="8">Subtotal:</th>
                                            <td class="text-right">250.30$</td>
                                        </tr>
                                        <tr>
                                            <th  class="text-right" colspan="8">Taxes:</th>
                                            <td class="text-right">10.34$</td>
                                        </tr>
                                        <tr>
                                            <th  class="text-right" colspan="8">Total:</th>
                                            <td class="text-right">265.24$</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-12">
                                    <p class="lead"><strong>Payment Methods:</strong> Credit Card</p>
                                    <table style="width: 100%; font-family: sans-serif;position: relative;margin-top: 10px;font-size: 12px;">
                                        <tr>
                                            <th colspan="3" style="padding: 10px;padding-left: 3px; text-align: left;">Notes:</th>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="padding: 3px;text-align: left;">
                                                1.Guest check-out date is determined by "Tawaklana" Application and PCR test results.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="padding: 3px;text-align: left;padding-bottom: 20px;">
                                                2.In case, guest stay extends due to any reason at the quarantine facility then an
                                                additional number of nights and food charges will be charged in cash at hotel reception by SAR 500 per
                                                night.
                                        </tr>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                    <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                                    <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                        <i class="fas fa-download"></i> Generate PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/Api_managements/flights/bookings/booking_details.blade.php ENDPATH**/ ?>