<?php

namespace Core\Classes;

class Crypto
{
	public static function encrypt($text) : string{

		return openssl_encrypt($text, 'AES-256-CTR', Config::Get('crypto_key'), null, Config::get('crypto_iv'));
	}

	public static function decrypt($text) : string{

		return openssl_decrypt($text, 'AES-256-CTR', Config::Get('crypto_key'), null, Config::get('crypto_iv'));
	}
}

?>