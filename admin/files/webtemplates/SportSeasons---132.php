<?PHP 
if ( !function_exists('slugify') ):
function slugify($value) 
{ 
    $value = str_replace('and ', '', $value);
    return preg_replace('/[^-a-z0-9]/', '', str_replace(' ', '-', strtolower($value))); 
} 

function class_id($id, $flip=FALSE)
{
        $lookup = Array(
                1 => '4A',
                2 => '5A',
                3 => '3A',
                4 => '2A',
                5 => '1A',
                6 => '8-man',
                7 => '6-man');
        $flipped = array_flip($lookup);
        if ( $flip === FALSE ) return $lookup[intval($id)]; 
        return $flipped[$id];
}

function sport_id($id, $flip=FALSE)
{
        $lookup = Array(
                1 => 'football',
                6 => 'boys-basketball',
                11 => 'girls-volleyball',
                12 => 'boys-soccer',
                13 => 'boys-cross-country',
                14 => 'girls-cross-country',
                15 => 'girls-soccer',
                16 => 'boys-swimming-diving',
                17 => 'girls-swimming-diving',
                18 => 'boys-golf',
                19 => 'girls-golf',
                21 => 'girls-basketball',
                23 => 'wrestling',
                25 => 'boys-track',
                27 => 'boys-tennis',
                28 => 'girls-track',
                29 => 'baseball',
                30 => 'softball',
                31 => 'girls-tennis',
                32 => 'field-hockey',
                33 => 'girls-gymnastics',
                34 => 'ice-hockey',
                35 => 'boys-lacrosse',
                36 => 'girls-lacrosse');
        $flipped = array_flip($lookup);
        if ( $flip === FALSE ) return $lookup[intval($id)]; 
        return $flipped[$id];
}
?>
<?PHP $seasonStart = array(); $seasonEnd = array(); ?>
<VAR $seasonStart["Football"] = "09/03">
<VAR $seasonEnd["Football"] = "12/05">

<VAR $seasonStart["Girls Cross Country"] = "08/27">
<VAR $seasonEnd["Girls Cross Country"] = "10/31">

<VAR $seasonStart["Boys Cross Country"] = "08/27">
<VAR $seasonEnd["Boys Cross Country"] = "10/31">

<VAR $seasonStart["Girls Volleyball"] = "08/27">
<VAR $seasonEnd["Girls Volleyball"] = "11/14">

<VAR $seasonStart["Baseball"] = "03/10">
<VAR $seasonEnd["Baseball"] = "05/28">

<VAR $seasonStart["Boys Basketball"] = "12/01">
<VAR $seasonEnd["Boys Basketball"] = "03/12">

<VAR $seasonStart["Girls Basketball"] = "12/01">
<VAR $seasonEnd["Girls Basketball"] = "03/12">

<VAR $seasonStart["Boys Soccer"] = "08/27">
<VAR $seasonEnd["Boys Soccer"] = "11/14">

<VAR $seasonStart["Girls Soccer"] = "03/10">
<VAR $seasonEnd["Girls Soccer"] = "05/25">

<VAR $seasonStart["Softball"] = "08/21">
<VAR $seasonEnd["Softball"] = "10/24">

<VAR $seasonStart["Boys Track and Field"] = "03/10">
<VAR $seasonEnd["Boys Track and Field"] = "05/21">

<VAR $seasonStart["Girls Track and Field"] = "03/10">
<VAR $seasonEnd["Girls Track and Field"] = "05/21">

<?PHP 
function sportInSeasonOrig($sportName,$dateToCheck) {
	global $seasonStart;
	global $seasonEnd;
	$inSeason = false;
	$startDate = $seasonStart[$sportName];
	$endDate = $seasonEnd[$sportName];

	if ($startDate == "" || $endDate == "") {
		return true;
	}

	$arrStart = explode("/",$startDate);
	$startMonth = $arrStart[0];
	$startDay = $arrStart[1];
	$arrEnd = explode("/",$endDate);
	$endMonth = $arrEnd[0];
	$endDay = $arrEnd[1];
	$arrDateCheck = explode("/",$dateToCheck);
	$currentMonth = $arrDateCheck[0];
	$currentDay = $arrDateCheck[1];
	
	if ($startMonth < $endMonth) {
		if ($currentMonth >= $startMonth && $currentMonth <= $endMonth) {
			if ($currentMonth == $startMonth) {
				if ($currentDay >= $startDay) {
					$inSeason = true;
				}
			} elseif ($currentMonth == $endMonth) {
				if ($currentDay <= $endDay) {
					$inSeason = true;
				}
			} else {
				$inSeason = true;
			}
		}
	} else {
	// Season spans 2 years
		if ($currentMonth >= $startMonth) {
			if ($currentMonth == $startMonth) {
				if ($currentDay >= $startDay) {
					$inSeason = true;
				}
			} else {
				$inSeason = true;
			}
		} elseif ($currentMonth <= $endMonth) {
			if ($currentMonth == $endMonth) {
				if ($currentDay <= $endDay) {
					$inSeason = true;
				}
			} else {
				$inSeason = true;
			}
		}
	}
	return $inSeason;
}

function sportInSeason($sportName,$dateToCheck) {
	global $seasonStart;
	global $seasonEnd;
	$inSeason = 1;
	$startDate = $seasonStart[$sportName];
	$endDate = $seasonEnd[$sportName];

	if ($startDate == "" || $endDate == "") {
		return 1;
	}

	$arrStart = explode("/",$startDate);
	$startMonth = $arrStart[0];
	$startDay = $arrStart[1];
	$arrEnd = explode("/",$endDate);
	$endMonth = $arrEnd[0];
	$endDay = $arrEnd[1];
	$arrDateCheck = explode("/",$dateToCheck);
	$currentMonth = $arrDateCheck[0];
	$currentDay = $arrDateCheck[1];
	
	if ($startMonth < $endMonth) {
		if ($currentMonth >= $startMonth && $currentMonth <= $endMonth) {
			if ($currentMonth == $startMonth) {
				if ($currentDay >= $startDay) {
					$inSeason = 1;
				} else {
					$inSeason = -1;
				}
			} elseif ($currentMonth == $endMonth) {
				if ($currentDay <= $endDay) {
					$inSeason = 1;
				} else {
					$inSeason = -2;
				}
			} else {
				$inSeason = 1;
			}
		} elseif ($currentMonth > 7) {
			if ($currentMonth > $startMonth && $currentMonth > $endMonth) {
				$inSeason = -1;
				if ($startMonth > 7) {
					$inSeason = -2;
				}
			} elseif ($currentMonth < $startMonth) {
				$inSeason = -1;
			}
		} else {
			if($currentMonth > $startMonth && $currentMonth > $endMonth) {
				$inSeason = -2;
			} elseif ($currentMonth < $startMonth) {
				$inSeason = -1;
				if ($startMonth > 7) {
					$inSeason = -2;
				}
			}
		}
	} else {
	// Season spans 2 years
		if ($currentMonth >= $startMonth) {
			if ($currentMonth == $startMonth) {
				if ($currentDay >= $startDay) {
					$inSeason = 1;
				} else {
					$inSeason = -1;
				}
			} else {
				$inSeason = 1;
			}
		} elseif ($currentMonth <= $endMonth) {
			if ($currentMonth == $endMonth) {
				if ($currentDay <= $endDay) {
					$inSeason = 1;
				} else {
					$inSeason = -2;
				}
			} else {
				$inSeason = 1;
			}
		} elseif ($currentMonth > 7) {
			$inSeason = -1;
		} else {
			$inSeason = -2;
		}
	}
	return $inSeason;
}

endif;
?>
