<?php require_once('config.php');
function replaceRelativePath($filename)
{
    $filename = str_replace('../', '/', $filename);
    return $filename;
}

$setting_cover = replaceRelativePath($setting_info['cover_image']);
$logo = replaceRelativePath($setting_info['system_logo']);
function transformChemin($chemin) {
    $nouveauChemin = preg_replace('/^\.\.\//', '', $chemin);
    return $nouveauChemin;
  }
  $cheminTransforme = transformChemin($setting_info['cover_image']);
?>