<?
/*
	mapping definition for importing data from CSV to USER table
	
	format:
	$mapping['<field name in csv>']=<field name in USER table>
	
	26-10-2012	rasmus@3kings.dk draft
*/

$destination_table = "user";
$mapping = array();
$mapping['uid'] = "uid";
$mapping['name'] = "username";
$mapping['pass'] = "password";
$mapping['tid'] = "cid";
$mapping['title'] = "profile_firstname";
$mapping['picture'] = "profile_image";
$mapping['field_profil_efternavn_value'] = "profile_lastname";
$mapping['field_profil_foedt_value'] = "profile_birthdate";
$mapping['field_profil_udmeldt_value'] = "profile_ended";
$mapping['field_profil_indmeldt_value'] = "profile_started";
$mapping['field_profil_privatadresse_value'] = "private_address";
$mapping['field_profil_husnr_value'] = "private_houseno";
$mapping['field_profil_husbogstav_value'] = "private_houseletter";
$mapping['field_profil_etage_value'] = "private_housefloor";
$mapping['field_profil_placering_value'] = "private_houseplacement";
$mapping['field_profil_privatpostnr_value'] = "private_zipno";
$mapping['field_privat_by_value'] = "private_city";
$mapping['field_profil_privatland_value'] = "private_country";
$mapping['field_profil_privattelefon_value'] = "private_phone";
$mapping['field_profil_privatmobil_value'] = "private_mobile";
$mapping['field_profil_privatemail_value'] = "private_email";
$mapping['field_profil_privatskype_value'] = "private_skype";
$mapping['field_profil_privatmsn_value'] = "private_msn";
$mapping['field_profil_firmanavn_value'] = "company_name";
$mapping['field_profil_firmastilling_value'] = "company_position";
$mapping['field_profil_firmabranche_value'] = "company_business";
$mapping['field_profil_firmaadresse_value'] = "company_address";
$mapping['field_profil_firmapostnr_value'] = "company_zipno";
$mapping['field_profil_firmaby_value'] = "company_city";
$mapping['field_profil_firmaland_value'] = "company_country";
$mapping['field_profil_firmatelefon_value'] = "company_phone";
$mapping['field_profil_firmaemail_value'] = "company_email";
$mapping['field_profil_firmaweb_value'] = "company_web";
$mapping['field_profil_privatprofil_value'] = "private_profile";
$mapping['field_profil_firmaprofil_value'] = "company_profile";
?>