<?php
/**
 *
 * Plugin	staticPagination
 * @author	Gérald Niel
 ° @version	1.1
 * @date	21/10/2015 
 **/
 
class staticPagination extends plxPlugin {

	/**
	 * Constructeur de la classe
	 *
	 * @param	default_lang	langue par défaut
	 * @return	stdio
	 * @author	Stephane F
	 **/
	public function __construct($default_lang) {

		// appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);

		// droits pour accèder à la page config.php du plugin
		$this->setConfigProfil(PROFIL_ADMIN);
		
		$this->addHook('staticPagination', 'staticPagination');
	}
	
	/**
	 * Méthode de traitement du hook staticPagination
	 *
	 * @return	stdio
	 * @author	Gérald Niel
	 **/
	public function  staticPagination() {
	
	$string = '
	<?php
	
	$pages = Array();
	$page_id = $plxShow->plxMotor->cible;
	$page_grp = trim($plxShow->plxMotor->aStats[$page_id]["group"]);
	
	if ($page_grp) {

		$dispTotalPg 	= '.$this->getParam("dispTotalPg").';
		$dispFirstLink	= '.$this->getParam("dispFirstLink").';
		$dispPrevLink	= '.$this->getParam("dispPrevLink").';
		$dispHellip		= '.$this->getParam("dispHellip").';
		$dispNextLink	= '.$this->getParam("dispNextLink").';
		$dispLastLink	= '.$this->getParam("dispLastLink").';
		$dispPages		= '.$this->getParam("dispPages").';
		$numberPg		= '.$this->getParam("numberPg").' - 1;
		$numberPg = $numberPg < 3 ? 4 : $numberPg; 
		echo "<div id=\"pagination\" role=\"navigation\"><p>";
		
		$static_pages = $plxShow->plxMotor->aStats;
		foreach($static_pages as $k=>$v) {
			if($v["active"] == 1 and trim($v["group"]) == $page_grp) {
				$url_p = $plxMotor->urlRewrite("?static".$k."/".$v["url"]);
				array_push($pages,  ["id"=>$k, "url"=>$url_p, "name"=>$v["name"]]);
			}
		}
		$nb_pages = count($pages);
		
		if ($nb_pages > 1) {
		
			$last_p = $nb_pages - 1;
			$hellip = "<span class=\"p_page\">&hellip;</span>";
			foreach($pages as $k=>$v) {
				if ($v["id"] == $page_id) {
					$no_page = $k + 1;
					$current_p = "<span class=\"p_current\">".$no_page."</span>";
					$stop_p = $k + round($numberPg/2) ;
					if( $stop_p < $numberPg ) $stop_p = $numberPg;
					if( $stop_p > $last_p ) $stop_p = $last_p;
					$start_p = $stop_p - $numberPg;
					if($start_p < 0 ) $start_p = 0;
					($k == 0) ? $prev_id = $last_p : $prev_id = $k - 1;
					($k == $last_p) ? $next_id = 0 : $next_id = $k + 1;
				
					if ( $no_page > 2 and $dispFirstLink ) echo "<span class=\"p_first\"><a href=\"".$pages[0]["url"]."\" title=\"".$pages[0]["name"]."\">".L_PAGINATION_FIRST."</a></span>";
					if ( $no_page > 1 and $dispPrevLink ) echo "<span class=\"p_prev\"><a href=\"".$pages[$prev_id]["url"]."\" title=\"".$pages[$prev_id]["name"]."\">".L_PAGINATION_PREVIOUS."</a></span>";
					if ( $start_p > 0 and $dispPages and $dispHellip ) echo $hellip;

					if ($dispPages) {
						for( $i = $start_p; $i <= $stop_p; $i++ ) {
							($k == $i ) ? $html_str = $current_p : $html_str = "<span class=\"p_page\"><a href=\"".$pages[$i]["url"]."\" title=\"".$pages[$i]["name"]."\">".($i +1)."</a></span>";
							echo $html_str;
						}
					} else {
						echo $current_p;
					}
					
					if ( $k < $last_p and $stop_p < $last_p and $dispPages and $dispHellip ) echo $hellip;
					if ( $no_page < $nb_pages and $dispNextLink ) echo "<span class=\"p_next\"><a href=\"".$pages[$next_id]["url"]."\" title=\"".$pages[$next_id]["name"]."\">".L_PAGINATION_NEXT."</a></span>";
					if ( $no_page < $last_p and $dispLastLink ) echo "<span class=\"p_last\"><a href=\"".$pages[$last_p]["url"]."\" title=\"".$pages[$last_p]["name"]."\">".L_PAGINATION_LAST."</a></span>";
					
					echo "</p>";
					if ($dispTotalPg) echo "<p class=\"p_paging\">Page ".$no_page." sur ".$nb_pages."</p>";
				}

			}
		} else {
			echo "<p><span class=\"p_current\">".$nb_pages."</span></p>";
		}
		echo "</div>";
	}
	?>';
	
	echo $string;
	
	}
}
?>
