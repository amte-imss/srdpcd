<?php foreach ($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach ($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
    <script src="<?php echo base_url('assets/tablero_tpl/js/material.min.js'); ?>" type="text/javascript"></script>


<div ng-class="panelClass" class="row">
    <div class="col col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body"><br>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row" style="margin:5px; overflow: auto;">
                            <div class="table table-container-fluid panel">
                                <?php
                                echo $output;

                                //pr($output);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
