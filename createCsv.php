<?php

/*
 * Please insert import_address_shipping.csv in var/import/address
 *
 */

use Magento\Framework\App\Bootstrap;
use Magento\Framework\Filesystem\IoInterface;

require __DIR__ . '/app/bootstrap.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);

ini_set('display_errors', 1);
umask(0);

set_time_limit(0);
ini_set('memory_limit', '1024M');
//
//function is_cli(){
//    return php_sapi_name() === 'cli';
//}

//if(!is_cli()){
//    die("Forbidden in HTTP mode");
//}


$file = 'listinoc.csv';
echo "Copying file: $file";
echo "\n";


$objectManager = $bootstrap->getObjectManager();
$state = $objectManager->get('\Magento\Framework\App\State');
$state->setAreaCode('frontend');


$customer = null;
$directory = $objectManager->get('\Magento\Framework\Filesystem\DirectoryList');
$customer = $objectManager->get(\Magento\Customer\Api\CustomerRepositoryInterface::class);
echo $rootPath = $directory->getPath('var') . "/import/" . $file;
$row = 1;
echo "<pre>";
if(($handle = fopen($rootPath, "r")) !== FALSE){
    while(($data = fgetcsv($handle, 1000, ";")) !== FALSE){
        $products[] = getProductArray($data);
    }
    fclose($handle);
    echo "<pre>";
    var_dump($products);
    echo "\n";
    echo "END";
}

function getProductArray($data){
    $return = null;
    $name = $data['1'];
    $description = $data['1'];
    $price = $data['2'] ? trim($data['2']) : 0;
    $stock = $data['3'] ? $data['3'] : 0;
    $prossimoArrivo = $data['4'];
    $brand = $data['6'];
    $sku = $data['8'];
    $category = calculateCategory($data['5']);
    $return = ['name' => $name, 'description' => $description, 'price' => $price,
        'stock' => $stock, 'prossimoArrivo' => $prossimoArrivo,
        'brand' => $brand, 'sku' => $sku, 'category' => $category];
    return $return;
}

