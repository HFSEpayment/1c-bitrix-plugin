<?
    if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
?>
<?
    $amountToPay = htmlspecialcharsbx($GLOBALS['SALE_INPUT_PARAMS']['ORDER']['SHOULD_PAY']);
    $currencyCode = htmlspecialcharsbx($GLOBALS['SALE_INPUT_PARAMS']['ORDER']['CURRENCY']);
    $language = htmlspecialcharsbx(CSalePaySystemAction::GetParamValue("LANGUAGE"));
    $currencySymbols = [
        'USD' => '$',
        'EUR' => '€',
        'JPY' => '¥',
        'GBP' => '£',
        'AUD' => 'A$',
        'CAD' => 'C$',
        'INR' => '₹',
        'KZT' => '₸',
        'RUB' => '₽',
        'UZS' => 'Soʻm',
        'KGS' => 'c',
        'TJS' => 'C',
    ];
    $currencySymbol = isset($currencySymbols[$currencyCode]) ? $currencySymbols[$currencyCode] : '';
    $amountText = $amountToPay.' '.$currencySymbol;
    $textService = '';
    $textPay = '';
    $textRedirect = '';
    switch ($language) {
        case 'eng':
            $textService = 'The service is provided by the online payment service <b>"Epay"</b><br><br>Amount to be paid on the bill: ';
            $textPay = 'Pay';
            $textRedirect = 'You will be redirected to the payment page';
            break;
        case 'kaz':
            $textService = 'Қызметті <b>«Epay»</b> онлайн төлем сервисі ұсынады<br><br>Төлеуге тиісті сома: ';
            $textPay = 'Төлеу';
            $textRedirect = 'Сіз төлем бетіне өтесіз';
            break;
        default:
            $textService = 'Услугу предоставляет сервис онлайн-платежей <b>«Epay»</b><br><br>Сумма к оплате по счету: ';
            $textPay = 'Оплатить';
            $textRedirect = 'Вы будете перенаправлены на страницу оплаты';
            break;
    }
?>

<p><?= $textService ?> <strong><?= $amountText ?></strong></p>
<form action="" method="post">
    <div class="d-flex align-items-center justify-content-start mb-4">
        <button class="btn btn-lg btn-success pl-4 pr-4" style="border-radius: 3px;background-color: #00875A;color: #fff;border-color: #007f1d;" type="submit" name="call_hb_redirect">
            <?= $textPay ?> <strong><?= $amountText ?></strong>
        </button>
        <p class="m-0 p-3"><?= $textRedirect ?></p>
    </div>
</form>

