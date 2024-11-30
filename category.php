<?php require_once "./composent/head.php"; ?>
<main>
    <?php
        $Projet_Pro = isset($_GET['Projet_Pro']) ? $_GET['Projet_Pro'] : null;
        echo "<div class='category-container flex-align-center' ><h1>$Projet_Pro</h1><div class='content-wrapper-category flex'>";

        require_once "coDB.php";
        $conn = connectDB();
        $sql = "
            SELECT 
                p.Projet_id, 
                p.Projet_name, 
                p.Projet_descipt, 
                p.category_name, 
                p.Projet_link, 
                p.Projet_image, 
                p.Projet_Pro, 
                o.outil_name, 
                o.outil_img 
            FROM 
                projet AS p
            LEFT JOIN 
                projet_outil AS po ON p.Projet_id = po.projet_id
            LEFT JOIN 
                outil AS o ON po.outil_id = o.outil_id
            ORDER BY 
                p.Projet_id, 
                o.outil_id;
        ";
        $result = $conn->query($sql);   
        if ($result->num_rows > 0) {
            $current_project_id = null;
            $tool_count = 0;
            
            while ($row = $result->fetch_assoc()) {
                //on affiche l'ensembre des projet a condition qu'il soit categorise comme pro
                if ($row['Projet_Pro'] == $Projet_Pro) {

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
                        echo "<a href='./projet.php?projet_id=" . $current_project_id . "' class='div7 produit-container-style flex-align-center colo1'>
                                <div style='margin: 10%;' class='diap colo1'>
                                    <h2>$projet_name</h2>
                                </div>
                                <div style='border-radius: 0 10px 10px 0;' class='description colo2'>
                                    <p>$projet_descipt</p>
                                    <div class='tools-container flex-align-center'>";
                    }
                    //on affiche seulement 4 tools par projet
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
                
            }
            echo "</div></div></a>";
        } else {
            echo "<h1>Aucun projet trouvé.</h1>";
        }
        
        $conn->close();
    ?>
    </div></div>

    
</main>

<?php require_once "./composent/foot.php"; ?>
