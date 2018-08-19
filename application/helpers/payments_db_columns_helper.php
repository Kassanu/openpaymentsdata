<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('get_payments_db_columns')) {
	function get_payments_db_columns() {
		return array(
			'applicable_manufacturer_or_applicable_gpo_making_payment_country',
			'applicable_manufacturer_or_applicable_gpo_making_payment_id',
			'applicable_manufacturer_or_applicable_gpo_making_payment_name',
			'applicable_manufacturer_or_applicable_gpo_making_payment_state',
			'associated_drug_or_biological_ndc_1',
			'associated_drug_or_biological_ndc_2',
			'associated_drug_or_biological_ndc_3',
			'associated_drug_or_biological_ndc_4',
			'associated_drug_or_biological_ndc_5',
			'change_type',
			'charity_indicator',
			'city_of_travel',
			'contextual_information',
			'country_of_travel',
			'covered_or_noncovered_indicator_1',
			'covered_or_noncovered_indicator_2',
			'covered_or_noncovered_indicator_3',
			'covered_or_noncovered_indicator_4',
			'covered_or_noncovered_indicator_5',
			'covered_recipient_type',
			'date_of_payment',
			'delay_in_publication_indicator',
			'dispute_status_for_publication',
			'form_of_payment_or_transfer_of_value',
			'indicate_drug_or_biological_or_device_or_medical_supply_1',
			'indicate_drug_or_biological_or_device_or_medical_supply_2',
			'indicate_drug_or_biological_or_device_or_medical_supply_3',
			'indicate_drug_or_biological_or_device_or_medical_supply_4',
			'indicate_drug_or_biological_or_device_or_medical_supply_5',
			'name_of_drug_or_biological_or_device_or_medical_supply_1',
			'name_of_drug_or_biological_or_device_or_medical_supply_2',
			'name_of_drug_or_biological_or_device_or_medical_supply_3',
			'name_of_drug_or_biological_or_device_or_medical_supply_4',
			'name_of_drug_or_biological_or_device_or_medical_supply_5',
			'name_of_third_party_entity_receiving_payment_or_transfer_of_valu',
			'nature_of_payment_or_transfer_of_value',
			'number_of_payments_included_in_total_amount',
			'payment_publication_date',
			'physician_first_name',
			'physician_last_name',
			'physician_license_state_code1',
			'physician_license_state_code2',
			'physician_license_state_code3',
			'physician_license_state_code4',
			'physician_license_state_code5',
			'physician_middle_name',
			'physician_name_suffix',
			'physician_ownership_indicator',
			'physician_primary_type',
			'physician_profile_id',
			'physician_specialty',
			'product_category_or_therapeutic_area_1',
			'product_category_or_therapeutic_area_2',
			'product_category_or_therapeutic_area_3',
			'product_category_or_therapeutic_area_4',
			'product_category_or_therapeutic_area_5',
			'program_year',
			'recipient_city',
			'recipient_country',
			'recipient_province',
			'recipient_postal_code ',
			'recipient_primary_business_street_address_line1',
			'recipient_primary_business_street_address_line2',
			'recipient_state',
			'recipient_zip_code',
			'record_id',
			'related_product_indicator',
			'state_of_travel',
			'submitting_applicable_manufacturer_or_applicable_gpo_name',
			'teaching_hospital_ccn',
			'teaching_hospital_id',
			'teaching_hospital_name',
			'third_party_equals_covered_recipient_indicator',
			'third_party_payment_recipient_indicator',
			'total_amount_of_payment_usdollars'
		);
	}
}
