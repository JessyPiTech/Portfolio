<div class="gallery-container">
    <div class="main-image-container flex-align-center">
        <button id="bouton-l" class="carousel-button carousel-button-left"><ion-icon class="iconD" name="chevron-back-outline"></ion-icon></button>
        <img src="<?php echo $projet_image; ?>" alt="<?php echo $projet_name; ?>" class="main-image">
        <button id="bouton-r" class="carousel-button carousel-button-right"><ion-icon class="iconD" name="chevron-forward-outline"></ion-icon></button>
    </div>
    <div class="thumbnails-container flex">
        <?php
        echo "<img src='$projet_image' alt='$projet_name' class='thumbnail active'>";
        
        if (!empty($additional_images)) {
            foreach ($additional_images as $image) {
                echo "<img src='$image' alt='Image supplémentaire du projet' class='thumbnail'>";
            }
        }
        ?>
    </div>
</div>
<script>
    const images = [
        '<?php echo $projet_image; ?>',
        <?php 
        if (!empty($additional_images)) {
            foreach ($additional_images as $image) {
                echo "'$image',";
            }
        }
        ?>
    ];
</script>
<script type="text/javascript" src="./static/js/scripts-gallery.js"></script>