<?
	if(array_key_exists('call_hb_redirect', $_POST)){
   		hb_redirect();
    }

    function padNumber($number) {
        return str_pad((string)$number, 6, '0', STR_PAD_LEFT);
    }

    function stringToAssociativeArray($str) {
        $str = trim($str);
        $pairs = explode('|', $str);
        $assocArray = [];

        foreach ($pairs as $pair) {
            $pair = trim($pair);

            if (strpos($pair, '=') !== false) {
                list($key, $value) = explode('=', $pair, 2);
                $assocArray[trim($key)] = trim($value);
            } else {
                $assocArray[trim($pair)] = '';
            }
        }

        return $assocArray;
    }

	function hb_redirect(){

		  $test_url = "https://testoauth.homebank.kz/epay2/oauth2/token";
		  $prod_url = 'https://epay-oauth.homebank.kz/oauth2/token';
		  $test_page = "https://test-epay.homebank.kz/payform/payment-api.js";
		  $prod_page = 'https://epay.homebank.kz/payform/payment-api.js';

		  $hbp_env = htmlspecialcharsbx(CSalePaySystemAction::GetParamValue('TEST_TRANSACTION'));
		  $hbp_client_id = htmlspecialcharsbx(CSalePaySystemAction::GetParamValue('CLIENTID'));
		  $hbp_client_secret = htmlspecialcharsbx(CSalePaySystemAction::GetParamValue('CLIENTSECRET'));
		  $hbp_terminal = htmlspecialcharsbx(CSalePaySystemAction::GetParamValue('TERMINAL'));
		  $hbp_back_link = htmlspecialcharsbx(CSalePaySystemAction::GetParamValue('BACK_LINK'));
		  $hbp_back_link = $hbp_back_link ? $hbp_back_link : 'http://' . SITE_SERVER_NAME . '/hbepay_resultpage/success.php';
		  $hbp_failure_back_link = htmlspecialcharsbx(CSalePaySystemAction::GetParamValue('FAILURE_BACK_LINK'));
		  $hbp_failure_back_link = $hbp_failure_back_link ? $hbp_failure_back_link : 'http://' . SITE_SERVER_NAME . '/hbepay_resultpage/failed.php';

		  $hbp_amount = htmlspecialcharsbx($GLOBALS['SALE_INPUT_PARAMS']['ORDER']['SHOULD_PAY']);
		  $hbp_invoice_id = padNumber(IntVal($GLOBALS['SALE_INPUT_PARAMS']['ORDER']['ID']));
		  $hbp_currency = htmlspecialcharsbx($GLOBALS['SALE_INPUT_PARAMS']['ORDER']['CURRENCY']);
		  $hbp_description = htmlspecialcharsbx(CSalePaySystemAction::GetParamValue('DESCRIPTION'));
          $hbp_language = htmlspecialcharsbx(CSalePaySystemAction::GetParamValue("LANGUAGE"));
          $hbp_language = $hbp_language ? $hbp_language : "rus";

		  $hbp_account_id = htmlspecialcharsbx($GLOBALS['SALE_INPUT_PARAMS']['ORDER']['USER_ID']);
		  $hbp_telephone = htmlspecialcharsbx($GLOBALS['SALE_INPUT_PARAMS']['PROPERTY']['PHONE']);
		  $hbp_email = htmlspecialcharsbx($GLOBALS['SALE_INPUT_PARAMS']['PROPERTY']['EMAIL']);
		  $hbp_name = htmlspecialcharsbx($GLOBALS['SALE_INPUT_PARAMS']['PROPERTY']['FIO']);

		  $hbp_post_link = htmlspecialcharsbx(CSalePaySystemAction::GetParamValue('POST_LINK'));
		  $hbp_failure_post_link = htmlspecialcharsbx(CSalePaySystemAction::GetParamValue('FAILURE_POST_LINK'));
		  $hbp_secret_hash_prop = htmlspecialcharsbx(CSalePaySystemAction::GetParamValue('SECRET_HASH'));
		  $hbp_secret_hash = $hbp_secret_hash_prop ? htmlspecialcharsbx($GLOBALS['SALE_INPUT_PARAMS']['ORDER'][$hbp_secret_hash_prop]) : "";

		  $hbp_additional_props_text = htmlspecialcharsbx(CSalePaySystemAction::GetParamValue('ADDITIONAL_STATIC_PROPS'));
          $hbp_additional_props = stringToAssociativeArray($hbp_additional_props_text);

		  if ($hbp_env == 'Y') {
			$token_api_url = $test_url;
			$pay_page = $test_page;
		  } else if($hbp_env == 'N') {
			$token_api_url = $prod_url;
			$pay_page = $prod_page;
		  }

		// initiate environment

		  $fields = [
			'grant_type'      => 'client_credentials', 
			'scope'           => 'payment usermanagement',
			'client_id'       => $hbp_client_id,
			'client_secret'   => $hbp_client_secret,
			'invoiceID'       => $hbp_invoice_id,
			'secret_hash'     => $hbp_secret_hash,
			'amount'          => $hbp_amount,
			'currency'        => $hbp_currency,
			'terminal'        => $hbp_terminal,
			'postLink'        => $hbp_post_link,
			'failurePostLink' => $hbp_failure_post_link
		  ];

		  // build query for request
		  $fields_string = http_build_query($fields);

		  // open connection
		  $ch = curl_init();

		  // set the option
		  curl_setopt($ch, CURLOPT_URL, $token_api_url);
		  curl_setopt($ch, CURLOPT_POST, true);
		  curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

		  // execute post
		  $result = curl_exec($ch);

		  $json_result = json_decode($result, true);
		  if (!curl_errno($ch)) {
			switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
			  case 200:
				$hbp_auth = (object) $json_result;

				$hbp_payment_object = [
				  'invoiceId' => $hbp_invoice_id,
				  //? invoiceIdAlt:"8564546",
				  'backLink' => $hbp_back_link,
				  'failureBackLink' => $hbp_failure_back_link,
				  'postLink' => $hbp_post_link,
				  'failurePostLink' => $hbp_failure_post_link,
				  'language' => $hbp_language,
				  'description' => $hbp_description,
				  'accountId' => $hbp_account_id,
				  'terminal' => $hbp_terminal,
				  'amount' => $hbp_amount,
				  //? data: "{\"statement\":{\"name\":\"Arman Ali\",\"invoiceID\":\"80000016\"}}",
				  'currency' => $hbp_currency,
				  'auth' => $hbp_auth,
				  'phone' => $hbp_telephone,
				  'email' => $hbp_email,
				  'name' => $hbp_name
				];
				$resultObj = (object) array_merge($hbp_additional_props, $hbp_payment_object);
				?>
				  <script src="<?=$pay_page?>"></script>
				  <script>
					halyk.pay(<?= json_encode($resultObj) ?>);
				  </script>
				<?
				break;
			  default:
				echo 'Неожиданный код HTTP: ', $http_code, "\n";
			}
		  }
	}
?>