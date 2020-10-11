<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';

$itemNAME = "Steel Mallet";
$itemRARITY = "RARE";
$itemLEVEL = 160;
$itemSTR = mt_rand(96, 100)/100;
$itemAGI = mt_rand(96, 100)/100;
$itemSTA = mt_rand(96, 100)/100;
$statPRIO = "STA";
$itemSLOT = "WEAPON";
$levelREQ = ceil($itemLEVEL/8);
$itemHASTE = 0; // bonus attack speed
$itemMOVESPEED = 0; //bonus movement speed (boots, pants, trinkets, rings, ?)
$itemEVASION = 0; // bonus dodge 5 points for 1 all ressist
$itemNATUREressist = 0; //poison
$itemCOLDressist = 0;
$itemFIREressist = 0;
$itemLIGHTNINGressist = 0; //shock resist
$itemLUCK = 0; //item, currency drop chance
$itemCRIT = 0;
$itemDAMAGEmin = 0;
$itemDAMAGEmax = 0;
$weaponSPEED = 0;
$itemARMOR = 0;
$weaponTYPE = 0;
$weaponHAND = 0;

switch($itemRARITY){
	case "COMMON":
		$RARITYmult = 0.8;
		$itemSTR = 0;
		$itemAGI = 0;
		break;
	case "RARE":
		$RARITYmult = 1.;
		break;
	case "EPIC":
		$RARITYmult = 1.2;
		break;
}

switch($statPRIO){   // PRIMARY STAT WEIGHT
	case "STR":
		$itemSTR *= 1.15;
		$itemAGI *= 0; //0.8
		$itemSTA *= 0.90;
		break;
	case "AGI":
		$itemSTR *= 0; //0.8
		$itemAGI *= 1.15;
		$itemSTA *= 0.90;
		break;
	case "STA":
		$itemSTR *= 0.75;
		$itemAGI *= 0.80;
		$itemSTA *= 1.20;
		break;
}

switch($itemSLOT){
	
	case "WEAPON":
	$weaponTYPE = "HAMMER";
	$weaponHAND = "ONEHANDED";
		switch($weaponTYPE){
			case "OFFHAND":
				$weaponSPEED = 0;
				break;
			case "STAFF":
				$weaponSPEED = 0.85;
				break;
			case "HAMMER":
				$weaponSPEED = 0.8;
				break;
			case "MACE":
				$weaponSPEED = 0.9;
				break;
			case "AXE":
				$weaponSPEED = 0.95;
				break;
			case "SWORD":
				$weaponSPEED = 1;
				break;
			case "DAGGER":
				$weaponSPEED = 1.2;
				break;
		}
		switch($weaponHAND){ //more dmg || more stats for twohands
			case "ONEHANDED":
				$weaponSPEED *= 1.5;
				$weaponSPEED = round($weaponSPEED, 1);
				break;
			case "TWOHANDED":
				$weaponSPEED *= 1;
				$weaponSPEED = round($weaponSPEED, 1);
				break;
		}
		$itemDAMAGEmin = mt_rand(1300, 1400)/1000;
		$itemDAMAGEmax = mt_rand(2900, 3000)/1000;
		$itemDAMAGEmin *= $itemLEVEL;
		$itemDAMAGEmax *= $itemLEVEL;
		$itemDAMAGEmin *= $RARITYmult;
		$itemDAMAGEmax *= $RARITYmult;
		$itemDAMAGEmin /= $weaponSPEED;
		$itemDAMAGEmax /= $weaponSPEED;
		$itemDAMAGEmin = floor($itemDAMAGEmin);
		$itemDAMAGEmax = floor($itemDAMAGEmax);
		$itemDPS = floor((($itemDAMAGEmin + $itemDAMAGEmax)/2)*$weaponSPEED);
		$suffix = array("of Courage", "of Grandior", "of Assault");
		$sp = mt_rand(0, (sizeof($suffix)-1));
		$itemNAME = $itemNAME . " " . $suffix[$sp];
		switch($sp){
			case 0:
				$itemCRIT = floor((mt_rand(600,650)/1000)*$itemLEVEL*$RARITYmult);
				$itemHASTE = floor((mt_rand(620, 700)/1000)*$itemLEVEL*$RARITYmult);
				break;
			case 1:
		}
		break;
	case "HELMET":
		$itemARMOR = (mt_rand(1300, 1500)/1000)*$itemLEVEL*$RARITYmult;
		$itemARMOR = floor($itemARMOR);
		break;
	case "CHEST":
		$itemARMOR = (mt_rand(1800, 2300)/1000)*$itemLEVEL*$RARITYmult;
		$itemARMOR = floor($itemARMOR);
		break;
	case "SHIELD":
		$itemARMOR = (mt_rand(3100, 3500)/1000)*$itemLEVEL*$RARITYmult;
		$itemARMOR = floor($itemARMOR);
		break;
}


$itemSTA *= $itemLEVEL;
$itemSTR *= $itemLEVEL;
$itemAGI *= $itemLEVEL;

$itemSTA = floor($itemSTA);
$itemSTR = floor($itemSTR);
$itemAGI = floor($itemAGI);




$sql = "INSERT INTO gentest (item_name, item_type, item_subtype, item_rarity, item_isequipable, item_slot, item_ATmin, item_ATmax, item_AS, item_armor, item_STA, item_STR, item_AGI, item_crit, item_haste, item_ilevel) VALUES ('$itemNAME', '$weaponTYPE', '$weaponHAND', '$itemRARITY', 1, '$itemSLOT', $itemDAMAGEmin, $itemDAMAGEmax, $weaponSPEED, $itemARMOR, $itemSTA, $itemSTR, $itemAGI, $itemCRIT, $itemHASTE, $itemLEVEL)";
$dbname = "at";
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->query($sql);
//echo mysqli_insert_id($conn);



	echo $itemNAME . "<br>";
	if($itemSLOT == "WEAPON"){echo $itemRARITY ." " . $weaponHAND . " " . $weaponTYPE . "<br>";}else{echo $itemRARITY . " " . $itemSLOT . "<br>";}
	if(isset($itemDAMAGEmax)){echo "Damage:" . $itemDAMAGEmin . "-" . $itemDAMAGEmax . " damage Attack Speed:" . $weaponSPEED . "<br>";}
	if(isset($itemDPS)){echo "DPS:" . $itemDPS . "<br>";}
	echo "Item Level:" . $itemLEVEL . "<br>";
	if($itemARMOR > 0){echo $itemARMOR . " Armor <br>";}
	echo "Strength:" . $itemSTR . "<br>";
	if($itemAGI > 0){echo "Agility:" . $itemAGI . "<br>";}
	echo "Stamina:" . $itemSTA . "<br>";
	if($itemCRIT > 0){echo "Crit rating: " . $itemCRIT . "<br>";}
	if($itemHASTE > 0){echo "Haste rating: " . $itemHASTE . "<br>";}
	echo $levelREQ . " level required to equip";





?>