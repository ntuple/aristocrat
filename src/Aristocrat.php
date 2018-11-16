<?php

namespace Matrix\Aristocrat;

use Exception;

class Aristocrat
{
    protected $conn;
    protected $config;

    public function __construct($config = [])
    {
        if (!function_exists('oci_connect')) {
            throw new Exception('You need to enable the oci for the further action');
        }
        $S7S = '(DESCRIPTION =
                (ADDRESS_LIST =
                (ADDRESS = (PROTOCOL = TCP)(HOST ='.$config['db_host'].')(PORT ='.$config['db_port'].'))
                )
                (CONNECT_DATA =
                (SERVICE_NAME = '.$config['db_servicename'].')
                )
                )';

        $this->conn = @oci_connect($config['db_username'], $config['db_password'], $S7S);

        if (!$this->conn) {
            throw new Exception('Fail to connect to the database with the provided details');
        }

        $this->config = $config;
    }

    public function addData($membership_number = null)
    {
        if (empty($dataArray)) {
            throw new Exception('Fail to connect to the database with the provided details');
        }

        $sql = '
                BEGIN
                SP_ADD_UPDATE_MEMBER(
                    :p_membership_number,
                    :p_firstname,
                    :p_surname,
                    :p_title,
                    :p_date_of_birth,
                    :p_join_date,
                    :p_gender,
                    :p_telephone,
                    :p_mobile_phone,
                    :p_address_line1,
                    :p_address_line2,
                    :p_address_line3,
                    :p_address_line4,
                    :p_post_code,
                    :p_mail_barcode,
                    :p_email,
                    :p_card_number,
                    :p_card_expiry_date,
                    :p_suspension_status,
                    :o_return_code,
                    :o_return_str,
                    :p_mem_status
                ); END;
            ';

        $p_membership_number = $dataArray['membershipnumber'];
        $p_firstname = $dataArray['firstname'];
        $p_surname = $dataArray['surname'];
        $p_title = $dataArray['title'];
        $p_date_of_birth = date('d-M-y', strtotime($dataArray['date_of_birth']));
        $p_join_date = date('d-M-y');
        $p_gender = $dataArray['gender'];
        $p_telephone = $dataArray['telephone'];
        $p_mobile_phone = $dataArray['mobile_phone'];
        $p_address_line1 = $dataArray['address_line1'];
        $p_address_line2 = $dataArray['address_line2'];
        $p_address_line3 = $dataArray['address_line3'];
        $p_address_line4 = $dataArray['address_line4'];
        $p_post_code = $dataArray['postcode'];
        $p_mail_barcode = $dataArray['mail_barcode'];
        $p_email = $dataArray['email'];
        $p_card_number = $dataArray['card_number'];
        $p_card_expiry_date = date('d-M-y', strtotime($dataArray['card_expiry_date']));
        $p_suspension_status = 1;
        $o_return_code = 12;
        $o_return_str = 'Output parameter from the stored procedure i.e. the string that gives more information';
        $p_mem_status = '1';

        $s = oci_parse($this->conn, $sql);
        oci_bind_by_name($s, ':p_membership_number', $p_membership_number);
        oci_bind_by_name($s, ':p_firstname', $p_firstname);
        oci_bind_by_name($s, ':p_surname', $p_surname);
        oci_bind_by_name($s, ':p_title', $p_title);
        oci_bind_by_name($s, ':p_date_of_birth', $p_date_of_birth);
        oci_bind_by_name($s, ':p_join_date', $p_join_date);
        oci_bind_by_name($s, ':p_gender', $p_gender);
        oci_bind_by_name($s, ':p_telephone', $p_telephone);
        oci_bind_by_name($s, ':p_mobile_phone', $p_mobile_phone);
        oci_bind_by_name($s, ':p_address_line1', $p_address_line1);
        oci_bind_by_name($s, ':p_address_line2', $p_address_line2);
        oci_bind_by_name($s, ':p_address_line3', $p_address_line3);
        oci_bind_by_name($s, ':p_address_line4', $p_address_line4);
        oci_bind_by_name($s, ':p_post_code', $p_post_code);
        oci_bind_by_name($s, ':p_mail_barcode', $p_mail_barcode);
        oci_bind_by_name($s, ':p_email', $p_email);
        oci_bind_by_name($s, ':p_card_number', $p_card_number);
        oci_bind_by_name($s, ':p_card_expiry_date', $p_card_expiry_date);
        oci_bind_by_name($s, ':p_suspension_status', $p_suspension_status);
        oci_bind_by_name($s, ':o_return_code', $o_return_code);
        oci_bind_by_name($s, ':o_return_str', $o_return_str);
        oci_bind_by_name($s, ':p_mem_status', $p_mem_status);

        oci_execute($s);
        echo $o_return_code;
        echo $o_return_str;
    }

    public function selectData()
    {
        $s = oci_parse($this->conn, "select * from v_pub_members where MEMBERNUMBER ={$this->config['membership_number']}");
        $ret = oci_execute($s);

        oci_fetch_all($s, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);

        return $result;
    }

    public function deleteData($membershipnumber)
    {
        $sql = '
            BEGIN
            SP_DELETE_MEMBER
            (
                :p_member_number,
                :o_return_code,
                :o_return_str
            ); END;
        ';

        $p_member_number = $membershipnumber;
        $o_return_code = 0;
        $o_return_str = 'This is the test';

        $s = oci_parse($this->conn, $sql);
        oci_bind_by_name($s, ':p_member_number', $p_member_number);
        oci_bind_by_name($s, ':o_return_code', $o_return_code);
        oci_bind_by_name($s, ':o_return_str', $o_return_str);

        $val = oci_execute($s);
    }
}
