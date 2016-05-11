<?php

namespace Pippin;

use ArrayAccess;
use RuntimeException;

final class IPN implements ArrayAccess {

	private $data = [];

	public function __construct($data) {
		$this->data = $data;
	}

	private function getDataValueOrNull($key) {
		if (array_key_exists($key, $this->data)) {
			return $this->data[$key];
		}

		return null;
	}

	public function getPayerEmail() {
		return $this['payer_email'];
	}

	public function getReceiverEmail() {
		return $this['receiver_email'];
	}

	public function getTransactionId() {
		return $this['txn_id'];
	}

	public function getCurrency() {
		$currency = $this['mc_currency'];
		return (is_string($currency)) ? strtoupper($currency) : null;
	}

	public function getGross() {
		return $this['mc_gross'];
	}

	public function getPaymentStatus() {
		return strtoupper($this['payment_status']);
	}

	public function getCustom() {
		return $this['custom'];
	}

	// ---

	public function offsetSet($key, $value) {
		throw new RuntimeException('offsetSet is unavailable for IPN, as it represents an immutable data type.');
	}

	public function offsetExists($key) {
		return isset($this->data[$key]);
	}

	public function offsetUnset($key) {
		throw new RuntimeException('offsetUnset is unavailable for IPN, as it represents an immutable data type.');
	}

	public function offsetGet($key) {
		return $this->getDataValueOrNull($key);
	}

}
