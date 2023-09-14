<?php
require_once './auth.php';
require_once '../lib/Editor.php';
require_once '../helpers/output.php';
require_once 'template/header.tpl';
require_once 'template/navbar.tpl';
?>
<div id="content" class="row">
    <h2>Add new Editor</h2>
    <?php
        if(isset($_POST['addEditor'])){
            // collect data 
            $name = $_POST['name'];
            $salary = $_POST['salary'];
            // check data valid or no 
            if($name == null){
                echo getNullMessage('Editor name');
            }else if($salary == null){
                echo getNullMessage('Editor salary');
            }else if(!is_numeric($salary)){
                echo getNonNumericMessage("Editor salary");
            }else{
                // create object from editor 
                $editor = new Editor($name, $salary);
                if($editor->addEditor()){
                    echo getSuccessMessage();
                }else{
                    echo getFailMessage();
                }
            }
        }
    ?>
    <form action="addeditor.php" method="post">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Editor name</label>
            <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Editor salary</label>
            <input type="text" name="salary" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
        <input type="submit" class="btn btn-primary" name="addEditor" value="add editor"/>
    </form>
</div>
<?php
require_once 'template/footer.tpl';
?>

