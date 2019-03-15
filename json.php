<?php


// include('config.php');
$conn = mysqli_connect("203.151.24.15", "molcoop_soat", "labouradmin","molcoop_soat");

if ($conn->connect_error) {
    echo "error connection database or mysql". $conn->connect_error;
 }
// mysqli_set_charset($conn,"utf-8");
mysqli_set_charset($conn,"utf8");
// echo "Hello WOrld";
//$mem_id = $_POST['mem_id'];
// $sql = "SELECT * FROM member  where mem_id = '2' order by mem_id";

// $sql ="SELECT * FROM cooparmy3_test.sc_confirm_register where membership_no = '0000091' OR membership_no = '0000115'";
// ---------------------------------------------Mem_status-------------------------------------------------------------------------------------
// $sql =
// "SELECT
//  sm_mem_m_membership_registered.membership_no,
//  sm_mem_m_membership_registered.member_name,
//  sm_mem_m_membership_registered.member_surname,
//  sm_mem_m_membership_registered.member_group_no,
//  sm_mem_m_membership_registered.member_status_code,
//  sm_mem_m_membership_registered.date_of_birth,
//  sm_mem_m_membership_registered.approve_date,
//  sm_mem_m_membership_registered.resignation_approve_date,
// sm_mem_m_membership_registered.sex,
// sm_mem_m_ucf_member_group.member_group_name,
// sm_mem_m_membership_registered.position_name,
// sm_mem_m_share_mem.period_recrieve,
// sm_mem_m_share_mem.share_stock,
// sm_mem_m_share_mem.share_amount,
// sm_mem_m_membership_registered.total_loan_int,
// sm_mem_m_membership_registered.salary_amount,
// sm_mem_m_membership_registered.address_present
// FROM 		sm_mem_m_membership_registered	,
//  sm_mem_m_ucf_member_group ,
// sm_mem_m_share_mem
// WHERE	sm_mem_m_membership_registered.member_group_no = sm_mem_m_ucf_member_group.member_group_no
// AND   sm_mem_m_membership_registered.membership_no = sm_mem_m_share_mem.membership_no
// AND	sm_mem_m_membership_registered.membership_no ='0000115'"
// ;
//----------------------------------------Mem_share_statement------------------------------------------------------------------------------
// $sql="SELECT share_amount , share_stock , period_recrieve ,drop_status
// ,( case drop_status when '1' then 'งดส่งค่าหุ้น'  else  format(share_amount,0) end) as share_amount_fp
// FROM sm_mem_m_share_mem
// WHERE membership_no = '0000115'";
// ---------------------------------------------------------------------------------------------------------------------------------------
// $sql ="SELECT DISTINCT 
// sm_mem_m_share_holding_detail.operate_date , 
// sm_mem_m_share_holding_detail.share_value , 
// sm_mem_m_share_holding_detail.item_type_description
//     ,sm_mem_m_share_holding_detail.period , 
//     sm_mem_m_share_holding_detail.share_stock
// FROM sm_mem_m_share_holding_detail 
// WHERE sm_mem_m_share_holding_detail.membership_no = '0000115'
// ORDER  BY sm_mem_m_share_holding_detail.seq_no DESC 
// LIMIT 0,7" ;

// ---------------------------------Loan------------------------------------------------------------
$sql="SELECT 
sm_lon_m_loan_card.principal_balance
,sm_lon_m_loan_card.loan_contract_no
,sm_lon_m_loan_card.BEGINING_OF_CONTRACT
,sm_lon_m_loan_card.loan_approve_amount
,sm_lon_m_loan_card.period_payment_amount
,sm_lon_m_loan_card.LOAN_PAYMENT_TYPE_CODE
,sm_lon_m_loan_card.LAST_PERIOD
,sm_lon_m_loan_card.membership_no
-- ,LOAN_TYPE_DESCRIPTION
-- sm_lon_m_loan_card_detail.
-- ,YEAR_TOTAL_INTEREST
-- ,LAST_ACCESS_DATE
,sm_lon_m_loan_card.LOAN_INSTALLMENT_AMOUNT
,( select count(loan_contract_no) from sm_lon_m_contract_coll where loan_contract_no = sm_lon_m_loan_card.loan_contract_no) as c_count_coll
,((loan_approve_amount -principal_balance )/loan_approve_amount) * 100 as percent_pay

FROM 	sm_lon_m_loan_card
WHERE 	membership_no = '0000115'
AND ( principal_balance > 0 )
ORDER BY BEGINING_OF_CONTRACT DESC,principal_balance";
// --------------------------------------------------------------------------
// $sql="SELECT PRINCIPAL_BALANCE
//               ,LOAN_CONTRACT_NO
//               ,LOAN_TYPE
//               ,BEGINING_OF_CONTRACT
//               ,LOAN_APPROVE_AMOUNT
//               ,PERIOD_PAYMENT_AMOUNT
//               ,LOAN_PAYMENT_TYPE_CODE
//               ,LAST_PERIOD
//               ,ATM_STATUS
//               ,MODIFY_STATUS
//              FROM 	sm_lon_m_loan_card
//              WHERE 	membership_no = '0000091'
//              AND ( PRINCIPAL_BALANCE > 0 OR ( ATM_STATUS = '1' AND MODIFY_STATUS <> 'C' ) )
//              ORDER BY LAST_CALCINT_DATE DESC";

$result = mysqli_query($conn,$sql);
if (mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_array($result)){
        $confirm_register = array(); 
        $confirm_register["principal_balance"]= $row["principal_balance"];
        $confirm_register["loan_contract_no"]= $row["loan_contract_no"];
        $confirm_register["LOAN_TYPE"]= $row["LOAN_TYPE"];
        $confirm_register["BEGINING_OF_CONTRACT"]= $row["BEGINING_OF_CONTRACT"];
        $confirm_register["loan_approve_amount"]= $row["loan_approve_amount"];
        $confirm_register["period_payment_amount"]= $row["period_payment_amount"];
        $confirm_register["LOAN_PAYMENT_TYPE_CODE"]=$row["LOAN_PAYMENT_TYPE_CODE"];
        $confirm_register["LAST_PERIOD"]=$row["LAST_PERIOD"];
       
        // $confirm_register["approve_date"]=$row["approve_date"];
        $confirm_register["membership_no"]=$row["membership_no"];
        
        $confirm_register["c_count_coll"]=$row["c_count_coll"];
        // $confirm_register["member_group_name"]=$row["member_group_name"];
        // $confirm_register["date_of_birth"]= $row["date_of_birth"];
        // $confirm_register["position_name"]=$row["position_name"];
        // $confirm_register["period_recrieve"]=$row["period_recrieve"];

        // $confirm_register["share_stock"]=$row["share_stock"];
        // $confirm_register["share_amount"]=$row["share_amount"];
        // $confirm_register["total_loan_int"]= $row["total_loan_int"];
        // $confirm_register["salary_amount"]=$row["salary_amount"];
        // $confirm_register["address_present"]=$row["address_present"];
      
        $reponse["confirm_register"]=array();
        array_push($reponse,$confirm_register);
        
    }
   

 

} else {
    echo "0 results";
}
       
echo json_encode($reponse);


?>
