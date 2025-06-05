<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <!-- Jumbotron dengan logo dan konten -->
        <div class="jumbotron p-5 rounded text-center shadow" style="background: linear-gradient(135deg, #e0f7fa, #fff); border: 2px solid #b2ebf2;">
            <!-- Logo Kampus -->
            <img src="<?php echo e(asset('storage/images/UGM_3D_NEW-1.jpg')); ?>" alt="Logo UGM" width="120" class="mb-4 rounded-circle border border-3" style="border-color: #ffd54f;">

            <!-- Judul -->
            <h1 class="display-5 mb-4 text-primary fw-bold">WEBGIS PGWEB LANJUT</h1>

            <!-- Informasi Praktikum -->
            <div class="mx-auto text-start bg-white p-4 rounded shadow-sm" style="max-width: 500px;">
                <h5 class="mb-3 text-center text-info">Informasi Praktikum</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-white">
                        <strong>Nama Praktikum:</strong> PGWEBL
                    </li>
                    <li class="list-group-item bg-white">
                        <strong>Nama:</strong> Mukhlish Sulthon Nashrullah
                    </li>
                    <li class="list-group-item bg-white">
                        <strong>NIM:</strong> 23/522421/SV/23692
                    </li>
                    <li class="list-group-item bg-white">
                        <strong>Kelas:</strong> A
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        .list-group-item strong {
            width: 180px;
            display: inline-block;
            color: #00796b;
        }

        .list-group-item {
            border: none;
            font-size: 16px;
            color: #37474f;
        }

        h1, h5 {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .jumbotron {
            animation: fadeInUp 0.8s ease-in-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.template', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\example-app\resources\views/home.blade.php ENDPATH**/ ?>