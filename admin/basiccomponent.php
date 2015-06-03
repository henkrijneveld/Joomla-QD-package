<?php
JToolBarHelper::title(JText::_('Basic Component'));
JToolBarHelper::preferences('com_basiccomponent');

$jinput = JFactory::getApplication()->input;

$filename = null;
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
<form method="post" action="<?php echo JURI::current();?>?option=com_basiccomponent" enctype="multipart/form-data">
    <p>Select the file with user to be imported from your local system</p><br>
    <input type="hidden" name="MAX_FILE_SIZE" value="32000" />
    <input type="file" name="file" size="100">
    <br><br>
    <input type="submit" value="Import">
</form>
<?php endif; ?>

<?php if ($filename) {
    if ($fileerror) {
        echo "Error processing file $filename. Errorcode: $fileerror";
    }

    if (!$fileerror) {
        ?><p>Contents of file <b><?= $filename; ?></b> (local name: <?= $uploadfile ?>)</p><br>
        <?= file_get_contents($uploadfile);

    }
} ?>