function calculateCategory($category){
    $categoria = '';
    $componentiPC = "Informatica,Informatica/Componenti PC";
    $rete = "Informatica,Informatica/Rete";
    $cavi = "Informatica,Informatica/Cavi Per Computer e Periferiche";
    $hd = "Informatica,Informatica/Hard-disk";
    $av = "Informatica,Informatica/Audio e Video";
    $software = "Informatica,Informatica/Software";
    $root = "Informatica,Informatica";
    $stampa = "Stampa,Stampa";
    if(strtoupper($category) == 'CPU BOXED'){
        $categoria = $componentiPC . "/CPU BOXED";
    }
    if(strtoupper($category) == 'CPU TRAY'){
        $categoria = $componentiPC . "/CPU";
    }
    if(strtoupper($category) == 'DVD - WRITER'){
        $categoria = $componentiPC . "/MASTERIZZATORI";
    }
    if(strtoupper($category) == 'THERMAL PASTE'){
        $categoria = $componentiPC . "/PASTA TERMICA";
    }
    if(strtoupper($category) == 'VGA'){
        $categoria = $componentiPC . "/SCHEDE VIDEO";
    }
    if(strtoupper($category) == 'PC-POWER SUPPLY'){
        $categoria = $componentiPC . "/ALIMENTATORI";
    }
    if(strtoupper($category) == 'PC-POWER SUPPLY BEQUIET'){
        $categoria = $componentiPC . "/ALIMENTATORI";
    }
    if(strtoupper($category) == 'COOLER'){
        $categoria = $componentiPC . "/VENTOLE";
    }
    if(strtoupper($category) == 'PC-CASE VENTILATOR'){
        $categoria = $componentiPC . "/VENTOLE";
    }
    if(strtoupper($category) == 'MATHERBOARDS ASROCK'){
        $categoria = $componentiPC . "/SCHEDE MADRI";
    }
    if(strtoupper($category) == 'MATHERBOARDS ASUS'){
        $categoria = $componentiPC . "/SCHEDE MADRI";
    }
    if(strtoupper($category) == 'MATHERBOARDS GIGABYTE'){
        $categoria = $componentiPC . "/SCHEDE MADRI";
    }
    if(strtoupper($category) == 'MATHERBOARDS MSI'){
        $categoria = $componentiPC . "/SCHEDE MADRI";
    }
    if(strtoupper($category) == 'NAS SERVER'){
        $categoria = $componentiPC . "/NAS";
    }
    if(strtoupper($category) == 'SDRAM 16 GB'){
        $categoria = $componentiPC . "/MEMORIE RAM";
    }
    if(strtoupper($category) == 'SDRAM 32 GB'){
        $categoria = $componentiPC . "/MEMORIE RAM";
    }
    if(strtoupper($category) == 'SDRAM 4 GB'){
        $categoria = $componentiPC . "/MEMORIE RAM";
    }
    if(strtoupper($category) == 'SDRAM 8 GB'){
        $categoria = $componentiPC . "/MEMORIE RAM";
    }

    if(strtoupper($category) == 'SOUND CARDS'){
        $categoria = $componentiPC . "/SCHEDE AUDIO";
    }
    if(strtoupper($category) == 'ANTENNA'){
        $categoria = $rete . "/ANTENNE";
    }
    if(strtoupper($category) == 'NETWORK INTERFACE CARD'){
        $categoria = $rete . "/ADATTATORE";
    }
    if(strtoupper($category) == 'ROUTER'){
        $categoria = $rete . "/ROUTER";
    }
    if(strtoupper($category) == 'SWITCHES'){
        $categoria = $rete . "/SWITCHES";
    }
    if(strtoupper($category) == 'WIRELESS ADAPTER'){
        $categoria = $rete . "/ADATTATORI PoE";
    }
    if(strtoupper($category) == 'CABLE'){
        $categoria = $cavi . "/CAVI";
    }
    if(strtoupper($category) == 'CARD READER'){
        $categoria = $cavi . "/LETTORI DI SCHEDE";
    }
    if(strtoupper($category) == "INPUT DEVICES"){
        $categoria = $cavi . "/PERIFERICHE";
    }
    if(strtoupper($category) == "EXT. HDD 2,5 BRAND"){
        $categoria = $hd . "/ESTERNI";
    }
    if(strtoupper($category) == "EXT. HDD 3,5 BRAND"){
        $categoria = $hd . "/ESTERNI";
    }
    if(strtoupper($category) == "HDD"){
        $categoria = $hd . "/INTERNI";
    }
    if($category == "HDD-Gehäuse Captiva"){
        $categoria = $hd . "/INTERNI";
    }
    if(strtoupper($category) == "SECURE DIGITAL CARD KINGSTON"){
        $categoria = $hd . "/MEMORY CARD";
    }
    if(strtoupper($category) == "SSD"){
        $categoria = $hd . "/MEMORY CARD";
    }
    if(($category) == "USB Memory Stick Kingston"){
        $categoria = $hd . "/PEN DRIVE";
    }
    if(($category) == "USB Memory Stick"){
        $categoria = $hd . "/PEN DRIVE";
    }
    if(strtoupper($category) == "TFT WITH DVI"){
        $categoria = $av . "/MONITOR";
    }
    if(strtoupper($category) == "TFT WITH HDMI"){
        $categoria = $av . "/MONITOR";
    }
    if(strtoupper($category) == "TFT WITHOUT DVI"){
        $categoria = $av . "/MONITOR";
    }
    if(strtoupper($category) == "HEADSETS"){
        $categoria = $av . "/CUFFIE";
    }
    if(strtoupper($category) == "SPEAKERS"){
        $categoria = $av . "/ALTOPARLANTI";
    }
    if(strtoupper($category) == "SOFTWARE MICROSOFT"){
        $categoria = $software . "/MICROSOFT";
    }
    if(strtoupper($category) == "WEBCAM"){
        $categoria = $root . "/WEBCAM";
    }
    if(strtoupper($category) == "INK"){
        $categoria = $stampa . "/Consumabili/INK";
    }
    if(strtoupper($category) == "TONER"){
        $categoria = $stampa . "/Consumabili/TONER";
    }
    return $categoria;
}

