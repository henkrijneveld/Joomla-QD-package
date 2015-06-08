<?php
JToolBarHelper::title(JText::_('Basic Component'));
JToolBarHelper::preferences('com_basiccomponent');

$jinput = JFactory::getApplication()->input;

$filename = null;
$fileerror = true;
$uploadfile = "";

if (!empty($_FILES) && !empty($_FILES["file"])) {
    $fileerror = $_FILES["file"]["error"];
    $filename = $_FILES["file"]["name"];
    if (!$fileerror) {
        $uploadfile = $_FILES["file"]["tmp_name"];
    }
}
?>

<?php if (!$filename):?>
<h1>User importer</h1>
<p>File format should be csv, and contain the following fields: name, username, email, password, group-1, group-2, group-3.</p>
<p>At least one group should be provided. The name must exactly match the name of the group,
    beware for translations (look it up in your Joomla installation).</p>
<p>No emails are sent to the new users, so you have to inform them in a other way.</p>
<form method="post" action="<?php echo JURI::current();?>?option=com_basiccomponent" enctype="multipart/form-data">
    <p>Select the file with user to be imported from your local system.</p><br>
    <input type="hidden" name="MAX_FILE_SIZE" value="32000" />
    <input type="file" name="file" size="100">
    <br><br>
    <input type="submit" value="Import">
</form>
<?php endif; ?>

<?php if ($filename) {
    if ($fileerror) {
        $errortext = array(
               UPLOAD_ERR_INI_SIZE =>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
               UPLOAD_ERR_FORM_SIZE =>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
               UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded",
               UPLOAD_ERR_NO_FILE => "No file was uploaded",
               UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder",
               UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk",
               UPLOAD_ERR_EXTENSION => "File upload stopped by extension"
            );

        echo "Error processing file $filename. Errorcode: $fileerror (";
        echo array_key_exists($fileerror, $errortext)?$errortext[$fileerror]:"Unknown error";
        echo ")<br>";
    }

    if (!$fileerror) {
        ?><p>Processing of file <b><?= $filename; ?></b> (local name: <?= $uploadfile ?>)</p><br>
        <?php // echo file_get_contents($uploadfile);

        JLoader::discover("VcUser", JPATH_COMPONENT."/vc/user");
        $cf = JFactory::getConfig();
        $config = VcUserHandler::makeConfig(
            $cf->get('host'),
            $cf->get('db'),
            3306,
            $cf->get('user'),
            $cf->get('password'),
            $cf->get('dbprefix')
        );
        $a = new VcUserHandler($config, false, true);
        $a->import($uploadfile);
    }?>

    <form method="post" action="<?php echo JURI::current();?>?option=com_basiccomponent" enctype="multipart/form-data">
        <br><br>
        <input type="submit" value="Again">
    </form>

<?php } ?>


