<?php

class Installer_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->dbforge();
    }

    public function createAndSeed() {
       $this->createTables();
       return $this->seedDatabase();
    }

    public function resetAndSeed() {
        $this->deleteTables();
        $this->createTables();
        return $this->seedDatabase();
    }

    private function createTables() {
		$fields = array(
            'applicable_manufacturer_or_applicable_gpo_making_payment_country' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
            ),
            'applicable_manufacturer_or_applicable_gpo_making_payment_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'applicable_manufacturer_or_applicable_gpo_making_payment_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'applicable_manufacturer_or_applicable_gpo_making_payment_state' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'associated_drug_or_biological_ndc_1' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'associated_drug_or_biological_ndc_2' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'associated_drug_or_biological_ndc_3' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'associated_drug_or_biological_ndc_4' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'associated_drug_or_biological_ndc_5' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'change_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'charity_indicator' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'city_of_travel' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'contextual_information' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'country_of_travel' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'covered_or_noncovered_indicator_1' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'covered_or_noncovered_indicator_2' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'covered_or_noncovered_indicator_3' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'covered_or_noncovered_indicator_4' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'covered_or_noncovered_indicator_5' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'covered_recipient_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'date_of_payment' => array(
                'type' => 'DATETIME'
            ),
            'delay_in_publication_indicator' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'dispute_status_for_publication' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'form_of_payment_or_transfer_of_value' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'indicate_drug_or_biological_or_device_or_medical_supply_1' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'indicate_drug_or_biological_or_device_or_medical_supply_2' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'indicate_drug_or_biological_or_device_or_medical_supply_3' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'indicate_drug_or_biological_or_device_or_medical_supply_4' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'indicate_drug_or_biological_or_device_or_medical_supply_5' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'name_of_drug_or_biological_or_device_or_medical_supply_1' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'name_of_drug_or_biological_or_device_or_medical_supply_2' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'name_of_drug_or_biological_or_device_or_medical_supply_3' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'name_of_drug_or_biological_or_device_or_medical_supply_4' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'name_of_drug_or_biological_or_device_or_medical_supply_5' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'name_of_third_party_entity_receiving_payment_or_transfer_of_valu' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'nature_of_payment_or_transfer_of_value' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'number_of_payments_included_in_total_amount' => array(
                'type' => 'INT',
                'constraint' => '11',
            ),
            'payment_publication_date' => array(
                'type' => 'DATETIME'
            ),
            'physician_first_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'physician_last_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'physician_license_state_code1' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'physician_license_state_code2' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'physician_license_state_code3' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'physician_license_state_code4' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'physician_license_state_code5' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'physician_middle_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'physician_name_suffix' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'physician_ownership_indicator' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'physician_primary_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'physician_profile_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'physician_specialty' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'product_category_or_therapeutic_area_1' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'product_category_or_therapeutic_area_2' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'product_category_or_therapeutic_area_3' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'product_category_or_therapeutic_area_4' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'product_category_or_therapeutic_area_5' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'program_year' => array(
                'type' => 'INT',
                'constraint' => '11',
            ),
            'recipient_city' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'recipient_country' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'recipient_province' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'recipient_postal_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'recipient_primary_business_street_address_line1' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'recipient_primary_business_street_address_line2' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'recipient_state' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'recipient_zip_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'record_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'related_product_indicator' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'state_of_travel' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'submitting_applicable_manufacturer_or_applicable_gpo_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'teaching_hospital_ccn' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'teaching_hospital_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'teaching_hospital_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'third_party_equals_covered_recipient_indicator' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'third_party_payment_recipient_indicator' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'total_amount_of_payment_usdollars' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            )
        );
        $this->dbforge->add_field('id');
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key(array('physician_first_name', 'physician_last_name'));
        $this->dbforge->add_key('physician_last_name');
        $this->dbforge->create_table('general_payment_data_2017', TRUE);
    }

    private function deleteTables() {
        $this->dbforge->drop_table('general_payment_data_2017', TRUE);
    }

    /*
     *  This takes a long time for the data, about 12 hours for grabbing all data.
     *  I haven't used any multithreading in a php application before but it might 
     *  be worth it to split this up into multiple threads
     *  one thread downloading new chunks of data and the other thread inserting the rows into mysql
     */
    public function seedDatabase() {
        $error = false;
        $this->db->save_queries = false; //fixes out of memory issue with codeigniter database class
		//running a batch insert requires the same columns/keys in all arrays
		//since the api rows only have the keys that are actually filled in we need to add all the missing keys back
		//this array is all of the fields that are in the database we will merge this with each row before inserting into the database
		$fields = array(
			'applicable_manufacturer_or_applicable_gpo_making_payment_country' => "",
			'applicable_manufacturer_or_applicable_gpo_making_payment_id' => "",
			'applicable_manufacturer_or_applicable_gpo_making_payment_name' => "",
			'applicable_manufacturer_or_applicable_gpo_making_payment_state' => "",
			'associated_drug_or_biological_ndc_1' => "",
			'associated_drug_or_biological_ndc_2' => "",
			'associated_drug_or_biological_ndc_3' => "",
			'associated_drug_or_biological_ndc_4' => "",
			'associated_drug_or_biological_ndc_5' => "",
			'change_type' => "",
			'charity_indicator' => "",
			'city_of_travel' => "",
			'contextual_information' => "",
			'country_of_travel' => "",
			'covered_or_noncovered_indicator_1' => "",
			'covered_or_noncovered_indicator_2' => "",
			'covered_or_noncovered_indicator_3' => "",
			'covered_or_noncovered_indicator_4' => "",
			'covered_or_noncovered_indicator_5' => "",
			'covered_recipient_type' => "",
			'date_of_payment' => "",
			'delay_in_publication_indicator' => "",
			'dispute_status_for_publication' => "",
			'form_of_payment_or_transfer_of_value' => "",
			'indicate_drug_or_biological_or_device_or_medical_supply_1' => "",
			'indicate_drug_or_biological_or_device_or_medical_supply_2' => "",
			'indicate_drug_or_biological_or_device_or_medical_supply_3' => "",
			'indicate_drug_or_biological_or_device_or_medical_supply_4' => "",
			'indicate_drug_or_biological_or_device_or_medical_supply_5' => "",
			'name_of_drug_or_biological_or_device_or_medical_supply_1' => "",
			'name_of_drug_or_biological_or_device_or_medical_supply_2' => "",
			'name_of_drug_or_biological_or_device_or_medical_supply_3' => "",
			'name_of_drug_or_biological_or_device_or_medical_supply_4' => "",
			'name_of_drug_or_biological_or_device_or_medical_supply_5' => "",
			'name_of_third_party_entity_receiving_payment_or_transfer_of_valu' => "",
			'nature_of_payment_or_transfer_of_value' => "",
			'number_of_payments_included_in_total_amount' => 0,
			'payment_publication_date' => "",
			'physician_first_name' => "",
			'physician_last_name' => "",
			'physician_license_state_code1' => "",
			'physician_license_state_code2' => "",
			'physician_license_state_code3' => "",
			'physician_license_state_code4' => "",
			'physician_license_state_code5' => "",
			'physician_middle_name' => "",
			'physician_name_suffix' => "",
			'physician_ownership_indicator' => "",
			'physician_primary_type' => "",
			'physician_profile_id' => "",
			'physician_specialty' => "",
			'product_category_or_therapeutic_area_1' => "",
			'product_category_or_therapeutic_area_2' => "",
			'product_category_or_therapeutic_area_3' => "",
			'product_category_or_therapeutic_area_4' => "",
			'product_category_or_therapeutic_area_5' => "",
			'program_year' => 0,
			'recipient_city' => "",
			'recipient_country' => "",
			'recipient_province' => "",
			'recipient_postal_code ' => "",
			'recipient_primary_business_street_address_line1' => "",
			'recipient_primary_business_street_address_line2' => "",
			'recipient_state' => "",
			'recipient_zip_code' => "",
			'record_id' => "",
			'related_product_indicator' => "",
			'state_of_travel' => "",
			'submitting_applicable_manufacturer_or_applicable_gpo_name' => "",
			'teaching_hospital_ccn' => "",
			'teaching_hospital_id' => "",
			'teaching_hospital_name' => "",
			'third_party_equals_covered_recipient_indicator' => "",
			'third_party_payment_recipient_indicator' => "",
			'total_amount_of_payment_usdollars' => 0
		);
		$apptoken = $this->config->item('openpaymentsdata_token');
		$limit = 100000;
        $offset = 0;
        $i = 1;
		$dataURL = 'https://openpaymentsdata.cms.gov/resource/ak56-dpcz.json?$$app_token='.$apptoken.'&$limit='.$limit.'&$offset='.$offset;
		$go = true;
		
		while ($go && !$error) {
            $result = $this->getResultsFromSourceAndInsert($dataURL, $fields);
            if ($result === false) {
                $error = true;
            }
            else {
                $offset += $limit;
                $dataURL = 'https://openpaymentsdata.cms.gov/resource/ak56-dpcz.json?$$app_token='.$apptoken.'&$limit='.$limit.'&$offset='.$offset;
                $i++;
                /*
                    the following if statements control if the requests should keep going until it runs out of data or if it should stop after a certain amount of iterations
                    use the first if "$i > (integer)" to just pull a smaller set of data
                    use the second if "$result < $limit" to grab all data
                */
                //if ($i > 10) {
                if ($result < $limit) {
                    $go = false;
                }
            }
			sleep(10);
        }
        return $error;
    } 

    private function getResultsFromSourceAndInsert($dataURL, $fields) {
        //fetching data like this is not the best (or sometimes safest) idea, but its easiest for this simple demo.
        $resultAmount = 0;
        $result = file_get_contents($dataURL);
        if ($result !== false) {
            
            //MySQL only supports up to 64 characters in a column name, this is just a quick little fix for this one column name.  A more robust, but slower way would be to foreach the array and build a new one with truncated names.
            $result = str_replace('name_of_third_party_entity_receiving_payment_or_transfer_of_value', 'name_of_third_party_entity_receiving_payment_or_transfer_of_valu', $result);
            $result = json_decode($result, true);
            //this map function will merge each row with the default $fields array to add the missing indexes
            $result = array_map(function($e) use ($fields) {
                return array_merge($fields, $e);
            }, $result);
            $resultAmount = count($result);
          /* while (count($result) > 0) {
               //this is dangerous
               $this->db->insert_batch('general_payment_data_2017', array_splice($result, 0, 10));
            }*/
            //running into issues with codeigniters insert_batch functions
            //it seems with large arrays it fails to convert to a string?
            //inserting one by one works but inserting is slower as a result
           foreach ($result as $row) {
                $this->db->insert('general_payment_data_2017', $row);
            }
        }
        else {
            return false;
        }
        
        return $resultAmount;
    }    

}