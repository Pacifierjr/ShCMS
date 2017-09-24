<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

class map{
	private static $map;
	
	public static function get($id){
		if ($id == NULL)
			return 'D-Water';
	
		self::$map = array('D-Water', 'Erina', 'Reikeuseu', 'D-Water', 'D-Water', "Cornwell's Ruin", "Cornwell's Ruin", 'Argilla Ruin', 'Argilla Ruin', // [8]
						   'D-Water', 'D-Water', 'D-Water', "Cloron's Lair", "Cloron's Lair", "Cloron's Lair", "Fantasma's Lair", "Fantasma's Lair", // [16]
						   "Fantasma's Lair", 'Proelium', 'Willieoseu', 'Keuraijen', 'Maytreyan', 'Maytreyan', 'Aidion Nekria', 'Aidion Nekria', // [24]
						   'Elemental Cave', 'Ruber Chaos', 'Ruber Chaos', 'Adellia', 'Adeurian', 'Cantabilian', 'Paros Temple', 'Rapioru Maze', // [32]
						   'Fedion Temple', 'Khalamus House', 'Apulune', 'Iris', 'Cave of Stigma', 'Aurizen Ruin', 'Secret Battle Arena', // [39]
						   'Underground Stadium', 'Prison', 'Auction House', 'Skulleron', 'Astenes', 'Deep Desert 1', 'Deep Desert 2', 'Stable Erde', // [47]
						   'Cryptic Throne', 'Cryptic Throne', 'GRB', 'Guild House', 'Guild House', 'Guild Office', 'Guild Office', // [54]
						   'Sky City', 'Sky City', 'Sky City', 'Sky City', 'Fedion Temple', 'Elemental Cave', 'Cave of Stigm', 'Khalamus House', 'Aurizen Ruin', // [63]
						   'Oblivion Insula', 'Caelum Sacra', 'Caelum Sacra', 'Caelum Sacra', 'Valdemar Regnum', 'Palaion Regnum', 'Kanos Illium', 'Queen Servus', 
						   'Queen Caput');
		if ($id > (count(self::$map) - 1))
			return 'Unknown';
		else
			return self::$map[$id];
	}
}
				  
?>