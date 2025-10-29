<?php

declare(strict_types=1);

/*
 * PaypalServerSdkLib
 */

namespace PaypalServerSdkLib\Controllers;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Response\Types\ErrorType;
use CoreInterfaces\Core\Request\RequestMethod;
use PaypalServerSdkLib\Exceptions\ErrorException;
use PaypalServerSdkLib\Http\ApiResponse;
use PaypalServerSdkLib\Models\SubscriptionCreatedResponse;

/**
 * Controller for subscription related transaction with the paypal api
 */
class SubscriptionsController extends BaseController {

	public function createSubscription(array $options): ApiResponse {
		$_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/v1/billing/subscriptions')
			->auth('Oauth2')
			->parameters(
				HeaderParam::init('Content-Type', 'application/json'),
				BodyParam::init($options)->extract('body'),
				HeaderParam::init('PayPal-Mock-Response', $options)->extract('paypalMockResponse'),
				HeaderParam::init('PayPal-Request-Id', $options)->extract('paypalRequestId'),
				HeaderParam::init('PayPal-Partner-Attribution-Id', $options)->extract('paypalPartnerAttributionId'),
				HeaderParam::init('PayPal-Client-Metadata-Id', $options)->extract('paypalClientMetadataId'),
				HeaderParam::init('Prefer', $options)->extract('prefer', 'return=minimal'),
				HeaderParam::init('PayPal-Auth-Assertion', $options)->extract('paypalAuthAssertion')
			);

		$_resHandler = $this->responseHandler()
			->throwErrorOn(
				'400',
				ErrorType::init(
					'Request is not well-formed, syntactically incorrect, or violates schema.',
					ErrorException::class
				)
			)
			->throwErrorOn(
				'403',
				ErrorType::init('Authorization failed due to insufficient permissions.', ErrorException::class)
			)
			->throwErrorOn('500', ErrorType::init('An internal server error has occurred.', ErrorException::class))
			->type(SubscriptionCreatedResponse::class)
			->returnApiResponse();

		return $this->execute($_reqBuilder, $_resHandler);
	}
}
