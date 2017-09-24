<style>
    /**/
.Theme--wow a {
    color: #f8b700;
}
@media only screen and (min-width: 641px)
.ForumCard--content {
    box-shadow: 0 0 0 1px #000;
}
@media only screen and (min-width: 641px)
.ForumCard {
    margin: 1.25rem .625rem 0;
    width: calc((100% / 2) - 1.25rem);
}
.ForumCard {
    -ms-flex-direction: row;
    flex-direction: row;
    width: 40%;
	
}
@media only screen and (min-width: 641px)
.Card, .Characters .Author, .ForumCard {
    border-width: 1px;
}
.ForumCard-description {
    color: rgba(255,255,255,.7);
    font-size: .9375rem;
    line-height: 1.25;
    margin: .25em 0 0;
    max-height: 3.515625rem;
    overflow: hidden;
    padding: 0;
}
.Theme--wow a {
    color: #f8b700;
}
.Card, .Characters .Author, .ForumCard {
    padding: 5px 5px
    background-color: rgba(255,255,255,.05);
    border-color: rgba(255,255,255,.15);
    border-style: solid;
    border-width: 0 0 1px;
    color: rgba(255,255,255,.7);
    display: -ms-flexbox;
    display: flex;
    -ms-flex: 0 0 auto;
    flex: 0 0 auto;
    -ms-flex-direction: column;
    flex-direction: column;
    margin: 0;
    max-width: 100%;
    min-height: 0;
    position: relative;
    text-decoration: none;
    margin: 5px;
}
.Theme--wow .ForumCard-heading {
    color: #fff;
}
    .Theme--wow .ForumCard-heading {
    font-family: wow,Blizzard,sans-serif;
}
    .Theme--wow .ForumCard-heading {
    color: #fff;
}
    .ForumCard-heading {
    font-size: 1.25rem;
    font-weight: 100;
    line-height: 1.25;
    max-height: 3.125rem;
    overflow: hidden;
    width: 100%;
}
    .ForumCard-details {
    display: -ms-flexbox;
    display: flex;
    -ms-flex: auto;
    flex: auto;
    -ms-flex-direction: column;
    flex-direction: column;
    margin-left: 1rem;
    overflow: hidden;
}
    .ForumCard-icon {
    background-repeat: no-repeat;
    background-size: contain;
    -ms-flex: none;
    flex: none;
    height: 50px;
    width: 50px;
}
.ForumCards {
    padding:5px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    flex-direction: row;
}
@media only screen and (min-width: 641px)
.Cards, .ForumCards {
    border: none;
}
.Cards, .ForumCards {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
}
    .ForumCategory-heading {
    color: rgba(255,255,255,.7);
    font-size: 1.0625rem;
    font-weight: 400;
    line-height: 1;
    margin: 2.5rem 0 0.55rem;
    text-transform: uppercase;
            font-family: Blizzard,sans-serif;
}  
</style>
<div id="Mcontainer">
    <center> <a href="/Home"><?=$SiteName?></a>
                                        →
                <a href="/Forum">Forum</a></center> 
     <? 
        if($CurrentUser->IsAdm()){
            if(isset($_POST["create"])){
                $DisplayOrder = $_POST["DisplayOrder"];
                $Icon = $_POST["SectionPicture"];
                $Title = $_POST["SectionName"];
                $Desc = $_POST["SectionDesc"];
                $ParentID = $IsParentCat = 0;
                if($_POST["ParentCat"] == "none"){
                    $ParentID = 0;
                    $IsParentCat = 1;
                }else{
                    $IsParentCat = 0;
                    $ParentID = $_POST["ParentCat"];
                }
                
                $query = $conn->prepare("INSERT INTO [Website].[dbo].[ForumSections] VALUES (?,?,?,?,?,?,?);");
                $query->bindParam(1,$Title, PDO::PARAM_STR);
                $query->bindParam(2,$Desc, PDO::PARAM_STR);
                $query->bindParam(3,$DisplayOrder,PDO::PARAM_INT);
                $query->bindParam(4,$ParentID, PDO::PARAM_INT);
                $query->bindParam(5,$IsParentCat, PDO::PARAM_INT);
                $query->bindParam(6,$Icon,PDO::PARAM_STR);
                $query->bindParam(7,$_POST["IsPublic"],PDO::PARAM_INT);
                $query->execute();
            }

        }


   
            $ParentSection = $conn->prepare("SELECT * FROM Website.dbo.ForumSections WHERE IsParentCat = 1 ORDER BY DisplayOrder ASC;");
            $ParentSection->execute();
            while($row = $ParentSection->fetch(PDO::FETCH_ASSOC)){
                
                
                
                ?>
                        <script LANGUAGE="JavaScript">
                        function section_delete_<?=$row["ID"]?>(){
                            if (confirm('Are you sure you want to delete this section ("<?=$row["Title"]?>") and all its posts/threads from the database? ')) {
                                window.location.replace("/ForumSectionDelete.<?=$row["ID"]?>");
                            } else {
                                window.location.replace("/Forum");
                            }
                        }
                    </script>
    
                   <div xmlns="http://www.w3.org/1999/xhtml" class="ForumCategory ">
					<header class="ForumCategory-header">
						<h1 class="ForumCategory-heading">
                                    <?php if($CurrentUser->IsAdm()){                            ?>
                                <a href="ForumSectionEditor.<?=$row["ID"]?>" style="margin-right:10px;"><img src="img/icon/forum/edit_btn.png"  style=";width: 20px;height: 20px;display:inline;"/></a>
                                <img src="./img/icon/forum/remove.png" onclick="section_delete_<?=$row["ID"]?>()" style=";width: 20px;height: 20px;display:inline;" />
                            <?php } ?><?=$row["Title"]?> - <small>(<?=$row["Description"]?>)</small>
                        </h1>
                
                        <hr style="border-top: 1px solid gray;width:450px;"><br/>			
					</header>
                    <center>

                       
					<div class="ForumCards ">
	                   <? 
                
                    $ChildSection = $conn->prepare("SELECT * FROM Website.dbo.ForumSections WHERE IsParentCat = 0 AND ParentID = ? ORDER BY DisplayOrder Asc;");
                    $ChildSection->bindParam(1,$row["ID"],PDO::PARAM_INT);           
                    $ChildSection->execute();
                    while($crow = $ChildSection->fetch(PDO::FETCH_ASSOC)){
                        
                    $ThreadCount = $conn->prepare("SELECT COUNT(*) AS Counter FROM Website.dbo.ForumThreads WHERE SectionID = ? AND IsFirstPost = 1;");
                    $ThreadCount->bindParam(1,$crow["ID"],PDO::FETCH_ASSOC);
                    $ThreadCount->execute();
                    $ThreadCount = $ThreadCount->fetch(PDO::FETCH_ASSOC)["Counter"];
                        
                    $PostCount = $conn->prepare("SELECT COUNT(*) AS Counter FROM Website.dbo.ForumThreads WHERE SectionID = ? AND IsFirstPost = 0;");
                    $PostCount->bindParam(1,$crow["ID"],PDO::FETCH_ASSOC);
                    $PostCount->execute();
                    $PostCount = $PostCount->fetch(PDO::FETCH_ASSOC)["Counter"];
                ?>
		          <script LANGUAGE="JavaScript">
                        function section_delete_<?=$crow["ID"]?>(){
                            if (confirm('Are you sure you want to delete this section ("<?=$crow["Title"]?>") and all its posts/threads from the database? ')) {
                                window.location.replace("/ForumSectionDelete.<?=$crow["ID"]?>");
                            } else {
                                window.location.replace("/Forum");
                            }
                        }
                    </script>
                    
                
                  <div class="ForumCard ForumCard--content"> 
                      <?php if($CurrentUser->IsAdm()){
                    ?>
                      
                       <a href="ForumSectionEditor.<?=$crow["ID"]?>" style="margin-right:10px;"><img src="img/icon/forum/edit_btn.png"  style=";width: 20px;height: 20px;display:inline;"/></a>
                     <i class="" onclick="section_delete_<?=$crow["ID"]?>()" style="background-image: url('./img/icon/forum/remove.png');width: 20px;height: 20px;margin-left: 100px;"></i><?php
                }
                        ?>
                      <i class="ForumCard-icon" style="background-image: url('./img/icon/forum/<?=$crow["IconURL"]?>');" onclick="window.location='ForumSection.<?=$crow["ID"]?>'"></i>
                        <a href="ForumSection.<?=$crow["ID"]?>">
                            <div class="ForumCard-details">
                                <h1 class="ForumCard-heading"><?=$crow["Title"]?>
                                </h1>
                                    <span class="ForumCard-description"><?=$crow["Description"]?><br/><?=$ThreadCount?> Threads <?=$PostCount?> Posts</span>

                            </div>
                        </a>
                   </div>
               
			 <? 
                 }
                ?>

                                   </div>        
                       </center>

				</div>
            
            <?
            }
            ?>
