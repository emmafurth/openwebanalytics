<div class="widget-PPM">

<script>
var test = new OWA.chart();
OWA.items['<?php echo $dom_id;?>'] = new OWA.chart();
OWA.items['<?php echo $dom_id;?>'].data = <?php echo json_encode($user_actions); ?>;
OWA.items['<?php echo $dom_id;?>'].render();

</script>
Test

</div>