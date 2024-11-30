<?php require_once "./composent/head.php"; ?>


<?php 
require_once "coDB.php";
$conn = connectDB();
$projet_id = isset($_GET['projet_id']) ? intval($_GET['projet_id']) : null;

if ($projet_id) {
    $sql = "
        SELECT 
            p.Projet_id, 
            p.Projet_name, 
            p.Projet_descipt, 
            p.category_name, 
            p.Projet_link, 
            p.Projet_image, 
            p.Projet_Pro, 
            p.Projet_En_Cours,
            o.outil_id,
            o.outil_name, 
            o.outil_img,
            GROUP_CONCAT(DISTINCT pi.image_path) AS additional_images
        FROM 
            projet AS p
        LEFT JOIN 
            projet_outil AS po ON p.Projet_id = po.projet_id
        LEFT JOIN 
            outil AS o ON po.outil_id = o.outil_id
        LEFT JOIN 
            projet_image AS pi ON p.Projet_id = pi.projet_id
        WHERE 
            p.Projet_id = ?
        GROUP BY 
            p.Projet_id, o.outil_id
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $projet_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $tools = array(); 
        $additional_images = array();
        $first_row = true;

        while($row = $result->fetch_assoc()) {
            if ($first_row) {
                $projet_id = $row['Projet_id'];
                $projet_name = htmlspecialchars($row['Projet_name']);
                $projet_descipt = htmlspecialchars($row['Projet_descipt']);
                $category_name = htmlspecialchars($row['category_name']);
                $projet_link = htmlspecialchars($row['Projet_link']);
                $projet_image = htmlspecialchars($row['Projet_image']);
                $projet_pro = $row['Projet_Pro'];
                $projet_en_cours = $row['Projet_En_Cours'];

                if (!empty($row['additional_images'])) {
                    $additional_images = array_map('htmlspecialchars', explode(',', $row['additional_images']));
                }
                
                $first_row = false;
            }

            if (!empty($row['outil_name'])) {
                $tools[] = array(
                    'id' => $row['outil_id'],
                    'name' => htmlspecialchars($row['outil_name']),
                    'image' => htmlspecialchars($row['outil_img'])
                );
            }
        }
    } else {
        echo "<h1>Aucun projet trouvé.</h1>";
    }
    
    $stmt->close();
} else {
    echo "<h1>Identifiant de projet non spécifié.</h1>";
}

$conn->close();
$tool_count = 0;

?>
<main class="flex-align-center">
    <div class="produit-container flex">

        <?php require_once "./composent/gallery.php"; ?>

        <div class="content-wrapper-produit flex">
            <?php
                echo "<div class='content-section-produit flex'><h1>$projet_name</h1>
                      <p>$projet_descipt</p>";
                
                if (!empty($projet_link)) {
                    echo "<a class='button-spe' href='$projet_link' target='_blank'>Voir le projet</a></div>";
                }

                if (!empty($tools) && $tool_count < 4) {
                    echo "<div class='tools-container flex-align-center'>";
                    foreach ($tools as $tool) {
                        if ($tool_count >= 4) break; 
                        
                        $tool_name = htmlspecialchars($tool['name']);
                        $tool_image = htmlspecialchars($tool['image']);
                        echo "
                        <div class='flex-align-center'>
                            <img src='$tool_image' alt='$tool_name' class='tool-image'>
                            <span class='tool_name'>$tool_name</span>
                        </div>";
                        $tool_count++;
                    }
                    echo "</div>";
                }
            ?>
        </div>
    </div>
    <?php require_once "./composent/carrousel.php"; ?>
</main>

<?php require_once "./composent/foot.php"; ?>
