<?php
require_once './auth.php';
require_once '../lib/Editor.php';
require_once '../lib/Category.php';
require_once '../helpers/output.php';
require_once 'template/header.tpl';
require_once 'template/navbar.tpl';
?>
<div id="content" class="row">
    <h2>Add new Category</h2>
    <?php
        if(isset($_POST['addCategory'])){
            // collect data
            $name = $_POST['name'];
            $id_manager = $_POST['id_manager'];
            // check data valid or no 
            if($name == null){
                echo getNullMessage("Category name");
            }else{
                // create object 
                $category = new Category($name, $id_manager);
                if($category->addCategory()){
                    echo getSuccessMessage();
                }else{
                    echo getFailMessage();
                }
            }
        }
    ?>
    <form action="addcategory.php" method="post">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Category name</label>
            <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Managed by</label>
            <select name="id_manager" class="form-select" aria-label="Default select example">
                <?php
                    $allEditors = Editor::retreiveAllEditors();
                    if(is_array($allEditors) && count($allEditors) >0){
                        foreach ($allEditors as $editor):
                            echo '<option value="'.$editor['id'].'">'.$editor['name'].'</option>';
                        endforeach;
                    }else{
                        echo '<option value="">no editor found</option>';
                    }
                ?>
                
                
            </select>
        </div>
        <input type="submit" class="btn btn-primary" name="addCategory" value="add category"/>
    </form>
</div>
<?php
require_once 'template/footer.tpl';
?>

