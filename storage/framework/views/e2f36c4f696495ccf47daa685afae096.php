<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">
    <style>
        #map {
            width: 100%;
            height: calc(100vh - 56px);
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id="map"></div>

    <!-- Modal Edit Polyline-->
    <div class="modal fade" id="editpolylineModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Polyline--</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo e(route('polylines.update', $id)); ?>"enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="" class="form-control" id="name" name="name"
                                placeholder="Fill polyline name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="geom_polyline" class="form-label">Geometry</label>
                            <textarea class="form-control" id="geom_polyline" name="geom_polyline" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="image_polyline" name="image"
                                onchange="document.getElementById('preview-image-polyline').src = window.URL.createObjectURL(this.files[0])">
                            <img src="" alt="" id="preview-image-polyline" class="img-thumbnail"
                                width="400">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script src="https://unpkg.com/@terraformer/wkt"></script>
    <script>
        var map = L.map('map').setView([-6.176533094143277, 106.83062228220317], 15);

        var baseMaps = {
            "OpenStreetMap": L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }),
            "Esri WorldImagery": L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
                }),

            "CartoDB DarkMatter": L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/">CARTO</a>'
            })
        };

        baseMaps["OpenStreetMap"].addTo(map);

        L.control.layers(baseMaps).addTo(map);

        /* Digitize Function */
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            draw: false,
            edit: true,
            edit: {
                featureGroup: drawnItems,
                edit: true,
                remove: false
            }
        });

        map.addControl(drawControl);

        map.on('draw:edited', function(e) {
            var layers = e.layers;

            layers.eachLayer(function(layer) {
                var drawnJSONObject = layer.toGeoJSON();
                console.log(drawnJSONObject);

                var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);
                console.log(objectGeometry);

                var properties = drawnJSONObject.properties;
                console.log(properties);

                drawnItems.addLayer(layer);

                $('#name').val(properties.name);
                $('#description').val(properties.description);
                $('#geom_polyline').val(objectGeometry);
                $('#preview-image-polyline').attr('src', "<?php echo e(asset('storage/images')); ?>/" + properties
                    .image);
                $('#editpolylineModal').modal('show');
            });
        }); // <- Ini harus TEPAT menutup 'draw:edited' dan setelahnya kode dilanjutkan seperti biasa

        // GeoJSON Polylines (bukan Points)
        var polyline = L.geoJson(null, {
            onEachFeature: function(feature, layer) {
                drawnItems.addLayer(layer);

                var properties = feature.properties;
                var objectGeometry = Terraformer.geojsonToWKT(feature.geometry);

                layer.on({
                    click: function(e) {
                        $('#name').val(properties.name);
                        $('#description').val(properties.description);
                        $('#geom_polyline').val(objectGeometry);
                        $('#preview-image-polyline').attr('src', "<?php echo e(asset('storage/images')); ?>/" +
                            properties.image);
                        $('#editpolylineModal').modal('show');
                    },
                });
            },
        });

        $.getJSON("<?php echo e(route('api.polyline', $id)); ?>", function(data) {
            polyline.addData(data);
            map.addLayer(polyline);
            map.fitBounds(polyline.getBounds(), {
                padding: [100, 100]
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.template', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\example-app\resources\views/editpolyline.blade.php ENDPATH**/ ?>