</div>
<?php 
if($CurrentUser->IsAdm()){
    
    ?>
<br/>

<div id="Mcontainer">
    
    <? if(isset($_POST["create"])){ ?>
   <font color="green"> Section created!</font><br/>
    <? } ?>
    <h1>Create a section</h1>
    <center>
        <script>
        function change() {
        document.getElementById("Icon").src = "./img/icon/forum/"+document.getElementById("SelectPic").options[document.getElementById("SelectPic").selectedIndex].value;
        }
        </script>
    <form method="POST" action="#">
        <table>
        <tr><td>Title: </td><td><input type="text" name="SectionName" placeholder="Section name"></td></tr>
        <tr><td>Description: </td><td><input type="text" name="SectionDesc" placeholder="Section description"></td></tr>
        <tr><td>Is Public Section: </td><td><select name="IsPublic"><option value="0">No</option><option value="1">Yes</option></select></td></tr>
        <tr><td>Display Order: </td><td><input type="number" name="DisplayOrder" placeholder="Display Order (minus first)"></td></tr>
        <tr><td>Parent Categorie: </td><td><select name="ParentCat">
            <?
    $query = $conn->prepare('SELECT * FROM Website.dbo.ForumSections WHERE IsParentCat = 1;');
        $query->execute();
        while($row = $query->fetch(PDO::FETCH_BOTH)){
            ?>
                <option value="<?=$row["ID"]?>"><?=$row["Title"]?></option> <? } ?>
            
            <option value="none">None (will create a parent section)</option>
            
            
            </select></td></tr>
            <tr><td>Section Image: </td><td><select name="SectionPicture" id="SelectPic" onchange="change()";>>
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
</div> 

<?
}
?>
         
       
    

        
