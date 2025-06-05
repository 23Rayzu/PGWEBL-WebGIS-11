<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map {
            width: 100%;
            height: 400px;
            margin-bottom: 20px;
        }

        .table th, .table td {
            vertical-align: middle;
            word-break: break-word;
        }

        .col-id { width: 60px; }
        .col-name { width: 150px; }
        .col-desc { width: 250px; }
        .col-image { width: 120px; }
        .col-date { width: 160px; }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt">

        
        <h4>Points</h4>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="col-id">No</th>
                        <th class="col-name">Name</th>
                        <th class="col-desc">Descriptions</th>
                        <th class="col-image">Image</th>
                        <th class="col-date">Created At</th>
                        <th class="col-date">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $points; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($p->id); ?></td>
                        <td><?php echo e($p->name); ?></td>
                        <td><?php echo e($p->description); ?></td>
                        <td>
                            <?php if($p->image): ?>
                                <img src="<?php echo e(asset('storage/images/'.$p->image)); ?>" alt="" class="img-thumbnail" width="100">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td><?php echo e(\Carbon\Carbon::parse($p->created_at)->format('d M Y')); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($p->updated_at)->format('d M Y')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        
        <h4>Polylines</h4>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="col-id">No</th>
                        <th class="col-name">Name</th>
                        <th class="col-desc">Descriptions</th>
                        <th class="col-image">Image</th>
                        <th class="col-date">Created At</th>
                        <th class="col-date">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $polylines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($p->id); ?></td>
                        <td><?php echo e($p->name); ?></td>
                        <td><?php echo e($p->description); ?></td>
                        <td>
                            <?php if($p->image): ?>
                                <img src="<?php echo e(asset('storage/images/'.$p->image)); ?>" alt="" class="img-thumbnail" width="100">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td><?php echo e(\Carbon\Carbon::parse($p->created_at)->format('d M Y')); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($p->updated_at)->format('d M Y')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        
        <h4>Polygons</h4>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="col-id">No</th>
                        <th class="col-name">Name</th>
                        <th class="col-desc">Descriptions</th>
                        <th class="col-image">Image</th>
                        <th class="col-date">Created At</th>
                        <th class="col-date">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $polygons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($p->id); ?></td>
                        <td><?php echo e($p->name); ?></td>
                        <td><?php echo e($p->description); ?></td>
                        <td>
                            <?php if($p->image): ?>
                                <img src="<?php echo e(asset('storage/images/'.$p->image)); ?>" alt="" class="img-thumbnail" width="100">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td><?php echo e(\Carbon\Carbon::parse($p->created_at)->format('d M Y')); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($p->updated_at)->format('d M Y')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.template', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\example-app\resources\views/table.blade.php ENDPATH**/ ?>