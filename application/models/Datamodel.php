<?php

Class Datamodel extends CI_Model {

	function __construct() {
		parent::__construct();
	}
  public function getSpeciesList($familyId)
  {
    $result=$this->db->query("select * from species where ID_Family=$familyId order by Species ASC")->result();
    return $result;

  }
  public function getAvailableData($speciesId)
  {
    $result=$this->db->query("SELECT s.ID_Species,g.Genus,(SELECT COUNT(*) FROM ae as ae LEFT JOIN species_group sr ON ae.Species=sr.Speciesgroup_ID
                              LEFT JOIN species s ON sr.ID_Species=s.ID_Species WHERE sr.ID_Species=$speciesId) TOTAL_AE,
                              (SELECT COUNT(*) FROM rd as rd LEFT JOIN species_group sr ON rd.Speciesgroup_ID=sr.Speciesgroup_ID
                              LEFT JOIN species s ON sr.ID_Species=s.ID_Species WHERE sr.ID_Species=$speciesId) TOTAL_RD,(SELECT COUNT(*) FROM ef as ef LEFT JOIN species_group sr ON ef.Species=sr.Speciesgroup_ID
                              LEFT JOIN species s ON sr.ID_Species=s.ID_Species WHERE sr.ID_Species=$speciesId) TOTAL_EF,
                              (SELECT COUNT(*) FROM wd WHERE ID_species=s.ID_Species) TOTAL_WD,
                              bd.*,s.Species,sl.local_name,si.image_name,g.Genus
                              FROM species s
                              LEFT JOIN genus g ON s.ID_Genus=g.ID_Genus
                              LEFT JOIN botanical_description bd ON s.ID_Species=bd.species
                              LEFT JOIN species_localname sl ON bd.botanical_id=sl.botanical_id
                              LEFT JOIN species_image si ON bd.botanical_id=si.botanical_id
                              where s.ID_Species=$speciesId limit 1")->row();
    return $result;
  }




   public function getAvailableDataSpeciesCharacter($speciesId)
  {
    $result=$this->db->query("SELECT sc.* FROM species_character sc
                              LEFT JOIN botanical_description bd ON sc.botanical_id=bd.botanical_id
                              LEFT JOIN species s ON bd.Species=s.ID_Species
                              where s.ID_Species=$speciesId")->result();
    return $result;
  }

 

     public function getAvailableDataImage($speciesId)
  {
    $result=$this->db->query("SELECT si.image_name FROM species_image si
                              LEFT JOIN species s ON si.Species_ID=s.ID_Species
                              where s.ID_Species=$speciesId")->result();
    return $result;
  }


}
  ?>
