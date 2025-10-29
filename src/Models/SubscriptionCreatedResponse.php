<?php

declare(strict_types=1);

/*
 * PaypalServerSdkLib
 */

namespace PaypalServerSdkLib\Models;

use stdClass;
use PaypalServerSdkLib\ApiHelper;

/**
 * The data associated with when a subscription is created
 */
class SubscriptionCreatedResponse implements \JsonSerializable {
	public $status;
	public $status_update_time;
	public $id;
	public $plan_id;
	public $start_time;
	public $quantity;
	public $subscriber;
	public $create_time;
	public $custom_id;
	public $plan_overridden;
	public $links;


	/**
	 * Converts the SubscriptionCreatedResponse object to a human-readable string representation.
	 *
	 * @return string The string representation of the SubscriptionCreatedResponse object.
	 */
	public function __toString(): string {
		return ApiHelper::stringify(
			'SubscriptionCreatedResponse',
			[
				'id' => $this->plan_id,
				'plan_id' => $this->plan_id,
				'links' => $this->links,
			]
		);
	}

	/**
	 * Encode this object to JSON
	 *
	 * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
	 *        are set. (default: false)
	 *
	 * @return array|stdClass
	 */
	#[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
	public function jsonSerialize(bool $asArrayWhenEmpty = false) {
		$json = [];
		if (isset($this->id)) {
			$json['id'] = $this->id;
		}
		if (isset($this->plan_id)) {
			$json['plan_id'] = $this->plan_id;
		}
		if (isset($this->links)) {
			$json['links'] = $this->links;
		}
		return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
	}
}

