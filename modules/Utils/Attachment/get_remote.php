<?php
if(!isset($_REQUEST['cid']) || !isset($_REQUEST['id']) || !isset($_REQUEST['path']))
    die('Invalid usage');
$cid = $_REQUEST['cid'];
$path = $_REQUEST['path'];
$id = $_REQUEST['id'];
$rev = $_REQUEST['revision'];
$disposition = (isset($_REQUEST['view']) && $_REQUEST['view'])?'inline':'attachment';

define('CID', $cid);
require_once('../../../include.php');

$public = Module::static_get_module_variable($path,'public',false);
$protected = Module::static_get_module_variable($path,'protected',false);
$private = Module::static_get_module_variable($path,'private',false);
$key = Module::static_get_module_variable($path,'key',null);
$local = Module::static_get_module_variable($path,'group',null);
session_commit();
if(!$key || $local===null || !Acl::is_user())
    die('Permission denied');
$row = DB::GetRow('SELECT uaf.id,uaf.original,ual.permission,ual.other_read,ual.permission_by FROM utils_attachment_file uaf INNER JOIN utils_attachment_link ual ON ual.id=uaf.attach_id WHERE ual.id='.DB::qstr($id).' AND uaf.revision='.DB::qstr($rev));
$original = $row['original'];
$file_id = $row['id'];
$filename = $local.'/'.$id.'_'.$rev;

if(!$row['other_read'] && $row['permission_by']!=Acl::get_user()) {
	if(($row['permission']==0 && !$public) ||
		($row['permission']==1 && !$protected) ||
		($row['permission']==2 && !$private))
		die('Permission denied');
}


if(headers_sent())
    die('Some data has already been output to browser, can\'t send file');

function get_mime_type($filepath) {
    //new method, but not compiled in by default
    if(extension_loaded('fileinfo')) {
        $fff = new finfo(FILEINFO_MIME);
        $ret = $fff->file($filepath);
        $fff->close();
        return $ret;
    }

    //deprecated method
    if(function_exists('mime_content_type'))
        return mime_content_type($filepath);

    //unix system
    ob_start();
    system("file -i -b {$filepath}");
    $output = ob_get_clean();
    $output = explode("; ",$output);
    if ( is_array($output) ) {
        $output = $output[0];
    }
    return $output;
}
$t = time();
$remote_address = $_SERVER['REMOTE_ADDR'];
$remote_host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
DB::Execute('INSERT INTO utils_attachment_download(attach_file_id,created_by,created_on,download_on,description,ip_address,host_name) VALUES (%d,%d,%T,%T,%s,%s,%s)',array($file_id,Acl::get_user(),$t,$t,$disposition,$remote_address,$remote_host));

$f_filename = 'data/Utils_Attachment/'.$filename;
$buffer = file_get_contents($f_filename);
header('Content-Type: '.get_mime_type($f_filename));
header('Content-Length: '.strlen($buffer));
header('Content-disposition: '.$disposition.'; filename="'.$original.'"');
echo $buffer;
?>
