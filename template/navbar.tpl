<div id="navbar" class="row">
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <?php
                        $allCategories = Category::retreiveAllCategories();
                        if(is_array($allCategories) && count($allCategories) > 0){
                            foreach ($allCategories as $category):
                                echo '<li><a href="category.php?id_category='.$category['id'].'">'.$category['name'].'</a></li>';
                            endforeach;
                        }
                    ?>
                </ul>
                
            </div>