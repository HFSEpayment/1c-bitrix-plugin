<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
$psTitle = "HB_epay";
$arPSCorrespondence = array(
			"TEST_TRANSACTION" => array(
				"NAME" => "Test transaction",
				"DESCR" => "Indicates whether the transaction should be processed as a test transaction",
				"TYPE" => "SELECT",
				"VALUE" => array(
				  "Y" => array(
					"NAME" => "Yes"),
				  "N" => array(
					"NAME" => "No")),
				"SORT" => 4
			),	
			"TERMINAL" => array(
				"NAME" => "*Terminal",
				"DESCR" => "",
				"VALUE" => "TERMINAL",
				"TYPE" => "PROPERTY",
				"SORT" => 3
			),
			"CLIENTSECRET" => array(
				"NAME" => "*Client secret",
				"DESCR" => "",
				"VALUE" => "CLIENTSECRET",
				"TYPE" => "",
				"SORT" => 2
			),
			"CLIENTID" => array(
				"NAME" => "*Client id",
				"DESCR" => "",
				"VALUE" => "CLIENTID",
				"TYPE" => "",
				"SORT" => 1
			),
			"LANGUAGE" => array(
            	"NAME" => "Язык страницы оплаты",
            	"DESCR" => "",
            	"TYPE" => "SELECT",
                "VALUE" => array(
                    "kaz" => array("NAME" => "Қазақша"),
                    "rus" => array("NAME" => "Русский"),
                    "eng" => array("NAME" => "English")
                ),
                "SORT" => 6
            ),
            "SECRET_HASH" => array(
                "NAME" => "Property for secret_hash",
                "DESCR" => "Property name of [ORDER] for secret_hash",
                "VALUE" => "",
                "TYPE" => "PROPERTY",
                "SORT" => 5
            ),
            "DESCRIPTION" => array(
                "NAME" => "Description",
                "DESCR" => "Description on epay payment page",
                "VALUE" => "Pay via HB payment gateway",
                "TYPE" => "PROPERTY",
                "SORT" => 7
            ),
            "POST_LINK" => array(
                "NAME" => "Post link URL",
                "DESCR" => "",
                "VALUE" => "",
                "TYPE" => "PROPERTY",
                "SORT" => 8
            ),
            "FAILURE_POST_LINK" => array(
                "NAME" => "Failure post link URL",
                "DESCR" => "",
                "VALUE" => "",
                "TYPE" => "PROPERTY",
                "SORT" => 9
            ),
            "BACK_LINK" => array(
                "NAME" => "Back link URL",
                "DESCR" => "",
                "VALUE" => "",
                "TYPE" => "PROPERTY",
                "SORT" => 10
            ),
            "FAILURE_BACK_LINK" => array(
                "NAME" => "Failure back link URL",
                "DESCR" => "",
                "VALUE" => "",
                "TYPE" => "",
                "SORT" => 11
            ),
            "ADDITIONAL_STATIC_PROPS" => array(
                "NAME" => "Additional properties",
                "DESCR" => "Additional properties for payment page. See the writing rule in readme",
                "VALUE" => "",
                "TYPE" => "",
                "SORT" => 12
            ),
	);
?>