<div class="" style="width:100%; background: ;">


    <form name="poiForm" id="poiForm" method="post">
        <div class="selectlist">
            <h1>Manage point of interest</h1>
            <select class="select-list" name="parade_id" id="parade_id" onChange="displayPoi();">
                <option value="#">--- DEFAULT---</option>
                <?php
                foreach ($parades as $parade) {
                    echo '<option value=' . $parade->id . '>' . $parade->name . '</option>';
                }
                ;
                ?>
            </select>
            <br><br>



            <input type="text" name="name" id="name" placeholder="Name" required>
            <input type="text" name="lat" id="lat" placeholder="Latitude" required>
            <input type="text" name="lon" id="lon" placeholder="Longitude" required>
            <input type="text" name="category" id="category" placeholder="Category" required>
            <input type="text" name="image" id="image" placeholder="Image url" required>
            <input type="hidden" name="pointid" id="pointid">


            <button type="submit">Submit</button>
        </div>


    </form>
    <!-- <div id="poiContainer"></div> -->
    <!-- loader  -->

    <div id="loading"></div>


    <table id="poiContainer" class="selectlist"></table>
</div>


<script src="<?php echo base_url() ?>js/poi.js?v=1.0"></script>