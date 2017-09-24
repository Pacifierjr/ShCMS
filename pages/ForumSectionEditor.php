<?php 
  include("core/styles/nice_table.php");
if($arg == null){ 
$arg = 1;
}

		
if($CurrentUser->IsAdm()){
    
    
    ?>
   <? if(isset($_POST["create"])){ 

    $query = $conn->prepare("UPDATE [Website].[dbo].[ForumSections]
   SET [Title] = ?
      ,[Description] = ?
      ,[DisplayOrder] = ?
      ,[ParentID] = ?
      ,[IsParentCat] = ?
      ,[IconURL] = ?
      ,[IsPublic] = ?
 WHERE ID = ?");
        $query->bindParam(1,$_POST["SectionName"],PDO::PARAM_STR);
        $query->bindParam(2,$_POST["SectionDesc"],PDO::PARAM_STR);
        $query->bindParam(3, $_POST["DisplayOrder"],PDO::PARAM_STR);
        $query->bindParam(4,$_POST["ParentCat"],PDO::PARAM_STR);
            if( $_POST["ParentCat"] != "none"){
                $isfirst = 0;
            }else{
                $isfirst = 1;
            }
        $query->bindParam(5, $isfirst,PDO::PARAM_INT);
        $query->bindParam(6, $_POST["SectionPicture"],PDO::PARAM_STR);

        
        $query->bindParam(7,$_POST["IsPublic"],PDO::PARAM_INT);
        $query->bindParam(8,$arg,PDO::PARAM_INT);
        $query->execute();

   ?>
<font color="green"> Section edited!</font><br/>
    <? } 
    $section = new Section($arg);

    ?>
    <h1>Edit a section</h1>
    <center>
        <script>
        function change() {
        document.getElementById("Icon").src = "./img/icon/forum/"+document.getElementById("SelectPic").options[document.getElementById("SelectPic").selectedIndex].value;
        }
        </script>
    <form method="POST" action="#">
        <table>
        <tr><td>Title: </td><td><input type="text" name="SectionName" placeholder="Section name" value="<?=$section->Get("Title")?>"></td></tr>
        <tr><td>Description: </td><td><input type="text" name="SectionDesc" placeholder="Section description" value="<?=$section->Get("Description")?>"></td></tr>
        <tr><td>Is Public Section: </td><td><select name="IsPublic" value="value="<?=$section->Get("IsPublic")?>""><option value="0">No</option><option value="1">Yes</option></select></td></tr>
        <tr><td>Display Order: </td><td><input type="number" name="DisplayOrder" placeholder="Display Order (minus first)" value="<?=$section->Get("DisplayOrder")?>"></td></tr> 
        <tr><td>Parent Categorie: </td><td><select name="ParentCat" value="<?=$section->Get("ParentCat")?>"> 
            <?
    $query = $conn->prepare('SELECT * FROM Website.dbo.ForumSections WHERE IsParentCat = 1;');
        $query->execute();
        while($row = $query->fetch(PDO::FETCH_BOTH)){
            ?>
                <option value="<?=$row["ID"]?>"><?=$row["Title"]?></option> <? } ?>
            
            <option value="none">None (will create a parent section)</option>
            
            
            </select></td></tr>
            <tr><td>Section Image: </td><td><select name="SectionPicture" id="SelectPic" onchange="change()";> 
        <?if ($handle = opendir('./img/icon/forum/')) {
                $thelist = null;
                $cnt = 0;
                $firstfile="";
                while (false !== ($file = readdir($handle)))
                {
                    if ($file != "." && $file != "..")
                    {
                         if($cnt==0){
                             $firstfile = $file;
                         }
                            $cnt++;
                         $thelist .= '<option value="'.$file.'">'.$file.'</option>';
                    }
                }
                closedir($handle);
            }
            echo($thelist);?>
        
                </select> <td></tr>
            </table>
            <center><img id="Icon" width="100px" height="100px" src="./img/icon/forum/<?=$firstfile?>" /></center>    

        <input type="submit" name="create">
    </form>
        
    </center>
    <?
}else{
    include("core/reqadm.inc.php");
}