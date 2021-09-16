<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Donation Report')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                <?php echo $__env->make('backend.partials.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php if(!empty($error_msg)): ?>
                    <div class="alert alert-danger"><?php echo e($error_msg); ?></div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title"><?php echo e(__("Donation Report")); ?></h4>
                        <form action="<?php echo e(route('admin.donations.report')); ?>" method="get" enctype="multipart/form-data" id="report_generate_form">
                            <input type="hidden" name="page" value="1">
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="start_date"><?php echo e(__('Start Date')); ?></label>
                                        <input type="date" name="start_date" value="<?php echo e($start_date); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="end_date"><?php echo e(__('End Date')); ?></label>
                                        <input type="date" name="end_date" value="<?php echo e($end_date); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="payment_status"><?php echo e(__('Payment Status')); ?></label>
                                        <select name="payment_status" id="order_status" class="form-control">
                                            <option value=""><?php echo e(__('All')); ?></option>
                                            <option <?php if( $payment_status == 'pending'): ?> selected <?php endif; ?> value="pending"><?php echo e(__('Pending')); ?></option>
                                            <option <?php if( $payment_status == 'complete'): ?> selected <?php endif; ?> value="complete"><?php echo e(__('Complete')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="items"><?php echo e(__('Items')); ?></label>
                                        <select name="items" id="items" class="form-control">
                                            <option <?php if( $items == '10'): ?> selected <?php endif; ?> value="10"><?php echo e(__('10')); ?></option>
                                            <option <?php if( $items == '20'): ?> selected <?php endif; ?> value="20"><?php echo e(__('20')); ?></option>
                                            <option <?php if( $items == '50'): ?> selected <?php endif; ?> value="50"><?php echo e(__('50')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4"><?php echo e(__('Submit')); ?></button>
                                    <?php if(!empty($order_data) && count($order_data) > 0): ?>
                                        <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" id="download_as_csv"><i class="fas fa-download"></i> <?php echo e(__('CSV')); ?></button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php if(!empty($order_data)): ?>
                    <div class="card">
                        <div class="card-body">
                            <?php if(count($order_data) > 0): ?>
                                <div class="table-wrap">
                                    <table class="table table-bordered">
                                        <thead>
                                        <th><?php echo e(__('Order ID')); ?></th>
                                        <th><?php echo e(__('Billing Name')); ?></th>
                                        <th><?php echo e(__('Billing Email')); ?></th>
                                        <th><?php echo e(__('Amount')); ?></th>
                                        <th><?php echo e(__('Payment Gateway')); ?></th>
                                        <th><?php echo e(__('Payment Status')); ?></th>
                                        <th><?php echo e(__('Transaction ID')); ?></th>
                                        <th><?php echo e(__('Date')); ?></th>
                                        </thead>
                                        <tbody>
                                        <?php $__currentLoopData = $order_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($data->id); ?></td>
                                                <td><?php echo e($data->name); ?></td>
                                                <td><?php echo e($data->email); ?></td>
                                                <td><?php echo e(amount_with_currency_symbol($data->amount)); ?></td>
                                                <td><strong><?php echo e(ucwords(str_replace('_',' ',$data->payment_gateway))); ?></strong></td>
                                                <td>
                                                    <?php if($data->status == 'pending'): ?>
                                                        <span class="alert alert-warning text-capitalize"><?php echo e(str_replace('-',' ',$data->status)); ?></span>
                                                    <?php else: ?>
                                                        <span class="alert alert-success text-capitalize"><?php echo e(str_replace('-',' ',$data->status)); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($data->transaction_id); ?></td>
                                                <td><?php echo e(date_format($data->created_at,'d M Y')); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="pagination-wrapper report-pagination">
                                    <?php echo $order_data->links(); ?>

                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning"><?php echo e(__('No Item Found')); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        $(document).ready(function (){
            $(document).on('click','.report-pagination nav ul li a',function (e){
                e.preventDefault();
                var el = $(this);
                var href = el.attr('href');
                var match = href.match(/(:?=)\d+/);
                var pageNumber = match != null ? match[0].replace('=',' ') : '';
                $('input[name="page"]').val(pageNumber.trim());
                $('#report_generate_form').submit();
            });

            $(document).on('click','#download_as_csv',function (e){
                e.preventDefault();
                exportTableToCSV('product-order-report.csv');
            });

            function downloadCSV(csv, filename) {
                var csvFile;
                var downloadLink;

                // CSV file
                csvFile = new Blob([csv], {type: "text/csv"});

                // Download link
                downloadLink = document.createElement("a");

                // File name
                downloadLink.download = filename;

                // Create a link to the file
                downloadLink.href = window.URL.createObjectURL(csvFile);

                // Hide download link
                downloadLink.style.display = "none";

                // Add the link to DOM
                document.body.appendChild(downloadLink);

                // Click download link
                downloadLink.click();
            }

            function exportTableToCSV(filename) {
                var csv = [];
                var rows = document.querySelectorAll("table tr");

                for (var i = 0; i < rows.length; i++) {
                    var row = [], cols = rows[i].querySelectorAll("td, th");

                    for (var j = 0; j < cols.length; j++)
                        row.push(cols[j].innerText);

                    csv.push(row.join(","));
                }

                // Download CSV file
                downloadCSV(csv.join("\n"), filename);
            }


        });


    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/backend/donations/donation-report.blade.php ENDPATH**/ ?>