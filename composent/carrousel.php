<div class="carousel-full flex-align-center">
    <button id="monBoutong" class="carousel-button carousel-button-left"><ion-icon class="iconD" name="chevron-back-outline"></ion-icon></button>
    <div id="monElement" class="carousel-container flex-align-center">
        <div id="monElementIn" class="carousel-inner flex-align-center">
            <?php
                require_once "coDB.php";
                $conn = connectDB();
                $sql = "
                    SELECT p.Projet_id, p.Projet_name, p.Projet_descipt, p.category_name, p.Projet_link, p.Projet_image, p.Projet_Pro, o.outil_name, o.outil_img 
                    FROM projet AS p
                    LEFT JOIN projet_outil AS po ON p.Projet_id = po.projet_id
                    LEFT JOIN outil AS o ON po.outil_id = o.outil_id
                    ORDER BY p.Projet_id, o.outil_id;
                ";  
                $result = $conn->query($sql);   
                if ($result->num_rows > 0) {
                    $current_project_id = null;
                    $tool_count = 0;
                
                    while ($row = $result->fetch_assoc()) {
                        if ($row['Projet_Pro'] === 'none') {
                            continue;
                        }
                
                        if ($current_project_id !== $row['Projet_id']) {
                            if ($current_project_id !== null) {
                                echo "</div></div></a>";
                            }
                            $current_project_id = htmlspecialchars($row['Projet_id']);
                            $tool_count = 0;
                            $projet_name = htmlspecialchars($row["Projet_name"]);
                            $projet_descipt = htmlspecialchars($row["Projet_descipt"]);
                            $category_name = htmlspecialchars($row["category_name"]);
                            $projet_link = htmlspecialchars($row["Projet_link"]);
                            $projet_image = htmlspecialchars($row["Projet_image"]);
                            echo "<a href='./projet.php?projet_id=" . $current_project_id . "' class='div6  produit-container-style flex-align-center colo1'>
                                    <div class='diap colo1'>
                                        <h2>$projet_name</h2>
                                    </div>
                                    <div class='description colo2'>
                                        <p>$projet_descipt</p>
                                        <div class='tools-container flex-align-center'>";
                        }
                        
                        if ($tool_count < 4 && !empty($row['outil_name'])) {
                            $outil_name = htmlspecialchars($row["outil_name"]);
                            $outil_img = htmlspecialchars($row["outil_img"]);

                            echo "<div class='flex-align-center'>
                                    <img src='$outil_img' alt='$outil_name' class='tool-image'>
                                    <span class='tool-name'>$outil_name</span>
                                  </div>";
                            $tool_count++;
                        }
                        
                    }
                    echo "</div></div></a>";
                } else {
                    echo "<h1>Aucun projet trouvé.</h1>";
                }
                $conn->close();
            ?>
        </div>
    </div>
    <button id="monBoutond" class="carousel-button carousel-button-right"><ion-icon class="iconD" name="chevron-forward-outline"></ion-icon></button>
</div>    

<script type="text/javascript" src="./static/js/scripts-mon-carrousel.js"></script>