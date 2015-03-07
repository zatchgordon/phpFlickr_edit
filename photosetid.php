<?php
require_once("phpFlickr.php");
header('Content-Type: application/json');


if(!isset($_POST["title"]) || $_POST["title"]==""){
    header("HTTP/1.1 400 Bad Request - Must specify 'title' when POSTing.");
    echo "you shouldn't be here";
    die();

}
$result = array();

$f = new phpFlickr("693af055013e44885afe5cce4468e6f2");
$f->enableCache("db", "mysql://root:pass@localhost/flickr", 60*60*24);

//$f->setToken("72157650742359347-5cdf8a04fa2c5d43");

//$f->sync_upload("img/background.png");

if($_POST["list"]=="true"){
    $person = $_POST["user"];
    $user = $f->people_findByUsername($person);
    $id = $user["id"];
    $set = $f->photosets_getList($id);
    array_push($result,$set);
    echo json_encode($result);
    return;
}



//global $db;
//$stmt1 = $db->prepare("SELECT * FROM post2 Where title = (:title)");
//$stmt1->bindValue(":title", $_POST["title"]);
//$stmt1->execute();

//while ($row = $stmt1->fetch(PDO::FETCH_ASSOC))
//{



    $thisalbum = $f->photosets_getPhotos($_POST['title']);
    array_push($result,$thisalbum);


    //echo "<h1>". $thisalbum['photoset']['title'] ."</h1><br>";
    //echo "<div id='#". $thisalbum['photoset']['title'] ."'>";

    //foreach ($thisalbum["photoset"]["photo"] as $thisphoto) {


      //  array_push($result,$thisphoto);


        //echo "<br><br><br>";
        //echo "<img src='https://farm" . $thisphoto['farm'] . ".staticflickr.com/" . $thisphoto["server"] . "/" . $thisphoto["id"] . "_" . $thisphoto["secret"] . ".jpg' ></li>";

    //}
    echo json_encode($result);

//}





/*   ->photosets_getList returns......

    <photosets page="1" pages="1" perpage="30" total="2" cancreate="1">
            <photoset id="72157626216528324" primary="5504567858" secret="017804c585" server="5174" farm="6" photos="22" videos="0" count_views="137" count_comments="0" can_comment="1" date_create="1299514498" date_update="1300335009">
                <title>Avis Blanche</title>
                <description>My Grandma's Recipe File.</description>
            </photoset>

            <photoset id="72157624618609504" primary="4847770787" secret="6abd09a292" server="4153" farm="5" photos="43" videos="12" count_views="523" count_comments="1" can_comment="1" date_create="1280530593" date_update="1308091378">
                <title>Mah Kittehs</title>
                <description>Sixty and Niner. Born on the 3rd of May, 2010, or thereabouts. Came to my place on Thursday, July 29, 2010.</description>
            </photoset>
        </photosets>
*/


    /* photosets_getPhotos returns......

        <photoset id="4" primary="2483" page="1" perpage="500" pages="1" total="2">
                <photo id="2484" secret="123456" server="1" title="my photo" isprimary="0" />
                <photo id="2483" secret="123456" server="1" title="flickr rocks" isprimary="1" />
        </photoset>
    */


?>

